<template>
    <v-app>
        <alert></alert>
        <keep-alive>
            <v-dialog v-model="dialog" fullscreen hide-overlay persistent transition="dialog-botton-transition">
                <search :is="currentComponent" @closed="setDialogStatus" />
            </v-dialog>
        </keep-alive>

        <v-navigation-drawer app v-model="drawer">
            <v-list>
                <v-list-item v-if="!guest">
                    <v-list-item-avatar>
                        <v-img src="https://randomuser.me/api/portraits/thumb/men/79.jpg"></v-img>
                    </v-list-item-avatar>
                    <v-list-item-content>
                        <v-list-item-title>
                            {{ user.user.name }}
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <div class="pa-2" v-if="guest">
                    <v-btn block @click="setDialogComponent('login')" color="primary" class="mb-1">
                         <v-icon color="" left>mdi-lock</v-icon>
                         Login
                    </v-btn>
                    <v-btn block color="success" class="mb-1">
                         <v-icon color="" left>mdi-account</v-icon>
                         Register
                    </v-btn>
                </div>

                <v-divider></v-divider>

                <v-list-item
                    v-for="(item,index) in menus"
                    :key="`menu-`+index"
                    :to="item.route"
                >

                    <v-list-item-icon>
                         <v-icon color="" left> {{item.icon}}</v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title>{{item.title}}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
            <template v-slot:append v-if="!guest">
                <div class="pa-2">
                    <v-btn @click="logout()" block color="red" dark>
                         <v-icon left>mdi-lock</v-icon>
                         Logout
                    </v-btn>
                </div>
            </template>


        </v-navigation-drawer>

        <v-app-bar app color="success" dark v-if="isHome">
            <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
            <v-toolbar-title>Crowdfunding APP</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn icon>
                <v-badge color="orange" overlap v-if="transactions > 0">
                    <template v-slot:badge>
                        <span>{{ transactions }}</span>
                    </template>
                    <v-icon>mdi-cash-multiple</v-icon>
                </v-badge>
                <v-icon v-else>mdi-cash-multiple</v-icon>

            </v-btn>

            <v-text-field
                slot="extension"
                hide-details="true"
                append-icon="mdi-microphone"
                flat
                label="search"
                prepend-inner-icon="mdi-magnify"
                solo-inverted
                @click="setDialogComponent('search')"
            >

            </v-text-field>




        </v-app-bar>
        <v-app-bar app color="success" dark v-else>
                <v-btn icon @click.stop="$router.go(-1)">
                    <v-icon>mdi-arrow-left-circle</v-icon>
                </v-btn>


            <v-spacer></v-spacer>
            <v-btn icon>
                <v-badge color="orange" overlap v-if="transactions > 0">
                    <template v-slot:badge>
                        <span>{{ transactions }}</span>
                    </template>
                    <v-icon>mdi-cash-multiple</v-icon>
                </v-badge>
                <v-badge color="orange" overlap v-else>

                    <v-icon>mdi-cash-multiple</v-icon>
                </v-badge>
            </v-btn>
        </v-app-bar>

        <!-- Sizes your content based upon application components -->
        <v-main>

            <!-- Provides the application the proper gutter -->
            <v-container fluid>

            <!-- If using vue-router -->
            <router-view></router-view>
            </v-container>
        </v-main>
        <v-footer padless>
            <v-col
            class="text-center"
            cols="12"
            >
            {{ new Date().getFullYear() }} — <strong>NupTzy</strong>
            </v-col>
        </v-footer>
    </v-app>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex'
    import Alert from './components/Alert.vue'
    import Search from './components/Search.vue'
    import Login from './components/Login.vue'

    export default {
    components: { Alert, Search,Login},
        name:'App',
        data:()=>   ({
            drawer:false,
            menus:[
                {title:'Home',icon:'mdi-home',route:'/'},
                {title:'Donations',icon:'mdi-hand-heart',route:'/donations'},
            ],
        }),
        methods:{
            logout () {
                console.log(this.user.token)
                let config = {
                    'headers' : {
                        'Authorization' : 'Bearer ' + this.user.token,
                    }
                }
                axios.get('/api/auth/logout',config)
                    .then((response) => {
                        this.setAuth({})
                        this.setAlert({
                            status:true,
                            color:'success',
                            text:'Berhasil Logout'
                        })
                    })
                    .catch((error) => {
                        console.log(error)
                        this.setAlert({
                            status:true,
                            color:'success',
                            text: 'ada error guys'
                        })
                    })
            },
            ...mapActions({
                setDialogStatus : 'dialog/setStatus',
                setDialogComponent : 'dialog/setComponent',
                setAlert : 'alert/set',
                setAuth : 'auth/set',
                checkToken : 'auth/checkToken'

            }),
            closeDialog(value){
                this.dialog = value
            }

        },
        computed:{
            isHome(){
                return (this.$route.path==='/' || this.$route.path==='/home')
            },
            ...mapGetters({
                'transactions':'transaction/transactions',
                'guest' : 'auth/guest',
                'user' : 'auth/user',
                'dialogStatus':'dialog/status',
                'currentComponent':'dialog/component'
            }),
            dialog:{
                get(){
                    return this.dialogStatus
                },
                set(value){
                    this.setDialogStatus(value)
                }
            }

        },
        mounted(){
            console.log(this.user)
            if(this.user){
                this.checkToken(this.user)
            }
        }


    }
</script>
