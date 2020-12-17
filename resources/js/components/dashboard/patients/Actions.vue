<template>
  <div class="col-12 mb-4">
    <h1 class="h5 black-alpha-50">Acciones</h1>
    <div class="d-flex flex-row justify-content-start">
      <span v-if="canEditPatient(patient)" class="actions-list">
        <router-link
          class="btn btn-blue-grey btn-sm"
          :to="'/dashboard/patient/assignment/' + patient.patient_id"
          ><i class="fad fa-user-md mr-3"></i>Asignar médicos</router-link
        >
        <router-link
          :to="'/dashboard/patient/system/change/' + patient.patient_id"
          class="btn btn-blue-grey btn-sm"
          ><i class="fad fa-exchange-alt mr-3"></i>Cambiar sistema</router-link
        >
        <button v-if="patientCanExit(patient)" class="btn btn-dark-green btn-sm" @click="declareExit">
          <i class="fad fa-shield-check mr-3"></i>Egresar del hospital
        </button>
        <button class="btn btn-danger btn-sm" @click="declareDeath">
          <i class="fad fa-times-hexagon mr-3"></i>Declarar óbito
        </button>
      </span>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "PatientActions",
  props: {
    patient: {
      type: Object,
    },
  },
  methods: {
    /**
     * Declarar óbito de paciente
     */
    declareExit() {
      const message = "¿Esta seguro de dar de alta al paciente?";
      if (confirm(message)) {
        const path = "/api/patient/declare/exit";
        this.sendData(path);
      }
    },

    /**
     * Declarar óbito de paciente
     */
    declareDeath() {
      const message = "¿Esta seguro de declarar óbito del paciente?";
      if (confirm(message)) {
        const path = "/api/patient/declare/death";
        this.sendData(path);
      }
    },

    /**
     * Enviar información.
     */
    sendData(path) {
      const AuthStr =
        "Bearer " + localStorage.getItem("access_token").toString();
      const formData = {
        patient_id: this.patient.patient_id,
      };

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
            this.$emit("reloadData");
          }
        })
        .catch((err) => {
          this.errorHandler(err.response.status);
          console.log(err);
        });
    },
  },
};
</script>

<style scoped>
.actions-list .btn:first-child {
  margin-left: 0 !important;
}
</style>