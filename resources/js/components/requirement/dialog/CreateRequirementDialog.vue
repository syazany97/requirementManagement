<template>
    <v-card>
        <v-container>

            <v-card-title class="headline">Create new requirement</v-card-title>

            <br>

            <label class="primary-label" for="grid-name">
                Name
            </label>

            <input class="primary-input"
                   v-model="requirement.name"
                   id="grid-name" type="text" placeholder="Name">

            <label class="primary-label" for="grid-priority">
                Priority
            </label>

            <vue-select :options="priorities"
                        v-model="requirement.requirement_priority_id"
                        id="grid-priority"
                        label="name"
                        :reduce="name => name.id">
            </vue-select>

            <label class="primary-label" for="grid-module-id">
                Under which module
            </label>

            <vue-select
                v-model="requirement.module_id"
                id="grid-module-id"
                :options="modules"
                label="name"
                :reduce="name => name.id"
            ></vue-select>

            <label class="primary-label" for="grid-status">
                Status
            </label>

            <vue-select
                v-model="requirement.requirement_status_id"
                :options="statuses"
                label="name"
                :reduce="name => name.id"
                id="grid-status"
            ></vue-select>


            <label class="primary-label" for="grid-description">
                Description
            </label>

            <div class="description">
                <textarea id="grid-description"
                          v-model="requirement.description"
                          class="primary-text-area text-input">

                </textarea>
            </div>

            <label class="primary-label" for="grid-assignees">
                Assignees
            </label>

            <vue-select
                v-model="requirement.assignees"
                id="grid-assignees"
                :options="users"
                label="name"
                :reduce="name => name.id"
                multiple
            ></vue-select>

            <v-card-actions>
                <v-spacer></v-spacer>

                <button @click="closeDialog()" class="secondary-btn">
                    <span>Cancel</span>
                </button>
                <div class="divider"></div>
                <button @click="addRequirement()" class="primary-btn">
                    <span>{{addingRequirement ? 'Creating' : 'Create'}}</span>
                </button>

            </v-card-actions>

        </v-container>
    </v-card>
</template>

<script>

    import requirementRepository from "../../../repositories/requirementRepository";
    import vSelect from 'vue-select';

    export default {
        name: "CreateRequirementDialog",
        props: {
            requirementDialog: Boolean
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
                },
                addingRequirement: false
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
                try {
                    this.addingRequirement = true;
                    await requirementRepository.store(this.requirement.module_id, this.requirement);
                    this.$store.dispatch('requirement/setRequirementList');
                    this.closeDialog();
                } catch (e) {
                    console.log(e);
                } finally {
                    this.addingRequirement = false;
                }
            },
            closeDialog() {
                this.requirement.name = "";
                this.requirement.description = "";
                this.requirement.assignees = [];
                this.requirement.requirement_status_id = null;
                this.requirement.requirement_priority_id = null;
                this.requirement.module_id = null;
                this.$emit('update:requirementDialog', false)
            }
        },
    }
</script>

<style scoped>

</style>
