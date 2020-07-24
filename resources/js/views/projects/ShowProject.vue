<template>

    <v-container fluid>
        <!-- create new module dialog -->
        <div class="text-right">
            <create-new-module></create-new-module>
        </div>
        <!-- // create new module dialog -->

        <v-row v-if="loaded">
            <v-col
                cols="6"
                md="4"
            >
                <requirement-list :modules="modules"></requirement-list>

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
                modules: [],
                requirements: [],
                loaded : false
            }
        },
        created() {
            this.setProject();
        },
        methods: {
            async setProject() {
                const response = await moduleRepository.all(this.projectId);
                console.log(response.data);
                // this.project = response.data.data;
                this.modules = response.data.data;
                this.loaded = true;
            }
        }
    }
</script>

<style scoped>

</style>
