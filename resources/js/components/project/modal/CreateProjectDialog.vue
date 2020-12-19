<template>
        <div class="container mx-auto py-2 overflow-y-auto">

            <div class="py-2">
                <span class="default-dialog-title">{{ updateProject ? 'Update project' : 'Create new project' }}</span>
            </div>

            <hr>

            <div class="bg-white px-4">
                <label class="primary-label" for="projectName">
                    Name
                </label>

                <input class="primary-input"
                       v-model="projectName"
                       id="projectName" name="projectName"
                       type="text" placeholder="Name">

                <p v-if="errors.hasOwnProperty('name')" class="error-message">
                    {{ errors.name[0] }}</p>

                <label class="primary-label" for="projectDescription">
                    Description
                </label>

                <textarea class="primary-input"
                          v-model="projectDescription"
                          id="projectDescription" name="projectDescription"
                          type="text" placeholder="Description" ></textarea>

                <p v-if="errors.hasOwnProperty('description')" class="error-message">
                    {{ errors.description[0] }}</p>

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

                <p v-if="errors.hasOwnProperty('project_status_id')" class="error-message">
                    {{ errors.project_status_id[0] }}</p>

                <div class="modal-button-alignment">
                    <button @click="closeDialog" class="btn btn-tertiary pr-3">
                        <span>Cancel</span>
                    </button>
                    <div class="divider"></div>
                    <button @click="createProject()" class="btn btn-primary">
                        <span>{{ updateProject ? 'Update' : 'Create' }}</span>
                    </button>
                </div>
            </div>
        </div>
</template>

<script>
import projectRepository from "../../../repositories/projectRepository";

export default {
    name: "CreateProjectDialog",
    props: {
        updateProject: {
            type: Boolean,
            default: false
        },
        project: {
            type: Object
        }
    },
    data() {
        return {
            // TODO : fix removal of id when update to signal is update mode
            valid: true,
            projectName: this.updateProject ? this.project.name : "",
            projectDescription: this.updateProject ? this.project.description : "",
            projectStatusId:  this.updateProject ? this.project.project_status_id : "",
            projectStatuses: [],
            errors: []
        }
    },
    created() {
        this.fetchProjectStatuses()
    },
    methods: {
        async createProject() {
            try {
                const payload = {
                    name: this.projectName,
                    description: this.projectDescription,
                    project_status_id: this.projectStatusId
                };

                if (this.updateProject) {
                    projectRepository.update(this.project.id, payload);
                } else {
                    projectRepository.store(payload);
                }

                this.projectName = "";
                this.projectStatusId = "";
                this.projectDescription = "";
                await this.$emit('fetchProjects');
                this.$store.commit("notification/showNotification", {
                    variant: "success",
                    message: "Project " + (this.updateProject ? 'Updated' : 'Created')
                });
                this.$emit('reset-project');
                this.closeDialog();
            } catch (err) {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
            }
        },
        closeDialog() {
            this.$modal.hide('modalProjectDialog');
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
