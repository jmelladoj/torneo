window.Vue = require('vue');

import VueRouter from 'vue-router'

Vue.use(VueRouter)

import Tallas from './components/intranet/tallas.vue'
import Categorias from './components/intranet/categorias.vue'
import Atletas from './components/intranet/atletas.vue'
import Ventas from './components/intranet/ventas.vue'
import Escritorio from './components/intranet/escritorio.vue'

export default new VueRouter({
    routes: [
        {
            path: '/tallas',
            name: 'tallas',
            component: Tallas
        },
        {
            path: '/categorias',
            name: 'categorias',
            component: Categorias
        },
        {
            path: '/atletas/:id',
            name: 'atletas',
            component: Atletas,
            props: true
        },
        {
            path: '/ventas',
            name: 'ventas',
            component: Ventas
        },
        {
            path: '/escritorio',
            name: 'escritorio',
            component: Escritorio
        },
    ],
    mode: 'history'
})
