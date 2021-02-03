<template>
    <v-app>
        <v-navigation-drawer app v-model="drawer">
            <v-list>
                <v-list-item v-if="!guest">
                    <v-list-item-avatar>
                        <v-img src="https://randomuser.me/api/portraits/thumb/men/79.jpg"></v-img>
                    </v-list-item-avatar>
                    <v-list-item-content>
                        <v-list-item-title>
                            John Leider
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <div class="pa-2" v-if="guest">
                    <v-btn block @click="login()" color="primary" class="mb-1">
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
                <v-badge color="orange" overlap>
                    <template v-slot:badge>
                        <span>{{ transactions }}</span>
                    </template>
                    <v-icon>mdi-cash-multiple</v-icon>
                </v-badge>
            </v-btn>
            <v-text-field
                slot="extension"
                hide-details="true"
                append-icon="mdi-microphone"
                flat
                label="search"
                prepend-inner-icon="mdi-magnify"
                solo-inverted

            ></v-text-field>



        </v-app-bar>
        <v-app-bar app color="success" dark v-else>
                <v-btn icon @click.stop="$router.go(-1)">
                    <v-icon>mdi-arrow-left-circle</v-icon>
                </v-btn>


            <v-spacer></v-spacer>
            <v-btn icon>
                <v-badge color="orange" overlap v-if="transaction>0">
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
        <v-footer app>
            footer slur
        </v-footer>
    </v-app>
</template>

<script>
    import {mapGetters} from 'vuex'
    export default {
        name:'App',
        data:()=>   ({
            drawer:false,
            menus:[
                {title:'Home',icon:'mdi-home',route:'/'},
                {title:'Donations',icon:'mdi-hand-heart',route:'/donations'},
            ],
            guest:false,

        }),
        methods:{
            logout:function () {
                this.guest = true
            },
            login:function (){
                this.guest = false
            }
        },
        computed:{
            isHome(){
                return (this.$route.path==='/' || this.$route.path==='/home')
            },
            ...mapGetters({
                'transactions':'transaction/transactions'
            }),
            // transaction (){
            //     return this.$store.getters.transaction
            // }
        }
    }
</script>
