<template>
  <!-- Dashboard card -->
  <dashboard-card>
    <loading-overlay v-if="loading" message="Cargando paciente" />
    <!-- Row -->
    <div v-else class="row">
      <!-- Nombre -->
      <div class="col-12 d-flex justify-content-between mb-3">
        <p class="h4-responsive">
          <span class="black-alpha-50">Paciente: </span>
          <router-link
            :to="'/dashboard/patient/' + patient.patient_id"
            class="primary"
            >{{ patient.name }} {{ patient.lastname }}</router-link
          >
        </p>
      </div>

      <div class="col-12 mb-5">
        <hr />
      </div>

      <div class="col-12">
        <evolution-modal-content :patient_id="patient_id"></evolution-modal-content>
      </div>
    </div>
    <!-- /.Row -->
  </dashboard-card>
  <!-- /.Dashboard card -->
</template>

<script>
import EvolutionModalContent from "../../components/dashboard/patients/EvolutionModal/Content";

export default {
  name: "PatientEvolutionAddView",
  props: ["patient_id"],
  components: {
    EvolutionModalContent,
  },
  data() {
    return {
      patient: {},
      systems: [],
      loading: true,
      clinicData: [],
      lastEvolutions: [],
    };
  },
  created() {
    this.$Progress.start();
    this.fetchPatient();
    this.fetchSystems();
    this.fetchClinicData();
  },
  methods: {
    // Obtener información del paciente.
    fetchPatient() {
      const path = "/api/patient/show/" + this.patient_id;
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
          this.patient = res.data;
          this.loading = false;
          this.$Progress.finish();
        })
        .catch((err) => {
          this.errorHandler(err.response.status);
          console.log(err);
        });
    },

    // Obtener sistemas.
    fetchSystems() {
      const path = "/api/system/index";
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
          this.systems = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },

    // Obtener hospitalizaciones.
    fetchClinicData() {
      const path = "/api/patient/clinic_data/" + this.patient_id;
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
          this.clinicData = res.data.clinicData;
          this.lastEvolutions = res.data.lastEvolutions;
        })
        .catch((err) => {
          console.log(err);
        });
    },

    // Hace el formato de DNI.
    dni() {
      return (this.patient.dni / 1)
        .toFixed(0)
        .replace(".")
        .toString()
        .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },

    // Fomatear el lugar donde se encuentra el paciente (Sistema, cama, sala).
    place() {
      var aux_room = this.patient.room != null ? ", " + this.patient.room : "";
      var aux_bed =
        this.patient.bed_number != null
          ? ", Cama " + this.patient.bed_number
          : "";
      return this.patient.system + aux_room + aux_bed;
    },
  },
};
</script>