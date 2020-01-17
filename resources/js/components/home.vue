<template>
    <div id="main-wrapper">
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header">
                    <a class="navbar-brand" href="/">
                        <b>
                            <img src="assets/images/logo-icon.png" alt="homepage" class="dark-logo" />
                            <img src="assets/images/logo-light-icon.png" alt="homepage" class="light-logo" />
                        </b>
                        <span>
                            <img src="assets/images/logo-text.png" alt="homepage" class="dark-logo" />
                            <img src="assets/images/logo-light-text.png" class="light-logo" alt="homepage" />
                        </span>
                    </a>
                </div>

                <div class="navbar-collapse">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item"> <a class="nav-link nav-toggler d-block d-sm-none waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        <li class="nav-item"> <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark" href="javascript:void(0)"><i class="icon-menu"></i></a> </li>
                    </ul>

                    <ul class="navbar-nav my-lg-0">
                        <li class="nav-item right-side-toggle" @click="cerrar_session"> <a class="nav-link  waves-effect waves-light" href="javascript:void(0)"><i class="ti-power-off"></i></a></li>
                        <li class="nav-item" v-if="usuario"><b-button pill variant="primary" class="nav-link dropdown-toggle waves-effect waves-dark profile-pic line-height-0 margin-top-0-5" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-text="usuario.nombre[0]"></b-button></li>
                    </ul>
                </div>
            </nav>
        </header>

        <aside class="left-sidebar" v-if="usuario">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">--- MENÚ</li>
                        <li><router-link class="waves-effect waves-dark" to="/tallas"><i class="fa fa-product-hunt"></i> <span class="hide-menu">Tallas de poleras</span></router-link></li>
                        <li><router-link class="waves-effect waves-dark" to="/categorias"><i class="fa fa fa-bars"></i><span class="hide-menu">Categorías</span></router-link> </li>
                        <li><router-link class="waves-effect waves-dark" to="/ventas"><i class="fa fa fa-usd"></i><span class="hide-menu">Ventas</span></router-link> </li>

                        <li v-if="individuales.length > 0">
                            <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-user"></i><span class="hide-menu">Indivual</span></a>
                            <ul aria-expanded="false" class="collapse-in">
                                <li @click="actualizar_datos" v-for="categoria in individuales" :key="categoria.id">
                                    <router-link
                                        :to="{ path: '/atletas/' + categoria.id}"
                                        v-text="categoria.nombre">
                                    </router-link>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-user"></i><span class="hide-menu">Indivual</span></a>
                            <ul aria-expanded="false" class="collapse-in">
                                <li @click="actualizar_datos" v-for="categoria in duplas" :key="categoria.id">
                                    <router-link
                                        :to="{ path: '/atletas/' + categoria.id}"
                                        v-text="categoria.nombre">
                                    </router-link>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-user"></i><span class="hide-menu">Tríos</span></a>
                            <ul aria-expanded="false" class="collapse-in">
                                <li @click="actualizar_datos" v-for="categoria in trios" :key="categoria.id">
                                    <router-link
                                        :to="{ path: '/atletas/' + categoria.id}"
                                        v-text="categoria.nombre">
                                    </router-link>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="page-wrapper">
            <b-container fluid>
                <router-view></router-view>
            </b-container>
        </div>
    </div>
</template>

<script>
    import { mapState, mapGetters, mapActions, mapMutations } from 'vuex'

    export default {
        data() {
            return {
                categorias: []
            }
        },
        computed: {
            ...mapGetters('usuario', ['saludo']),
            ...mapState('usuario', ['usuario']),
            individuales() {
                return this.categorias.filter(c => c.categoria == 1)
            },
            duplas() {
                return this.categorias.filter(c => c.categoria == 2)
            },
            trios() {
                return this.categorias.filter(c => c.categoria == 3)
            }

        },
        methods: {
            ...mapActions('usuario', ['salir']),
            ...mapMutations('usuario', ['actualizar']),
            actualizar_datos(){
                Event.$emit('refrescar');
            },
            listar_categorias(){
                let me = this

                axios.get('/categorias/atletas').then(function (response) {
                    me.categorias = response.data.categorias
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            usuario_logeado(){
                let me = this

                axios.get('/usuario/logeado').then(function (response) {
                    if(response.data.usuario){
                        me.actualizar(response.data.usuario)
                        me.saludo
                    } else {
                        me.$router.push('/')
                    }
                })
            },
            cerrar_session(){

                let me = this

                axios.post('/logout').then(function (response) {
                    if (response.status === 302 || 401) {
                        me.salir()
                        window.location.href = "/";
                    }
                    else {
                        console.log(response)
                    }
                })
                .catch(function (error) {
                    console.log(error)
                });

            }
        },
        mounted(){
            this.usuario_logeado()
            this.listar_categorias()
        }
    }
</script>
