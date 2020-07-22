<template>
    <v-container>
        <h1>Show project</h1>
        <v-row>
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
            }
        },
        created() {
            this.setProject();
        },
        methods: {
            async setProject() {
                const response = await projectRepository.find(this.projectId)
                this.project = response.data.data.project;

                console.log(response.data);

            }
        }
    }
</script>

<style scoped>

</style>
