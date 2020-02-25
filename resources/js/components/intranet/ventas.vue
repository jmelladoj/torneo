<template>
    <div>
        <titulo-pagina titulo="Ventas"></titulo-pagina>

        <b-row>
            <b-col>
                <b-card-group>
                    <b-card class="mt-0 mb-0">
                            <b-col cols="12">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h4><i class="fa fa-usd"></i></h4>
                                        <h6 class="text-muted"><b>Recaudado</b></h6>
                                    </div>
                                    <div class="ml-auto">
                                        <h4 class="counter text-primary">{{ recaudado | currency }}</h4>
                                    </div>
                                </div>
                            </b-col>
                    </b-card>
                    <b-card class="mt-0 mb-0">
                            <b-col cols="12">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h4><i class="fa fa-usd"></i></h4>
                                        <h6 class="text-muted"><b>Webpay</b></h6>
                                    </div>
                                    <div class="ml-auto">
                                        <h4 class="counter text-primary">{{ webpay | currency }}</h4>
                                    </div>
                                </div>
                            </b-col>
                    </b-card>
                    <b-card class="mt-0 mb-0">
                        <b-col cols="12">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <h4><i class="fa fa-usd"></i></h4>
                                    <h6 class="text-muted"><b>Transferencia</b></h6>
                                </div>
                                <div class="ml-auto">
                                    <h4 class="counter text-primary">{{ transferencia | currency }}</h4>
                                </div>
                            </div>
                        </b-col>
                    </b-card>
                </b-card-group>
            </b-col>
        </b-row>

        <b-row>
            <b-col>
                <b-card-group>
                    <b-card class="mt-0 mb-0">
                            <b-col cols="12">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h4><i class="fa fa-list"></i></h4>
                                        <h6 class="text-muted"><b>Cantidad ventas</b></h6>
                                    </div>
                                    <div class="ml-auto">
                                        <h4 class="counter text-primary">{{ items.length }}</h4>
                                    </div>
                                </div>
                            </b-col>
                    </b-card>
                    <b-card class="mt-0 mb-0">
                            <b-col cols="12">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h4><i class="fa fa-list"></i></h4>
                                        <h6 class="text-muted"><b>Cantidad Webpay</b></h6>
                                    </div>
                                    <div class="ml-auto">
                                        <h4 class="counter text-primary">{{ cantidad_webpay }}</h4>
                                    </div>
                                </div>
                            </b-col>
                    </b-card>
                    <b-card class="mt-0 mb-0">
                        <b-col cols="12">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <h4><i class="fa fa-list"></i></h4>
                                    <h6 class="text-muted"><b>Cantidad transferencias</b></h6>
                                </div>
                                <div class="ml-auto">
                                    <h4 class="counter text-primary">{{ cantidad_transferencia }}</h4>
                                </div>
                            </div>
                        </b-col>
                    </b-card>
                </b-card-group>
            </b-col>
        </b-row>

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
                            <b-button v-if="row.item.estado == 0" size="xs" variant="success" title="Confirmar notificando a atleta" @click="confirmarOpendiente(row.item.id, 1, 1)">
                                <i class="fa fa-bell"></i>
                            </b-button>

                            <b-button v-if="row.item.estado == 0" size="xs" variant="success" title="Confirmar inscripción sin notificar" @click="confirmarOpendiente(row.item.id, 1, 0)">
                                <i class="fa fa-check"></i>
                            </b-button>

                            <b-button v-if="row.item.estado == 0" size="xs" variant="danger" title="Eliminar inscripción notificando" @click="anular_inscripcion(row.item.id, 1)">
                                <i class="fa fa-envelope-o"></i>
                            </b-button>

                            <b-button v-if="row.item.estado == 0" size="xs" variant="danger" title="Eliminar inscripción sin notificar" @click="anular_inscripcion(row.item.id, 0)">
                                <i class="fa fa-trash-o"></i>
                            </b-button>

                            <b-button v-if="row.item.estado == 1" size="xs" variant="danger" title="Marcar como pendiente de pago" @click="confirmarOpendiente(row.item.id, 0, 0)">
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
            recaudado(){
                return this.items.reduce((total, v) => total += v.estado == 1 && v.invitado == 0 ? parseInt(v.monto_pago) : 0, 0)
            },
            webpay(){
                return this.items.reduce((total, v) => total += v.token && v.estado == 1 && v.invitado == 0  ? parseInt(v.monto_pago) : 0, 0)
            },
            transferencia(){
                return this.items.reduce((total, v) => total += !v.token && v.estado == 1 && v.invitado == 0  ? parseInt(v.monto_pago) : 0, 0)
            },
            cantidad_webpay(){
                return this.items.reduce((total, v) => total += v.token ? 1 : 0, 0)
            },
            cantidad_transferencia(){
                return this.items.reduce((total, v) => total += !v.token ? 1 : 0, 0)
            },
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
            confirmarOpendiente(id, accion, envia_mail) {
                var mensaje_uno = envia_mail == 1 ? '¿Deseas confirmar la venta notificando al atelta?' : '¿Deseas confirmar la venta sin notificar?'

                swal.fire({
                    title: accion == 1 ? mensaje_uno : '¿Deseas marcar la venta como pendiente de pago?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, ¡confirmar!'
                }).then((result) => {
                    if (result.value) {
                        let me = this
                        axios.post('/venta/confirmar/pendiente',{
                            'id': id,
                            'accion': accion,
                            'envia_mail': envia_mail
                        }).then(function (response) {
                            me.listar_ventas();
                            me.$store.commit('msg_success', accion == 1 ? 'Venta confirmada exitosamente.' : 'Venta marcada como pendiente de pago')
                        }).catch(function (error) {
                            console.log(error);
                        })
                    }
                })
            },
            anular_inscripcion(id, accion) {
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
                        axios.post('/venta/anular/inscripcion',{
                            'id': id,
                            'accion': accion
                        }).then(function (response) {
                            me.listar_ventas();
                            me.$store.commit('msg_success', 'Venta eliminada exitosamente.')
                        }).catch(function (error) {
                            console.log(error);
                        })
                    }
                })
            }
        },
        mounted() {
            this.listar_ventas()
        }
    }
</script>
