<template>
    <div>

        <button @click="$modal.show('moduleDialog')"
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

        <modal name="requirementDialog" :adaptive="true" width="50%" :scrollable="true" height="auto">
            <create-requirement-dialog :requirement-dialog.sync="requirementDialog"></create-requirement-dialog>
        </modal>

        <modal name="moduleDialog">
            <div class="container mx-auto">
                <h1>Create new module</h1>

                <label class="primary-label" for="moduleName">Module</label>

                <input class="primary-input"
                       v-model="moduleName"
                       id="moduleName" type="text" placeholder="Name">

                <div class="inline-flex text-right pt-4">
                    <button @click="$modal.hide('moduleDialog')" class="tertiary-btn pr-3">
                        <span>Cancel</span>
                    </button>
                    <div class="divider"></div>
                    <button @click="addModule()" class="primary-btn">
                        <span>Create</span>
                    </button>
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
