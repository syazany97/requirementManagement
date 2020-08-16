<template>

    <div class="container">
        <!-- create new module dialog -->
        <div class="text-right pb-2">
            <create-new-module></create-new-module>
        </div>
        <!-- // create new module dialog -->

        <div class="flex mb-4" v-if="modules.length">
            <div class="flex-none px-5">
                <requirement-list></requirement-list>
            </div>

            <div class="flex-none">
                <show-requirement></show-requirement>
            </div>
        </div>

    </div>

</template>

<script>
    import projectRepository from "../../repositories/projectRepository";
    import moduleRepository from "../../repositories/moduleRepository";

    export default {
        name: "Show",
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
