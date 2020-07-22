<template>
    <v-card
        class="pa-2"
        outlined
        tile
    >
        <h6>{{requirement.numbering}} {{requirement.title}}</h6>

        <v-row>
            <v-col cols="6" md="6">
            <v-list-item  v-for="(value, propertyName) in firstList" v-bind:key="propertyName" two-line>
                <v-list-item-content>
                    <v-list-item-title>{{propertyName | titleCase}}</v-list-item-title>
                    <v-list-item-subtitle>{{value}}</v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>
            </v-col>

            <v-col cols="6" md="6">
                <v-list-item  v-for="(value, propertyName) in secondList" v-bind:key="propertyName" two-line>
                    <v-list-item-content>
                        <v-list-item-title>{{propertyName | titleCase}}</v-list-item-title>
                        <v-list-item-subtitle>{{value}}</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
            </v-col>
        </v-row>

        <h5>Description</h5>
        <span>{{requirement.description}}</span>

        <h5>Attachments</h5>

    </v-card>
</template>

<script>
    import dayjs from "dayjs";
    export default {
        name: "ShowRequirement",
        data() {
            return {
                itemsColumn: ['email', 'assigned',]
            }
        },
        computed: {
            requirement() {
                return this.$store.getters['requirementList/currentRequirement']
            },
            firstList() {
                return {
                    assigned : this.get(this.requirement, 'assigned.title', ''),
                    created : dayjs(this.requirement.created_at).format('LLL'),
                    updated : dayjs(this.requirement.updated_at).format('LLL')
                }
            },
            secondList() {
                return {
                    priority : this.get(this.requirement, 'priority.title', ''),
                    type : this.requirement.type
                }
            }
        },
        methods: {
            get(data, column, defaultValue) {
                return _.get(data, column, defaultValue);
            }
        }
    }
</script>

<style scoped>

</style>
