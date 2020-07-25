<template>
    <v-dialog v-model="requirementDialog" max-width="400">
        <v-card>
            <v-container>
                <v-card-title class="headline">Create new requirement</v-card-title>

                <v-text-field label="Name" v-model="requirement.name"></v-text-field>

                <v-select
                    v-model="requirement.module_id"
                    :items="modules"
                    label="Under which module"
                    item-text="name"
                    item-value="id"
                    persistent-hint
                ></v-select>

                <v-textarea label="description" v-model="requirement.description"></v-textarea>

                <v-select
                    v-model="requirement.assigned"
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
                    assigned: []
                }
            }
        },
        computed: {
            users() {
                return this.$store.getters['user/users'];
            },
            modules() {
                let modules = this.$store.getters['requirementList/requirementList'];

                return modules.filter(element => element.parent_id === null);
            }
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

            },
            addRequirement() {

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
