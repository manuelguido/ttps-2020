<template>
  <!-- Historia clínica -->
  <div class="col-12">
    <!-- Row -->
    <div class="row">
      <div
        class="col-12 d-flex justify-content-between align-items-center mb-5"
      >
        <p class="h4-responsive mb-0">
          <span class="black-alpha-50">{{ title }}</span>
        </p>
        <span>
          <evolution-modal
            @reload-data="reloadData()"
            :patient_id="patient_id"
          ></evolution-modal>
        </span>
      </div>

      <!-- Col -->
      <div v-if="showEvolutions" class="col-12">
        <div class="d-flex flex-column w-100">
          <!-- Lista de ultimas evoluciones -->
          <mdb-list-group v-for="le in lastEvolutions" :key="le.evolution_id">
            <!-- Hospitalización -->
            <mdb-list-group-item>
              <div class="d-flex flex-column">
                <p class="black-alpha-20">{{ le.date }}</p>
              </div>
            </mdb-list-group-item>
          </mdb-list-group>
          <!-- /.Lista de ultimas evoluciones -->
        </div>
      </div>

      <div
        v-else
        class="col-12 mb-5"
        v-for="en in clinicData"
        :key="en.entry_id"
      >
        <div class="d-flex flex-column w-100">
          <!-- Fecha de ingreso al sistema -->
          <p class="">Ingreso al hospital: {{ en.date | formatDateFull }}</p>
          <p class="">
            Egreso del hospital:&nbsp;
            <span v-if="en.date_of_exit != null">{{
              en.date_of_exit | formatDateFull
            }}</span>
            <span v-else>Aún en el hospital</span>
          </p>
          <div>
            <!-- Lista de hospitalizaciones -->
            <mdb-list-group
              v-for="h in en.hospitalizations"
              :key="h.hospitalization_id"
            >
              <!-- Hospitalización -->
              <mdb-list-group-item>
                <div class="d-flex flex-column w-100">
                  <p class="h6-responsive">Sistema {{ h.system }}&nbsp;</p>
                  <p class="black-alhpa-60">
                    Fecha de diagnostico
                    <span class="black-alpha-20">{{
                      h.date_of_diagnosis | formatDate
                    }}</span>
                  </p>
                  <p class="black-alhpa-60">
                    Fecha de admisión
                    <span class="black-alpha-20">{{
                      h.date_of_diagnosis | formatDate
                    }}</span>
                  </p>
                  <span>
                    <!-- Lista de entradas al sistema -->
                    <mdb-list-group
                      v-for="e in h.evolutions"
                      :key="e.evolution_id"
                    >
                      <!-- Item -->
                      <mdb-list-group-item>
                        <div class="d-flex flex-column">
                          <span class="h6">{{ h.system_id }}</span>
                        </div>
                      </mdb-list-group-item>
                    </mdb-list-group>
                  </span>
                </div>
              </mdb-list-group-item>
              <!-- /.Hospitalización -->
            </mdb-list-group>
            <!-- /.Lista de hospitalizaciones -->
          </div>
        </div>
      </div>
      <!-- /.Col -->
    </div>
  </div>
</template>

<script>
import EvolutionModal from "./EvolutionModal/Index";
import { mdbListGroup, mdbListGroupItem } from "mdbvue";

export default {
  name: "ClinicData",
  props: {
    clinicData: {
      type: Array,
      default: [],
    },
    lastEvolutions: {
      type: Array,
      default: [],
    },
    patient_id: {
      type: String,
    },
  },
  components: {
    mdbListGroup,
    mdbListGroupItem,
    EvolutionModal,
  },
  data() {
    return {
      showEvolutions: null,
      title: "",
    };
  },
  created() {
    this.showEvolutions = true;
  },
  methods: {
    reloadData() {
      this.$emit("reload-data");
    },
  },
  watch: {
    showEvolutions: function () {
      this.title = this.showEvolutions
        ? "Ultimas evoluciones"
        : "Historia Clínica";
    },
  },
};
</script>

<style scoped>
.select-container {
  background: #f4f4f4;
  border-radius: 8px;
  overflow: hidden;
  /* padding: .5em; */
}
.select-container,
.select-container * {
  transition: 0.1s all;
}

.option-button,
.option-button {
  flex: 1;
  padding: 0.75em 0;
  cursor: pointer;
  color: #999;
  text-align: center;
}
.option-button:first {
  border-top-left-radius: 100px;
}

.button-active {
  background: #aaa !important;
  color: #fff !important;
}
</style>
