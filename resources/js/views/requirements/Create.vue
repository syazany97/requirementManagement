<template>
    <v-container v-if="requirement.id !== null">
    <h1>{{requirement.name}}</h1>

        <table class="table-auto">
            <thead>
            <tr>
                <th class="px-4 py-2">No</th>
                <th class="px-4 py-2">Step</th>
                <th class="px-4 py-2">Input</th>
                <th class="px-4 py-2">Expected results</th>
                <th class="px-4 py-2">Result</th>
                <th class="px-4 py-2">Comment</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(index, step) in steps" v-bind:key="step.id" :class="index % 2 !== 0 ? '' : 'bg-gray-100' ">
                <td class="border px-4 py-2">{{index}}</td>
                <td class="border px-4 py-2">   <input class="primary-input"
                                                       v-model="step.step"
                                                       id="grid-name" type="text" placeholder="Name"></td>
                <td class="border px-4 py-2">Adam</td>
                <td class="border px-4 py-2">Adam</td>
                <td class="border px-4 py-2">Adam</td>
                <td class="border px-4 py-2">858</td>
                <td class="border px-4 py-2"><button class="primary-btn">Add Step</button></td>
            </tr>
            <tr class="bg-gray-100">
                <td class="border px-4 py-2">A Long and Winding Tour of the History of UI Frameworks and Tools and the
                    Impact on Design
                </td>
                <td class="border px-4 py-2">Adam</td>
                <td class="border px-4 py-2">Adam</td>
                <td class="border px-4 py-2">Adam</td>
                <td class="border px-4 py-2">Adam</td>
                <td class="border px-4 py-2">112</td>
            </tr>
            </tbody>
        </table>

    </v-container>

</template>

<script>
export default {
    name: "Create.vue",
    created() {
            this.$store.dispatch('requirement/setRequirement', this.$route.params.requirement);
    },
    data() {
      return {
          steps : [],
          step : {

          }
      }
    },
    computed : {
        requirement()  {
          return this.$store.getters['requirement/currentRequirement'];
        }
    },
    methods: {
        addStep(step) {
            this.steps.push(step);
        }

    }
}
</script>

<style scoped>

</style>
