<template>
    <div
        v-if="requirement.id !== null"
        class="pa-2"
        outlined
        tile
    >
        <nav class="px-1 pt-2">
            <div class="-mb-px flex justify-left">
                <a v-for="tab in items" :class="currentTab === tab.component ? 'active-tab' : 'tab'" href="#" @click.prevent="currentTab= tab.component">
                    {{tab.tab}}
                </a>
            </div>
        </nav>

        <div v-for="tab in items" v-bind:key="tab.component">
            <component v-show="currentTab === tab.component"  v-bind:is="tab.component"></component>
        </div>

    </div>
</template>

<script>
export default {
    data() {
        return {
            tab: null,
            items: [
                {
                    tab: 'Requirement', component: 'requirement-details'
                },
                {
                    tab: 'Test Case', component: 'test-case-details'
                },
                {
                    tab: 'History', component: 'requirement-history'
                }
            ],
            currentTab: 'requirement-details'
        }
    },
    computed: {
        requirement() {
            return this.$store.getters['requirement/currentRequirement']
        }
    }

}

</script>

