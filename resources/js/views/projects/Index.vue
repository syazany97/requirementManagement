<template>
    <div v-click-outside="hideAllDropdowns" class="container mx-auto py-6 px-4">
        <h1 class="h1">Projects</h1>

        <!--        <div class="flex pt-2">-->
        <!--            <div class="w-3/4"></div>-->
        <!--            <div class="w-1/4">-->
        <!--                <button class="btn btn-primary float-right">Add project</button>-->
        <!--            </div>-->
        <!--        </div>-->

        <div class="mb-4 flex justify-between items-center mt-2">
            <div class="flex-1 pr-4">
                <div class="relative md:w-1/3">
                    <input v-model="search" type="text"
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
<!--                                                <button @click.prevent="showHeading = !showHeading"-->
<!--                                                        class="rounded-lg inline-flex items-center bg-white hover:text-blue-500 focus:outline-none focus:shadow-outline text-gray-500 font-semibold py-2 px-2 md:px-4">-->
<!--                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 md:hidden"-->
<!--                                                         viewBox="0 0 24 24"-->
<!--                                                         stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"-->
<!--                                                         stroke-linejoin="round">-->
<!--                                                        <rect x="0" y="0" width="24" height="24" stroke="none"></rect>-->
<!--                                                        <path-->
<!--                                                            d="M5.5 5h13a1 1 0 0 1 0.5 1.5L14 12L14 19L10 16L10 12L5 6.5a1 1 0 0 1 0.5 -1.5"/>-->
<!--                                                    </svg>-->
<!--                                                    <span class="hidden md:block">Display</span>-->
<!--                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-1" width="24" height="24"-->
<!--                                                         viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"-->
<!--                                                         stroke-linecap="round" stroke-linejoin="round">-->
<!--                                                        <rect x="0" y="0" width="24" height="24" stroke="none"></rect>-->
<!--                                                        <polyline points="6 9 12 15 18 9"/>-->
<!--                                                    </svg>-->
<!--                                                </button>-->
                        <button @click="hideAllDropdowns(); $modal.show('modalProjectDialog')" class="btn btn-primary float-right">Add
                            project
                        </button>

                        <!-- Create Project Modal -->
                        <modal name="modalProjectDialog" class="sm:w-full md:w-1/4" :adaptive="true" :scrollable="true"
                               height="auto">
                            <create-project-dialog></create-project-dialog>
                        </modal>
                        <!-- End create project modal -->

                        <!-- Delete confirmation modal -->
                        <delete-confirmation-dialog object-type="Project" @delete="deleteProject"></delete-confirmation-dialog>
                        <!-- End delete confirmation modal -->

                        <default-transition>

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
                        </default-transition>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mx-auto">

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
                        class="default-header"
                    >{{ heading }}
                    </th>
                </tr>

                </thead>
                <tbody>
                <tr v-for="(project, index) in projects" v-bind:key="project.id"
                    class="cursor-pointer hover:bg-gray-200"
                    @click="viewProject(project.id)">
                    <td class="default-row">
                        <span class="text-gray-700 px-6 py-3 flex items-center">{{ project.id }}</span>
                    </td>
                    <td class="default-row">
                        <span class="text-gray-700 px-6 py-3 flex items-center">{{ project.name }}</span>
                    </td>
                    <td class="default-row">
                                								<span class="text-gray-700 px-6 py-3 flex items-center"
                                                                >{{ project.modules_count }}</span>
                    </td>
                    <td class="default-row">
                                								<span class="text-gray-700 px-6 py-3 flex items-center"
                                                                >{{ get(project, 'owner.name', null) }}</span>
                    </td>
                    <td class="default-row">
                                								<span class="text-gray-700 px-6 py-3 flex items-center"
                                                                >{{ project.created_at | formatDateTime }}</span>
                    </td>

                    <td class="default-row">
                        <!--                                								<button class="border-opacity-100 hover:bg-red hover:border-grey-300 rounded">-->
                        <button @click.stop="showDropdown(index)"
                                class="btn-dropdown px-2 focus:outline-none">
                            <svg viewBox="0 0 20 20" fill="currentColor" class="dots-horizontal w-6 h-6 px-1">
                                <path
                                    d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"></path>
                            </svg>
                        </button>


                        <default-transition>
                            <div v-if="isOpen[index]"
                                 class="absolute cross-origin-top-right mt-2 w-56 bg-white rounded-md shadow-xl z-20">
                                <div class="ContextualPopover-arrow"></div>
                                <div class="rounded-md bg-white bg-opacity-0 shadow-xs">
                                    <div class="py-1" role="menu" aria-orientation="vertical"
                                         aria-labelledby="options-menu">
                                        <a href="#"
                                           class="block font-medium px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100
                                           hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900 bg-opacity-0"
                                           role="menuitem">Account settings</a>
                                        <a @click.stop="currentProjectId = project.id; hideAllDropdowns(); $modal.show('confirmationDialog');" href="#"
                                           class="block px-4 py-2 text-sm leading-5 text-red-700
                                           font-medium
                                           hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900"
                                           role="menuitem">Delete this project</a>
                                    </div>
                                </div>
                            </div>
                        </default-transition>

                        <!--                            <button class="bg-red-500 rounded px-2 py-2 hover:bg-white border-transparent hover:border-black border"></button>-->
                    </td>

                </tr>

                </tbody>
            </table>
        </div>

        <div v-if="pagination.meta !== null" class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between pt-3">
            <div>
                <p class="text-sm leading-5 text-gray-700">
                    Showing
                    <span class="font-medium">{{ pagination.meta.from }}</span>
                    to
                    <span class="font-medium">{{ this.pagination.meta.to }}</span>
                    of
                    <span class="font-medium">{{ pagination.meta.total }}</span>
                    results
                </p>
            </div>
            <div>
                <button class="btn btn-tertiary border border-gray-400"
                        :class="pagination.links.prev === null ? 'btn-disabled' : ''"
                        @click="fetchProjects(pagination.links.prev)">Previous
                </button>

                <div class="divider"></div>

                <button class="btn btn-tertiary border border-gray-400"
                        :class="pagination.links.next === null ? 'btn-disabled' : ''"
                        @click="fetchProjects(pagination.links.next)">Next
                </button>
            </div>
        </div>

    </div>


</template>

<script>
import CreateProjectDialog from "../../components/project/modal/CreateProjectDialog";
import {debounce} from "../../helper";
import projectRepository from "../../repositories/projectRepository";
import DeleteConfirmationDialog from "../../components/layouts/modal/DeleteConfirmationDialog";

export default {
    name: "Index.vue",
    components: {DeleteConfirmationDialog, CreateProjectDialog},
    data() {
        return {
            projects: [],
            dense: false,
            fixedHeader: false,
            height: 300,
            projectDialog: false,
            headings: [
                'Name',
                'No of modules',
                'Owner',
                'Created',
                ''
            ],
            currentProjectId : null,
            showHeading: false,
            pagination: {
                links: null,
                meta: null
            },
            url: '/api/projects',
            search: "",
            isOpen: []
        };
    },
    created() {
        this.fetchProjects();
    },
    watch: {
        search: debounce(function () {
            this.fetchProjects();
        }, 1000)
    },
    methods: {
        async fetchProjects(link = null) {
            const url = link === null ? this.url + ('?q=' + this.search) : link;
            const response = await axios.get(url);
            console.log(response.data);
            this.projects = response.data.data;
            this.pagination.links = response.data.links;
            this.pagination.meta = response.data.meta;

            for (let i = 0; i < this.projects.length; i++) {
                this.isOpen.push(false);
            }
        },
        get(data, column, defaultValue) {
            return _.get(data, column, defaultValue);
        },
        async deleteProject() {
            try {
                const response = await projectRepository.delete(this.currentProjectId);
                await this.fetchProjects();
                console.log('delete project', response);
            } catch (e) {
                console.log('error', e);
            }
        },
        showDropdown(projectIndex) {
            this.isOpen.forEach((x, index) => {
                if (index !== projectIndex) {
                    this.isOpen.splice(index, 1, false);
                }
            })

            this.isOpen.splice(projectIndex, 1, !this.isOpen[projectIndex]);
        },
        hideAllDropdowns() {
            this.isOpen.forEach((x, index) => {
                this.isOpen.splice(index, 1, false);
            })

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

.ContextualPopover-arrow {
    z-index: 1;
    width: 21px;
    height: 21px;
    margin: -7px;
    background: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyMSIgaGVpZ2h0PSI5Ij48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxwYXRoIGZpbGw9IiM4ODk4QUEiIGZpbGwtb3BhY2l0eT0iLjEiIGQ9Ik0xIDkuMDkyaDE5bC02LjQwMi02Ljc0Yy0xLjcxNy0xLjgwNi00LjQ4NS0xLjgtNi4xOTYgMEwxIDkuMDkzek0yMC4zNDIgOGwtNi4wMi02LjMzNmMtMi4xMDgtMi4yMi01LjUzOC0yLjIxOC03LjY0NSAwTC42NTggOGgxOS42ODR6Ii8+PHBhdGggZmlsbD0iI0ZGRiIgZD0iTTcuNDAyIDIuMzUzYzEuNzExLTEuODAxIDQuNDgtMS44MDcgNi4xOTYgMEwyMCA5LjA5M0gxbDYuNDAyLTYuNzR6Ii8+PC9nPjwvc3ZnPg==) no-repeat 50%;
}
</style>
