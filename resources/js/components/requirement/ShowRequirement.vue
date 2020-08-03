<template>
    <v-card
        v-if="requirement.id !== null"
        class="pa-2"
        outlined
        tile
    >
        <ul class="nav nav-pills">
            <li v-for="tab in items" class="nav-item">
                <a :class="'nav-link ' +  (currentTab === tab.component ? 'active' : '')"
                   href="#" @click.prevent="currentTab= tab.component">{{tab.tab}}</a>
            </li>
        </ul>

        <div v-for="tab in items" v-bind:key="tab.component">
            <component v-show="currentTab === tab.component"  v-bind:is="tab.component"></component>
        </div>

    </v-card>
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

