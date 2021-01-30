<template>
    <div>
        <textarea class="primary-input"
          :value="value"
          :id="id" :name="name"
          :placeholder="placeholder">
              </textarea>

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
            required: true
        },
        inputType: {
            type: String,
            default: 'text'
        },
        placeholder: {
            type: String,
            default: ''
        },
        name: {
            type: String,
            default: '',
            required: true
        },
        className: {
            type: String,
            default: ''
        },
        value: {
            type: String | Number,
            default: ''
        }
    },
    computed: {
        ...mapGetters(
            'error', [
                'errors'
            ]
        ),
    },
    name: "PrimaryTextArea",
    methods: {
        handleTextChange(e) {
            this.$emit('input', e.target.value);
        }
    }
}
</script>

<style scoped>

</style>
