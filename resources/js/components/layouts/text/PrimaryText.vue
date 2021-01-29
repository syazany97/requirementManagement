<template>
    <div>
        <input class="primary-input"
               :class="className"
               @input="handleTextChange"
               :id="id" :type="inputType" :placeholder="placeholder">
        <error-message :name="name"/>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import ErrorMessage from "../ErrorMessage";

export default {
    components: {ErrorMessage},
    props: {
        id: {
            type: String,
            default: '',
            required : true
        },
        inputType : {
            type : String,
            default : 'text'
        },
        placeholder: {
            type: String,
            default: '',
            required : true
        },
        name: {
            type: String,
            default: '',
            required : true
        },
        className : {
            type : String,
            default : ''
        }
    },
    computed: {
        ...mapGetters(
            'error', [
                'errors'
            ]
        ),
    },
    name: "PrimaryText",
    methods: {
        handleTextChange(e) {
            this.$emit('input', e.target.value);
        }
    }
}
</script>

<style scoped>

</style>
