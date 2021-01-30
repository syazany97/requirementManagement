<template>
        <div class="container mx-auto py-2 overflow-y-auto">

            <div class="py-2">
                <span class="default-dialog-title">{{ updateProject ? 'Update project' : 'Create new project' }}</span>
            </div>

            <hr>

            <div class="bg-white px-4">
                <label class="primary-label" for="name">
                    Name
                </label>

                <primary-text  v-model="name"
                                id="name" name="name"
                                type="text" placeholder="Name"/>

                <label class="primary-label" for="description">
                    Description
                </label>

                <primary-text-area v-model="description"  id="description" name="description"
                                    type="text" placeholder="Description" />

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

                <error-message name="project_status_id"/>

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
import PrimaryText from "../../layouts/text/PrimaryText";
import ErrorMessage from "../../layouts/ErrorMessage";
import PrimaryTextArea from "../../layouts/text/PrimaryTextArea";

export default {
    name: "CreateProjectDialog",
    components: {PrimaryTextArea, ErrorMessage, PrimaryText},
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
            name: this.updateProject ? this.project.name : "",
            description: this.updateProject ? this.project.description : "",
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
                    name: this.name,
                    description: this.description,
                    project_status_id: this.projectStatusId
                };

                if (this.updateProject) {
                    await projectRepository.update(this.project.id, payload);
                } else {
                    await projectRepository.store(payload);
                }

                this.name = "";
                this.projectStatusId = "";
                this.description = "";
                await this.$emit('fetchProjects');
                this.$store.commit("notification/showNotification", {
                    variant: "success",
                    message: "Project " + (this.updateProject ? 'Updated' : 'Created')
                });
                this.$emit('reset-project');
                this.closeDialog();
            } catch (err) {
                console.log({err});
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
