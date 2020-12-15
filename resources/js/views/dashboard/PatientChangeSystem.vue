<template>
  <!-- Dashboard card -->
  <dashboard-card title="Cambiar paciente de sistema">
    <!-- Title -->
    <loading-overlay
      v-if="loading"
      message="Cargando paciente"
    ></loading-overlay>
    <!-- Row -->
    <div v-else class="row">
      <!-- Información de paciente -->
      <div class="col-12">
        <p class="h3 primary">{{ patient.lastname }}, {{ patient.name }}</p>
        <p class="h6 black-alpha-40">DNI {{ formatDni(patient.dni) }}</p>
      </div>
      <div class="col-12 mt-5">
        <p class="h4">
          <span class="black-alpha-60">Se encuentra en </span>
          <span class="black-alpha-40">{{ patient.system }}</span>
        </p>
      </div>
      <!-- /.Información de paciente -->

      <!-- Cambio de sistema -->
      <div v-if="canEditPatient(patient)" class="col-12 col-lg-8 col-xl-7 mt-5">
        <p class="h5 black-alpha-40 mb-3">Puede pasar a</p>
        <!-- Form -->
        <form @submit.prevent="changeSystem">
          <div
            v-for="s in allowedSystems"
            :key="s.system_id"
            :class="[
              'custom-control custom-radio mb-2',
              s.free_beds == 0 ? 'disabled' : '',
            ]"
          >
            <input
              type="radio"
              class="custom-control-input"
              :id="'radio' + s.system_id"
              :value="s.system_id"
              v-model="newSystem"
            />
            <label :for="'radio' + s.system_id" class="custom-control-label">
              <span>{{ s.system }}</span>
              <span class="black-alpha-40">{{ formatSystem(s) }}</span>
            </label>
          </div>
          <save-button :disabled="disabledSubmit" classList="mt-5" />
        </form>
        <!-- /.Form -->
      </div>
      <!-- /.Cambio de sistema -->
    </div>
    <!-- /.Row -->
  </dashboard-card>
  <!-- /.Dashboard card -->
</template>

<script>
export default {
  name: "PatientChangeSystemView",
  props: ["patient_id"],
  data() {
    return {
      loading: true,
      patient: {},
      allowedSystems: [],
      newSystem: null,
      disabledSubmit: true,
      backLink: {
        url: "/dashboard/patients",
        text: "Pacientes",
      },
      userSystemId: JSON.parse(localStorage.getItem("system")),
    };
  },
  created() {
    this.hasPermission("patient_update");
    this.$Progress.start();
    this.fetchPatient();
  },
  methods: {
    formatSystem(system) {
      return (
        " (Ocupación de camas: " +
        system.occupied_beds +
        "/" +
        system.total_beds +
        ")"
      );
    },
    /**
     * Obtener información del paciente.
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
          this.fetchAllowedSystems();
        })
        .catch((err) => {
          this.errorHandler(err.response.status);
          var $this = this;
          setTimeout(function () {
            $this.fetchPatient();
          }, 1300);
          console.log(err);
        });
    },

    /**
     * Obtener sistemas.
     */
    fetchAllowedSystems() {
      const path = "/api/system/allowed/index";
      const AuthStr =
        "Bearer " + localStorage.getItem("access_token").toString();

      const formData = {
        system_id: this.patient.system_id,
      };
      axios
        .post(path, formData, {
          headers: {
            Accept: "application/json",
            Authorization: AuthStr,
          },
        })
        .then((res) => {
          this.allowedSystems = res.data;
        })
        .catch((err) => {
          this.errorHandler(err.response.status);
          console.log(err);
        })
        .finally(() => {
          this.loading = false;
          this.$Progress.finish();
        });
    },

    /**
     * Cambiar de sistema.
     */
    changeSystem() {
      const confirmMessage =
        "¿Estas seguro que quieres pasar al paciente de sistema?\n Todos los médicos que tenga asignados serán desasignados del paciente";
      if (confirm(confirmMessage)) {
        const path = "/api/patient/system/change";
        const AuthStr =
          "Bearer " + localStorage.getItem("access_token").toString();

        const formData = {
          patient_id: this.patient.patient_id,
          system_id: this.newSystem,
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
              this.patient = null;
              this.patient = res.data.patient;
            }
          })
          .catch((err) => {
            console.log(err);
          });
      }
    },
  },
  watch: {
    newSystem: function () {
      if (this.newSystem) {
        this.disabledSubmit = false;
      }
    },
  },
};
</script>

<style scoped>
.custom-control,
.custom-control *,
.custom-control:hover {
  cursor: pointer;
}

.custom-control.disabled,
.custom-control.disabled *,
.custom-control.disabled:hover {
  opacity: 0.5;
  cursor: not-allowed;
}
</style>