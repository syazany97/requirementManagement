<template>
    <div>
        <button @click.stop="dialog = true"
                class="primary-btn">
            <svg fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                      d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                      clip-rule="evenodd"></path>
            </svg>
            <span>Add module</span>
        </button>

        <button @click.stop="$modal.show('requirementDialog')" class="secondary-btn">
            <svg fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                      d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                      clip-rule="evenodd"></path>
            </svg>
            <span>Add requirement</span>
        </button>

        <button @click.stop="testDialog = !testDialog" class="secondary-btn">
            <svg fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                      d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                      clip-rule="evenodd"></path>
            </svg>
            <span>Test dialog</span>
        </button>

                <v-dialog v-model="testDialog">
            <test-dialog></test-dialog>
        </v-dialog>

       <modal name="requirementDialog" :adaptive="true"  width="50%" :scrollable="true" height="auto">
           <create-requirement-dialog :requirement-dialog.sync="requirementDialog"></create-requirement-dialog>
       </modal>

        <v-dialog
            v-model="dialog"
            max-width="400"
        >
            <v-card>
                <v-container>
                    <v-card-title class="headline">Create new module</v-card-title>

                    <v-text-field label="Name" v-model="moduleName"></v-text-field>

                    <v-card-actions>
                        <v-spacer></v-spacer>

                        <v-btn
                            color="green darken-1"
                            text
                            @click="moduleName = '';dialog = false"
                        >
                            Cancel
                        </v-btn>

                        <v-btn
                            color="green darken-1"
                            text
                            @click="addModule()"
                        >
                            Create
                        </v-btn>
                    </v-card-actions>
                </v-container>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    import moduleRepository from "../../../repositories/moduleRepository";
    import CreateRequirementDialog from "../../requirement/dialog/CreateRequirementDialog";

    export default {
        components: {CreateRequirementDialog},
        props: {
            module: {
                type: Object,
                default: null
            }
        },
        data() {
            return {
                dialog: false,
                moduleName: "",
                requirementDialog: false,
                requirement: {
                    name: "",
                    assigned: [],
                    description: ""
                },
                testDialog: false
            }
        },
        methods: {
            async addModule() {
                try {
                    await moduleRepository.store(this.$route.params.project, {
                        name: this.moduleName
                    })

                    this.$store.dispatch('requirement/setRequirementList',
                        {project_id: this.$route.params.project});

                    this.moduleName = "";

                    this.dialog = false;


                } catch (e) {
                    console.log(e);
                }

            }
        }
    }
</script>

<style scoped>
    .btn {
        @apply font-bold py-2 px-4 rounded;
    }

    .btn-blue {
        @apply bg-blue-500 text-white;
    }

    .btn-blue:hover {
        @apply bg-blue-700;
    }

</style>
