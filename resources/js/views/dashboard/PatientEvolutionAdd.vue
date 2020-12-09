<template>
  <!-- Dashboard card -->
  <dasbboard-card>
    <loading-dots v-if="loading" message="Cargando paciente"></loading-dots>
    <!-- Row -->
    <div v-else class="row">
      <div class="col-12">
        <backlink></backlink>
      </div>

      <!-- Nombre -->
      <div class="col-12 d-flex justify-content-between mb-3">
        <p class="h4-responsive">
          <span class="black-alpha-50">Paciente: </span>
          <span class="primary">{{ patient.name }} {{ patient.lastname }}</span>
        </p>
        <span>
          <router-link
            class="btn btn-outline-primary btn-sm"
            :to="'/dashboard/patient/assignment/' + patient.patient_id"
            >Asignar médicos</router-link
          >
          <change-system-modal
            :patient="patient"
            :systems="systems"
            @reload-data="fetchHospitalizations()"
          ></change-system-modal>
        </span>
      </div>

      <!-- Información -->
      <div class="col-12">
        <info-data data="DNI" :value="dni()"></info-data>
        <info-data
          data="Teléfono"
          :value="patient.phone.toString()"
        ></info-data>
        <info-data
          data="Fecha de nacimiento"
          :value="patient.birth_date | formatDateFull"
        ></info-data>
        <info-data
          data="Antecedentes personales"
          :value="patient.personal_background"
        ></info-data>
        <info-data
          data="Información familiar"
          :value="patient.family_data"
        ></info-data>
        <hr class="mb-4" />
        <info-data
          data="Obra social"
          :value="patient.medical_ensurance"
        ></info-data>
        <info-data data="Se encuentra en" :value="place()"></info-data>
        <info-data data="Estado" :value="patient.patient_state"></info-data>
      </div>
      <!-- /.Información -->

      <div class="col-12 mb-4">
        <hr />
      </div>

      <!-- Hospitalizaciones (Listado) -->
      <!-- Son cambios de sistema + evoluciones -->
      <div class="col-12 mb-3">
        <clinic-data
          @reload-data="fetchClinicData()"
          :patient_id="patient_id"
          :clinicData="clinicData"
          :lastEvolutions="lastEvolutions"
        >
        </clinic-data>
      </div>
      <!-- /.Hospitalizaciones -->
    </div>
    <!-- /.Row -->
  </dasbboard-card>
  <!-- /.Dashboard card -->
</template>

<script>
import { mdbListGroup, mdbListGroupItem } from "mdbvue";
import ClinicData from "../../components/dashboard/patients/ClinicData.vue";
import changeSystemModal from "../../components/dashboard/patients/ChangeSystemModal";

export default {
  name: "Patient",
  props: ["patient_id"],
  components: {
    mdbListGroup,
    mdbListGroupItem,
    "change-system-modal": changeSystemModal,
    "clinic-data": ClinicData,
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