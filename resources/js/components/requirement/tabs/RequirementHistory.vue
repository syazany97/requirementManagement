<template>
    <!--<h1>Requirement History</h1>-->
    <div>
<!--        <span v-for="history in histories" :key="history.id">{{ history.causer.name + ' ' + history.description }}</span>-->
        <primary-table :headings="headings">
            <tr v-for="(history, index) in histories" :key="history.id">
                <td class="default-row">
                    <span class="text-gray-700 px-6 py-4 flex items-center">
                        {{index}}
                    </span>
                </td>
                <td class="default-row">
                    <span class="text-gray-700 px-6 py-4 flex items-center">
                        {{history.causer.name + ' ' + history.description}}
                    </span>
                </td>
                <td class="default-row">
                    <span class="text-gray-700 px-6 py-4 flex items-center">
                        {{dayjs(history.created_at)}}
                    </span>
                </td>
            </tr>
        </primary-table>
    </div>
</template>

<script>
import requirementHistoryRepository from "../../../repositories/history/requirementHistoryRepository";
import PrimaryTable from "../../layouts/table/PrimaryTable";
import dayjs from "dayjs";
export default {
    name: "RequirementHistory",
    components: {PrimaryTable},
    props: {
        historyType: {
            type: String,
            default: 'requirement'
        },
        objectId: {
            type: Number,
            default: null
        }
    },
    data() {
        return {
            histories: [],
            headings : ['description', 'time']
        }
    },
    created() {
        this.fetchHistories();
    },
    watch: {
        objectId() {
            this.fetchHistories();
        }
    },
    methods: {
        async fetchHistories() {
            if (this.objectId === null) return;

            if (this.historyType === 'requirement') {
                const response = await requirementHistoryRepository.all(this.objectId);
                this.histories = response.data.data;
                console.log('histories', this.histories);
            }
        },
        dayjs(val) {
            return dayjs(val);
        }
    }
}
</script>

<style scoped>

</style>
