<template>
    <div class="container mx-auto px-4" v-if="requirement.id !== null && dataLoaded">
        <h1>{{ requirement.name }}</h1>

        <label class="primary-label" for="test-case-title">
            Title
        </label>

        <input class="primary-input" v-model="testCase.title"
               id="test-case-title" type="text" placeholder="Title">

        <label class="primary-label" for="test-case-description">
            Description
        </label>


        <quill-editor v-model="testCase.description"
                      id="test-case-description" class="primary-text-area text-input">

        </quill-editor>

        <!--        <textarea class="primary-input" v-model="testCase.description"-->
        <!--                  id="test-case-description" type="text"></textarea>-->

        <label class="primary-label" for="test-case-preconditions">
            Preconditions
        </label>

        <textarea class="primary-input" v-model="testCase.preconditions"
                  id="test-case-preconditions" type="text"></textarea>

        <button class="primary-btn" @click="addStep">Add step</button>

        <table class="table-auto">
            <thead>
            <tr>
                <th class="px-4 py-2">No</th>
                <th class="px-4 py-2">Id</th>
                <th class="px-4 py-2">Step</th>
                <th class="px-4 py-2">Input</th>
                <th class="px-4 py-2">Expected results</th>
                <th class="px-4 py-2">Result</th>
                <th class="px-4 py-2">Comment</th>
                <th class="px-4 py-2">Test passed</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(step, index) in steps" v-bind:key="index" :class="index % 2 !== 0 ? '' : 'bg-gray-100' ">
                <td class="border px-4 py-2">{{ index + 1 }}</td>
                <td class="border px-4 py-2">{{ step.id }}</td>
                <td class="border px-4 py-2">
                    <textarea class="primary-input" v-model="step.description" type="text"></textarea>
                </td>
                <td class="border px-4 py-2">
                    <textarea class="primary-input" v-model="step.input" type="text"></textarea>
                </td>
                <td class="border px-4 py-2">
                    <textarea class="primary-input" v-model="step.expected_result" type="text"></textarea>
                </td>
                <td class="border px-4 py-2">
                    <textarea class="primary-input" v-model="step.result" type="text"></textarea>
                </td>
                <td class="border px-4 py-2">
                    <textarea class="primary-input" v-model="step.comment" type="text"></textarea>
                </td>
                <td class="border px-4 py-2">
                    <vue-select :options="testPassedOptions" label="label" :reduce="label => label.value"
                                :clearable="false" :searchable="false"
                                v-model="step.is_passed"></vue-select>
                </td>
                <td class="border px-4 py-2">
                    <button class="primary-btn">Add Step</button>
                </td>
            </tr>
            </tbody>
        </table>

        <ul class="nav nav-pills">
            <li v-for="tab in items" class="nav-item">
                <a :class="'nav-link ' +  (currentTab === tab.props.is ? 'active' : '')"
                   href="#" @click.prevent="currentTab = tab.props.is">{{ tab.tab }}</a>
            </li>
        </ul>

        <div v-for="tab in items" v-bind:key="tab.props.is">
            <component v-show="currentTab === tab.props.is" v-bind="tab.props"></component>
        </div>

        <button v-if="steps.length" class="primary-btn" @click="submitTestCase()">Submit</button>

    </div>

</template>

<script>
import requirementTestCaseRepository from "../../repositories/requirement/requirementTestCaseRepository";
import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'
import {quillEditor} from 'vue-quill-editor'

export default {
    name: "Create.vue",
    created() {
        if (this.$route.name !== 'test-cases.create') {
            this.isEditMode = true;
            this.testCaseId = this.$route.params.testCase;
            this.fetchTestCase();
        } else {
            this.$store.dispatch('requirement/setRequirement', this.$route.params.requirement);
        }
    },
    components: {
        quillEditor
    },
    data() {
        return {
            steps: [],
            isEditMode: false,
            testCaseId: null,
            testPassedOptions: [{
                label: 'Yes',
                value: true
            }, {
                label: 'No',
                value: false
            }],
            testCase: {
                title: "",
                description: "",
                preconditions: ""
            },
            items: [],
            currentTab: 'comment-list',
            dataLoaded: false
        }
    },
    computed: {
        requirement() {
            return this.$store.getters['requirement/currentRequirement'];
        }
    },
    methods: {
        addStep() {
            let step = {
                comment: "",
                description: "",
                input: "",
                expected_result: "",
                is_passed: false
            }
            this.steps.push(step);
        },
        async submitTestCase() {
            try {

                const payload = {
                    test_case: this.testCase,
                    steps: this.steps
                }

                const params = this.isEditMode ? this.testCaseId : this.requirement.id;

                if (this.isEditMode) {
                    await requirementTestCaseRepository.update(params, payload)
                } else {
                    await requirementTestCaseRepository.store(params, payload);
                }

                location.reload();

            } catch (e) {
                console.log(e);
            } finally {

            }
        },
        async fetchTestCase() {
            // get test case with the requirement
            const response = await requirementTestCaseRepository.find(this.$route.params.testCase,
                'requirement,steps');
            await this.$store.dispatch('requirement/setRequirement', response.data.data.requirement_id);
            this.steps = _.get(response, 'data.data.relationships.steps', []);
            this.testCase = response.data.data;
            this.setItems();
            this.dataLoaded = true;
            console.log(this.testCase);
        },
        setItems() {
            this.items = [
                {
                    tab: 'Comments',
                    props: {
                        'test-case': this.testCase,
                        'is': 'comment-list',
                        'repository-type': 'test-case'
                    }
                },
                {
                    tab: 'History',
                    props: {
                        'is': 'histories-list',
                    }
                }
            ]

        }

    }

}
</script>

<style scoped>

</style>
