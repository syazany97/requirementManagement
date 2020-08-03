<template>
    <v-container v-if="requirement.id !== null">
        <h1>{{ requirement.name }}</h1>

        <label class="primary-label" for="test-case-title">
            Title
        </label>

        <input class="primary-input" v-model="testCase.title"
               id="test-case-title" type="text" placeholder="Title">

        <label class="primary-label" for="test-case-description">
            Description
        </label>

        <textarea class="primary-input" v-model="testCase.description"
                  id="test-case-description" type="text"></textarea>

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

        <button v-if="steps.length" class="primary-btn" @click="submitTestCase()">Submit</button>

    </v-container>

</template>

<script>
import requirementTestCaseRepository from "../../repositories/requirement/requirementTestCaseRepository";

export default {
    name: "Create.vue",
    created() {
        this.$store.dispatch('requirement/setRequirement', this.$route.params.requirement);
    },
    data() {
        return {
            steps: [],
            testPassedOptions: [{
                'label': 'Yes',
                'value': true
            }, {
                'label': 'No',
                'value': false
            }],
            testCase: {
                title: "",
                description: "",
                preconditions: ""
            }
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
                'comment': "",
                'description': "",
                'input': "",
                'expected_result': "",
                'is_pass': false
            }
            this.steps.push(step);
        },
        async submitTestCase() {
            try {
                await requirementTestCaseRepository.store(this.requirement.id, {
                    test_case: this.testCase,
                    steps: this.steps
                });
            } catch (e) {
                console.log(e);
            } finally {

            }
        }

    }
}
</script>

<style scoped>

</style>
