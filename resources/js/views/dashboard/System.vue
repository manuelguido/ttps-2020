<template>
  <!-- Dashboard card -->
  <dashboard-card :title="cardTitle" :backLink="backLink" colored>
    <loading-overlay v-if="loadingSystem" />
    <!-- Row -->
    <div v-else class="row">
      <!-- Col -->
      <div class="col-12 col-lg-6 col-xl-5">
        <!-- Camas ilimitadas -->
        <infinite-beds-switch
          v-if="allowedInfiniteBeds(system.system)"
          :system="system"
        />
        <!-- ./Camas ilimitadas -->

        <!-- Uso de camas -->
        <bed-usage :system="system" />
        <!-- /.Uso de camas -->
      </div>
      <!-- /.Col -->

      <!-- Col -->
      <div class="col-12 mb-5">
        <hr class="m-0" />
      </div>
      <!-- /.Col -->

      <!-- Information -->
      <div class="col-12 col-lg-6 col-xl-5 mb-5">
        <info-data data="Cantidad de salas" :value="system.total_rooms" />
        <info-data data="Camas totales" :value="system.total_beds" />
        <info-data data="Camas disponibles" :value="system.free_beds" />
        <info-data data="Camas ocupadas" :value="system.occupied_beds" />
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
import InfiniteBedsSwitch from "../../components/dashboard/systems/InfiniteBedsSwitch.vue";
import BedUsage from "../../components/dashboard/systems/BedUsage.vue";

export default {
  name: "SystemView",
  components: {
    Dashboard,
    InfiniteBedsSwitch,
    BedUsage,
  },
  name: "system",
  props: ["system_id"],
  data() {
    return {
      cardTitle: "",
      system: {},
      rooms: [],
      showingMedics: true,
      loadingSystem: true,
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
    /**
     * Obtiene el sistema con sus habitaciones y camas
     */
    fetchSystem() {
      const path = "/api/system/show";
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
          this.loadingSystem = false;
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
