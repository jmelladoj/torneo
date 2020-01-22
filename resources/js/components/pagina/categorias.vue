<template>
    <div>
        <section id="inscripciones">
            <div class="container wow fadeInUp">
            <div class="section-header">
                <h2>Categorías</h2>
                <p>Asegura tu cupo ahora mismo</p>
            </div>

            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" v-if="individuales.length > 0">
                <a class="nav-link active" href="#individual" role="tab" data-toggle="tab">Individual</a>
                </li>
                <li class="nav-item" v-if="duplas.length > 0">
                <a class="nav-link" href="#duplas" role="tab" data-toggle="tab">Duplas</a>
                </li>
                <li class="nav-item" v-if="trios.length > 0">
                <a class="nav-link" href="#trios" role="tab" data-toggle="tab">Tríos</a>
                </li>
            </ul>

            <div class="tab-content row justify-content-center">

                <div role="tabpanel" class="col-lg-9 tab-pane fade show active" id="individual">
                    <div class="row schedule-item" v-for="i in individuales" :key="i.id">
                        <div class="col-md-8">
                            <h4 v-text="i.categoria_nombre + ' ' + i.nombre "></h4>
                        </div>
                        <div class="col-md-4 text-right"><b-button @click="abrir_modal_inscripcion(i)">Inscribirme</b-button></div>
                    </div>
                </div>

                <div role="tabpanel" class="col-lg-9  tab-pane fade" id="duplas">
                    <div class="row schedule-item" v-for="d in duplas" :key="d.id">
                        <div class="col-md-8">
                            <h4 v-text="d.categoria_nombre + ' ' + d.nombre "></h4>
                        </div>
                        <div class="col-md-4 text-right"><b-button @click="abrir_modal_inscripcion(d)">Inscribirme</b-button></div>
                    </div>
                </div>

                <div role="tabpanel" class="col-lg-9  tab-pane fade" id="trios">
                    <div class="row schedule-item" v-for="t in trios" :key="t.id">
                        <div class="col-md-8">
                            <h4 v-text="t.categoria_nombre + ' ' + t.nombre "></h4>
                        </div>
                        <div class="col-md-4 text-right"><b-button @click="abrir_modal_inscripcion(t)">Inscribirme</b-button></div>
                    </div>
                </div>
            </div>

            </div>
        </section>

        <b-modal ref="modal_inscripcion" size="lg" :title="modal_inscripcion.titulo" no-close-on-backdrop scrollable static>
            <b-form v-show="modal_inscripcion.estado == 0">
                <b-row>
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
                    <b-col xs="12" sm="12" md="6">
                        <b-form-group label="Box">
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
                    <b-col xs="12" sm="12" md="6" v-show="categoria_seleccionada > 1">
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

            <b-form v-show="modal_inscripcion.estado == 1">
                <p class="text-justify">
                    Para finalizar debes pagar tu inscripción en la categoría <b> {{ categoria.categoria_nombre + ' ' + categoria.nombre }} </b> por medio de una transferencia bancaria con los datos que se indican a continuación:
                </p>

                <p class="text-justify">
                    <b>Recuerda que en esta opción debes enviar el comprobante de transferencia a <a href="javascript:void(0)">pagos@torneoarena.cl</a>, indicando correctamente en el asunto tu nombre (la de la dupla o trío) y categoría</b>). <br><br>
                    El valor a transferir según la categoría es de: <b>INDIVIDUAL $35.000</b>. <b>DUPLAS $70.000</b> y <b>TRÍOS $105.000</b>, y los datos de transferencia son:
                </p>

                <p class="text-center">
                    <strong>
                        <b>
                            VIVALLOS Y ARIAS LIMITADA<br>
                            CUENTA CORRIENTE BANCO BCI<br>
                            Nº 61991431<br>
                            R.U.T. 76.691.998-7<br>
                            pagos@torneoarena.cl
                        </b>
                    </strong>

                </p>

                <p>
                    <ul>
                        <li>Una vez realizado el pago y dentro de las próximas horas te enviaremos un correo de confirmación validando que ya estas inscrito correctamente.</li>
                        <li>El solo hecho de de haber  completado el formulario de registro no es válido como inscripción ni como reserva de cupos.</li>
                        <li>La inscripción debe ser pagada en su totalidad, en caso de duplas y tríos, no se puede pagar de forma individual.</li>
                        <li>Recuerda incluir el nombre de los atletas en el comprobante de pago.</li>
                    </ul>
                </p>

                <p class="text-center">
                    <b>DE PARTE DE LA ORGANIZACIÓN, <br>
                    GRACIAS POR QUERER FORMAR PARTE DE ARENA 2020</b>
                </p>
            </b-form>

            <template slot="modal-footer">
                <b-button :disabled="$v.registro_atleta.$invalid" v-show="modal_inscripcion.estado == 0" size="md" variant="success" @click="inscripcion_webpay"> Pagar con webpay </b-button>
                <b-button :disabled="$v.registro_atleta.$invalid" v-show="modal_inscripcion.estado == 0" size="md" variant="info" @click="inscripcion_transferencia"> Pagar con transferencia </b-button>
                <b-button size="md" variant="danger" @click="cerrar_modal_inscripcion"> Cerrar </b-button>
            </template>
        </b-modal>
    </div>
</template>

<script>
    import { required, minLength, numeric, minValue, requiredIf, email } from 'vuelidate/lib/validators'
    import { mapMutations, mapGetters } from 'vuex'

    export default {
        data() {
            return {
                individuales: [],
                duplas: [],
                trios: [],
                categoria: [],
                categoria_seleccionada: null,
                categorias: [],
                poleras: [],
                registro_atleta: {
                    nombre_equipo: '',
                    atletas: [],
                    box: '',
                    email: ''
                },
                modal_inscripcion: {
                    titulo: '',
                    estado: 0
                }
            }
        },
        validations:{
            registro_atleta: {
                box:{
                    required: requiredIf(function () {
                        return this.registro_atleta.box.length > 0 ? true : false
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
        methods: {
            ...mapMutations(['msg_success', 'msg_error']),
            listar_tallas(){
                let me = this

                axios.get('/poleras').then(function (response) {
                    me.poleras = response.data.poleras
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listar_categorias(){
                let me = this

                axios.get('/categorias/pagina').then(function (response) {
                    me.individuales = response.data.individuales
                    me.duplas = response.data.duplas
                    me.trios = response.data.trios
                })
                .catch(function (error) {
                    console.log(error);
                });
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
            abrir_modal_inscripcion(data = []){
                this.limpiar_datos_registro()

                this.modal_inscripcion.titulo = data.categoria_nombre + ' - ' + data.nombre

                this.categoria = data
                this.categoria_seleccionada = data.categoria
                this.cargar_campos_atletas()

                this.$refs['modal_inscripcion'].show()
            },
            cerrar_modal_inscripcion(){
                this.$refs['modal_inscripcion'].hide()
            },
            limpiar_datos_registro() {
                this.registro_atleta.nombre_equipo = ''
                this.registro_atleta.box = ''
                this.registro_atleta.email = ''
                this.registro_atleta.atletas = []

                this.modal_inscripcion.titulo = ''
                this.modal_inscripcion.estado = 0

                this.$v.$reset();
            },
            inscripcion_webpay(){
                if(this.$v.registro_atleta.$invalid){
                    this.$v.registro_atleta.$touch()
                    return
                }

                let me = this

                axios.post('/atletas/usuario/agregar/webpay',{
                    'categoria_id': me.categoria.id,
                    'nombre_equipo': me.registro_atleta.nombre_equipo,
                    'atletas': me.registro_atleta.atletas,
                    'box': me.registro_atleta.box,
                    'email': me.registro_atleta.email
                }).then(function (response) {
                    me.listar_categorias()

                    var form = document.createElement("form");
                    var input_token = document.createElement("input");

                    form.method = "POST";
                    form.action = response.data.url;

                    input_token.value = response.data.token;
                    input_token.name = "TBK_TOKEN";

                    form.appendChild(input_token);
                    document.body.appendChild(form);
                    form.submit();

                }).catch(function (error) {
                    console.log(error)
                })
            },
            inscripcion_transferencia(){
                if(this.$v.registro_atleta.$invalid){
                    this.$v.registro_atleta.$touch()
                    return
                }

                let me = this

                axios.post('/atletas/usuario/agregar/transferencia',{
                    'categoria_id': me.categoria.id,
                    'nombre_equipo': me.registro_atleta.nombre_equipo,
                    'atletas': me.registro_atleta.atletas,
                    'box': me.registro_atleta.box,
                    'email': me.registro_atleta.email
                }).then(function (response) {
                    me.listar_categorias()

                    me.modal_inscripcion.titulo = 'Ya falta poco para completar tu registro en ARENA 2020'
                    me.modal_inscripcion.estado = 1

                }).catch(function (error) {
                    console.log(error)
                })
            }
        },
        mounted() {
            this.listar_categorias()
            this.listar_tallas()
        }
    }
</script>
