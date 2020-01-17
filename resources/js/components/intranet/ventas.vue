<template>
    <div>
        <titulo-pagina titulo="Ventas"></titulo-pagina>

        <b-row>
            <b-col>
                <b-card>
                    <b-row>
                        <b-col lg="6" class="my-1">
                            <b-form-group label="Búsqueda" label-cols-sm="2" label-align-sm="left" label-size="sm" label-for="filterInput" class="mb-0" >
                            <b-input-group size="sm">
                                <b-form-input v-model="filter" type="search" id="filterInput" placeholder="Escribe para buscar"></b-form-input>
                                <b-input-group-append>
                                    <b-button :disabled="!filter" @click="filter = ''">Limpiar</b-button>
                                </b-input-group-append>
                            </b-input-group>
                            </b-form-group>
                        </b-col>

                        <b-col lg="6" class="my-1">
                            <b-form-group label="Ordenar" label-cols-sm="2" label-align-sm="left" label-size="sm" label-for="sortBySelect" class="mb-0">
                                <b-input-group size="sm">
                                    <b-form-select v-model="sortBy" id="sortBySelect" :options="sortOptions" class="w-75">
                                        <template v-slot:first>
                                            <option value="">Sin ordenar</option>
                                        </template>
                                    </b-form-select>
                                    <b-form-select v-model="sortDesc" size="sm" :disabled="!sortBy" class="w-25">
                                        <option :value="false">Asc</option>
                                        <option :value="true">Desc</option>
                                    </b-form-select>
                                </b-input-group>
                            </b-form-group>
                        </b-col>

                        <b-col lg="6" class="my-1">
                            <b-form-group label="Por página" label-cols-sm="2" label-align-sm="left" label-size="sm" label-for="perPageSelect" class="mb-0">
                                <b-form-select v-model="perPage" id="perPageSelect" size="sm" :options="pageOptions"></b-form-select>
                            </b-form-group>
                        </b-col>

                        <b-col lg="6" class="my-1">
                            <b-pagination v-model="currentPage" :total-rows="totalRows" :per-page="perPage" align="fill" size="sm" class="my-0" ></b-pagination>
                        </b-col>
                    </b-row>

                    <b-table class="my-3" show-empty small striped outlined stacked="sm" :items="items" :fields="fields" :current-page="currentPage" :per-page="perPage" :filter="filter" :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" @filtered="onFiltered">
                        <template v-slot:empty>
                            <center><h5>No hay registros</h5></center>
                        </template>

                        <template v-slot:cell(monto_pago)="data">
                            {{ data.item.monto_pago  | currency }}
                        </template>

                        <template v-slot:cell(estado)="data">
                            <label v-text="data.item.estado == 0 ? 'PENDIENTE' : 'CONFIRMADO'"></label>
                        </template>

                        <template v-slot:cell(acciones)="row">
                            <b-button v-if="row.item.estado == 0" size="xs" variant="success" title="Confirmar inscripción" @click="confirmar(row.item.id)">
                                <i class="fa fa-check"></i>
                            </b-button>

                            <b-button v-if="row.item.estado == 0" size="xs" variant="danger" title="Eliminar inscripción notificando" @click="borrar(row.item.id, 1)">
                                <i class="fa fa-envelope-o"></i>
                            </b-button>

                            <b-button v-if="row.item.estado == 0" size="xs" variant="danger" title="Eliminar inscripción sin notificar" @click="borrar(row.item.id, 2)">
                                <i class="fa fa-trash-o"></i>
                            </b-button>

                            <b-button v-if="row.item.estado == 1" size="xs" variant="danger" title="Marcar como pendiente de pago" @click="pendiente(row.item.id)">
                                <i class="fa fa-remove"></i>
                            </b-button>
                        </template>
                    </b-table>
                </b-card>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    import { mapMutations, mapGetters } from 'vuex'

    export default {
        data() {
            return {
                items: [],
                fields: [
                    { key: 'id', label: '#', sortable: true, class: 'text-center' },
                    { key: 'nombre_atleta', label: 'Nombre', sortable: true, class: 'text-left' },
                    { key: 'run_atleta', label: 'Run', sortable: true, class: 'text-left' },
                    { key: 'correo_atleta', label: 'Correo', sortable: true, class: 'text-left' },
                    { key: 'categoria_atleta', label: 'Categoría', sortable: true, class: 'text-left' },
                    { key: 'monto_pago', label: 'Valor', sortable: true, class: 'text-left' },
                    { key: 'estado', label: 'Estado', sortable: true, class: 'text-left' },
                    { key: 'acciones', label: 'Acciones', class: 'text-center'}
                ],
                totalRows: 1,
                currentPage: 1,
                perPage: 15,
                pageOptions: [15, 50, 100, 150, 200, 150],
                sortBy: '',
                sortDesc: false,
                filter: null
            }
        },
        computed: {
            sortOptions() {
                return this.fields.filter(f => f.sortable).map(f => {
                    return { text: f.label, value: f.key }
                })
            }
        },
        methods: {
            ...mapMutations(['msg_success', 'msg_error']),
            onFiltered(filteredItems) {
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            listar_ventas(){
                let me = this

                axios.get('/ventas/torneo').then(function (response) {
                    me.items = response.data.ventas
                    me.totalRows = me.items.length;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            confirmar(id) {
                swal.fire({
                    title: '¿Deseas confirmar la venta?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, ¡confirmar!'
                }).then((result) => {
                    if (result.value) {
                        let me = this
                        axios.post('/venta/confirmar',{
                            'id': id
                        }).then(function (response) {
                            me.listar_categorias();
                            me.$store.commit('msg_success', 'Venta confirmada exitosamente.')
                        }).catch(function (error) {
                            console.log(error);
                        })
                    }
                })
            },
            borrar(id, accion) {
                swal.fire({
                    title: accion == 1 ? '¿Deseas eliminar la inscripción notificando al atleta?' : '¿Deseas eliminar la inscripción sin notificar al atleta?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, ¡borrar!'
                }).then((result) => {
                    if (result.value) {
                        let me = this
                        axios.post('/venta/confirmar',{
                            'id': id
                        }).then(function (response) {
                            me.listar_categorias();
                            me.$store.commit('msg_success', 'Venta eliminada exitosamente.')
                        }).catch(function (error) {
                            console.log(error);
                        })
                    }
                })
            },
            confirmar(id) {
                swal.fire({
                    title: '¿Deseas marcar como pendiente la venta?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, ¡marcar!'
                }).then((result) => {
                    if (result.value) {
                        let me = this
                        axios.post('/venta/confirmar',{
                            'id': id
                        }).then(function (response) {
                            me.listar_categorias();
                            me.$store.commit('msg_success', 'Venta marcada como pendiente exitosamente.')
                        }).catch(function (error) {
                            console.log(error);
                        })
                    }
                })
            },
        },
        mounted() {
            this.listar_ventas()
        }
    }
</script>
