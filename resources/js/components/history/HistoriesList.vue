<template>
    <div class="pt-3" v-if="histories.length">
<!--        <div v-for="history in histories" v-bind:key="history.id">-->
<!--            <span>{{ history.description }}</span>-->
<!--            <span>{{ get(history, 'user', "") }}</span>-->
<!--        </div>-->

        <primary-table :headings="headings">
            <tr v-for="history in histories" :key="history.id">
                <td class="default-row">
                    <span class="text-gray-700 px-6 py-4 flex items-center">
                        {{history.description}}
                    </span>
                </td>
            </tr>


        </primary-table>


    </div>

</template>
t
<script>

import testCaseLogRepository from "../../repositories/testCase/logs/testCaseLogRepository";
import PrimaryTable from "../layouts/table/PrimaryTable";

export default {
    name: "HistoriesList",
    components: {PrimaryTable},
    data() {
        return {
            testCaseId: this.$route.params.testCase,
            histories: [],
            headings : ['description']
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
