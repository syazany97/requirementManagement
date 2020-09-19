<template>
    <div class="container md:mx-auto sm:w-full py-2 overflow-y-auto">

        <h1 class="default-dialog-title">Add requirement</h1>

        <hr>

        <div class="bg-white px-4">

            <label class="primary-label" for="grid-name">
                Name
            </label>

            <input class="primary-input"
                   v-model="requirement.name"
                   id="grid-name" type="text" placeholder="Requirement A">
            <p v-if="errors.hasOwnProperty('name')" class="validation-error">{{ errors.name[0] }}</p>

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
            <p v-if="errors.hasOwnProperty('requirement_priority_id')" class="validation-error">{{ errors.requirement_priority_id[0] }}</p>

            <label class="primary-label" for="hours_to_complete">
                Hours to complete
            </label>

            <input v-model="requirement.hours_to_complete" type="number" class="primary-input" name="hours_to_complete"
                   id="hours_to_complete">
            <p v-if="errors.hasOwnProperty('hours_to_complete')" class="validation-error">{{ errors.hours_to_complete[0] }}</p>

                <label class="primary-label" for="grid-module-id">
                    Under which module
                </label>

                <vue-select
                    v-model="requirement.module_id"
                    id="grid-module-id"
                    class="primary-select"
                    :options="modules"
                    label="name"
                    :reduce="name => name.id"
                ></vue-select>

                <p v-if="errors.hasOwnProperty('module_id')" class="validation-error">{{ errors.module_id[0] }}</p>

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
            <p v-if="errors.hasOwnProperty('requirement_status_id')" class="validation-error">{{ errors.requirement_status_id[0] }}</p>


            <label class="primary-label" for="grid-description">
                Description
            </label>

            <quill-editor id="grid-description"
                          height="200"
                          v-model="requirement.description"
                          class="primary-rich-text">

            </quill-editor>
            <p v-if="errors.hasOwnProperty('description')" class="validation-error">{{ errors.description[0] }}</p>

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
            <p v-if="errors.hasOwnProperty('assignees')" class="validation-error">{{ errors.assignees[0] }}</p>

            <div class="inline-flex text-right pt-4 pb-5">
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

import requirementRepository from "../../../repositories/requirementRepository";
import vSelect from 'vue-select';
import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'
import {quillEditor} from 'vue-quill-editor'

export default {
    name: "CreateRequirementDialog",
    props: {
        requirementDialog: Boolean
    },
    components: {
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
            addingRequirement: false,
            errors: {
                name: [],
                description: [],
                assignees: [],
                requirement_status_id: [],
                requirement_priority_id: [],
                module_id: [],
                hours_to_complete: []
            }
        }
    },
    computed: {
        users() {
            return this.$store.getters['user/users'];
        },
        modules() {
            return this.$store.getters['requirement/requirementList']
                .filter(element => element.parent_id === null);
        },
        statuses() {
            return this.$store.getters['requirement/statuses'];
        },
        priorities() {
            return this.$store.getters['requirement/priorities'];
        },
    },
    created() {
        this.fetchUsers();
        this.fetchRequirementStatuses();
    },
    methods: {
        fetchUsers() {
            if (!this.$store.getters['users']) {
                this.$store.dispatch('user/setUsers');
            }
        },
        fetchRequirementStatuses() {

            if (!this.$store.getters['requirement/statuses'].length) {
                this.$store.dispatch('requirement/setRequirementStatuses');
            }

            if (!this.$store.getters['requirement/priorities'].length) {
                this.$store.dispatch('requirement/setPriorities');
            }
        },
        async addRequirement() {
            if (this.requirement.module_id === null) {
                console.log('adad error');
                this.errors.module_id.push('Please select a module');
            } else {
                try {
                    this.addingRequirement = true;
                    await requirementRepository.store(this.requirement.module_id, this.requirement);
                    await this.$store.dispatch('requirement/setRequirementList',
                        {project_id: this.$route.params.project});
                    this.closeDialog();
                } catch (e) {
                    console.log(e.response);

                    if (e.response.status === 422) {
                        this.errors = e.response.data.errors;
                    }

                } finally {
                    this.addingRequirement = false;
                }
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
