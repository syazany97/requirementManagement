<template>
    <div>

        <v-btn
            small
            color="primary"
            dark
            @click.stop="dialog = true"
        >
            <v-icon>mdi-plus</v-icon>
            Module
        </v-btn>

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
                            @click="dialog = false"
                        >
                            Cancel
                        </v-btn>

                        <v-btn
                            color="green darken-1"
                            text
                            @click="addModule"
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

    export default {
        props: {
            module: {
                type: Object,
                default: null
            }
        },
        data() {
            return {
                dialog: false,
                moduleName: ""
            }
        },
        methods: {
            async addModule() {
                try {
                    const response = await moduleRepository.store(this.$route.params.project, {
                        name: this.moduleName
                    })

                    this.dialog = false;

                } catch (e) {
                    console.log(e);
                }

            }
        }
    }
</script>

<style scoped>

</style>
