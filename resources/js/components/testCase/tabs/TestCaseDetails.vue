<template>

    <div>
        <div class="text-right">
            <button @click="redirectToTestCasePage()" class="primary-btn">
                <svg fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                          d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                          clip-rule="evenodd"></path>
                </svg>
                <span>New test case</span>
            </button>
        </div>

        <table v-if="testCases.length" class="table-auto">
            <thead>
            <tr>
                <th class="px-4 py-2">No</th>
                <th class="px-4 py-2">Title</th>
                <th class="px-4 py-2">User</th>
                <th class="px-4 py-2">Created</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(test, index) in testCases" v-bind:key="test.id" :class="index % 0 === 0 ? 'bg-gray-100' : ''">
                <td class="border px-4 py-2">{{index + 1}}</td>
                <td class="border px-4 py-2">{{test.description}}</td>
                <td class="border px-4 py-2">{{test.user.name}}</td>
                <td class="border px-4 py-2">{{test.created_at | formatDateTime}}</td>
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
            testCases: []
        }
    },
    created() {
        this.fetchTestCases();
    },
    methods: {
        async fetchTestCases() {
            const response = await requirementTestCaseRepository.all(this.$store.getters['requirement/currentRequirement'].id);
            this.testCases = response.data.data;
            console.log(response.data.data);
        },
        redirectToTestCasePage() {
            this.$router.push({ name: 'test-case.create', params: { requirement:
                    this.$store.getters['requirement/currentRequirement'].id } })
        }
    }
}
</script>

<style scoped>

</style>
