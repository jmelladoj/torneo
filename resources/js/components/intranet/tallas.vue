<template>
    <div>
        <titulo-pagina titulo="Tallas de poleras"></titulo-pagina>

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

                        <template v-slot:cell(index)="data">
                            {{ data.index + 1 }}
                        </template>


                        <template v-slot:cell(acciones)="row">
                            <b-button size="xs" variant="warning" title="Actualizar información" @click="abrir_modal_polera(row.item)">
                                <i class="fa fa-pencil"></i>
                            </b-button>

                            <b-button size="xs" variant="danger" title="Eliminar registro" @click="borrar(row.item.id)">
                                <i class="fa fa-trash"></i>
                            </b-button>
                        </template>

                    </b-table>
                </b-card>
            </b-col>
        </b-row>

        <b-modal ref="modal_polera" :title="modal_polera.titulo" no-close-on-backdrop scrollable static>
            <b-form>
                <b-form-group label="Talla de polera">
                    <b-form-input
                        v-model="$v.polera.talla.$model"
                        :state="$v.polera.talla.$dirty ? !$v.polera.talla.$error : null"
                        aria-describedby="polera-talla"
                    ></b-form-input>

                    <b-form-invalid-feedback id="polera-talla">
                        Campo alfabético, mínimo de 1 caracterer.
                    </b-form-invalid-feedback>
                </b-form-group>
            </b-form>

            <template slot="modal-footer">
                <b-button :disabled="$v.polera.$invalid" v-show="modal_polera.accion == 1" size="md" variant="success" @click="crear_actualizar_polera"> Guardar </b-button>
                <b-button :disabled="$v.polera.$invalid" v-show="modal_polera.accion == 2" size="md" variant="warning" @click="crear_actualizar_polera"> Actualizar </b-button>
                <b-button size="md" variant="danger" @click="cerrar_modal_polera"> Cerrar </b-button>
            </template>
        </b-modal>

        <div class="fixed-bottom mb-5 mr-5">
            <b-button pill variant="success" size="lg" class="pull-right heigth-50" @click="abrir_modal_polera"><i class="ti-plus"></i></b-button>
        </div>
    </div>
</template>

<script>
    import { required, minLength, alpha } from 'vuelidate/lib/validators'
    import { mapMutations, mapGetters } from 'vuex'

    export default {
        data() {
            return {
                items: [],
                fields: [
                    { key: 'index', label: '#', sortable: true, class: 'text-center' },
                    { key: 'talla', label: 'Nombre', sortable: true, class: 'text-left' },
                    { key: 'cantidad_poleras', label: 'Cantidad poleras', sortable: true, class: 'text-left' },
                    { key: 'acciones', label: 'Acciones', class: 'text-center'}
                ],
                totalRows: 1,
                currentPage: 1,
                perPage: 15,
                pageOptions: [15, 50, 100, 150, 200, 150],
                sortBy: '',
                sortDesc: false,
                filter: null,
                modal_polera: {
                    titulo: '',
                    accion: 0
                },
                polera: {
                    id: 0,
                    talla: ''
                }
            }
        },
        validations:{
            polera: {
                talla: {
                    required,
                    minLength: minLength(1),
                    alpha
                }
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
            listar_poleras(){
                let me = this

                axios.get('/poleras').then(function (response) {
                    me.items = response.data.poleras
                    me.totalRows = me.items.length;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            abrir_modal_polera(data = []) {
                let me = this

                me.limpiar_datos_polera()
                me.modal_polera.titulo = data.id == undefined ? "Agregar polera" : "Modificar polera"
                me.modal_polera.accion = data.id == undefined ? 1 : 2

                if(me.modal_polera.accion == 2){
                    me.polera.id = data.id
                    me.polera.talla = data.talla

                    this.$v.polera.$touch(true)
                }

                this.$refs['modal_polera'].show()
            },
            cerrar_modal_polera() {
                this.modal_polera.titulo = ""
                this.modal_polera.accion = 0
                this.$refs['modal_polera'].hide()
            },
            limpiar_datos_polera() {
                this.polera.id = 0
                this.polera.talla = ''

                this.$v.$reset();
            },
            crear_actualizar_polera() {
                if(this.$v.polera.$invalid){
                    this.$v.polera.$touch()
                    return
                }

                let me = this

                axios.post('/polera/crear/actualizar',{
                        'id': me.polera.id,
                        'talla': me.polera.talla
                    }).then(function (response) {
                        me.listar_poleras()
                        me.$store.commit('msg_success', me.polera.id == 0 ? 'Registro agregado exitosamente.' :  'Registro actualizado exitosamente.')

                        if(me.polera.id == 0){
                            me.limpiar_datos_polera()
                        } else {
                            me.cerrar_modal_polera()
                        }

                    }).catch(function (error) {
                        console.log(error)
                })
            },
            borrar(id) {
                swal.fire({
                    title: '¿Deseas borrar el registro?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, ¡bórralo!'
                }).then((result) => {
                    if (result.value) {
                        let me = this
                        axios.post('/polera/borrar',{
                            'id': id
                        }).then(function (response) {
                            me.listar_poleras();
                            me.$store.commit('msg_success', 'Registro eliminado exitosamente.')
                        }).catch(function (error) {
                            console.log(error);
                        })
                    }
                })
            }
        },
        mounted() {
            this.listar_poleras()
        }
    }
</script>
