<template>

    <div>
        <div class="text-right">
            <button @click="redirectToTestCasePage()" class="btn btn-primary btn-icon">

                <svg viewBox="0 0 20 20" fill="currentColor" class="plus w-6 h-6">
                    <path fill-rule="evenodd"
                          d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                          clip-rule="evenodd">
                    </path>
                </svg>

                <span>Create test case</span>
            </button>
        </div>

        <table v-if="testCases.length" class="cursor-pointer hover:bg-gray-200 mt-4">
            <thead>
            <tr>
                <th v-for="heading in headings" class="default-header">{{heading}}</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(test, index) in testCases" v-bind:key="test.id" :class="index % 0 === 0 ? 'bg-gray-100' : ''">
                <td class="default-row">{{ index + 1 }}</td>
                <td class="default-row" v-html="test.description">a</td>
                <td class="default-row">{{ test.user.name }}</td>
                <td class="default-row">{{ test.created_at | formatDateTime }}</td>
                <td class="default-row">
                    <router-link :to="{name : 'test-case.edit' ,params : {testCase : test.id}}"
                                 tag="button" class="btn btn-primary">View
                    </router-link>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import requirementTestCaseRepository from "../../../repositories/requirement/requirementTestCaseRepository";

export default {
    name: "TestCaseDetails",
    data() {
        return {
            testCases: [],
            headings: [
                'No', 'Title', 'User', 'Created', 'Action'
            ]
        }
    },
    created() {
        if (this.requirement.id !== null) this.fetchTestCases()
    },
    computed: {
        requirement() {
            return this.$store.getters['requirement/currentRequirement'];
        }
    },
    watch: {
        requirement() {
            if (this.requirement.id !== null) {
                this.fetchTestCases();
            }
        }
    },
    methods: {
        async fetchTestCases() {
            const response = await requirementTestCaseRepository.all(this.$store.getters['requirement/currentRequirement'].id);
            this.testCases = response.data.data;
        },
        redirectToTestCasePage() {
            this.$router.push({
                name: 'test-case.create', params: {
                    requirement:
                    this.$store.getters['requirement/currentRequirement'].id
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
