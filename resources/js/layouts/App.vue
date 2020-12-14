<template>
    <!-- App.vue -->

    <v-app>

        <!-- Alert -->
        <alert></alert>

        <!-- Search Bar -->

        <keep-alive>
	  	    <v-dialog v-model="dialog" fullscreen hide-overlay persistent transition="dialog-bottom-transition">
	  		    <component :is="currentComponent" @closed="setDialogStatus"></component>
	  	    </v-dialog>
	    </keep-alive>

        <!-- sidebar -->
        <v-navigation-drawer app v-model="drawer">
            <v-list>
                <v-list-item v-if="!guest">
                    <v-list-item-avatar>
                        <v-img :src="user.user.photo_profile"></v-img>
                    </v-list-item-avatar>
                    <v-list-item-content>
                        <v-list-item-title>{{ user.user.name }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <div class="pa-2" v-if="guest">
                    <v-btn block color="primary" class="mb-1" @click="setDialogComponent('Login')">
                        <v-icon left>mdi-lock</v-icon>
                        Login
                    </v-btn>
                    <v-btn block color="success">
                        <v-icon left>mdi-account</v-icon>
                        Register
                    </v-btn>
                </div>

                <v-divider></v-divider>

                <v-list-item
                    v-for="(item, index) in menus "
                    :key="'menu-' + index"
                    :to="item.route" 
                >
                    <v-list-item-icon>
                        <v-icon left>{{ item.icon }} </v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title>{{ item.title }} </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>

            <template v-slot:append v-if="!guest">
                <div class="pa-2">
                    <v-btn block color="red" dark @click="logout">
                        <v-icon left>mdi-lock</v-icon>
                            Logout
                    </v-btn>
                </div>
            </template>

        </v-navigation-drawer>

        <!-- header -->
        <v-app-bar app color="light-blue darken-2" dark v-if="isHome">
            <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>

            <v-toolbar-title>Charity Organization</v-toolbar-title>

            <!-- divider -->
            <v-spacer></v-spacer>
            
            <v-btn icon>
                <v-badge color="orange" overlap v-if="transactions>0">
                    <template v-slot:badge >
                        <span> {{ transactions }} </span>
                    </template>
                    <v-icon>mdi-cash-multiple</v-icon>
                </v-badge>
                <v-icon v-else>mdi-cash-multiple</v-icon>
            </v-btn>

            <v-text-field
                slot="extension"
                hide-details
                append-icon="mdi-microphone"
                flat
                label="Search"
                prepend-inner-icon="mdi-magnify"
                solo-inverted
                @click="setDialogComponent('search')"
            ></v-text-field>

        </v-app-bar>

        <v-app-bar app color="light-blue darken-2" dark v-else>
            <v-btn icon @click.stop="$router.go(-1)">
                <v-icon>mdi-arrow-left-circle</v-icon>
            </v-btn>
            <!-- Divider -->
            <v-spacer></v-spacer>

            <v-btn icon>
                <v-badge color="orange" overlap v-if="transactions>0">
                    <template v-slot:badge >
                        <span> {{ transactions }} </span>
                    </template>
                    <v-icon>mdi-cash-multiple</v-icon>
                </v-badge>
                <v-icon v-else>mdi-cash-multiple</v-icon>
            </v-btn>

        </v-app-bar>

        <!-- contents -->
        <v-main>

            <!-- Provides the application the proper gutter -->
            <v-container fluid>
                <!-- If using vue-router -->
                <v-slide-y-transition>
                    <router-view></router-view>
                </v-slide-y-transition>
            </v-container>
        </v-main>

        <!-- footer -->
        <v-card>
            <v-footer absolute app>
                <v-card-text class="text-center">
                    &copy; {{ new Date().getFullYear() }} - <strong>sire-dh33</strong>
                </v-card-text>
            </v-footer>
        </v-card>
    </v-app>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex'
    import Alert from '../components/Alert'
    import Search from '../components/Search'
    import Login from '../components/Login'

    export default {
        name : "App",
        components: {
            Alert,
            Search,
            Login,
        },
        data : () => ({
            drawer : false,
            menus : [
                { title : 'Home', icon : 'mdi-home', route: '/' },
                { title : 'Campaign', icon : 'mdi-hand-heart', route: '/campaigns' },
            ],
        }),
        computed: {
            isHome () {
                return (this.$route.path==='/' | this.$route.path==='/home')
            },
            ...mapGetters({
                transactions    : 'transaction/transactions',  // "Left" New Instance, "Right" from modules  &then $store
                guest           : 'auth/guest',
                user            : 'auth/user',
                dialogStatus    : 'dialog/status',
                currentComponent: 'dialog/component',
            }),
            dialog:{
                get () {
                    return this.dialogStatus
                },
                set (value) {
                    this.setDialogStatus(value)
                }
            }

        },
        methods: {
            ...mapActions({
                setDialogStatus : 'dialog/setStatus',
                setDialogComponent : 'dialog/setComponent',
                setAuth : 'auth/set',
                setAlert : 'alert/set',
                checkToken : 'auth/checkToken'
            }),
            logout () {
                let config = {
                    headers : {
                        'Authorization' : 'Bearer ' + this.user.token,
                    },
                }
                axios.post('api/auth/logout', {}, config)
                .then((response) => {
                    this.setAuth({})
                    this.setAlert({
                        status : true,
                        color : 'success',
                        text : 'Logged out successfully'
                    })
                })
                .catch((error) => {
                    let {data} = error.response
                    this.setAlert({
                        status : true,
                        color : 'error',
                        text : data.message,
                    })
                })
            }
        },

        // mounted() {
        //     if(this.user) {
        //         this.checkToken(this.user)
        //     }
        //     // this.$router.push({ name : 'home' })
        // },

    }
</script>