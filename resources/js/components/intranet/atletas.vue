<template>
    <div>
        <titulo-pagina v-if="categoria" :titulo="nombre_categoria"></titulo-pagina>

        <b-row>
            <b-col>
                <b-card-group>
                    <b-card class="mt-0 mb-0">
                            <b-col cols="12">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h4><i class="fa fa-users"></i></h4>
                                        <h6 class="text-muted"><b>Inscritos</b></h6>
                                    </div>
                                    <div class="ml-auto">
                                        <h4 class="counter text-primary">0</h4>
                                    </div>
                                </div>
                            </b-col>
                    </b-card>
                    <b-card class="mt-0 mb-0">
                            <b-col cols="12">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h4><i class="fa fa-users"></i></h4>
                                        <h6 class="text-muted"><b>Pendientes</b></h6>
                                    </div>
                                    <div class="ml-auto">
                                        <h4 class="counter text-primary">0</h4>
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

                        <template v-slot:cell(index)="data">
                            {{ data.index + 1 }}
                        </template>

                        <template v-slot:cell(acciones)="row">
                            <b-button size="xs" variant="warning" title="Actualizar información" @click="abrir_modal_atleta(row.item)">
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

        <b-modal ref="modal_atleta" size="lg" :title="modal_atleta.titulo" no-close-on-backdrop scrollable static>
            <b-form>
                <b-row>
                    <b-col xs="12" sm="12" md="6">
                        <b-form-group label="Tipo de pago">
                            <b-form-select
                                v-model="tipo_pago"
                                aria-describedby="categoria-categoria"
                                :options="opciones_pago">
                            </b-form-select>

                            <b-form-invalid-feedback id="categoria-categoria">
                                Debes de seleccionar una opción.
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </b-col>
                    <b-col xs="12" sm="12" md="6">
                        <b-form-group label="Seleccionar categoría">
                            <b-form-select
                                v-model="categoria_seleccionada"
                                aria-describedby="categoria-categoria"
                                :options="opciones_categoria"
                                disabled>
                            </b-form-select>

                            <b-form-invalid-feedback id="categoria-categoria">
                                Debes de seleccionar una opción.
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row v-for="(atleta, index) in atletas" :key="index">
                    <b-col xs="12" sm="12" md="12">
                        <h6 class="text-right" v-text="'Datos atleta ' + (index + 1)"></h6>
                    </b-col>
                    <b-col xs="12" sm="12" md="6">
                        <b-form-group label="Run atleta">
                            <b-form-input
                                v-rut:live
                                v-model="$v.atletas.$each[index].run.$model"
                                :state="$v.atletas.$each[index].run.$dirty ? !$v.atletas.$each[index].run.$error : null"
                                :aria-describedby="'atleta-run' + index"
                            ></b-form-input>

                            <b-form-invalid-feedback :id="'atleta-run' + index">
                                Campo de texto, mínimo de 3 caracteres.
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </b-col>
                    <b-col xs="12" sm="12" md="6">
                        <b-form-group label="Nombre y apellido atleta">
                            <b-form-input
                                v-model="$v.atletas.$each[index].nombre.$model"
                                :state="$v.atletas.$each[index].nombre.$dirty ? !$v.atletas.$each[index].nombre.$error : null"
                                :aria-describedby="'atleta-nombre' + index"
                            ></b-form-input>

                            <b-form-invalid-feedback :id="'atleta-nombre' + index">
                                Campo de texto, mínimo de 3 caracteres.
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </b-col>
                    <b-col xs="12" sm="12" md="6">
                        <b-form-group label="Talla de polera">
                            <b-form-select
                                v-model="$v.atletas.$each[index].polera.$model"
                                :state="$v.atletas.$each[index].polera.$dirty ? !$v.atletas.$each[index].polera.$error : null"
                                :aria-describedby="'atleta-polera' + index">

                                <option :value="null">Selecciona una opción ...</option>
                                <option v-for="polera in poleras" :key="polera.id" :value="polera.id" v-text="polera.talla"></option>
                            </b-form-select>

                            <b-form-invalid-feedback :id="'atleta-polera' + index">
                                Debes de seleccionar una opción.
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </b-col>
                    <b-col xs="12" sm="12" md="6" v-show="categoria.limitancia_edad == 1">
                        <b-form-group label="Fecha de nacimiento">
                            <b-form-input
                                type="date"
                                v-model="$v.atletas.$each[index].fecha_nacimiento.$model"
                                :state="$v.atletas.$each[index].fecha_nacimiento.$dirty ? !$v.atletas.$each[index].fecha_nacimiento.$error : null"
                                :aria-describedby="'atleta-fecha-nacimiento' + index"
                            ></b-form-input>

                            <b-form-invalid-feedback :id="'atleta-fecha-nacimiento' + index">
                                Ingresa una fecha válida para tu categoría.
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </b-col>
                    <b-col xs="12" sm="12" md="12" v-show="index < 3">
                        <hr>
                    </b-col>
                </b-row>
            </b-form>

            <template slot="modal-footer">
                <b-button :disabled="$v.atletas.$invalid" size="md" variant="success" @click="agregar_atletas"> Agregar atletas </b-button>
                <b-button size="md" variant="danger" @click="cerrar_modal_atleta"> Cerrar </b-button>
            </template>
        </b-modal>

        <div class="fixed-bottom mb-5 mr-5">
            <b-button pill variant="success" size="lg" class="pull-right heigth-50" @click="abrir_modal_atleta"><i class="ti-plus"></i></b-button>
        </div>
    </div>
</template>

<script>
    import { required, minLength, numeric, minValue, maxValue, requiredIf } from 'vuelidate/lib/validators'
    import { mapMutations, mapGetters } from 'vuex'

    export default {
        props: [
            'id'
        ],
        data() {
            return {
                categoria_seleccionada: null,
                tipo_pago: 0,
                categoria: [],
                atletas: [],
                poleras: [],
                opciones_categoria: [
                    { value: null, text: 'Selecciona una opción ...' },
                    { value: 1, text: 'Individual' },
                    { value: 2, text: 'Duplas' },
                    { value: 3, text: 'Tríos' },
                ],
                opciones_pago: [
                    { value: 0, text: 'Invitado' },
                    { value: 1, text: 'Transferencia' },
                ],
                items: [],
                fields: [
                    { key: 'index', label: '#', sortable: true, class: 'text-center' },
                    { key: 'nombre', label: 'Nombre', sortable: true, class: 'text-left' },
                    { key: 'atleta_nombre', label: 'Categoría', sortable: true, class: 'text-left' },
                    { key: 'valor', label: 'Valor', sortable: true, class: 'text-left' },
                    { key: 'cupos', label: 'Cupos', sortable: true, class: 'text-left' },
                    { key: 'inscritos', label: 'Inscritos', sortable: true, class: 'text-left' },
                    { key: 'acciones', label: 'Acciones', class: 'text-center'}
                ],
                totalRows: 1,
                currentPage: 1,
                perPage: 15,
                pageOptions: [15, 50, 100, 150, 200, 150],
                sortBy: '',
                sortDesc: false,
                filter: null,
                modal_atleta: {
                    titulo: '',
                    accion: 0
                }
            }
        },
        validations:{
            atleta:{
                run: {
                    required
                },
                nombre: {
                    required
                }
            },
            atletas: {
                $each: {
                    run: {
                        required,
                        minLength: minLength(3)
                    },
                    nombre: {
                        required,
                        minLength: minLength(3)
                    },
                    polera: {
                        required,
                        minValue: minValue(1)
                    },
                    fecha_nacimiento: {
                        required: requiredIf(function () {
                            return this.categoria.limitancia_edad == 1 ? true : false
                        })
                    }
                }
            }
        },
        computed: {
            sortOptions() {
                return this.fields.filter(f => f.sortable).map(f => {
                    return { text: f.label, value: f.key }
                })
            },
            nombre_categoria() {
                return 'Atletas en ' + this.categoria.nombre
            }
        },
        methods: {
            ...mapMutations(['msg_success', 'msg_error']),
            fecha_limitancia_atleta(){
                var f = new Date();
                f.setMonth(f.getMonth() - (this.categoria.edad_minima * 12))
                return f.getFullYear() + "-" + (f.getMonth() + 1) + "-" + f.getDate()
            },
            onFiltered(filteredItems) {
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            listar_tallas(){
                let me = this

                axios.get('/poleras').then(function (response) {
                    me.poleras = response.data.poleras
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listar_categoria(){
                let me = this

                axios.get('/categorias/atletas/' + this.id).then(function (response) {
                    me.categoria = response.data.categoria
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listar_atletas(){
                let me = this

                axios.get('/atletas/categoria/' + this.id).then(function (response) {
                    me.items = response.data.atletas
                    me.totalRows = me.items.length;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            abrir_modal_atleta(data = []) {
                let me = this

                //me.limpiar_datos_atleta()
                me.modal_atleta.titulo = 'Agregar atletas a ' + me.categoria.nombre
                me.categoria_seleccionada = me.categoria.categoria
                me.cargar_campos_atletas()

                this.$refs['modal_atleta'].show()
            },
            cerrar_modal_atleta() {
                this.modal_atleta.titulo = ""
                this.modal_atleta.accion = 0
                this.$refs['modal_atleta'].hide()
            },
            cargar_campos_atletas(){
                this.atletas = []

                for (var i = 0; i < this.categoria_seleccionada; i++) {
                    var atleta = new Object()
                    atleta.nombre = ''
                    atleta.run = ''
                    atleta.polera = null
                    atleta.fecha_nacimiento = null
                    this.atletas.push(atleta)
                }
            },
            limpiar_datos_atleta() {
                this.atleta.id = 0
                this.atleta.nombre = ''
                this.atleta.valor = null
                this.atleta.cupos = null
                this.atleta.atleta = null

                this.$v.$reset();
            },
            agregar_atletas() {
                if(this.$v.atletas.$invalid){
                    this.$v.atletas.$touch()
                    return
                }

                let me = this

                axios.post('/atletas/agregar',{
                        'atletas': me.atletas,
                        'categoria_id': me.categoria.id,
                        'tipo_pago': me.tipo_pago
                    }).then(function (response) {
                        me.listar_atletas()
                        me.$store.commit('msg_success', 'Registro agregado exitosamente.')
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
                        axios.post('/atleta/borrar',{
                            'id': id
                        }).then(function (response) {
                            me.listar_atletas();
                            me.$store.commit('msg_success', 'Registro eliminado exitosamente.')
                        }).catch(function (error) {
                            console.log(error);
                        })
                    }
                })
            }
        },
        mounted() {
            this.listar_categoria()
            this.listar_atletas()
            this.listar_tallas()
        }
    }
</script>
