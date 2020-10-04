<template>
    <div class="mt-6">
        <button @click="$modal.show('moduleDialog')"
                class="btn btn-primary">
            <svg fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                      d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                      clip-rule="evenodd"></path>
            </svg>
            <span>Add module</span>
        </button>

        <button @click.stop="$modal.show('requirementDialog')" class="btn btn-secondary">
            <svg fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                      d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                      clip-rule="evenodd"></path>
            </svg>
            <span>Add requirement</span>
        </button>

        <modal name="requirementDialog" class="sm:w-full md:w-1/4" :adaptive="true" :scrollable="true" height="auto">
            <create-requirement-dialog :requirement-dialog.sync="requirementDialog"
                                       @close-requirement-dialog="closeRequirementDialog()" ></create-requirement-dialog>
        </modal>

        <modal :shiftY="0.2" name="moduleDialog" height="auto">
            <div class="container mx-auto py-2 overflow-y-auto">
                <h1 class="default-dialog-title">Create new module</h1>
                <hr>
                <div class="bg-white-100 px-4">

                    <label class="primary-label" for="moduleName">Module</label>

                    <input class="primary-input"
                           v-model="moduleName"
                           id="moduleName" type="text" placeholder="Name">

                    <div class="modal-button-alignment">
                        <button @click="$modal.hide('moduleDialog')" class="btn btn-tertiary pr-3">
                            <span>Cancel</span>
                        </button>
                        <div class="divider"></div>
                        <button @click="addModule()" class="btn btn-primary">
                            <span>{{ adding ? 'Creating' : 'Create' }}</span>
                        </button>
                    </div>
                </div>

            </div>

        </modal>


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
            testDialog: false,
            adding: false
        }
    },
    methods: {
        async addModule() {
            try {
                this.adding = true;
                await moduleRepository.store(this.$route.params.project, {
                    name: this.moduleName
                })
                await this.$store.dispatch('requirement/setRequirementList',
                    {project_id: this.$route.params.project});
                this.adding = false;
                this.moduleName = "";
                this.$modal.hide('moduleDialog')
            } catch (e) {
                console.log(e);
            }
        },
        closeRequirementDialog() {
            this.$modal.hide('requirementDialog');
        }
    }
}
</script>

