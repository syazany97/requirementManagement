<template>
    <v-card>
        <v-card-title class="headline">New Project</v-card-title>

        <v-card-text>
            <v-form
                ref="form"
                v-model="valid"
                lazy-validation
            >
                <v-text-field
                    v-model="projectName"
                    label="Name"
                    required
                ></v-text-field>

                <v-text-field
                    v-model="projectDescription"
                ></v-text-field>
            </v-form>
        </v-card-text>

        <v-card-actions>
            <v-spacer></v-spacer>

            <v-btn
                color="primary"
                @click="dialog = false"
            >
                Cancel
            </v-btn>

            <v-btn
                color="primary"
                @click="submit()"
            >
                Create
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
    export default {
        name: "CreateProjectDialog",
        data() {
            return {
                valid : true,
                projectName : "",
                projectDescription : ""
            }
        },
        methods : {
            submit() {
                console.log(this.projectName);
            }
        }
    }
</script>

<style scoped>

</style>
