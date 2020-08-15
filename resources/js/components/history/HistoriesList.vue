<template>
    <div v-if="histories.length">
        <h1>Histories List</h1>
        <span v-for="history in histories" v-bind:key="history.id">{{ history }}</span>
    </div>

</template>

<script>

import testCaseLogRepository from "../../repositories/testCase/logs/testCaseLogRepository";

export default {
    name: "HistoriesList",
    data() {
        return {
            testCaseId: this.$route.params.testCase,
            histories: []
        }
    },
    created() {
        this.fetchLogs();
    },
    methods: {
        async fetchLogs() {
            const response = await testCaseLogRepository.all(this.testCaseId);
            this.histories = response.data.data;
            console.log(response);
        }
    }
}
</script>

<style scoped>

</style>
