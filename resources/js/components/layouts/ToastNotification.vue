<template>


</template>
<script>
// import 'vue-toast-notification/dist/theme-default.css';
import 'vue-toast-notification/dist/theme-sugar.css';
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
                    type: this.$store.getters["notification/variant"],
                    message: this.$store.getters["notification/message"],
                    position: "top",
                    duration: this.$store.getters["notification/duration"]
                });
            },
        },
    };
</script>
