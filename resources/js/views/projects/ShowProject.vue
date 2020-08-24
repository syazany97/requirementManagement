<template>

    <div class="container mx-auto">
        <!-- create new module dialog -->
        <div class="text-right pb-2 mt-2">
            <create-new-module></create-new-module>
        </div>
        <!-- // create new module dialog -->
        <div class="md:flex mb-4" v-if="modules.length">
            <div class="flex-none w-1/3 px-5">
                <requirement-list></requirement-list>
            </div>

            <div class="flex-none w-2/3">
                <show-requirement></show-requirement>
            </div>
        </div>
    </div>

</template>

<script>
import projectRepository from "../../repositories/projectRepository";
import moduleRepository from "../../repositories/moduleRepository";
import RequirementList from "../../components/requirement/RequirementList";
import ShowRequirement from "../../components/requirement/ShowRequirement";

export default {
    name: "Show",
    components: {RequirementList, ShowRequirement},
    data() {
        return {
            projectId: this.$route.params.project,
            project: {},
            requirements: [],
            loaded: false
        }
    },
    created() {
        this.$store.dispatch('requirement/setRequirementList',
            {project_id: this.projectId});
        this.setQueryParameter();
    },
    computed: {
        modules() {
            return this.$store.getters['requirement/requirementList'];
        }
    },
    methods: {
        setQueryParameter() {
            if (this.$route.query.requirement) {
                // if there is a query parameter on url then set display it
                this.$store.dispatch('requirement/setRequirement', this.$route.query.requirement);
            }
        }
    }
}
</script>

<style scoped>


</style>
