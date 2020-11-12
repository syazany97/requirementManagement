<template>

    <div class="container mx-auto">
        <div class="flex justify-between">
            <div>
                <h1>{{ project.name }}</h1>
            </div>
            <create-new-module></create-new-module>

        </div>
        <hr>


        <!-- create new module dialog -->
        <!--        <div class="text-right pb-2 mt-2">-->

        <!--        </div>-->
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

const qs = require('qs');

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
        this.setProject();
        this.setQueryParameter();
    },
    computed: {
        modules() {
            return this.$store.getters['requirement/requirementList'];
        }
    },
    methods: {
        async setProject() {
            const response = await projectRepository.find(this.projectId);
            this.project = response.data.data;
        },
        setQueryParameter() {
            if (this.$route.query.requirement) {
                // if there is a query parameter on url then set display it
                this.$store.dispatch('requirement/setRequirement', this.$route.query.requirement);
            }

            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);

            console.log({urlParams});
            console.log('qs', qs.parse(window.location.search));



        }
    }
}
</script>

<style scoped>


</style>
