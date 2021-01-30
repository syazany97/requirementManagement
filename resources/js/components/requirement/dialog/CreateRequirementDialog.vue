<template>
    <div class="container md:mx-auto sm:w-full py-2 overflow-y-auto">

        <div class="py-4">
            <span class="default-dialog-title">Add requirement</span>
        </div>

        <hr>

        <div class="bg-white px-4">
            <label class="primary-label" for="name">
                Name
            </label>

            <primary-text placeholder="Requirement A" name="name" id="name" v-model="requirement.name"/>

            <label class="primary-label" for="grid-priority">
                Priority
            </label>

            <vue-select :options="priorities"
                        class="primary-select"
                        v-model="requirement.requirement_priority_id"
                        id="grid-priority"
                        label="name"
                        :reduce="name => name.id">
            </vue-select>

            <error-message name="requirement_priority_id" />

            <label class="primary-label" for="requirement.hours_to_complete">
                Hours to complete
            </label>

            <primary-text id="requirement.hours_to_complete" v-model="requirement.hours_to_complete" type="number"
                          name="hours_to_complete"/>

            <label class="primary-label" for="module_id">
                Under which module
            </label>

            <vue-select
                v-model="requirement.module_id"
                id="module_id"
                class="primary-select"
                :options="modules"
                label="name"
                required
                :reduce="name => name.id"
            ></vue-select>

            <error-message name="module_id" />

            <label class="primary-label" for="grid-status">
                Status
            </label>

            <vue-select
                v-model="requirement.requirement_status_id"
                :options="statuses"
                class="primary-select"
                label="name"
                :reduce="name => name.id"
                id="grid-status"
            ></vue-select>

            <error-message name="requirement_status_id" />

            <label class="primary-label" for="description">
                Description
            </label>

            <quill-editor id="description"
                          height="200"
                          v-model="requirement.description"
                          :options="editorOptions"
                          class="primary-rich-text">
            </quill-editor>

            <error-message name="description" />

            <label class="primary-label" for="grid-assignees">
                Assignees
            </label>

            <vue-select
                v-model="requirement.assignees"
                id="grid-assignees"
                class="primary-select"
                :options="users"
                label="name"
                :reduce="name => name.id"
                multiple
            ></vue-select>

            <div class="modal-button-alignment">
                <button @click="closeDialog()" class="btn btn-tertiary pr-3">
                    <span>Cancel</span>
                </button>
                <div class="divider"></div>
                <button @click="addRequirement()" class="btn btn-primary">
                    <span>{{ addingRequirement ? 'Creating' : 'Create' }}</span>
                </button>
            </div>
        </div>

    </div>
</template>

<script>
import {editorOptions} from "../../../helper";

import requirementRepository from "../../../repositories/requirementRepository";
import vSelect from 'vue-select';
import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'
import {quillEditor} from 'vue-quill-editor'
import PrimaryText from "../../layouts/text/PrimaryText";
import ErrorMessage from "../../layouts/ErrorMessage";
import {mapGetters} from "vuex";

export default {
    name: "CreateRequirementDialog",
    props: {
        requirementDialog: Boolean,
        requirementProp: {
            type: Object,
            default: () => {}
        }
    },
    components: {
        ErrorMessage,
        PrimaryText,
        quillEditor
    },
    data() {
        return {
            requirement: {
                name: "",
                description: "",
                assignees: [],
                requirement_status_id: null,
                requirement_priority_id: null,
                module_id: null,
                hours_to_complete: 1
            },
            editorOptions,
            addingRequirement: false
        }
    },
    computed: {
        ...mapGetters(
            'requirement', [
                'requirementList', 'statuses', 'priorities'
            ]
        ),
        users() {
            return this.$store.getters['user/users'];
        },
        modules() {
            return this.requirementList.filter(x => x.parent_id === null);
        }
    },
    created() {
        if (this.requirementProp !== null && this.requirementProp !== undefined) {
            this.setRequirement();
        }
        this.fetchUsers();
        this.fetchRequirementStatuses();
    },
    methods: {
        fetchUsers() {
            if (!this.users.length) {
                this.$store.dispatch('user/setUsers');
            }
        },
        fetchRequirementStatuses() {
            if (!this.statuses.length) {
                this.$store.dispatch('requirement/setRequirementStatuses');
            }

            if (!this.priorities.length) {
                this.$store.dispatch('requirement/setPriorities');
            }
        },
        async addRequirement() {
            try {
                if (!this.requirement.module_id) {
                   return this.$store.commit('error/errors', {module_id: ['Please select a module']});
                }
                this.addingRequirement = true;
                await requirementRepository.store(this.requirement.module_id, this.requirement);
                await this.$store.dispatch('requirement/setRequirementList',
                    {project_id: this.$route.params.project});
                this.closeDialog();
                this.$store.commit("notification/showNotification", {variant: "success", message: "Requirement added"});
            } catch (e) {
                console.log(e);
            } finally {
                this.addingRequirement = false;
            }
        },
        async setRequirement() {
            try {
                const response = await requirementRepository.find(this.requirementProp.id);
                this.requirement = response.data.data;

            } catch (e) {
                console.log('error', e);
            }
        },
        closeDialog() {
            this.requirement.name = "";
            this.requirement.description = "";
            this.requirement.assignees = [];
            this.requirement.requirement_status_id = null;
            this.requirement.requirement_priority_id = null;
            this.requirement.module_id = null;
            this.$emit('close-requirement-dialog')
        }
    },
}
</script>

<style scoped>

</style>
