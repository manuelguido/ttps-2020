<template>
  <!-- Step 1  -->
  <div class="step-content animated">
    <!-- Row -->
    <div class="row justify-content-center">
      <!-- Main title -->
      <div
        class="col-lg-10 d-flex justify-content-between align-items-baseline"
      >
        <dashboard-title :text="title" colored></dashboard-title>
        <span @click="searchAgain" class="primary c-pointer">
          <i class="fad fa-chevron-left mr-3"></i>Buscar otro paciente
        </span>
      </div>
      <!-- /.Main title -->
      <!-- Form -->
      <form
        class="col-12 col-lg-10 text-center d-flex flex-column align-items-center"
        @submit.prevent="createUpdatePatient()"
      >
        <!-- Row -->
        <div class="row text-left">
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

          <!-- Title -->
          <div class="col-12 my-4">
            <dashboard-subtitle
              text="Información de enfermedad"
            ></dashboard-subtitle>
          </div>
          <!-- /.Title -->
          <v-input
            v-model="entryData.actual_disease"
            label="Enfermedad actual"
            placeholder="Enfermedad actual del paciente"
            classList="col-lg-6 mb-4"
            required
          ></v-input>
          <v-input
            v-model="entryData.date_of_symptoms"
            label="Fecha de inicio de síntomas"
            classList="col-lg-6 mb-4"
            type="date"
            required
          ></v-input>
          <v-input
            v-model="entryData.date_of_diagnosis"
            label="Fecha de diagnóstico"
            classList="col-lg-6 mb-4"
            type="date"
            required
          ></v-input>
          <v-input
            v-model="entryData.date_of_admission"
            label="Fecha de admisión"
            classList="col-lg-6 mb-4"
            type="date"
            required
          ></v-input>

          <!-- Col -->
          <div class="col-12 mt-4">
            <!-- Button -->
            <save-button text="Guardar datos"></save-button>
            <!-- /.Button -->
          </div>
          <!-- /.Col -->
        </div>
        <!-- /.Row -->
      </form>
      <!-- /.Form -->
    </div>
    <!-- /.Row -->
  </div>
  <!-- /.Step 1 -->
</template>

<script>
export default {
  name: "CreateUpdatePatient",
  props: {
    createPatient: {
      type: Boolean,
      default: true,
    },
    patient: {
      type: Object,
      default: {
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
    },
    medical_ensurances: {
      type: Array,
      default: [],
    },
  },
  data() {
    return {
      entryData: {
        actual_disease: "",
        date_of_symptoms: "",
        date_of_diagnosis: "",
        date_of_admission: "",
      },
    };
  },
  computed: {
    title: function () {
      return this.createPatient
        ? "Ingresar datos del nuevo paciente"
        : "Paciente existente: verificar datos";
    },
  },
  methods: {
    /**
     * Obtener información del paciente para el formulario.
     *
     * @return JSON.
     */
    patientFormData() {
      return {
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
        actual_disease: this.entryData.actual_disease,
        date_of_symptoms: this.entryData.date_of_symptoms,
        date_of_diagnosis: this.entryData.date_of_diagnosis,
        date_of_admission: this.entryData.date_of_admission,
      };
    },

    /**
     * Crea un paciente, le agrega una entrada al sistema y una hospitalización en guardia.
     *
     * @return void.
     */
    createUpdatePatient() {
      this.$emit("loadingData", true);
      const path = this.createPatient
        ? "/api/patient/store"
        : "/api/patient/new_entry";

      const AuthStr =
        "Bearer " + localStorage.getItem("access_token").toString();

      let formData = this.patientFormData();
      if (!this.createPatient) {
        formData.patient_id = this.patient.patient_id;
      }

      axios
        .post(path, formData, {
          headers: {
            Accept: "application/json",
            Authorization: AuthStr,
          },
        })
        .then((res) => {
          this.new_alert(res.data);
          if (res.data.status == "success") {
            this.$emit("loadingData", false);
            this.searchAgain();
          }
        })
        .catch((err) => {
          console.log(err);
          this.$emit("loadingData", false);
        });
    },

    searchAgain() {
      this.$emit("searchAgain");
    },
  },
};
</script>
