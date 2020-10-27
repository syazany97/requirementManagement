<template>

    <div>
        <div class="text-right">
            <button @click="redirectToTestCasePage()" class="btn btn-primary btn-icon">

                <svg viewBox="0 0 20 20" fill="currentColor" class="plus w-6 h-6">
                    <path fill-rule="evenodd"
                          d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                          clip-rule="evenodd">
                    </path>
                </svg>

                <span>Create test case</span>
            </button>
        </div>

        <table v-if="testCases.length" class="cursor-pointer hover:bg-gray-200 mt-4">
            <thead>
            <tr>
                <th v-for="heading in headings" class="default-header">{{heading}}</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(test, index) in testCases" v-bind:key="test.id" :class="index % 0 === 0 ? 'bg-gray-100' : ''">
                <td class="default-row">{{ index + 1 }}</td>
                <td class="default-row" v-html="test.title">a</td>
                <td class="default-row">{{ test.user.name }}</td>
                <td class="default-row">{{ test.created_at | formatDateTime }}</td>
                <td v-click-outside="hideAllDropdowns" class="default-row">
                    <button @click.stop="showDropdown(index)"
                            class="btn-dropdown px-1 focus:outline-none">
                        <svg viewBox="0 0 20 20" fill="currentColor" class="dots-horizontal w-6 h-6 px-1">
                            <path
                                d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"></path>
                        </svg>
                    </button>
                    <default-transition>
                        <div v-if="isOpen[index]"
                             class="contextual-popover-content cross-origin-top-right">
                            <div class="rounded-md bg-white bg-opacity-0 shadow-xs">
                                <div class="py-1" role="menu" aria-orientation="vertical"aria-labelledby="options-menu">
                                    <a href="#"
                                       class="block font-medium px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100
                                           hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900 bg-opacity-0"
                                       role="menuitem">Account settings</a>
<!--                                    <a @click.stop="currentProjectId = project.id; hideAllDropdowns(); $modal.show('deleteConfirmationDialog');" href="#"-->
<!--                                       class="block px-4 py-2 text-sm leading-5 text-red-700-->
<!--                                           font-medium-->
<!--                                           hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900"-->
<!--                                       role="menuitem">Delete this project</a>-->
                                </div>
                            </div>
                        </div>
                    </default-transition>
                </td>
<!--                <td class="default-row">-->
<!--                    <router-link :to="{name : 'test-case.edit' ,params : {testCase : test.id}}"-->
<!--                                 tag="button" class="btn btn-primary">View-->
<!--                    </router-link>-->
<!--                </td>-->
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import requirementTestCaseRepository from "../../../repositories/requirement/requirementTestCaseRepository";

export default {
    name: "TestCaseDetails",
    data() {
        return {
            testCases: [],
            headings: [
                'No', 'Title', 'User', 'Created', 'Action'
            ],
            isOpen : []
        }
    },
    created() {
        if (this.requirement.id !== null) this.fetchTestCases()
    },
    computed: {
        requirement() {
            return this.$store.getters['requirement/currentRequirement'];
        }
    },
    watch: {
        requirement() {
            if (this.requirement.id !== null) {
                this.fetchTestCases();
            }
        }
    },
    methods: {
        async fetchTestCases() {
            const response = await requirementTestCaseRepository.all(this.$store.getters['requirement/currentRequirement'].id);
            this.testCases = response.data.data;
            this.testCases.forEach(x => this.isOpen.push(false));
        },
        redirectToTestCasePage() {
            this.$router.push({
                name: 'test-case.create', params: {
                    requirement:
                    this.$store.getters['requirement/currentRequirement'].id
                }
            })
        },
        showDropdown(testIndex) {
            this.isOpen.forEach((x, index) => {
                if (index !== testIndex) {
                    this.isOpen.splice(index, 1, false);
                }
            })

            this.isOpen.splice(testIndex, 1, !this.isOpen[testIndex]);
        },
        hideAllDropdowns() {
            this.isOpen.forEach((x, index) => {
                this.isOpen.splice(index, 1, false);
            })

        },
    }
}
</script>

<style scoped>

</style>
