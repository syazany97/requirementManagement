<template>
    <div>
    <toast-notification></toast-notification>
    <router-view :key="$route.fullPath"></router-view>

    </div>
</template>

<script>
export default {
    props: {
        source: String,
    },
    data: () => ({
        drawer: null,
    }),
}
</script>
