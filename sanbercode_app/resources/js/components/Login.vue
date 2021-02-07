<template>
    <v-card>
        <v-toolbar dark color="success">
            <v-btn icon dark @click.native="close">
                <v-icon>mdi-close</v-icon>
            </v-btn>
            <v-toolbar-title>Login</v-toolbar-title>
        </v-toolbar>
        <v-divider></v-divider>

        <v-container fluid>
            <v-form ref="form" v-model="valid" lazy-validation>
                <v-text-field
                    v-model="email"
                    :rules="emailRules"
                    label="Email"
                    required
                    append-icon="mdi-email"
                >
                </v-text-field>

                <v-text-field
                    v-model="password"
                    :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                    :rules="passwordRules"
                    :type="showPassword ? 'text':'password'"
                    label="password"
                    hint="Minimal 6 karakter"
                    counter
                    @click:append="showPassword = !showPassword"

                >

                </v-text-field>
                <div class="text-xs-center">
                    <v-btn
                        color="success lighten-1"
                        :disabled="!valid"
                        @click="submit"
                    >
                        LOGIN
                        <v-icon right dark>mdi-lock-open</v-icon>
                    </v-btn>
                    <v-btn
                        color="primary lighten-1"
                        @click="authProvider('google')"
                    >
                        LOGIN WITH GOOGLE
                        <v-icon right dark>mdi-google</v-icon>
                    </v-btn>
                </div>
            </v-form>
        </v-container>
    </v-card>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
    name:'login',
    data(){
        return {
            valid:true,
            email:"example@example.com",
            emailRules:[
                v => !!v || 'Email is Required',
                v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
            ],
            showPassword:false,
            password:'',
            passwordRules:[
                v => !!v || 'Password is Required',
                v => (v && v.length >= 6) || 'min 6 characters'
            ]
        }
    },
    computed:{
        ...mapGetters({
            user : 'auth/user',
        })
    },
    methods:{
        ...mapActions({
            setAlert : 'alert/set',
            setAuth : 'auth/set'
        }),
        authProvider(provider){
            let url = '/api/auth/social/' + provider
            axios.get(url)
            .then((response) => {
                let data = response.data
                window.location.href = data.url
            })
            .error((error) => {
                let response = error.response
                    this.setAlert({
                        status : true,
                        color : 'error',
                        text : response.data.error
                    })
            })
        },
        submit () {
            if(this.$refs.form.validate()){
                let formData = {
                    'email' : this.email,
                    'password' : this.password
                }
                axios.post('/api/auth/login',formData)
                    .then((response) => {
                        let {data} = response.data
                        console.log(data)
                        this.setAuth(data)
                        if(this.user.user.id.length > 0){
                            this.setAlert({
                                status : true,
                                color : 'success',
                                text : 'login success'
                            })
                            this.close()
                        }else{
                            this.setAlert({
                                status : true,
                                color : 'error',
                                text : 'Login Failed'
                            })
                        }
                    })
                    .catch((error) => {
                        let response = error.response
                        this.setAlert({
                            status : true,
                            color : 'error',
                            text : response.data.error
                        })
                    })
            }
        },
        close() {
            this.$emit('closed',false)
        }
    }
}
</script>
