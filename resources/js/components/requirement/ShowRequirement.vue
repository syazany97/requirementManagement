<template>
    <v-card
        v-if="requirement.id !== null"
        class="pa-2"
        outlined
        tile
    >
        <v-tabs v-model="tab">
            <keep-alive v-for="tab in items" v-bind:key="tab.component">
                <v-tab>{{tab.tab}}</v-tab>
            </keep-alive>

            <v-tabs-items v-model="tab">
                <v-tab-item v-for="tab in items" v-bind:key="tab.component">
                    <component v-bind:is="tab.component"></component>
                </v-tab-item>
            </v-tabs-items>

        </v-tabs>
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
                ]
            }
        },
        computed: {
            requirement() {
                return this.$store.getters['requirement/currentRequirement']
            }
        }

    }

</script>

