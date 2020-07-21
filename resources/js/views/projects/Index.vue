<template>
    <div>
        <h1>Projects</h1>
        <v-col class="text-end">
            <v-btn @click.stop="projectDialog = true" color="primary" small>
                <v-icon left dark>mdi-plus</v-icon>New project
            </v-btn>
            <v-dialog
                v-model="projectDialog"
                max-width="500"
            >
                <create-project-dialog></create-project-dialog>
            </v-dialog>

        </v-col>
        <div>
            <v-simple-table
                :dense="dense"
                :fixed-header="fixedHeader"
                :height="height"
            >
                <template v-slot:default>
                    <thead>
                    <tr>
                        <th class="text-left">Number</th>
                        <th class="text-left">Name</th>
                        <th class="text-left">Description</th>
                        <th class="text-left">No of modules</th>
                        <th class="text-left">Owner</th>
                    </tr>
                    </thead>
                    <tbody v-if="projects.length">
                    <tr v-for="(project, index) in projects" :key="project.id">
                        <td>{{ index + 1 }}</td>
                        <td>{{ project.name }}</td>
                        <td>{{ project.description }}</td>
                        <td>{{ project.modules_count }}</td>
                        <td>{{ get(project, 'owner.name', null) }}</td>
                    </tr>
                    </tbody>
                </template>
            </v-simple-table>
        </div>

    </div>
</template>

<script>
    import CreateProjectDialog from "../../components/project/modal/CreateProjectDialog";
    export default {
        name: "Index.vue",
        components: {CreateProjectDialog},
        data() {
            return {
                projects: [],
                dense: false,
                fixedHeader: false,
                height: 300,
                projectDialog : false
            };
        },
        created() {
            this.fetchProjects();
        },
        methods: {
            async fetchProjects() {
                const response = await axios.get('/api/projects');
                this.projects = response.data.data;
                console.log(response.data);
            },
            get(data, column, defaultValue) {
                return _.get(data,column, defaultValue);
            },
            test() {
                console.log('woi');
            }
        }
    }
</script>

<style scoped>

</style>
