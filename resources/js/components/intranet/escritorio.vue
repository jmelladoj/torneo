<template>
    <div>
        <titulo-pagina titulo="Escritorio"></titulo-pagina>

        <b-row>
            <b-col>
                <b-card-group>
                    <b-card class="mt-0 mb-0">
                            <b-col cols="12">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h4><i class="fa fa-users"></i></h4>
                                        <h6 class="text-muted"><b>Total atletas</b></h6>
                                    </div>
                                    <div class="ml-auto">
                                        <h4 class="counter text-primary">{{ atletas.length }}</h4>
                                    </div>
                                </div>
                            </b-col>
                    </b-card>
                    <b-card class="mt-0 mb-0">
                            <b-col cols="12">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h4><i class="fa fa-users"></i></h4>
                                        <h6 class="text-muted"><b>Pagaron</b></h6>
                                    </div>
                                    <div class="ml-auto">
                                        <h4 class="counter text-primary">{{ pagaron }}</h4>
                                    </div>
                                </div>
                            </b-col>
                    </b-card>
                    <b-card class="mt-0 mb-0">
                            <b-col cols="12">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h4><i class="fa fa-users"></i></h4>
                                        <h6 class="text-muted"><b>Invitados</b></h6>
                                    </div>
                                    <div class="ml-auto">
                                        <h4 class="counter text-primary">{{ invitados }} </h4>
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

                    <b-table class="my-3" show-empty small striped outlined stacked="sm" :items="atletas" :fields="fields" :current-page="currentPage" :per-page="perPage" :filter="filter" :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" @filtered="onFiltered">
                        <template v-slot:empty>
                            <center><h5>No hay registros</h5></center>
                        </template>

                        <template v-slot:cell(index)="data">
                            {{ data.index + 1 }}
                        </template>

                        <template v-slot:cell(pago)="data">
                            {{ data.item.pago == 1 ? 'APROBADO' : 'PENDIENTE' }}
                        </template>

                        <template v-slot:cell(invitado)="data">
                            {{ data.item.invitado == 1 ? 'SÍ' : 'NO' }}
                        </template>

                        <template v-slot:cell(encargado)="data">
                            {{ data.item.encargado == 1 ? 'SÍ' : 'NO' }}
                        </template>

                         <template v-slot:cell(acciones)="row">
                            <b-button size="xs" variant="warning" title="Actualizar información" @click="abrir_modal_actualizar_atleta(row.item.id, row.item.categoria_id)">
                                <i class="fa fa-pencil"></i>
                            </b-button>
                        </template>
                    </b-table>
                </b-card>
            </b-col>
        </b-row>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                atletas: [],
                ventas: [],
                fields: [
                    { key: 'index', label: '#', sortable: true, class: 'text-center' },
                    { key: 'nombre', label: 'Nombre', sortable: true, class: 'text-left' },
                    { key: 'run', label: 'Run', sortable: true, class: 'text-left' },
                    { key: 'categoria_completa', label: 'Categoría atleta', sortable: true, class: 'text-left' },
                    { key: 'fecha_nacimiento', label: 'Fecha de nacimiento', sortable: true, class: 'text-left' },
                    { key: 'correo', label: 'Correo', sortable: true, class: 'text-left' },
                    { key: 'box', label: 'Box', sortable: true, class: 'text-left' },
                    { key: 'talla_polera', label: 'Talla polera', sortable: true, class: 'text-left' },
                    { key: 'pago', label: 'Pago', sortable: true, class: 'text-center' },
                    { key: 'invitado', label: 'Invitado', sortable: true, class: 'text-center' },
                    { key: 'acciones', label: 'Acciones', class: 'text-center'}
                ],
                totalRows: 1,
                currentPage: 1,
                perPage: 15,
                pageOptions: [15, 50, 100, 150, 200, 150],
                sortBy: '',
                sortDesc: false,
                filter: null,
            }
        },
        computed: {
            pagaron() {
                return this.atletas.filter(i => i.pago == 1  && i.invitado == 0).length
            },
            invitados() {
                return this.atletas.filter(i => i.invitado == 1 && i.pago == 0).length
            },
            recaudado(){
                return this.ventas.reduce((total, v) => total += v.estado == 1 && v.invitado == 0 ? parseInt(v.monto_pago) : 0, 0)
            },
            webpay(){
                return this.ventas.reduce((total, v) => total += v.token && v.estado == 1 && v.invitado == 0  ? parseInt(v.monto_pago) : 0, 0)
            },
            transferencia(){
                return this.ventas.reduce((total, v) => total += !v.token && v.estado == 1 && v.invitado == 0  ? parseInt(v.monto_pago) : 0, 0)
            },
            sortOptions() {
                return this.atletas.filter(f => f.sortable).map(f => {
                    return { text: f.label, value: f.key }
                })
            },
        },
        methods: {
            onFiltered(filteredItems) {
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            obtener_registros(){
                this.listar_atletas()
                this.listar_ventas()
            },
            listar_atletas(){
                let me = this

                axios.get('/atletas/obtener').then(function (response) {
                    me.atletas = response.data.atletas
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listar_ventas(){
                let me = this

                axios.get('/ventas/torneo').then(function (response) {
                    me.ventas = response.data.ventas
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            abrir_modal_actualizar_atleta(id_atleta, id_categoria){
                Evento.$emit('cargar_modal_atleta', id_atleta, id_categoria, 1);
            }
        },
        beforeMount() {
            this.obtener_registros()

            Evento.$on('refrescar_escritorio', (id) => {
                this.obtener_registros()
            })
        }
    }
</script>
