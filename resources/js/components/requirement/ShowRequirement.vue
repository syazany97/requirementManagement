<template>
    <v-card
        class="pa-2"
        outlined
        tile
    >
        <h6>{{requirement.numbering}} {{requirement.title}}</h6>

        <v-list-item  v-for="(value, propertyName) in items" two-line>
            <v-list-item-content>
                <v-list-item-title>{{propertyName | titleCase}}</v-list-item-title>
                <v-list-item-subtitle>{{setValue(value)}}</v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>

        <h5>Description</h5>
        <span>{{requirement.description}}</span>

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
            items() {
                return {
                    assigned : this.get(this.requirement, 'assigned.title', ''),
                    created : dayjs(this.requirement.created_at).format('LLL'),
                    updated : dayjs(this.requirement.updated_at).format('LLL')
                }
            }
        },
        methods: {
            get(data, column, defaultValue) {
                return _.get(data, column, defaultValue);
            },
            setValue(value) {
                if(value instanceof Date) return dayjs(value).format('LLL');
                return value;
            }
        }
    }
</script>

<style scoped>

</style>
