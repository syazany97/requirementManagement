<template>
    <p v-if="findError.length" class="text-red-500 text-sm">{{ findError[0] }}</p>
</template>

<script>
import {mapGetters} from "vuex";
import {get} from 'lodash';

export default {
    props: {
        name: {
            type: String,
            default: ''
        }
    },
    computed: {
        ...mapGetters(
            'error', [
                'errors'
            ]
        ),
        findError() {
            return _.get(this.errors, name, []);
        }
    },
    name: "ErrorMessage"
}
</script>

<style scoped>

</style>
