<template>
    <div v-if="histories.length">
        <h1>Histories List</h1>
        <div v-for="history in histories" v-bind:key="history.id">
            <span>{{ history.description }}</span>
            <span>{{ get(history, 'user', "") }}</span>
        </div>

        <button class="primary-btn" @click="modal.visible = !modal.visible">Open Modal</button>

        <div class="h-screen w-full flex flex-col items-center justify-center bg-teal-lightest font-sans">
            <div v-if="modal.visible" @click.self="modal.visible = false" class="h-screen w-full absolute flex items-center justify-center bg-modal">
                <div class="bg-white rounded shadow p-8 m-4 max-w-xs max-h-full text-center overflow-y-scroll">
                    <div class="mb-4">
                        <h1>Welcome!</h1>
                    </div>
                    <div class="mb-8">
                        <p>Ready to get started? Keep scrolling to see some great components.</p>
                    </div>
                    <div class="flex justify-center">
                        <button class="flex-no-shrink text-white py-2 px-4 rounded bg-teal hover:bg-teal-dark">Let's Go</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

</template>

<script>

import testCaseLogRepository from "../../repositories/testCase/logs/testCaseLogRepository";

export default {
    name: "HistoriesList",
    data() {
        return {
            testCaseId: this.$route.params.testCase,
            histories: [],
            modal : {
                visible : false
            }
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
