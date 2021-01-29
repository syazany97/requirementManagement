<template>
    <p v-if="findError.length" class="text-red-500 text-sm">{{ findError[0] }}</p>
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
        findError() {
            const errors = _.get(this.errors, this.name, []);

            if (errors.length) {
                return errors.map(x => x.replace(' id ', ' '));
            }

            return [];
        }
    },
    name: "ErrorMessage"
}
</script>

<style scoped>

</style>
