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
        <evolution-modal-content
          :patient_id="patient_id"
        ></evolution-modal-content>
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
      loading: true,
    };
  },
  created() {
    this.$Progress.start();
    this.fetchPatient();
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
  },
};
</script>