<template>
  <!-- Container -->
  <div class="container-fluid">
    <!-- Row -->
    <div class="row justify-content-center">
      <!-- Col -->
      <div class="col-12 col-lg-9">
        <div class="card c-card">
          <div class="card-body p-md-4 p-lg-5">

            <!-- Row -->
            <div class="row">
              <backlink url="/dashboard/systems" text="Sistemas"></backlink>


              <!-- Nombre -->
              <div class="col-12 d-flex justify-content-between mb-3">
                <p class="h3-responsive primary">{{system.system}}</p>
              </div>

              <!-- Camas ilimitadas -->
              <div v-if="allowedInfiniteBeds()" class="col-12 mb-3">
                <div class="row d-flex align-items-center">

                  <!-- Total de camas -->
                  <div class="col-3 primary">
                    Camas ilimitadas
                  </div>

                  <!-- Activado / Descativado -->
                  <div class="col-9">
                    <switcher></switcher>
                  </div>
                </div>
              </div>
              <!-- ./Camas ilimitadas -->

              <!-- Uso de camas -->
              <div class="col-12">
                <div class="row">
                  <div class="col-3 mb-3 primary">
                    Uso de camas
                  </div>
                  <div class="col-9 mb-3">
                    {{bed_percentage}}
                  </div>
                </div>
              </div>
              <!-- /.Uso de camas -->

              <!-- Information -->
              <div class="col-12 mb-5">
                <hr class="mb-4">
                <info-data data="Cantidad de salas" :value="system.total_rooms"></info-data>
                <info-data data="Camas totales" :value="system.total_beds"></info-data>
                <info-data data="Camas disponibles" :value="system.free_beds"></info-data>
                <info-data data="Camas ocupadas" :value="system.occupied_beds"></info-data>
              </div>
              <!-- /.Information -->

              <!-- Col -->
              <div class="col-12">
                <!-- Selector -->
                <div class="select-container d-flex justify-content-between mb-5 uns">
                  <span :class="['option-button d-flex align-items-center flex-column', showingMedics ? 'button-active' : '']" @click="showingMedics = true">
                    <i class="fad fa-user-nurse fa-2x"></i>
                    <div class="mt-2">Médicos</div>
                  </span>
                  <span :class="['option-button d-flex align-items-center flex-column', showingMedics ? '' : 'button-active']" @click="showingMedics = false">
                    <i class="fad fa-user-tag fa-2x"></i>
                    <div class="mt-2">Pacientes</div>
                  </span>
                </div>
                <!-- Selector -->
              </div>
              <!-- /.Col -->

              <div v-if="showingMedics" class="col-12">
                <dashboard-title text="Médicos"></dashboard-title>
                <medics-short-table :medics="medics" :loading="loadingMedics"></medics-short-table>
              </div>

              <div v-else class="col-12">
                <dashboard-title text="Pacientes"></dashboard-title>
                <patients-short-table :patients="patients" :loading="loadingPatients"></patients-short-table>
              </div>

            </div>
            <!-- /.Row -->

          </div>
        </div>

      </div>
      <!-- /.Col -->
    </div>
    <!-- /.Row -->
  </div>
  <!-- Container -->
</template>

<script>
import Dashboard from '../../layouts/Dashboard.vue';
export default {
  components: { Dashboard },
  name: 'system',
  props: ['system_id'],
  data () {
    return {
      bed_percentage: 0,
      loading: true,
      system: {},
      rooms: [],
      userSystem: JSON.parse(localStorage.getItem('system')),
      showingMedics: true,
      loadingMedics: true,
      loadingPatients: true,
      medics: [],
      patients: [],
    }
  },
  mounted () {
    this.fetchSystem();
    this.fetchMedics();
    this.fetchPatients();
  },
  methods: {
    calcBedPercentage() {
      this.bed_percentage = (((this.system.occupied_beds * 100) / this.system.total_beds).toFixed(1)) + '%';
    },

    /**
     * Tiene permitida la configuración de camas
     */
    allowedInfiniteBeds(){
      const guardSystem = 'Guardia';
      return (this.system.system === guardSystem && this.userSystem === guardSystem);
    },

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
        this.calcBedPercentage();
        this.loading = false;
      }).catch((err) => {
        this.errorHandler(err.response.status);
        console.log(err);
      })
    },

    /**
     * Obtener los médicos del sistema.
     */
    fetchMedics () {
      const path = '/api/medic/index/'+this.system_id;
      const AuthStr = 'Bearer ' + localStorage.getItem('access_token').toString();

      axios.get(path, {
        headers: {
          'Accept': 'application/json',
          'Authorization': AuthStr
        }
      }).then((res) => {
        this.loadMedics(res.data);
        this.loadingMedics = false;
      }).catch((err) => {
        this.errorHandler(err.response.status);
        
        var $this = this;
        setTimeout(function(){ $this.fetchMedics(); }, 1300);
        console.log(err);
      });
    },

    /**
     * Cargar medicos en variable local.
     */
    loadMedics (data) {
      this.medics = [];
      var maindata = data;
      maindata.forEach(element => {
        element.show = true;
      });
      this.medics = maindata;
    },

    /**
     * Obtener los pacientes del sistema.
     */
    fetchPatients () {
      const path = '/api/patient/index/'+this.system_id;
      const AuthStr = 'Bearer ' + localStorage.getItem('access_token').toString();

      axios.get(path, {
        headers: {
          'Accept': 'application/json',
          'Authorization': AuthStr
        }
      }).then((res) => {
        this.loadPatient(res.data);
        this.loadingPatients = false;
      }).catch((err) => {
        this.errorHandler(err.response.status);

        var $this = this;
        setTimeout(function(){ $this.fetchPatients(); }, 1300);
        console.log(err);
      });
    },

    /**
     * Cargar pacientes en variable local.
     */
    loadPatient (data) {
      this.patients = [];
      var maindata = data;
      maindata.forEach(element => {
        element.show = true;
      });
      this.patients = maindata;
    },

  }

}
</script>

<style scoped>
.select-container {
  background: #f4f4f4;
  border-radius: 8px;
  overflow: hidden;
  /* padding: .5em; */
}
.select-container,
.select-container * {
  transition: 0.1s all;
}

.option-button,
.option-button {
  flex: 1;
  padding: .75em 0;
  cursor: pointer;
  color: #999;
  text-align: center;
}
.option-button:first {
  border-top-left-radius: 100px;
}

.button-active {
  background: #aaa !important;
  color: #fff !important;
}
</style>
