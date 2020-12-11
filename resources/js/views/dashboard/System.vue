<template>
  <!-- Dashboard card -->
  <dashboard-card :title="cardTitle" :backLink="backLink" colored>
    <loading-overlay v-if="loading" />
    <!-- Row -->
    <div class="row">
      <!-- Camas ilimitadas -->
      <div v-if="allowedInfiniteBeds(system.system)" class="col-12 mb-3">
        <div class="row d-flex align-items-center">
          <!-- Total de camas -->
          <div class="col-3 primary">Camas ilimitadas</div>

          <!-- Activado / Descativado -->
          <div class="col-9">
            <switcher />
          </div>
        </div>
      </div>
      <!-- ./Camas ilimitadas -->

      <!-- Uso de camas -->
      <div class="col-12">
        <div class="row">
          <div class="col-3 mb-3 primary">Uso de camas</div>
          <div class="col-9 mb-3">
            {{ bed_percentage }}
          </div>
        </div>
      </div>
      <!-- /.Uso de camas -->

      <!-- Information -->
      <div class="col-12 mb-5">
        <hr class="mb-4" />
        <info-data
          data="Cantidad de salas"
          :value="system.total_rooms"
        ></info-data>
        <info-data data="Camas totales" :value="system.total_beds"></info-data>
        <info-data
          data="Camas disponibles"
          :value="system.free_beds"
        ></info-data>
        <info-data
          data="Camas ocupadas"
          :value="system.occupied_beds"
        ></info-data>
      </div>
      <!-- /.Information -->

      <!-- Col -->
      <div class="col-12">
        <!-- Selector -->
        <div class="select-container d-flex justify-content-between mb-5 uns">
          <span
            :class="[
              'option-button d-flex align-items-center flex-column',
              showingMedics ? 'button-active' : '',
            ]"
            @click="showingMedics = true"
          >
            <i class="fad fa-user-nurse fa-2x"></i>
            <div class="mt-2">Médicos</div>
          </span>
          <span
            :class="[
              'option-button d-flex align-items-center flex-column',
              showingMedics ? '' : 'button-active',
            ]"
            @click="showingMedics = false"
          >
            <i class="fad fa-user-tag fa-2x"></i>
            <div class="mt-2">Pacientes</div>
          </span>
        </div>
        <!-- Selector -->
      </div>
      <!-- /.Col -->

      <div v-if="showingMedics" class="col-12">
        <dashboard-title text="Médicos"></dashboard-title>
        <medics-short-table
          :medics="medics"
          :loading="loadingMedics"
        ></medics-short-table>
      </div>

      <div v-else class="col-12">
        <dashboard-title text="Pacientes"></dashboard-title>
        <patients-short-table
          :patients="patients"
          :loading="loadingPatients"
        ></patients-short-table>
      </div>
    </div>
    <!-- /.Row -->
  </dashboard-card>
  <!-- /.Dashboard card -->
</template>

<script>
import Dashboard from "../../layouts/Dashboard.vue";
export default {
  name: "SystemView",
  components: {
    Dashboard,
  },
  name: "system",
  props: ["system_id"],
  data() {
    return {
      cardTitle: "",
      bed_percentage: 0,
      loading: true,
      system: {},
      rooms: [],
      showingMedics: true,
      loadingMedics: true,
      loadingPatients: true,
      medics: [],
      patients: [],
      backLink: {
        url: "/dashboard/systems",
        text: "Sistemas",
      },
    };
  },
  mounted() {
    this.fetchSystem();
    this.fetchMedics();
    this.fetchPatients();
  },
  methods: {
    calcBedPercentage() {
      this.bed_percentage =
        ((this.system.occupied_beds * 100) / this.system.total_beds).toFixed(
          1
        ) + "%";
    },

    /**
     * Obtiene el sistema con sus habitaciones y camas
     */
    fetchSystem() {
      const path = "/api/system/full";
      const AuthStr =
        "Bearer " + localStorage.getItem("access_token").toString();

      axios
        .get(path, {
          params: {
            system_id: this.system_id,
          },
          headers: {
            Accept: "application/json",
            Authorization: AuthStr,
          },
        })
        .then((res) => {
          this.system = res.data;
          this.cardTitle = this.system.system;
          this.calcBedPercentage();
          this.loading = false;
        })
        .catch((err) => {
          this.errorHandler(err.response.status);
          console.log(err);
        });
    },

    /**
     * Obtener los médicos del sistema.
     */
    fetchMedics() {
      const path = "/api/medic/index/" + this.system_id;
      const AuthStr =
        "Bearer " + localStorage.getItem("access_token").toString();

      axios
        .get(path, {
          headers: {
            Accept: "application/json",
            Authorization: AuthStr,
          },
        })
        .then((res) => {
          this.loadMedics(res.data);
          this.loadingMedics = false;
        })
        .catch((err) => {
          this.errorHandler(err.response.status);

          var $this = this;
          setTimeout(function () {
            $this.fetchMedics();
          }, 1300);
          console.log(err);
        });
    },

    /**
     * Cargar medicos en variable local.
     */
    loadMedics(data) {
      this.medics = [];
      var maindata = data;
      maindata.forEach((element) => {
        element.show = true;
      });
      this.medics = maindata;
    },

    /**
     * Obtener los pacientes del sistema.
     */
    fetchPatients() {
      const path = "/api/patient/index/" + this.system_id;
      const AuthStr =
        "Bearer " + localStorage.getItem("access_token").toString();

      axios
        .get(path, {
          headers: {
            Accept: "application/json",
            Authorization: AuthStr,
          },
        })
        .then((res) => {
          this.loadPatient(res.data);
          this.loadingPatients = false;
        })
        .catch((err) => {
          this.errorHandler(err.response.status);

          var $this = this;
          setTimeout(function () {
            $this.fetchPatients();
          }, 1300);
          console.log(err);
        });
    },

    /**
     * Cargar pacientes en variable local.
     */
    loadPatient(data) {
      this.patients = [];
      var maindata = data;
      maindata.forEach((element) => {
        element.show = true;
      });
      this.patients = maindata;
    },
  },
};
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
  padding: 0.75em 0;
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
