<template>
    <p v-if="error.length" class="text-red-500 text-sm">{{ error[0] }}</p>
</template>

<script>
import {mapGetters} from "vuex";


export default {
    props: {
        name: {
            type: String,
            default: '',
            required: true
        }
    },
    computed: {
        ...mapGetters(
            'error', [
                'errors'
            ]
        ),
        error() {
            return _.get(this.errors, this.name, []).map(x => x.replace(' id ', ' '));
        }
    },
    name: "ErrorMessage"
}
</script>

<style scoped>

</style>
