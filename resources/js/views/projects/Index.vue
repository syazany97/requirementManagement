<template>
<h1>Projects</h1>
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
