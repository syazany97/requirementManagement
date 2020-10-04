<template>

    <modal name="confirmationDialog" class="sm:w-full md:w-1/4" :adaptive="true" :scrollable="true"
           :shiftY="0.3" height="auto" width="620px">
        <div class="container md:mx-auto sm:w-full py-2 overflow-y-auto">
            <h1 class="default-dialog-title">Delete {{ type }}</h1>
            <span class="px-4">Are you sure you want to permanently delete this {{ type }}? This cannot be undone</span>
            <div class="inline-flex text-right px-4 pt-4 pb-5 float-right">
                <button @click="$modal.hide('confirmationDialog')" class="btn btn-tertiary pr-3">
                    <span>Cancel</span>
                </button>
                <div class="divider"></div>
                <button @click="deleteObject" class="btn btn-primary">
                    <span>Delete {{ type }}</span>
                </button>
            </div>
        </div>

    </modal>

</template>

<script>
export default {
    props: {
        objectType: {
            type: String,
            default: 'Project'
        }
    },
    computed : {
      type() {
          return this.objectType.toLowerCase();
      }
    },
    name: "DeleteConfirmationDialog",
    methods : {
        deleteObject() {
            this.$emit('delete');
        }
    }
}
</script>

<style scoped>

</style>
