<template>
  <div>
    <mdb-btn color="primary" @click.native="modal = true" class="mr-0 ml-5">
      <i class="fad fa-user-plus mr-2"></i>
      Nuevo ingreso
    </mdb-btn>
    <mdb-modal :show="modal" size="lg" @close="modal = false">
      <mdb-modal-header>
        <mdb-modal-title>
          <span v-if="step == 1">Registrar paciente</span>
          <span v-else-if="step == 2">Registrar ingreso del paciente</span>
        </mdb-modal-title>
      </mdb-modal-header>
      <mdb-modal-body class="text-left p-md-2 p-lg-4 p-xl-5">
        <!-- Form -->
        <form v-if="step == 1" method="POST" @submit.prevent="newPatient">
          <!-- Row -->
          <div class="row">
            <!-- Nombre -->
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label>Nombre (*)</label>
                <input
                  type="text"
                  class="form-control mb-3"
                  v-model="name"
                  placeholder="Ingrese el nombre"
                  required
                />
              </div>
            </div>
            <!-- Apellido -->
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label>Apellido (*)</label>
                <input
                  type="text"
                  class="form-control mb-3"
                  v-model="lastname"
                  placeholder="Ingrese el apellido"
                  required
                />
              </div>
            </div>
          </div>
          <!-- /.Row -->

          <!-- Row -->
          <div class="row">
            <!-- DNI -->
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label>DNI (*)</label>
                <input
                  type="number"
                  min="0"
                  class="form-control mb-3"
                  v-model="dni"
                  placeholder="Ingrese solo números"
                  required
                />
              </div>
            </div>
            <!-- Dirección -->
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label>Dirección (*)</label>
                <input
                  type="text"
                  class="form-control mb-3"
                  v-model="address"
                  placeholder="Ingrese dirección del paciente"
                  required
                />
              </div>
            </div>
          </div>
          <!-- /.Row -->

          <!-- Row -->
          <div class="row">
            <!-- Teléfono -->
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label>Teléfono (*)</label>
                <input
                  type="number"
                  min="0"
                  class="form-control mb-3"
                  v-model="phone"
                  placeholder="Ingrese solo números"
                  required
                />
              </div>
            </div>
            <!-- Fecha de nacimiento -->
            <div class="col-12 col-md-6">
              <div class="form-group px-0">
                <label>Fecha de nacimiento (*)</label>
                <input
                  type="date"
                  class="form-control mb-3"
                  v-model="birth_date"
                  required
                />
              </div>
            </div>
          </div>
          <!-- /.Row -->

          <div class="form-group">
            <label>Antecedentes personales</label>
            <textarea
              rows="3"
              class="form-control mb-3"
              v-model="personal_background"
              placeholder="Ingresar antecedentes personales del paciente"
            ></textarea>
          </div>

          <div class="form-group">
            <label>Información opcional de familiares</label>
            <textarea
              rows="3"
              class="form-control mb-3"
              v-model="family_data"
              placeholder="Ejemplo: telefono y nombre de padre/madre/tutor"
            ></textarea>
          </div>

          <div class="row">
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label>Obra social (*)</label>
                <select
                  v-model="medical_ensurance_id"
                  class="custom-select"
                  required
                >
                  <option value="0" disabled>Seleccionar</option>
                  <option
                    v-for="m in medical_ensurances"
                    :key="m.medical_ensurance_id"
                    :value="m.medical_ensurance_id"
                  >
                    {{ m.medical_ensurance }}
                  </option>
                </select>
              </div>
            </div>

            <div class="col-12 col-md-6">
              <div class="form-group px-0">
                <label>Ingresa a:</label>
                <input
                  type="text"
                  class="form-control disabled mb-3"
                  disabled
                  value="Guardia"
                />
              </div>
            </div>
          </div>

          <button class="btn btn-primary btn-block mt-4 mt-lg-5" type="submit">
            Cargar
          </button>
        </form>

        <!-- Registrar ingreso de paciente -->
        <form v-if="step == 2" method="POST" @submit.prevent="newEntry"></form>

        <!-- Form -->
      </mdb-modal-body>
    </mdb-modal>
  </div>
</template>

<script>
import {
  mdbModal,
  mdbModalHeader,
  mdbModalTitle,
  mdbModalBody,
  mdbModalFooter,
  mdbBtn,
} from "mdbvue";
export default {
  components: {
    mdbModal,
    mdbModalHeader,
    mdbModalTitle,
    mdbModalBody,
    mdbModalFooter,
    mdbBtn,
  },
  data() {
    return {
      modal: false,
      step: 1,
      name: "",
      lastname: "",
      dni: "",
      address: "",
      phone: "",
      birth_date: "",
      personal_background: "",
      family_data: "",
      medical_ensurance_id: 0,
      medical_ensurances: "",
      stored_patient: {},
    };
  },
  created() {
    this.getMedicalEnsurances();
  },
  methods: {
    resetForm() {
      this.name = "";
      this.lastname = "";
      (this.dni = ""), (this.address = "");
      this.phone = "";
      this.birth_date = "";
      this.personal_background = "";
      this.medical_ensurance_id = 0;
    },

    /**
     * Guarda un paciente
     */
    newPatient() {
      const path = "/api/patient/store";
      const AuthStr =
        "Bearer " + localStorage.getItem("access_token").toString();

      var formData = new FormData();
      formData.append("name", this.name);
      formData.append("lastname", this.lastname);
      formData.append("dni", this.dni);
      formData.append("address", this.address);
      formData.append("phone", this.phone);
      formData.append("birth_date", this.birth_date);
      formData.append("personal_background", this.personal_background);
      formData.append("family_data", this.family_data);
      formData.append("medical_ensurance_id", this.medical_ensurance_id);

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
            this.resetForm();
            this.stored_patient = res.data.patient;
            this.modal = false;
            this.$emit("reload-patients");
          }
          console.log(res);
        })
        .catch((err) => {
          console.log(err);
        });
    },

    newEntry() {
      const path = "/api/patient/store";
      const AuthStr =
        "Bearer " + localStorage.getItem("access_token").toString();

      var formData = new FormData();
      formData.append("name", this.name);
      formData.append("lastname", this.lastname);
      formData.append("dni", this.dni);
      formData.append("address", this.address);
      formData.append("phone", this.phone);
      formData.append("birth_date", this.birth_date);
      formData.append("personal_background", this.personal_background);
      formData.append("family_data", this.family_data);
      formData.append("medical_ensurance_id", this.medical_ensurance_id);

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
            this.resetForm();
            this.stored_patient = res.data.patient;
            this.modal = false;
            this.$emit("reload-patients");
          }
          console.log(res);
        })
        .catch((err) => {
          console.log(err);
        });
    },

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
          this.medical_ensurances = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>
