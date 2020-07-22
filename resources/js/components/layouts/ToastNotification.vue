<template>


</template>
<script>
    export default {
        computed: {
            showNotification() {
                return this.$store.getters["notification/show"];
            }
        },
        watch: {
            showNotification: function () {
            console.log('test');
                this.$toast.open({
                    variant: this.$store.getters["notification/variant"],
                    message: this.$store.getters["notification/message"],
                    position: "top",
                    duration: this.$store.getters["notification/duration"]
                });
            },
        },
    };
</script>
