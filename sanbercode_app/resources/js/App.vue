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
                    <v-btn block color="primary" class="mb-1">
                         <v-icon color="" left>mdi-lock</v-icon>
                         Login
                    </v-btn>
                    <v-btn block color="success" class="mb-1">
                         <v-icon color="" left>mdi-account</v-icon>
                         Register
                    </v-btn>
                </div>

                <v-devider></v-devider>

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
                    <v-btn color="red" dark>
                         <v-icon left>mdi-lock</v-icon>
                         Logout
                    </v-btn>
                </div>
            </template>


        </v-navigation-drawer>

        <v-app-bar app>
            App Slur
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
    export default {
        name:'App',
        data:()=>   ({
            drawer:true,
            menus:[
                {title:'Home',icon:'mdi-home',route:'/'},
                {title:'Campaigns',icon:'mdi-hand-heart',route:'/campaigns'},
            ],
            guest:false
        })
    }
</script>
