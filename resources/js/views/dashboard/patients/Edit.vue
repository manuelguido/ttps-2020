<template>
  <!-- Dashboard card -->
  <dashboard-card>
    <loading-overlay v-if="loadingPatient" message="Cargando paciente" />
    <!-- Row -->
    <div v-else class="row justify-content-center">
      <!-- Col -->
      <div
        class="col-12 col-lg-10 col-xl-7 d-flex align-items-baseline justify-content-between mb-5"
      >
        <p>
          <span class="h4 black-alpha-50">Editar paciente</span>
        </p>
      </div>

      <!-- Information Col -->
      <div class="col-12 col-lg-10 col-xl-7">
        <!-- Row -->
        <form class="row text-left" method="POST" @submit.prevent="updatePatient">
          <!-- Title -->
          <div class="col-12 mb-4">
            <dashboard-subtitle
              text="Información personal"
            ></dashboard-subtitle>
          </div>
          <!-- /.Title -->
          <!-- Nombre -->
          <v-input
            v-model="patient.name"
            label="Nombre"
            placeholder="Nombre del paciente"
            classList="col-lg-6 mb-4"
            onlyLetters
            required
          ></v-input>
          <!-- /.Nombre -->
          <!-- Apellido -->
          <v-input
            v-model="patient.lastname"
            label="Apellido"
            placeholder="Apellido del paciente"
            classList="col-lg-6 mb-4"
            onlyLetters
            required
          ></v-input>
          <!-- /.Apellido -->
          <!-- DNI -->
          <v-input
            v-model="patient.dni"
            label="DNI"
            placeholder="DNI del paciente"
            classList="col-lg-6 mb-4"
            onlyNumbers
            required
            disabled
          ></v-input>
          <!-- /.DNI -->
          <!-- Dirección -->
          <v-input
            v-model="patient.address"
            label="Dirección"
            placeholder="Dirección del paciente"
            classList="col-lg-6 mb-4"
            required
          ></v-input>
          <!-- /.Dirección -->
          <!-- Teléfono -->
          <v-input
            v-model="patient.phone"
            label="Teléfono"
            placeholder="Teléfono del paciente"
            classList="col-lg-6 mb-4"
            onlyNumbersAndSymbols
            required
          ></v-input>
          <!-- /.Teléfono -->
          <!-- Fecha de nacimiento -->
          <v-input
            v-model="patient.birth_date"
            label="Fecha de nacimiento"
            classList="col-lg-6 mb-4"
            type="date"
            required
          ></v-input>
          <!-- /.Fecha de nacimiento -->
          <!-- Información personal -->
          <v-textarea
            v-model="patient.personal_background"
            label="Información personal"
            classList="col-12 mb-4"
            placeholder="Información personal del paciente"
            :options="medical_ensurances"
          ></v-textarea>
          <!-- /.Información personal -->
          <!-- Obra social -->
          <v-input-select
            v-model="patient.medical_ensurance_id"
            label="Obra social"
            classList="col-lg-6 mb-4"
            :options="medical_ensurances"
            required
          ></v-input-select>
          <!-- /.Obra social -->
          <!-- Email del paciente -->
          <v-input
            v-model="patient.email"
            label="Email"
            placeholder="Email del paciente"
            classList="col-lg-6 mb-4"
            type="email"
            required
          ></v-input>
          <!-- /.Email del paciente -->

          <!-- Title -->
          <div class="col-12 my-4">
            <dashboard-subtitle
              text="Información de contacto (Familiar o responsable)"
            ></dashboard-subtitle>
          </div>
          <!-- /.Title -->
          <v-input
            v-model="patient.contact_name"
            label="Nombre"
            placeholder="Nombre de contacto del paciente"
            classList="col-lg-6 mb-4"
            onlyLetters
            required
          ></v-input>
          <v-input
            v-model="patient.contact_lastname"
            label="Apellido"
            placeholder="Apellido de contacto del paciente"
            classList="col-lg-6 mb-4"
            onlyLetters
            required
          ></v-input>
          <v-input
            v-model="patient.contact_phone"
            label="Teléfono"
            placeholder="Ingrese sólo números"
            classList="col-lg-6 mb-4"
            onlyNumbersAndSymbols
            required
          ></v-input>
          <!-- Col -->
          <div class="col-12 mt-4">
            <!-- Button -->
            <save-button text="Guardar datos"></save-button>
            <!-- /.Button -->
          </div>
          <!-- /.Col -->
        </form>
        <!-- /.Row -->
      </div>
      <!-- /.Col -->
    </div>
    <!-- /.Row -->
  </dashboard-card>
  <!-- /.   Dashboard card -->
</template>

<script>
export default {
  name: "PatientEditView",
  props: {
    patient_id: {
      type: [Number, String],
    },
  },
  data() {
    return {
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
      loadingPatient: true,
      medical_ensurances: [],
    };
  },
  created() {
    this.hasPermission("patient_update");
    this.$Progress.start();
    this.fetchPatient();
    this.fetchMedicalEnsurances();
  },
  methods: {
    /**
     * Obtener información del paciente para el formulario.
     *
     * @return JSON.
     */
    patientFormData() {
      return {
        patient_id: this.patient.patient_id,
        name: this.patient.name,
        lastname: this.patient.lastname,
        dni: this.patient.dni,
        address: this.patient.address,
        phone: this.patient.phone,
        birth_date: this.patient.birth_date,
        personal_background: this.patient.personal_background,
        medical_ensurance_id: this.patient.medical_ensurance_id,
        email: this.patient.email,
        contact_name: this.patient.contact_name,
        contact_lastname: this.patient.contact_lastname,
        contact_phone: this.patient.contact_phone,
      };
    },

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
          if (!this.canEditPatient(res.data)) {
            this.handle403();
          }
          this.patient = res.data;
          this.$Progress.finish();
          this.loadingPatient = false;
        })
        .catch((err) => {
          this.errorHandler(err.response.status);
          console.log(err);
        });
    },

    /**
     * Guardar perfil de usuario
     */
    updatePatient() {
      this.loadingPatient = true;
      const path = "/api/patient/update";
      const AuthStr =
        "Bearer " + localStorage.getItem("access_token").toString();

      const formData = this.patientFormData();

      axios
        .post(path, formData, {
          headers: {
            Accept: "application/json",
            Authorization: AuthStr,
          },
        })
        .then((res) => {
          this.new_alert(res.data);
          loadingPatient = false;
        })
        .catch((err) => {
          console.log(err);
          this.loadingPatient = false;
        });
    },

    /**
     *
     */
    reloadData() {
      this.fetchPatient();
    },

    /**
     * Obtener todas las obras sociales.
     */
    fetchMedicalEnsurances() {
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