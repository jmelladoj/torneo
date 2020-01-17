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
                                        <h4 class="counter text-primary">{{ inscritos }}</h4>
                                    </div>
                                </div>
                            </b-col>
                    </b-card>
                    <b-card class="mt-0 mb-0">
                            <b-col cols="12">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h4><i class="fa fa-users"></i></h4>
                                        <h6 class="text-muted"><b>Aprobados</b></h6>
                                    </div>
                                    <div class="ml-auto">
                                        <h4 class="counter text-primary">{{ aprobados }}</h4>
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
                                        <h4 class="counter text-primary">{{ pendientes }} </h4>
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

                        <template v-slot:cell(encargado)="data">
                            <label v-if="data.item.encargado == 1">SÍ</label>
                            <label v-else>NO</label>
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
                                v-model="registro_atleta.tipo_pago"
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
                    <b-col xs="12" sm="12" md="6">
                        <b-form-group label="Email encargado">
                            <b-form-input
                                v-model="$v.registro_atleta.email.$model"
                                :state="$v.registro_atleta.email.$dirty ? !$v.registro_atleta.email.$error : null"
                                aria-describedby="atleta-email"
                            ></b-form-input>

                            <b-form-invalid-feedback id="atleta-email">
                                Ingresa un correo válido, mínimo de 3 caracteres.
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </b-col>
                    <b-col xs="12" sm="12" md="6" v-show="categoria.categoria == 1">
                        <b-form-group label="Box de crossfit">
                            <b-form-input
                                v-model="$v.registro_atleta.box.$model"
                                :state="$v.registro_atleta.box.$dirty ? !$v.registro_atleta.box.$error : null"
                                aria-describedby="atleta-box"
                            ></b-form-input>

                            <b-form-invalid-feedback id="atleta-box">
                                Campo de texto, mínimo de 1 caracter.
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </b-col>
                    <b-col xs="12" sm="12" md="6" v-show="categoria.categoria > 1">
                        <b-form-group label="Nombre de equipo">
                            <b-form-input
                                v-model="$v.registro_atleta.nombre_equipo.$model"
                                :state="$v.registro_atleta.nombre_equipo.$dirty ? !$v.registro_atleta.nombre_equipo.$error : null"
                                aria-describedby="atleta-nombre-equipo"
                            ></b-form-input>

                            <b-form-invalid-feedback id="atleta-nombre-equipo">
                                Campo de texto, mínimo de 1 caracter.
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row v-for="(atleta, index) in registro_atleta.atletas" :key="index">
                    <b-col xs="12" sm="12" md="12">
                        <h6 class="text-right" v-text="'Datos atleta ' + (index + 1)"></h6>
                    </b-col>
                    <b-col xs="12" sm="12" md="6">
                        <b-form-group label="Run atleta">
                            <b-form-input
                                v-rut:live
                                v-model="$v.registro_atleta.atletas.$each[index].run.$model"
                                :state="$v.registro_atleta.atletas.$each[index].run.$dirty ? !$v.registro_atleta.atletas.$each[index].run.$error : null"
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
                                v-model="$v.registro_atleta.atletas.$each[index].nombre.$model"
                                :state="$v.registro_atleta.atletas.$each[index].nombre.$dirty ? !$v.registro_atleta.atletas.$each[index].nombre.$error : null"
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
                                v-model="$v.registro_atleta.atletas.$each[index].polera.$model"
                                :state="$v.registro_atleta.atletas.$each[index].polera.$dirty ? !$v.registro_atleta.atletas.$each[index].polera.$error : null"
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
                                v-model="$v.registro_atleta.atletas.$each[index].fecha_nacimiento.$model"
                                :state="$v.registro_atleta.atletas.$each[index].fecha_nacimiento.$dirty ? !$v.registro_atleta.atletas.$each[index].fecha_nacimiento.$error : null"
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
                <b-button :disabled="$v.registro_atleta.$invalid" size="md" variant="success" @click="agregar_atletas"> Agregar atletas </b-button>
                <b-button size="md" variant="danger" @click="cerrar_modal_atleta"> Cerrar </b-button>
            </template>
        </b-modal>

        <div class="fixed-bottom mb-5 mr-5">
            <b-button pill variant="success" size="lg" class="pull-right heigth-50" @click="abrir_modal_atleta"><i class="ti-plus"></i></b-button>
        </div>
    </div>
</template>

<script>
    import { required, minLength, numeric, minValue, maxValue, requiredIf, email } from 'vuelidate/lib/validators'
    import { mapMutations, mapGetters } from 'vuex'

    export default {
        props: [
            'id'
        ],
        data() {
            return {
                categoria_seleccionada: null,
                registro_atleta: {
                    nombre_equipo: '',
                    tipo_pago: 0,
                    atletas: [],
                    box: '',
                    email: ''
                },
                categoria: [],
                poleras: [],
                opciones_categoria: [
                    { value: null, text: 'Selecciona una opción ...' },
                    { value: 1, text: 'Individual' },
                    { value: 2, text: 'Duplas' },
                    { value: 3, text: 'Tríos' },
                ],
                opciones_pago: [
                    { value: 1, text: 'Invitado' },
                    { value: 0, text: 'Transferencia' },
                ],
                items: [],
                fields: [],
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
            registro_atleta: {
                box:{
                    required: requiredIf(function () {
                        return this.categoria.categoria == 1 ? true : false
                    }),
                    minLength: minLength(1)
                },
                nombre_equipo:{
                    required: requiredIf(function () {
                        return this.categoria.categoria > 1 ? true : false
                    }),
                    minLength: minLength(1)
                },
                email: {
                    required,
                    email
                },
                tipo_pago: {
                    required,
                    minValue: minValue(0)
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
            },
            inscritos() {
                return this.items.length
            },
            aprobados() {
                return this.items.filter(i => i.pago == 1).length
            },
            pendientes() {
                return this.items.filter(i => i.pago == 0).length
            },
            invitados() {
                return this.items.filter(i => i.invitado == 1).length
            }
        },
        methods: {
            ...mapMutations(['msg_success', 'msg_error']),
            onFiltered(filteredItems) {
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            obtener_registros(){
                let me = this
                this.$nextTick(() => {
                    this.listar_categoria()
                    this.listar_atletas()
                    this.listar_tallas()
                    this.limpiar_datos_registro()
                })
            },
            cargar_campos_tabla(){
                let me = this

                me.fields = []

                if(this.categoria.categoria < 2){
                    if(this.categoria.limitancia_edad == 1){
                        me.fields = [
                            { key: 'index', label: '#', sortable: true, class: 'text-center' },
                            { key: 'nombre', label: 'Nombre', sortable: true, class: 'text-left' },
                            { key: 'run', label: 'Run', sortable: true, class: 'text-left' },
                            { key: 'fecha_nacimiento', label: 'Fecha de nacimiento', sortable: true, class: 'text-left' },
                            { key: 'correo', label: 'Correo', sortable: true, class: 'text-left' },
                            { key: 'box', label: 'Box', sortable: true, class: 'text-left' },
                            { key: 'talla_polera', label: 'Talla polera', sortable: true, class: 'text-left' },
                            { key: 'acciones', label: 'Acciones', class: 'text-center'}
                        ]
                    } else {
                        me.fields = [
                            { key: 'index', label: '#', sortable: true, class: 'text-center' },
                            { key: 'nombre', label: 'Nombre', sortable: true, class: 'text-left' },
                            { key: 'run', label: 'Run', sortable: true, class: 'text-left' },
                            { key: 'correo', label: 'Correo', sortable: true, class: 'text-left' },
                            { key: 'box', label: 'Box', sortable: true, class: 'text-left' },
                            { key: 'talla_polera', label: 'Talla polera', sortable: true, class: 'text-left' },
                            { key: 'acciones', label: 'Acciones', class: 'text-center'}
                        ]
                    }
                } else {
                    me.fields = [
                        { key: 'index', label: '#', sortable: true, class: 'text-center' },
                        { key: 'nombre', label: 'Nombre', sortable: true, class: 'text-left' },
                        { key: 'run', label: 'Run', sortable: true, class: 'text-left' },
                        { key: 'correo', label: 'Correo', sortable: true, class: 'text-left' },
                        { key: 'nombre_equipo', label: 'Equipo', sortable: true, class: 'text-left' },
                        { key: 'encargado', label: 'Encargado', sortable: true, class: 'text-left' },
                        { key: 'talla_polera', label: 'Talla polera', sortable: true, class: 'text-left' },
                        { key: 'acciones', label: 'Acciones', class: 'text-center'}
                    ]
                }
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

                this.limpiar_datos_registro()
                this.modal_atleta.titulo = 'Agregar atletas a ' + this.categoria.nombre
                this.categoria_seleccionada = this.categoria.categoria
                this.cargar_campos_atletas()

                this.$refs['modal_atleta'].show()
            },
            cerrar_modal_atleta() {
                this.modal_atleta.titulo = ""
                this.modal_atleta.accion = 0
                this.$refs['modal_atleta'].hide()
            },
            cargar_campos_atletas(){
                let me = this

                for (var i = 0; i < this.categoria_seleccionada; i++) {
                    var atleta = new Object()
                    atleta.nombre = ''
                    atleta.run = ''
                    atleta.polera = null
                    atleta.fecha_nacimiento = null
                    me.registro_atleta.atletas.push(atleta)
                }
            },
            limpiar_datos_registro() {
                this.registro_atleta.nombre_equipo = ''
                this.registro_atleta.blox = ''
                this.registro_atleta.email = ''
                this.registro_atleta.atletas = []
                this.registro_atleta.tipo_pago = 0

                this.$v.$reset();
            },
            agregar_atletas() {
                if(this.$v.registro_atleta.$invalid){
                    this.$v.registro_atleta.$touch()
                    return
                }

                let me = this

                axios.post('/atletas/admin/agregar',{
                    'categoria_id': me.categoria.id,
                    'nombre_equipo': me.registro_atleta.nombre_equipo,
                    'atletas': me.registro_atleta.atletas,
                    'box': me.registro_atleta.box,
                    'email': me.registro_atleta.email,
                    'tipo_pago': me.registro_atleta.tipo_pago
                }).then(function (response) {
                    me.listar_atletas()
                    me.$store.commit('msg_success', 'Registro agregado exitosamente.')
                }).catch(function (error) {
                    console.log(error)
                })
            }
        },
        mounted() {
            this.obtener_registros()
            this.cargar_campos_tabla()

            Event.$on('refrescar', (id) => {
                this.obtener_registros()
                this.cargar_campos_tabla()
            })
        }
    }
</script>
