<template>
    <div class="container mx-auto px-4 py-4 overflow-y-auto">

        <h1 class="headline text-left">Create new project</h1>

        <label class="primary-label" for="projectName">
            Name
        </label>

        <input class="primary-input"
               v-model="projectName"
               id="projectName" name="projectName"
               type="text" placeholder="Name">

        <label class="primary-label" for="projectDescription">
            Description
        </label>

        <input class="primary-input"
               v-model="projectDescription"
               id="projectDescription" name="projectDescription"
               type="text" placeholder="Description">

        <label class="primary-label" for="projectStatus">
            Project Status
        </label>

        <vue-select
            v-model="projectStatusId"
            name="projectStatus"
            id="projectStatus"
            :options="projectStatuses"
            label="title"
            :reduce="title => title.id"
        ></vue-select>

        <div class="inline-flex text-right pt-4">
            <button @click="dialog = false" class="btn-tertiary pr-3">
                <span>Cancel</span>
            </button>
            <div class="divider"></div>
            <button @click="createProject()" class="btn-primary">
                <span>Create</span>
            </button>
        </div>
    </div>
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
                projectStatusId: "",
                projectStatuses: []
            }
        },
        created() {
            this.fetchProjectStatuses()
        },
        methods: {
            createProject() {
                projectRepository.store({
                    name: this.projectName,
                    description: this.projectDescription,
                    project_status_id: this.projectStatusId
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
