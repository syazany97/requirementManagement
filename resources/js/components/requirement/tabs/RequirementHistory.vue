<template>
    <!--<h1>Requirement History</h1>-->
    <div>
        <span v-for="history in histories" :key="history.id">{{ history.causer.name + ' ' + history.description }}</span>

    </div>
</template>

<script>
import requirementHistoryRepository from "../../../repositories/history/requirementHistoryRepository";

export default {
    name: "RequirementHistory",
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
            histories: []
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
        }
    }
}
</script>

<style scoped>

</style>
