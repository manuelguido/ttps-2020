<template>
  <!-- Dashboard card -->
  <dashboard-card>
    <loading-overlay v-if="loadingPatient" message="Cargando paciente" />
    <!-- Row -->
    <div v-else class="row">
      <!-- Nombre -->
      <div
        class="col-12 d-flex align-items-baseline justify-content-between mb-5"
      >
        <p>
          <span class="h4 black-alpha-50">Paciente: </span>
          <span class="h4 primary"
            >{{ patient.name }} {{ patient.lastname }}</span
          >
          <br />
          <br />
          <span class="h5 black-alpha-50"
            >Se encuentra en: {{ patient.system }}</span
          >
        </p>
      </div>

      <!-- Información -->
      <div class="col-12 col-lg-9 col-xl-6">
        <info-data data="DNI" :value="formatDni(patient.dni)"></info-data>
        <info-data
          data="Teléfono"
          :value="patient.phone.toString()"
        ></info-data>
        <info-data
          data="Fecha de nacimiento"
          :value="patient.birth_date | formatDateFull"
        ></info-data>

        <info-data
          v-if="patient.personal_background"
          data="Antecedentes personales"
          :value="patient.personal_background"
        ></info-data>
      </div>
      <div class="col-12 mb-4">
        <hr />
      </div>
      <div class="col-12 col-lg-9 col-xl-6">
        <info-data
          data="Obra social"
          :value="patient.medical_ensurance"
        ></info-data>
        <info-data data="Se encuentra en" :value="place()"></info-data>
        <info-data data="Estado" :value="patient.patient_state"></info-data>
      </div>
      <!-- /.Información -->

      <div v-if="patientIsHospitalized(patient)" class="col-12">
        <div class="row">
          <div class="col-12 mb-4">
            <hr />
          </div>

          <patient-actions @reloadData="reloadData" :patient="patient" />

          <div class="col-12 mb-4">
            <hr />
          </div>

          <!-- Hospitalizaciones (Listado) -->
          <div v-if="canEditPatient(patient)" class="col-12 mb-3">
            <loading-overlay v-if="loadingClinicData" />
            <clinic-data
              @reload-data="fetchClinicData()"
              :patient_id="patient_id"
              :clinicData="clinicData"
            >
            </clinic-data>
          </div>
          <!-- /.Hospitalizaciones -->
        </div>
      </div>
    </div>
    <!-- /.Row -->
  </dashboard-card>
  <!-- /.   Dashboard card -->
</template>

<script>
import { mdbListGroup, mdbListGroupItem } from "mdbvue";
import ClinicData from "../../components/dashboard/patients/ClinicData/Index.vue";
import PatientActions from "../../components/dashboard/patients/Actions.vue";

export default {
  name: "PatientView",
  props: ["patient_id"],
  components: {
    mdbListGroup,
    mdbListGroupItem,
    ClinicData,
    PatientActions,
  },
  data() {
    return {
      patient: {},
      loadingPatient: true,
      loadingClinicData: false,
      clinicData: [],
    };
  },
  created() {
    this.hasPermission("patient_show");
    this.$Progress.start();
    this.fetchPatient();
    this.fetchClinicData();
  },
  methods: {
    /**
     * Obtener información de paciente.
     *
     * @return void.
     */
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
          this.cardTitle = this.patient.name + " " + this.patient.lastname;
          this.loadingPatient = false;
          this.$Progress.finish();
        })
        .catch((err) => {
          this.errorHandler(err.response.status);
          console.log(err);
        });
    },

    /**
     * Obtener hospitalizaciones del paciente.
     *
     * @return void.
     */
    fetchClinicData() {
      this.loadingClinicData = true;
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
          let system_changes = res.data.system_changes;
          let evolutions = res.data.evolutions;

          let items = evolutions.concat(system_changes);

          items.sort(function (a, b) {
            return b.created_at.localeCompare(a.created_at);
          });

          this.clinicData = items;
          this.loadingClinicData = false;
        })
        .catch((err) => {
          console.log(err);
          this.loadingClinicData = false;
        });
    },

    /**
     *
     */
    reloadData() {
      this.fetchPatient();
      this.fetchClinicData();
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