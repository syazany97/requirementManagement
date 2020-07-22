<template>
    <v-card
        class="pa-2"
        outlined
        tile
    >
        <h1>Requirement 1</h1>

        <v-list-item>
            <v-list-item-content>
                <v-list-item-title>Single-line item</v-list-item-title>
            </v-list-item-content>
        </v-list-item>

        <v-list-item two-line>
            <v-list-item-content>
                <v-list-item-title>Two-line item</v-list-item-title>
                <v-list-item-subtitle>Secondary text</v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>

        <v-list-item three-line>
            <v-list-item-content>
                <v-list-item-title>Three-line item</v-list-item-title>
                <v-list-item-subtitle>
                    Secondary line text Lorem ipsum dolor sit amet,
                </v-list-item-subtitle>
                <v-list-item-subtitle>
                    consectetur adipiscing elit.
                </v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>
    </v-card>
</template>

<script>
    export default {
        name: "ShowRequirement"
    }
</script>

<style scoped>

</style>
