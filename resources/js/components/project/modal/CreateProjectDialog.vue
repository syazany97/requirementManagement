<template>
    <v-card>
        <v-card-title class="headline">New Project</v-card-title>

        <v-card-text>
            <v-form
                ref="form"
                v-model="valid"
                lazy-validation
            >
                <v-text-field
                    v-model="projectName"
                    label="Name"
                    required
                ></v-text-field>

                <v-text-field
                    v-model="projectDescription"
                ></v-text-field>

                <v-select
                    v-model="projectStatusId"
                    :items="projectStatuses"
                    item-text="title"
                    item-value="id"
                    label="Standard"
                ></v-select>
            </v-form>
        </v-card-text>

        <v-card-actions>
            <v-spacer></v-spacer>

            <v-btn
                color="primary"
                @click="dialog = false"
            >
                Cancel
            </v-btn>

            <v-btn
                color="primary"
                @click="createProject()"
            >
                Create
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
    import projectRepository from "../../../repositories/projectRepository";
    export default {
        name: "CreateProjectDialog",
        data() {
            return {
                valid: true,
                projectName: "",
                projectDescription: "",
                projectStatusId : "",
                projectStatuses : []
            }
        },
        created() {
            this.fetchProjectStatuses()
        },
        methods: {
            createProject() {
                projectRepository.store({
                    name : this.projectName,
                    description : this.projectDescription,
                    project_status_id : this.projectStatusId
                }).then(res => {
                    this.$emit('fetch-projects', 'fetchProjects');
                    this.projectName = "";
                    this.projectStatusId = "";
                    this.projectDescription = "";
                    const payload = {
                        variant: "success",
                        message: "Project Created"
                    };
                    this.$store.commit("notification/showNotification", payload);
                }).catch(err => {
                    console.log(err.response.data.errors);
                })
            },
            async fetchProjectStatuses() {
                const response = await projectRepository.getProjectStatuses();
                this.projectStatuses = response.data;
            }
        },
    }
</script>

<style scoped>

</style>
