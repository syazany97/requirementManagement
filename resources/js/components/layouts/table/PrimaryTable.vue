<template>

    <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
        <thead>
        <tr class="text-left">
            <th class="py-2 px-3 sticky top-0 border-b border-gray-200 bg-gray-100">
                <label
                    class="text-teal-500 inline-flex justify-between items-center hover:bg-gray-200 px-2 py-2 rounded-lg cursor-pointer">
                    <input type="checkbox" class="form-checkbox focus:outline-none focus:shadow-outline"
                    >
                </label>
            </th>
            <th v-for="heading in headings"
                class="default-header"
            >{{ heading }}
            </th>
        </tr>

        </thead>
        <tbody>
        <slot>


        </slot>
        </tbody>
    </table>

</template>

<script>
export default {
    name: "PrimaryTable",
    props: {
        headings: {
            type: Array
        }
    },
    watch: {
        headings(val) {
            console.log('headings', this.headings);
        }
    },
    created() {
        // console.log('headings', this.headings);
    }
}
</script>

<style scoped>

</style>
