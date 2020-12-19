<template>
    <div
        v-if="currentRequirement.id !== null"
        class="pa-2"
    >
        <nav class="px-1 pt-2">
            <div class="-mb-px flex justify-left">
                <a v-for="tab in tabs" class="tab" :class="currentTab === tab.component ? 'active-tab' : ''" href="#"
                   @click.prevent="currentTab= tab.component">
                    {{ tab.tab }}
                </a>
            </div>
        </nav>

        <div v-for="tab in tabs" v-bind:key="tab.component">
            <component v-show="currentTab === tab.component" v-bind:is="tab.component"
                       v-bind="{...tab.props}"></component>
        </div>

    </div>
</template>

<script>
import {mapGetters} from 'vuex';
const qs = require('qs');
export default {
    data() {
        return {
            tab: null
        }
    },
    created() {
        this.setRequirement();
    },
    watch: {
        requirement() {
            const tabIndex = this.tabs.findIndex(x => x.tab === 'History');

            if (tabIndex === -1) return;

            this.tabs[tabIndex].props.objectId = this.requirement.id;

            this.tabs.splice(tabIndex, 1, this.tabs[tabIndex]);
        }
    },
    computed: {
        ...mapGetters('requirement', [
            'currentRequirement', 'requirementList'
        ]),
        tabs: {
            get() {
                return this.$store.getters['requirement/tabs']
            },
            set(value) {
                return this.$store.commit('requirement/tabs', value);
            }
        },
        currentTab: {
            get() {
                return this.$store.getters['requirement/currentTab'];
            },
            set(value) {
                this.$store.commit('requirement/currentTab', value);
                this.$store.dispatch('requirement/updateQueryParam');
            }
        }
    },
    methods: {
        setRequirement() {
            const parameters = qs.parse(location.search.split('?')[1]);

            if (!parameters.hasOwnProperty('requirement')) return;

            this.$store.commit('requirement/setRequirement',
                this.requirementList
                    .map(x => x.requirements)
                    .flat(1)
                    .find(a => a.id === parseInt(parameters.requirement))
            );
        }
    }

}

</script>

