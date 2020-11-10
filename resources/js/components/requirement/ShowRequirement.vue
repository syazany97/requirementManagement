<template>
    <div
        v-if="requirement.id !== null"
        class="pa-2"
    >
        <nav class="px-1 pt-2">
            <div class="-mb-px flex justify-left">
                <a v-for="tab in items" class="tab" :class="currentTab === tab.component ? 'active-tab' : ''" href="#"
                   @click.prevent="currentTab= tab.component">
                    {{ tab.tab }}
                </a>
            </div>
        </nav>

        <div v-for="tab in items" v-bind:key="tab.component">
            <component v-show="currentTab === tab.component" v-bind:is="tab.component"
                       v-bind="{...tab.props}"></component>
        </div>

    </div>
</template>

<script>
const qs = require('qs');
export default {
    data() {
        return {
            tab: null,
            items: [
                {
                    tab: 'Requirement', component: 'requirement-details', props: {}
                },
                {
                    tab: 'Test Case', component: 'test-case-details', props: {}
                },
                {
                    tab: 'History',
                    component: 'requirement-history',
                    props: {
                        objectId: null,
                        historyType: 'requirement'
                    }
                }
            ],
            currentTab: 'requirement-details'
        }
    },
    created() {
        this.setRequirement();
    },
    watch: {
        requirement() {
            let tabIndex = this.items.findIndex(x => x.tab === 'History');

            if (tabIndex === -1) return;

            this.items[tabIndex].props.objectId = this.requirement.id;

            this.items.splice(tabIndex, 1, this.items[tabIndex]);
        }
    },
    computed: {
        requirement() {
            return this.$store.getters['requirement/currentRequirement']
        }
    },
    methods: {
        setRequirement() {
            const parameters = qs.parse(location.search.split('?')[1]);

            if (!parameters.hasOwnProperty('requirement')) return;

            this.$store.commit('requirement/setRequirement',
                this.$store.getters['requirement/requirementList']
                    .map(x => x.requirements)
                    .flat(1)
                    .find(a => a.id === parseInt(parameters.requirement))
            );
        }
    }

}

</script>

