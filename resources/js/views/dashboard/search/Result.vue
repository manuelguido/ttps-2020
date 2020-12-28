<template>
  <!-- Container -->
  <dashboard-card :title="cardTitle" noBack>
    <loading-overlay v-if="loadingData" />
    <!-- Row -->
    <div v-else class="row justify-content-center">
      <!-- Col -->
      <div class="col-12">
        <h1 class="h5 black-alpha-70 mb-4">
          {{ patient.name }} {{ patient.lastname }}
        </h1>
        <p class="h6 black-alpha-50 mb-3">Obra social: {{ patient.medical_ensurance }}</p>
        <p class="h6 black-alpha-50 mb-3">DNI {{ formatDni(patient.dni) }}</p>
        <p class="h6 black-alpha-50 mb-3">Estado actual: {{patient.patient_state}} </p>
        <hr />
      </div>
      <!-- /.Col -->

      <!-- Col -->
      <div v-for="e in entries" :key="e.entry_id" class="col-12 mb-4">
        <h1 class="black-alpha-40 h6">
          Fecha de admission: {{ e.date_of_admission | formatDate }}
        </h1>
        <h1 v-if="e.date_of_exit" class="black-alpha-40 h6">
          Fecha de egreso: {{ e.date_of_exit | formatDate }}
        </h1>
        <h1 v-if="e.date_of_death" class="black-alpha-40 h6">
          Fecha de óbito: {{ e.date_of_death | formatDate }}
        </h1>

        <!-- List -->
        <mdb-list-group
          v-for="h in e.hospitalizations"
          :key="h.hospitalization_id"
        >
          <mdb-list-group-item class="d-flex flex-column align-items-start">
            <span class="h4 primary mb-2">{{ h.system }}</span>
            <span class="h5 black-alpha-50 my-3">Evoluciones</span>

            <!-- Evolutions -->
            <span class="w-100 p-0">
              <div class="container-fluid p-0">
                <div class="row">
                  <clinic-data
                    :patient_id="patient.patient_id"
                    :clinicData="h.evolutions"
                    :noEdit="true"
                    noTitle
                  />
                </div>
              </div>

              <!-- <mdb-list-group v-for="ev in h.evolutions" :key="ev.evolution_id">
                <mdb-list-group-item>{{ ev.evolution_id }} </mdb-list-group-item>
              </mdb-list-group> -->
            </span>
            <!-- /.Evolutions -->
          </mdb-list-group-item>
        </mdb-list-group>
        <!-- /.List -->
      </div>
      <!-- /.Col -->
    </div>
    <!-- /.Row -->
  </dashboard-card>
  <!-- Container -->
</template>

<script>
import { mdbListGroup, mdbListGroupItem } from "mdbvue";
import ClinicData from "../../../components/dashboard/patients/ClinicData/Index.vue";

export default {
  name: "ResultView",
  props: {
    patient_id: {
      type: [Number, String],
    },
  },
  components: {
    ClinicData,
    mdbListGroup,
    mdbListGroupItem,
  },
  data() {
    return {
      patient: {},
      entries: [],
      cardTitle: "Paciente - Historia Clínica",
      loadingData: true,
    };
  },
  created() {
    this.fetchData();
  },
  methods: {
    /**
     * Obtener información de paciente.
     */
    fetchData() {
      const path = "/api/patient/complete/" + this.patient_id;
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
          this.patient = res.data.patient;
          this.entries = res.data.entries;
          // var entries = res.data.entries;

          // for (let index = 0; index < entries.length; index++) {
          //   let system_changes = entries[index].system_changes;
          //   let evolutions = entries[index].evolutions;
          // }

          // let system_changes = res.data.system_changes;
          // let evolutions = res.data.evolutions;

          // let items = evolutions.concat(system_changes);

          // items.sort(function (a, b) {
          //   return b.created_at.localeCompare(a.created_at);
          // });

          // this.entries = res.data.entries;

          // this.clinicData = items;

          this.loadingData = false;
        })
        .catch((err) => {
          console.log(err);
          this.loadingData = false;
        });
    },
  },
};
</script>

<style scoped>
.align-items-start {
  align-items: flex-start !important;
}
</style>