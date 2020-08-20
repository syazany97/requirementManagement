<template>
    <div>
        <h1>Projects</h1>
        <!--        <v-col class="text-end">-->
        <!--            <button @click.stop="$modal.show('projectDialog')" class="btn-primary">-->
        <!--                New project-->
        <!--            </button>-->
        <!--            <modal name="projectDialog"-->
        <!--            >-->
        <!--                <create-project-dialog @fetch-projects="fetchProjects(); projectDialog = false"></create-project-dialog>-->
        <!--            </modal>-->

        <!--        </v-col>-->
        <div>
            <div class="container mx-auto py-6 px-4" x-data="datatables()" x-cloak>
                <h1 class="text-3xl py-4 border-b font-bold mb-10">Datatable</h1>

                <!--                <div x-show="selectedRows.length" class="bg-teal-200 fixed top-0 left-0 right-0 z-40 w-full shadow">-->
                <!--                    <div class="container mx-auto px-4 py-4">-->
                <!--                        <div class="flex md:items-center">-->
                <!--                            <div class="mr-4 flex-shrink-0">-->
                <!--                                <svg class="h-8 w-8 text-teal-600" viewBox="0 0 20 20" fill="currentColor">-->
                <!--                                    <path fill-rule="evenodd"-->
                <!--                                          d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"-->
                <!--                                          clip-rule="evenodd"/>-->
                <!--                                </svg>-->
                <!--                            </div>-->
                <!--                            <div x-html="selectedRows.length + ' rows are selected'"-->
                <!--                                 class="text-teal-800 text-lg"></div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->

                <div class="mb-4 flex justify-between items-center">
                    <div class="flex-1 pr-4">
                        <div class="relative md:w-1/3">
                            <input type="search"
                                   class="w-full pl-10 pr-4 py-2 rounded-lg shadow focus:outline-none focus:shadow-outline text-gray-600 font-medium"
                                   placeholder="Search...">
                            <div class="absolute top-0 left-0 inline-flex items-center p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400"
                                     viewBox="0 0 24 24"
                                     stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                     stroke-linejoin="round">
                                    <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                                    <circle cx="10" cy="10" r="7"/>
                                    <line x1="21" y1="21" x2="15" y2="15"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="shadow rounded-lg flex">
                            <div class="relative">
                                <button @click.prevent="showHeading = !showHeading"
                                        class="rounded-lg inline-flex items-center bg-white hover:text-blue-500 focus:outline-none focus:shadow-outline text-gray-500 font-semibold py-2 px-2 md:px-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 md:hidden"
                                         viewBox="0 0 24 24"
                                         stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                         stroke-linejoin="round">
                                        <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                                        <path
                                            d="M5.5 5h13a1 1 0 0 1 0.5 1.5L14 12L14 19L10 16L10 12L5 6.5a1 1 0 0 1 0.5 -1.5"/>
                                    </svg>
                                    <span class="hidden md:block">Display</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-1" width="24" height="24"
                                         viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                         stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                                        <polyline points="6 9 12 15 18 9"/>
                                    </svg>
                                </button>

                                <div v-if="showHeading"
                                     class="z-40 absolute top-0 right-0 w-40 bg-white rounded-lg shadow-lg mt-12 -mr-1 block py-1 overflow-hidden">
                                    <label v-for="heading in headings"
                                           class="flex justify-start items-center text-truncate hover:bg-gray-100 px-4 py-2">
                                        <div class="text-teal-600 mr-3">
                                            <input type="checkbox"
                                                   class="form-checkbox focus:outline-none focus:shadow-outline" checked
                                                   @click="">
                                        </div>
                                        <div class="select-none text-gray-700">{{ heading }}</div>
                                    </label>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative"
                     style="height: 405px;">
                    <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                        <thead>
                        <tr class="text-left">
                            <th class="py-2 px-3 sticky top-0 border-b border-gray-200 bg-gray-100">
                                <label
                                    class="text-teal-500 inline-flex justify-between items-center hover:bg-gray-200 px-2 py-2 rounded-lg cursor-pointer">
                                    <input type="checkbox" class="form-checkbox focus:outline-none focus:shadow-outline"
                                           @click="selectAllCheckbox($event);">
                                </label>
                            </th>
                            <th v-for="heading in headings"
                                class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs"
                            >{{ heading }}
                            </th>
                        </tr>

                        </thead>
                        <tbody>
                        <template>
                            <tr v-for="project in projects" v-bind:key="project.id" class="cursor-pointer hover:bg-gray-200" @click="viewProject(project.id)">
                                <td class="border-dashed border-t border-gray-200 px-3">
                                    <label
                                        class="text-teal-500 inline-flex justify-between items-center hover:bg-gray-200 px-2 py-2 rounded-lg cursor-pointer">
                                        <!--                                        <input type="checkbox" class="form-checkbox rowCheckbox focus:outline-none focus:shadow-outline" :name="user.userId"-->
                                        <!--                                               @click="">-->
                                    </label>
                                </td>
                                <td class="border-dashed border-t border-gray-200">
                                    <span class="text-gray-700 px-6 py-3 flex items-center" v-model="project.id"></span>
                                </td>
                                <td class="border-dashed border-t border-gray-200">
                                    <span class="text-gray-700 px-6 py-3 flex items-center">{{ project.name }}</span>
                                </td>
                                <td class="border-dashed border-t border-gray-200">
                                    <span class="text-gray-700 px-6 py-3 flex items-center"
                                    >{{ project.description | limitWords }}</span>
                                </td>
                                <td class="border-dashed border-t border-gray-200">
                                								<span class="text-gray-700 px-6 py-3 flex items-center"
                                                                ></span>{{ project.modules_count }}
                                </td>
                                <td class="border-dashed border-t border-gray-200">
                                								<span class="text-gray-700 px-6 py-3 flex items-center"
                                                                >{{ get(project, 'owner.name', null) }}</span>
                                </td>
                                <td class="border-dashed border-t border-gray-200">
                                    <button  @click="viewProject(project.id)" class="btn-primary">View</button>
                                </td>
                            </tr>
                        </template>
                        </tbody>
                    </table>
                </div>
            </div>
            <!--            <v-simple-table-->
            <!--                :dense="dense"-->
            <!--                :fixed-header="fixedHeader"-->
            <!--                :height="height"-->
            <!--            >-->
            <!--                <template v-slot:default>-->
            <!--                    <thead>-->
            <!--                    <tr>-->
            <!--                        <th class="text-left">Number</th>-->
            <!--                        <th class="text-left">Name</th>-->
            <!--                        <th class="text-left">Description</th>-->
            <!--                        <th class="text-left">No of modules</th>-->
            <!--                        <th class="text-left">Owner</th>-->
            <!--                        <th class="text-left">Action</th>-->
            <!--                    </tr>-->
            <!--                    </thead>-->
            <!--                    <tbody v-if="projects.length">-->
            <!--                    <tr v-for="(project, index) in projects" :key="project.id">-->
            <!--                        <td>{{ index + 1 }}</td>-->
            <!--                        <td>{{ project.name }}</td>-->
            <!--                        <td>{{ project.description }}</td>-->
            <!--                        <td>{{ project.modules_count }}</td>-->
            <!--                        <td>{{ get(project, 'owner.name', null) }}</td>-->
            <!--                        <td>-->
            <!--                            <v-btn x-small @click="viewProject(project.id)">View</v-btn>-->
            <!--                        </td>-->
            <!--                    </tr>-->
            <!--                    </tbody>-->
            <!--                </template>-->
            <!--            </v-simple-table>-->
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
            projectDialog: false,
            headings: [
                'Number',
                'Name',
                'Description',
                'No of modules',
                'Owner',
                'Action ',
            ],
            showHeading: false
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
            return _.get(data, column, defaultValue);
        },
        test() {
            console.log('woi');
        },
        viewProject(projectId) {
            this.$router.push({
                name: 'project.show', params: {
                    project: projectId
                }
            });
        }
    }
}
</script>

<style scoped>

</style>
