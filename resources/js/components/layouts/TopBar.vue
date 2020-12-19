<template>
    <nav class="bg-white fixed top-0 shadow-lg w-full">
        <div class="px-4 mx-auto">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <div class="justify-center hover:text-blue-500 hover:bg-blue-100 rounded-full p-2 text-center">

                        <!--                        <svg class="w-4 h-4 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="currentColor"-->
                        <!--                             viewBox="0 0 477.867 477.867">-->
                        <!--                            <path fill-rule="evenodd"-->
                        <!--                                  d="M119.467 0h-102.4C7.641 0 0 7.641 0 17.067v102.4c0 9.426 7.641 17.067 17.067 17.067h102.4c9.426 0 17.067-7.641 17.067-17.067v-102.4C136.533 7.641 128.892 0 119.467 0zM102.4 102.4H34.133V34.133H102.4V102.4zM290.133 0h-102.4c-9.426 0-17.067 7.641-17.067 17.067v102.4c0 9.426 7.641 17.067 17.067 17.067h102.4c9.426 0 17.067-7.641 17.067-17.067v-102.4C307.2 7.641 299.559 0 290.133 0zm-17.066 102.4H204.8V34.133h68.267V102.4zM460.8 0H358.4c-9.426 0-17.067 7.641-17.067 17.067v102.4c0 9.426 7.641 17.067 17.067 17.067h102.4c9.426 0 17.067-7.641 17.067-17.067v-102.4C477.867 7.641 470.226 0 460.8 0zm-17.067 102.4h-68.267V34.133h68.267V102.4zM119.467 170.667h-102.4C7.641 170.667 0 178.308 0 187.733v102.4c0 9.426 7.641 17.067 17.067 17.067h102.4c9.426 0 17.067-7.641 17.067-17.067v-102.4c-.001-9.425-7.642-17.066-17.067-17.066zm-17.067 102.4H34.133V204.8H102.4v68.267zM290.133 170.667h-102.4c-9.426 0-17.067 7.641-17.067 17.067v102.4c0 9.426 7.641 17.067 17.067 17.067h102.4c9.426 0 17.067-7.641 17.067-17.067v-102.4c0-9.426-7.641-17.067-17.067-17.067zm-17.066 102.4H204.8V204.8h68.267v68.267zM460.8 170.667H358.4c-9.426 0-17.067 7.641-17.067 17.067v102.4c0 9.426 7.641 17.067 17.067 17.067h102.4c9.426 0 17.067-7.641 17.067-17.067v-102.4c0-9.426-7.641-17.067-17.067-17.067zm-17.067 102.4h-68.267V204.8h68.267v68.267zM119.467 341.333h-102.4C7.641 341.333 0 348.974 0 358.4v102.4c0 9.426 7.641 17.067 17.067 17.067h102.4c9.426 0 17.067-7.641 17.067-17.067V358.4c-.001-9.426-7.642-17.067-17.067-17.067zm-17.067 102.4H34.133v-68.267H102.4v68.267zM290.133 341.333h-102.4c-9.426 0-17.067 7.641-17.067 17.067v102.4c0 9.426 7.641 17.067 17.067 17.067h102.4c9.426 0 17.067-7.641 17.067-17.067V358.4c0-9.426-7.641-17.067-17.067-17.067zm-17.066 102.4H204.8v-68.267h68.267v68.267zM460.8 341.333H358.4c-9.426 0-17.067 7.641-17.067 17.067v102.4c0 9.426 7.641 17.067 17.067 17.067h102.4c9.426 0 17.067-7.641 17.067-17.067V358.4c0-9.426-7.641-17.067-17.067-17.067zm-17.067 102.4h-68.267v-68.267h68.267v68.267z"/>-->
                        <!--                        </svg>-->

                    </div>
                    <div
                        class="flex px-2 py-1 self-center text-sm font-medium text-gray-800 antialiased rounded-md focus:outline-none hover:bg-blue-100 hover:text-blue-500 focus:bg-blue-100">
                        <div class="justify-center mt-1 mr-1">
                            <!--                            <img class="h-5 w-5"-->
                            <!--                                 src="https://biltrax.atlassian.net/s/-egccmf/b/23/b6b48b2829824b869586ac216d119363/_/favicon-software.ico">-->
                        </div>
                        <div @click="showIndexPage"
                             class="justify-center cursor-pointer text-xl font-semibold text-center">
                            Zany Software
                        </div>
                    </div>
                </div>

                <div class="hidden md:block">

                    <div class="flex items-center ml-4 md:ml-6">
                        <div v-click-outside="hideDropDown" class="relative ml-2">
                            <button @click="isOpen = !isOpen"
                                    class="p-1 flex hover:text-blue-500 hover:bg-blue-100  text-gray-700 border-2 border-transparent items-center max-w-xs text-sm rounded-full focus:outline-none"
                                    id="user-menu" aria-label="User menu" aria-haspopup="true">
                                <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                          clip-rule="evenodd">
                                    </path>
                                </svg>
                            </button>

                            <default-transition>
                                <div v-if="isOpen"
                                     class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg">
                                    <div class="rounded-md bg-white shadow-xs">
                                        <div class="py-1" role="menu" aria-orientation="vertical"
                                             aria-labelledby="options-menu">
                                            <!--                                            <a href="#"-->
                                            <!--                                               class="block w-full text-left px-4 py-2 text-sm leading-5 hover:bg-gray-100-->
                                            <!--                                                        hover:text-gray-900 text-color-purple focus:outline-none font-medium focus:bg-gray-100 focus:text-gray-900"-->
                                            <!--                                               role="menuitem">Profile</a>-->
                                            <form method="POST" action="/logout">
                                                <input type="hidden" name="_token" :value="csrf">
                                                <button type="submit"
                                                        class="block w-full text-left px-4 py-2 text-sm leading-5 hover:bg-gray-100
                                                        hover:text-gray-900 text-color-purple focus:outline-none font-medium focus:bg-gray-100 focus:text-gray-900"
                                                        role="menuitem">
                                                    Sign out
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </default-transition>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

</template>

<script>
export default {
    name: "TopBar",
    data: () => ({
        isOpen: false,
        showAppSelect: false,
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }),
    methods: {
        hideDropDown() {
            this.isOpen = false;
            this.showAppSelect = false;
        },
        showIndexPage() {
            if (this.$router.currentRoute.name !== 'project.index') {
                this.$router.push({name: 'project.index'});
            }
        }
    },
}
</script>

<style scoped>

</style>
