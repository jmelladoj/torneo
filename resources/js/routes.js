window.Vue = require('vue');

import VueRouter from 'vue-router'

Vue.use(VueRouter)

import Tallas from './components/intranet/tallas.vue'
import Categorias from './components/intranet/categorias.vue'
import Atletas from './components/intranet/atletas.vue'

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
    ],
    mode: 'history'
})
