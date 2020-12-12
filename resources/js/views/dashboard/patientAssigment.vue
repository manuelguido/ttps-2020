<template>
  <!-- Dashboard card -->
  <dashboard-card :title="cardTitle">
    <loading-overlay
      v-if="loading_patient"
      message="Buscando paciente"
    ></loading-overlay>
    <!-- Row -->
    <div v-else class="row">
      <!-- Nombre -->
      <div class="col-12 mb-3">
        <p class="h4-responsive">
          <span class="black-alpha-50">Paciente: </span>
          <span class="primary">{{ patient.name }} {{ patient.lastname }}</span>
        </p>
      </div>

      <!-- Información -->
      <div class="col-12">
        <info-data data="DNI" :value="dni()"></info-data>
        <info-data data="Se encuentra en" :value="place()"></info-data>
        <info-data data="Estado" :value="patient.patient_state"></info-data>
      </div>
      <!-- /.Información -->

      <!-- Hr -->
      <div class="col-12 mb-3">
        <hr />
      </div>

      <!-- Titulo -->
      <div class="col-12 mb-3">
        <dashboard-subtitle :text="newAssigmentTitle"></dashboard-subtitle>
      </div>
      <!-- /.Titulo -->

      <!-- Asignación -->
      <div class="col-12 col-lg-8 mb-5">
        <div class="row align-items-center">
          <div class="col-12 col-lg-8 col-xl-9">
            <select v-model="new_medic_id" class="form-control">
              <option value="0">Seleccionar</option>
              <option
                v-for="m in posibleMedics"
                :key="m.medic_id"
                :value="m.medic_id"
              >
                {{ m.name + " " + m.lastname }}
              </option>
            </select>
          </div>
          <div class="col-12 col-lg-4 col-xl-3 text-right">
            <button
              :class="[
                'btn btn-block btn-primary ml-lg-4 mt-3 mt-lg-0 mr-0 py-2',
                new_medic_id == 0 ? 'disabled' : '',
              ]"
              @click="addMedic()"
            >
              Asignar
            </button>
          </div>
        </div>
      </div>
      <!-- /.Asignación -->

      <!-- Titulo -->
      <div class="col-12 mb-3">
        <dashboard-subtitle text="Médicos asignados"></dashboard-subtitle>
      </div>
      <!-- /.Titulo -->

      <!-- Médicos -->
      <div v-if="medics.length > 0" class="col-12 col-md-9 mb-3">
        <mdb-list-group>
          <mdb-list-group-item
            v-for="m in medics"
            :key="m.medic_id"
            class="d-flex justify-content-between align-items-center"
          >
            <span>{{ m.name + " " + m.lastname }}</span>
            <div
              class="text-right action-button"
              @click="removeMedic(m.medic_id)"
            >
              <i class="fas fa-times"></i>
            </div>
          </mdb-list-group-item>
        </mdb-list-group>
      </div>
      <!-- Medicos -->

      <div v-else class="col-12">
        <p class="black-alpha-30">
          <i class="fad fa-meh mr-4 fa-2x"></i>
          Parece que aún no hay médicos asignados al paciente
        </p>
      </div>
    </div>
    <!-- /.Row -->
  </dashboard-card>
  <!-- /.Dashboard Card -->
</template>

<script>
import { mdbListGroup, mdbListGroupItem } from "mdbvue";

export default {
  name: "PatientAssigmentView",
  props: ["patient_id"],
  components: {
    mdbListGroup,
    mdbListGroupItem,
  },
  data() {
    return {
      cardTitle: "Asignar médicos al paciente",
      newAssigmentTitle:
        "Asignar nuevo médico de " +
        JSON.parse(localStorage.getItem("system")).system,
      patient: {},
      loading_patient: true,
      loadingMedics: true,
      new_medic_id: 0,
      medics: [],
    };
  },
  created() {
    this.$Progress.start();
    this.fetchPatient();
    this.fetchMedics();
  },
  methods: {
    /**
     * Obtener el paciente.
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
          this.loading_patient = false;
        })
        .catch((err) => {
          this.errorHandler(err.response.status);
          console.log(err);
        });
    },

    /**
     * Obtener los médicos.
     * 
     * @return void.
     */
    fetchMedics() {
      const path = "/api/patient/medics/" + this.patient_id;
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
          this.medics = res.data.medics;
          this.posibleMedics = res.data.posible_medics;
          this.loadingMedics = false;
          this.$Progress.finish();
        })
        .catch((err) => {
          this.errorHandler(err.response.status);
          console.log(err);
        });
    },


    /**
     * Añadir médico al paciente.
     * 
     * @return void.
     */
    addMedic() {
      if (this.new_medic_id > 0) {
        const path = "/api/patient/medic/add";
        const AuthStr =
          "Bearer " + localStorage.getItem("access_token").toString();

        var formData = new FormData();
        formData.append("patient_id", this.patient_id);
        formData.append("medic_id", this.new_medic_id);
        console.log(this.new_medic_id);
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
              this.fetchMedics();
              this.new_medic_id = 0;
            }
            console.log(res);
          })
          .catch((err) => {
            this.errorHandler(err.response.status);
            console.log(err);
          });
      }
    },

    /**
     * Quitar médico del paciente.
     * 
     * @return void.
     */
    removeMedic(medicId) {
      const path = "/api/patient/medic/remove";
      const AuthStr =
        "Bearer " + localStorage.getItem("access_token").toString();

      var formData = new FormData();
      formData.append("patient_id", this.patient_id);
      formData.append("medic_id", medicId);
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
            this.fetchMedics();
          }
          console.log(res);
        })
        .catch((err) => {
          this.errorHandler(err.response.status);
          console.log(err);
        });
    },

    /**
     * Hace el formato de DNI
     */
    dni() {
      let val = (this.patient.dni / 1).toFixed(0).replace(".");
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },

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

<style scoped>
.action-button {
  border-radius: 50px;
  width: 30px !important;
  height: 30px !important;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #eee;
  margin: 0;
  transition: 0.1s all !important;
  cursor: pointer;
}
.action-button:hover {
  background: #f8f8f8;
  box-shadow: 0px 0px 2px 1px rgba(0, 0, 0, 0.3);
}

.action-button:last-child {
  margin: 0;
}
</style>