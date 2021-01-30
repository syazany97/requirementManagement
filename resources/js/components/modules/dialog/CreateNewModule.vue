<template>
    <div class="mt-6">
        <primary-button @click="$modal.show('moduleDialog')" icon="M12 6v6m0 0v6m0-6h6m-6 0H6">
            <span>Add module</span>
        </primary-button>

        <secondary-button @click="$modal.show('requirementDialog')" icon="M12 6v6m0 0v6m0-6h6m-6 0H6">
            <span>Add requirement</span>
        </secondary-button>

        <modal name="requirementDialog" class="sm:w-full md:w-1/4" :adaptive="true" :scrollable="true" height="auto">
            <create-requirement-dialog :requirement-dialog.sync="requirementDialog"
                                       @close-requirement-dialog="closeRequirementDialog()"></create-requirement-dialog>
        </modal>

        <modal :shiftY="0.2" name="moduleDialog" @closed="$store.commit('error/setEmptyErrors')" height="auto">
            <div class="container mx-auto py-2 overflow-y-auto">
                <div class="py-2">
                    <span class="default-dialog-title">Create new module</span>
                </div>
                <hr>
                <div class="bg-white-100 px-4">

                    <label class="primary-label" for="moduleName">Module</label>

                    <primary-text v-model="moduleName" name="name" id="moduleName" placeholder="Name"/>

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
import {mapGetters} from "vuex";
import PrimaryText from "../../layouts/text/PrimaryText";
import PrimaryButton from "../../layouts/buttons/PrimaryButton";
import SecondaryButton from "../../layouts/buttons/SecondaryButton";

export default {
    components: {SecondaryButton, PrimaryButton, PrimaryText, CreateRequirementDialog},
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

