<template>
    <v-card>
        <v-card-title class="headline">Login</v-card-title>

        <v-card-text>
            <v-form
                ref="form"
                v-model="valid"
                lazy-validation
            >
                <v-text-field
                    v-model="email"
                    label="Email"
                    required
                ></v-text-field>

                <v-text-field
                    label="Password"
                    v-model="password"
                    type="password"
                ></v-text-field>
            </v-form>
        </v-card-text>

        <v-card-actions>
            <v-spacer></v-spacer>

            <v-btn
                color="primary"
                @click="login()"
            >
                Login
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
    export default {
        data() {
            return {
                valid: true,
                email: "",
                password: ""
            }
        },
        created() {
        },
        methods: {
            login() {
                axios.post('/login', {
                    email: this.email,
                    password: this.password
                }).then(res => {
                    this.$router.push({name: 'project.index'});

                })
                    .catch(err => {
                        console.log(err);
                    })
            }
        },
    }
</script>

<style scoped>

</style>
