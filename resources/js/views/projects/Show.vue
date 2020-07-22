<template>
    <v-container>
        <h1>Show project</h1>
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
                <v-card
                    class="pa-2"
                    outlined
                    tile
                >
                    .col-6 .col-md-4
                </v-card>
            </v-col>
        </v-row>

    </v-container>

</template>

<script>
    import projectRepository from "../../repositories/projectRepository";

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
                const response = await projectRepository.find(this.projectId);
                console.log(response.data);
                this.project = response.data.data;
                this.modules = response.data.data.modules;
                this.loaded = true;
            }
        }
    }
</script>

<style scoped>

</style>
