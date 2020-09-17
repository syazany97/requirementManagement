<template>
    <button
        class="p-1 ml-2 hover:text-blue-500 text-gray-700 border-2 border-transparent rounded-full hover:bg-blue-100 focus:outline-none"
        aria-label="Remove">
        <svg class="w-6 h-6" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24"
             xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  :d="icon ? icon : 'M12 6v6m0 0v6m0-6h6m-6 0H6'"></path>
        </svg>
        <slot/>
    </button>
</template>

<script>
export default {
    props: {
        icon: {
            type: 'String'
        }
    },
    name: "DefaultButton",
    methods: {
        click() {
            this.$emit('click');
        }
    }
}
</script>

<style scoped>

</style>
