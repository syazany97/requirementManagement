<template>
    <v-dialog v-model="requirementDialog" max-width="400">
        <v-card>
            <v-container>
                <v-card-title class="headline">Create new requirement</v-card-title>

                <v-text-field label="Name" v-model="requirement.name"></v-text-field>

                <v-select
                    v-model="requirement.requirement_priority_id"
                    :items="priorities"
                    label="Priority"
                    item-text="name"
                    item-value="id"
                    persistent-hint
                ></v-select>

                <v-select
                    v-model="requirement.module_id"
                    :items="modules"
                    label="Under which module"
                    item-text="name"
                    item-value="id"
                    persistent-hint
                ></v-select>

                <v-select
                    v-model="requirement.requirement_status_id"
                    :items="statuses"
                    label="Status"
                    item-text="name"
                    item-value="id"
                    persistent-hint
                ></v-select>

                <v-textarea label="description" v-model="requirement.description"></v-textarea>

                <v-select
                    v-model="requirement.assignees"
                    :items="users"
                    label="Name"
                    item-text="name"
                    item-value="id"
                    multiple
                    chips
                    hint="Users assigned for this requirement"
                    persistent-hint
                ></v-select>

                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn
                        color="green darken-1"
                        text
                        @click="closeDialog()"
                    >
                        Cancel
                    </v-btn>

                    <v-btn
                        color="green darken-1"
                        text
                        @click="addRequirement"
                    >
                        Create
                    </v-btn>
                </v-card-actions>

            </v-container>
        </v-card>
    </v-dialog>
</template>

<script>

    import requirementRepository from "../../../repositories/requirementRepository";

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
                    module_id: null
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
                try {
                    await requirementRepository.store(this.requirement.module_id, this.requirement);
                    this.$store.dispatch('requirement/setRequirementList');
                    this.closeDialog();
                } catch (e) {
                    console.log(e);
                }
            },
            closeDialog() {
                this.requirement.name = '';
                this.requirement.description = '';
                this.requirement.assigned = [];
                this.$emit('update:requirementDialog', false)
            }
        },
    }
</script>

<style scoped>

</style>
