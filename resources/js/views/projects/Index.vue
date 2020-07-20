<template>
    <div class="my-2">
    <h1>Projects</h1>
        <v-btn small @click="testing()">Normal</v-btn>
    </div>
</template>

<script>
    export default {
        name: "Index.vue",
        data() {
            return {
                test : 0
            };
        },
        created() {
            console.log('here');
        },
        methods : {
            testing() {
                this.test++;
                console.log(this.test);
            }
        }
    }
</script>

<style scoped>

</style>
