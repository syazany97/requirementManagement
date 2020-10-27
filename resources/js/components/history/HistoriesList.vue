<template>
    <div class="pt-3" v-if="histories.length">
        <div v-for="history in histories" v-bind:key="history.id">
            <span>{{ history.description }}</span>
            <span>{{ get(history, 'user', "") }}</span>
        </div>
    </div>

</template>
t
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
        },
        get(key, attributes, defaultValue) {
            return _.get(key, attributes, defaultValue);
        }
    }
}
</script>

<style scoped>

</style>
