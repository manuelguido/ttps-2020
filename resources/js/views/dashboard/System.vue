<template>
  <!-- Container -->
  <div class="container-fluid">
    <!-- Row -->
    <div class="row justify-content-center">
      <!-- Col -->
      <div class="col-12">
        <div class="card">
          <div class="card-body p-md-4 p-lg-5">

            <!-- Row -->
            <div class="row">
              <backlink url="/dashboard/systems" text="Sistemas"></backlink>


              <!-- Nombre -->
              <div class="col-12 d-flex justify-content-between mb-3">
                <p class="h3-responsive primary">
                  {{system.system}}
                </p>
                <div>
                  <router-link class="btn btn-outline-primary btn-sm" :to="'/dashboard/patients/'+system.system_id">Ver pacientes</router-link>
                  <router-link class="btn btn-outline-primary btn-sm" :to="'/dashboard/medics/'+system.system_id">Ver médicos</router-link>
                </div>
              </div>

              <!-- Camas ilimitadas -->
              <div v-if="system.system === 'Guardia'" class="col-12 mb-3">
                <div class="row d-flex align-items-center">

                  <!-- Total de camas -->
                  <div class="col-3 primary">
                    Camas ilimitadas
                  </div>

                  <!-- Activado / Descativado -->
                  <div class="col-9">
                    <span class="d-flex align-items-center" v-if="system.infinite_beds">
                      Activado
                      <button class="btn btn-sm button-primary p-1">Desactivar</button>
                    </span>
                    <span class="d-flex align-items-center" v-else>
                      Descactivado
                      <button class="btn btn-sm button-primary p-1">Activar</button>
                    </span>
                  </div>
                </div>
              </div>
              <!-- ./Camas ilimitadas -->

              <!-- Information -->
              <div class="col-12">
                <hr class="mb-4">
                <info-data data="Cantidad de salas" :value="system.total_rooms"></info-data>
                <info-data data="Camas totales" :value="system.total_beds"></info-data>
                <info-data data="Camas disponibles" :value="system.free_beds"></info-data>
                <info-data data="Camas ocupadas" :value="system.occupied_beds"></info-data>
              </div>
              <!-- /.Information -->

            </div>
            <!-- /.Row -->

          </div>
        </div>

      </div>
      <!-- /.Col -->
      <!-- Col -->
      <div class="col-12 col-lg-6 text-left">
        
      </div>
      <!-- /.Col -->
    </div>
    <!-- /.Row -->
  </div>
  <!-- Container -->
</template>

<script>
export default {
  name: 'system',
  props: ['system_id'],
  data () {
    return {
      loading: true,
      system: {},
      rooms: [],
    }
  },
  created () {
    this.fetchSystem();
  },
  methods: {
    /**
     * Obtiene el sistema con sus habitaciones y camas
     */
    fetchSystem () {
      const path = '/api/system/full';
      const AuthStr = 'Bearer ' + localStorage.getItem('access_token').toString();

      axios.get(path, {
        params: {
          system_id: this.system_id,
        },
        headers: {
          'Accept': 'application/json',
          'Authorization': AuthStr
        }
      }).then((res) => {
        this.system = res.data
        this.loading = false;
      }).catch((err) => {
        console.log(err)
      })
    }
  }

}
</script>
