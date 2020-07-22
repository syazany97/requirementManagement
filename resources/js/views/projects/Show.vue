<template>
    <h1>Show project</h1>
</template>

<script>
    import projectRepository from "../../repositories/projectRepository";
    export default {
        name: "Show",
        data() {
          return {
              projectId : this.$route.params.project,
              project : {},
              modules : [],
              requirements : [],
          }
        },
        created() {
            this.setProject();
        },
        methods : {
            async setProject() {
                const response = await projectRepository.find(this.projectId)
                this.project = response.data.data.project;

                console.log(response.data);

            }
        }
    }
</script>

<style scoped>

</style>
