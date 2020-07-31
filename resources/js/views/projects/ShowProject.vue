<template>

    <v-container fluid>
        <!-- create new module dialog -->
        <div class="text-right">
            <create-new-module></create-new-module>
        </div>
        <!-- // create new module dialog -->

        <v-row v-if="modules.length">
            <v-col
                cols="6"
                md="4"
            >
                <requirement-list></requirement-list>

            </v-col>
            <v-col
                cols="12"
                md="8"
            >
                <show-requirement></show-requirement>
            </v-col>
        </v-row>

    </v-container>

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
