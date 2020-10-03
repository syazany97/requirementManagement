<template>
    <div class="container mx-auto px-4" style="padding-bottom: 250px" v-if="requirement.id !== null && dataLoaded">
        <h1 class="h1">{{ requirement.name }}</h1>

        <button v-if="steps.length" class="btn btn-primary mt-2" @click="submitTestCase()">Submit</button>

        <label class="primary-label" for="test-case-title">
            Title
        </label>

        <input class="primary-input" v-model="testCase.title"
               id="test-case-title" type="text" placeholder="Title">

        <label class="primary-label" for="test-case-description">
            Description
        </label>


        <quill-editor v-model="testCase.description"
                      id="test-case-description" class="primary-rich-text">

        </quill-editor>

        <label class="primary-label" for="test-case-preconditions">
            Preconditions
        </label>

        <textarea class="primary-text-area" v-model="testCase.preconditions"
                  id="test-case-preconditions" type="text"></textarea>

        <button class="btn btn-primary" @click="addStep">Add step</button>

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
                <td class="border px-4 py-2">{{ step.order }}</td>
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

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <button
                                @click="addStep(index)"
                                class="p-1 ml-2 hover:text-blue-500 text-gray-700 border-2 border-transparent rounded-full hover:bg-blue-100 focus:outline-none"
                                aria-label="Add">
                                <svg class="w-6 h-6" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </button>
                        </div>
                        <!-- ... -->
                        <div>

                            <button
                                @click="removeStep(step)"
                                class="p-1 ml-2 hover:text-blue-500 text-gray-700 border-2 border-transparent rounded-full hover:bg-blue-100 focus:outline-none"
                                aria-label="Remove">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                </td>
            </tr>
            </tbody>
        </table>

        <div class="pt-5">

            <ul class="nav nav-pills">
                <li v-for="tab in items" class="nav-item">
                    <a :class="'nav-link ' +  (currentTab === tab.props.is ? 'active' : '')"
                       href="#" @click.prevent="currentTab = tab.props.is">{{ tab.tab }}</a>
                </li>
            </ul>

            <div v-for="tab in items" v-bind:key="tab.props.is">
                <component v-show="currentTab === tab.props.is" v-bind="tab.props"></component>
            </div>
        </div>

    </div>

</template>

<script>
import requirementTestCaseRepository from "../../repositories/requirement/requirementTestCaseRepository";
import {quillEditor} from 'vue-quill-editor'
import DefaultButton from "../../components/layouts/buttons/DefaultButton";

export default {
    name: "Create.vue",
    created() {
        if (this.$route.name !== 'test-case.create') {
            this.isEditMode = true;
            this.testCaseId = this.$route.params.testCase;
            this.fetchTestCase();
        } else {
            this.$store.dispatch('requirement/setRequirement', this.$route.params.requirement);
            this.dataLoaded = true;
        }
    },
    components: {
        DefaultButton,
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
        test() {
            console.log('test');
        },
        addStep(order = null) {
            let step = {
                comment: "",
                description: "",
                input: "",
                expected_result: "",
                is_passed: false
            }

            order === null ? this.steps.push(step) : this.steps.splice(order + 1, 0, step);

            this.updateSteps();
        },
        removeStep(step) {
            const indexStep = this.steps.findIndex(element => element.order === step.order);

            if (indexStep) {
                this.steps.splice(indexStep, 1);
            }

            this.updateSteps();

        },
        updateSteps() {
            for (let i = 0; i < this.steps.length; i++) {
                Vue.set(this.steps[i], 'order', i + 1);
            }
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
