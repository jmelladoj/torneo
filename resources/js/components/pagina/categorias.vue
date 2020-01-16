<template>
    <section id="schedule" class="section-with-bg">
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
                    <div class="col-md-4 text-right"><b-button>Inscribirme</b-button></div>
                </div>
            </div>

            <div role="tabpanel" class="col-lg-9  tab-pane fade" id="duplas">
                <div class="row schedule-item" v-for="d in duplas" :key="d.id">
                    <div class="col-md-8">
                        <h4 v-text="d.categoria_nombre + ' ' + d.nombre "></h4>
                    </div>
                    <div class="col-md-4 text-right"><b-button>Inscribirme</b-button></div>
                </div>
            </div>

            <div role="tabpanel" class="col-lg-9  tab-pane fade" id="trios">
                <div class="row schedule-item" v-for="t in trios" :key="t.id">
                    <div class="col-md-8">
                        <h4 v-text="t.categoria_nombre + ' ' + t.nombre "></h4>
                    </div>
                    <div class="col-md-4 text-right"><b-button>Inscribirme</b-button></div>
                </div>
            </div>
          </div>

        </div>
    </section>

</template>

<script>
    import { required, minLength, numeric, minValue, requiredIf } from 'vuelidate/lib/validators'
    import { mapMutations, mapGetters } from 'vuex'

    export default {
        data() {
            return {
                categorias: [],
            }
        },
        computed: {
            individuales() {
                return this.categorias.filter(c => c.categoria == 1)
            },
            duplas() {
                return this.categorias.filter(c => c.categoria == 2)
            },
            trios() {
                return this.categorias.filter(c => c.categoria == 3)
            }
        },
        methods: {
            ...mapMutations(['msg_success', 'msg_error']),
            onFiltered(filteredcategorias) {
                this.totalRows = filteredcategorias.length
                this.currentPage = 1
            },
            listar_categorias(){
                let me = this

                axios.get('/categorias/atletas').then(function (response) {
                    me.categorias = response.data.categorias
                    me.totalRows = me.categorias.length;
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        },
        mounted() {
            this.listar_categorias()
        }
    }
</script>
