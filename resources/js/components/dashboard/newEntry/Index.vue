<template>
  <!-- Container -->
  <div>
    <!-- Stepper content -->
    <div class="stepper-content">
      <loading-overlay v-if="loading"></loading-overlay>

      <!-- Step 1: Buscar paciente por dni -->
      <search-patient-by-dni
        v-if="currentStep == 1"
        @updateData="setCurrentStep"
        @loadingData="loadingData"
      ></search-patient-by-dni>
      <!-- /.Step 1 -->

      <!-- Step 2: Crear nuevo paciente o actualizar  -->
      <create-update-patient
        v-else-if="currentStep == 2"
        :patient="patient"
        :medical_ensurances="medical_ensurances"
        :createPatient="createPatient"
        @searchAgain="searchAgain"
      ></create-update-patient>
      <!-- /.Step 2 -->
    </div>
    <!-- /.Stepper content -->
  </div>
  <!-- Container -->
</template>

<script>
import CreateUpdatePatient from "./CreateUpdatePatient.vue";
import SearchPatientByDni from "./SearchPatientByDni.vue";
export default {
  name: "NewEntryIndex",
  components: {
    CreateUpdatePatient,
    SearchPatientByDni,
  },
  data() {
    return {
      currentStep: 1,
      loading: false,
      // Steps data
      steps: [
        {
          order: 1,
          name: "DNI",
          icon: "fad fa-id-card",
          clickable: true,
        },
        {
          order: 2,
          name: "Paciente",
          icon: "fad fa-user-alt",
          clickable: false,
        },
      ],
      patient: {
        patient_id: null,
        name: "",
        lastname: "",
        dni: "",
        address: "",
        phone: "",
        birth_date: "",
        personal_background: "",
        medical_ensurance_id: 0,
        email: "",
        contact_name: "",
        contact_lastname: "",
        contact_phone: "",
      },
      medical_ensurances: [],
      createPatient: true,
    };
  },
  mounted() {
    this.getMedicalEnsurances();
  },
  methods: {
    /**
     * Setear paso actual.
     */
    setStep(value) {
      this.currentStep = value;
    },

    /**
     * Ver si se puede enviar o no el formulario.
     */
    allowSubmit() {
      return this.dniInput != "";
    },

    /**
     * Resetear formulario.
     */
    resetForm() {
      this.patient.forEach((field) => {
        field = "";
      });
    },

    /**
     * Cambiar de paso.
     */
    setCurrentStep(data) {
      if (data.patient) {
        this.patient = data.patient;
        this.createPatient = false;
      } else if (data.dni) {
        this.patient.dni = data.dni;
        this.createPatient = true;
      }
      this.currentStep = 2;
    },

    /**
     * Cambiar de estado la variable de carga.
     */
    loadingData(newStatus) {
      this.loading = newStatus;
    },

    searchAgain() {
      this.setStep(1);
      this.resetForm();
    },

    /**
     * Obtener todas las obras sociales.
     */
    getMedicalEnsurances() {
      const path = "/api/medical_ensurance/index";
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
          this.formatMedicalEnsurances(res.data);
        })
        .catch((err) => {
          console.log(err);
        });
    },

    /**
     * Formatear las obras sociales para el formulario.
     */
    formatMedicalEnsurances(data) {
      var newData = data;
      newData.forEach((element) => {
        element.id = element.medical_ensurance_id;
        element.name = element.medical_ensurance;
      });
      this.medical_ensurances = newData;
    },
  },
};
</script>
