<template>
    <b-modal ref="modal_atleta" size="lg" :title="modal_atleta.titulo" no-close-on-backdrop scrollable static>
        <b-form>
            <b-row>
                <b-col xs="12" sm="12" md="6">
                    <b-form-group label="Nombre de atleta">
                        <b-form-input
                            v-model="$v.atleta.nombre.$model"
                            :state="$v.atleta.nombre.$dirty ? !$v.atleta.nombre.$error : null"
                            aria-describedby="atleta-nombre"
                        ></b-form-input>

                        <b-form-invalid-feedback id="atleta-nombre">
                            Campo de texto, mínimo de 3 caracteres.
                        </b-form-invalid-feedback>
                    </b-form-group>
                </b-col>
                <b-col xs="12" sm="12" md="6">
                    <b-form-group label="Correo de atleta">
                        <b-form-input
                            v-model="$v.atleta.correo.$model"
                            :state="$v.atleta.correo.$dirty ? !$v.atleta.correo.$error : null"
                            aria-describedby="atleta-correo"
                        ></b-form-input>

                        <b-form-invalid-feedback id="atleta-correo">
                            Ingresa un correo válido, mínimo de 3 caracteres.
                        </b-form-invalid-feedback>
                    </b-form-group>
                </b-col>
                <b-col xs="12" sm="12" md="6">
                    <b-form-group label="Box">
                        <b-form-input
                            v-model="$v.atleta.box.$model"
                            :state="$v.atleta.box.$dirty ? !$v.atleta.box.$error : null"
                            aria-describedby="atleta-box"
                        ></b-form-input>

                        <b-form-invalid-feedback id="atleta-box">
                            Campo de texto, mínimo de 3 caracteres.
                        </b-form-invalid-feedback>
                    </b-form-group>
                </b-col>
                <b-col xs="12" sm="12" md="6" v-show="categoria.categoria > 1">
                    <b-form-group  label="Nombre de equipo">
                        <b-form-input
                            v-model="$v.atleta.nombre_equipo.$model"
                            :state="$v.atleta.nombre_equipo.$dirty ? !$v.atleta.nombre_equipo.$error : null"
                            aria-describedby="atleta-nombre-equipo"
                        ></b-form-input>

                        <b-form-invalid-feedback id="atleta-nombre-equipo">
                            Campo de texto, mínimo de 1 caracteres.
                        </b-form-invalid-feedback>
                    </b-form-group>
                </b-col>
                <b-col xs="12" sm="12" md="6" v-show="categoria.limitancia_edad == 1">
                    <b-form-group label="Fecha de nacimiento">
                        <b-form-input
                            type="date"
                            v-model="$v.atleta.fecha_nacimiento.$model"
                            :state="$v.atleta.fecha_nacimiento.$dirty ? !$v.atleta.fecha_nacimiento.$error : null"
                            aria-describedby="atleta-fecha-nacimiento"
                        ></b-form-input>

                        <b-form-invalid-feedback id="atleta-fecha-nacimiento">
                            Ingresa una fecha válida para tu categoría.
                        </b-form-invalid-feedback>
                    </b-form-group>
                </b-col>
                <b-col xs="12" sm="12" md="6">
                    <b-form-group label="Talla de polera">
                        <b-form-select
                            v-model="$v.atleta.polera_id.$model"
                            :state="$v.atleta.polera_id.$dirty ? !$v.atleta.polera_id.$error : null"
                            aria-describedby="atleta-polera-id">

                            <option v-for="polera in poleras" :key="polera.id" :value="polera.id" v-text="polera.talla"></option>
                        </b-form-select>

                        <b-form-invalid-feedback id="atleta-polera-id">
                            Debes de seleccionar una opción.
                        </b-form-invalid-feedback>
                    </b-form-group>
                </b-col>
            </b-row>
        </b-form>

        <template slot="modal-footer">
            <b-button :disabled="$v.atleta.$invalid" size="md" variant="warning" @click="actualizar_atleta"> Actualizar </b-button>
            <b-button size="md" variant="danger" @click="cerrar_modal_atleta"> Cerrar </b-button>
        </template>
    </b-modal>
</template>
<script>
    import { required, minLength, numeric, minValue, requiredIf, email } from 'vuelidate/lib/validators'
    import { mapMutations, mapGetters } from 'vuex'

    export default {
        data(){
            return {
                id_atleta: null,
                id_categoria: null,
                ubicacion: null,
                categoria: [],
                poleras: [],
                atleta: {
                    id: null,
                    run: '',
                    nombre: '',
                    correo: '',
                    nombre_equipo: '',
                    fecha_nacimiento: '',
                    box: '',
                    polera_id: null
                },
                modal_atleta: {
                    titulo: ''
                }
            }
        },
        validations:{
            atleta: {
                nombre:{
                    required,
                    minLength: minLength(3)
                },
                polera_id: {
                    required
                },
                correo: {
                    required,
                    email,
                    minLength: minLength(3)
                },
                box:{
                    required,
                    minLength: minLength(3)
                },
                nombre_equipo:{
                    required: requiredIf(function () {
                        return this.categoria.categoria > 1 ? true : false
                    }),
                    minLength: minLength(3)
                },
                fecha_nacimiento: {
                    required: requiredIf(function () {
                        return this.categoria.limitancia_edad == 1 ? true : false
                    }),
                }
            }
        },
        methods: {
            listar_tallas(){
                let me = this

                axios.get('/poleras').then(function (response) {
                    me.poleras = response.data.poleras
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            obtener_registros(){
                this.listar_tallas()
                this.listar_categoria()
                this.listar_atleta()
            },
            listar_atleta(){
                let me = this

                axios.get('/atleta/' + this.id_atleta).then(function (response) {
                    me.atleta.id = response.data.atleta.id
                    me.atleta.run = response.data.atleta.run
                    me.atleta.nombre = response.data.atleta.nombre
                    me.atleta.correo = response.data.atleta.correo
                    me.atleta.box = response.data.atleta.box
                    me.atleta.nombre_equipo = response.data.atleta.nombre_equipo
                    me.atleta.fecha_nacimiento = response.data.atleta.fecha_nacimiento
                    me.atleta.polera_id = response.data.atleta.polera_id
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listar_categoria(){
                let me = this

                axios.get('/categorias/atletas/' + this.id_categoria).then(function (response) {
                    me.categoria = response.data.categoria
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            limpiar_datos_atleta(){
                this.atleta.id = null
                this.atleta.run = null
                this.atleta.nombre = null
                this.atleta.correo = null
                this.atleta.nombre_equipo = null
                this.atleta.fecha_nacimiento = null
                this.atleta.box = null
                this.atleta.polera_id = null
            },
            abrir_modal_atleta(){
                let me = this

                me.limpiar_datos_atleta()
                me.obtener_registros()

                me.modal_atleta.titulo = 'Actualizar datos'
                me.$refs['modal_atleta'].show()
            },
            cerrar_modal_atleta(){
                this.id_atleta = null
                this.id_categoria = null
                this.ubicacion = null

                this.modal_atleta.titulo = ''
                this.$refs['modal_atleta'].hide()
            },
            actualizar_atleta(){
                if(this.$v.atleta.$invalid){
                    this.$v.atleta.$touch()
                    return
                }

                let me = this

                axios.post('/atletas/admin/actualizar',{
                    'id': me.atleta.id,
                    'nombre': me.atleta.nombre,
                    'correo': me.atleta.correo,
                    'nombre_equipo': me.atleta.nombre_equipo,
                    'fecha_nacimiento': me.atleta.fecha_nacimiento,
                    'box': me.atleta.box,
                    'polera_id': me.atleta.polera_id
                }).then(function (response) {
                    if(me.ubicacion == 1){
                        Evento.$emit('refrescar_escritorio')
                    } else {
                        Evento.$emit('refrescar')
                    }


                    me.$store.commit('msg_success', 'Registro actualizado exitosamente.')
                }).catch(function (error) {
                    console.log(error)
                })
            }
        },
        mounted(){
            Evento.$on('cargar_modal_atleta', (id_atleta, id_categoria, ubicacion) => {

                this.id_atleta = id_atleta
                this.id_categoria = id_categoria
                this.ubicacion = ubicacion

                this.abrir_modal_atleta()
            })
        }
    }
</script>
