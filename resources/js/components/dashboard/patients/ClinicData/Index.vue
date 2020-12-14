<template>
  <!-- Historia clínica -->
  <div class="col-12">
    <!-- Row -->
    <div class="row">
      <!-- Col -->
      <div
        class="col-12 d-flex justify-content-between align-items-center mb-5"
      >
        <!-- Title -->
        <p class="h4-responsive mb-0">
          <span class="black-alpha-50">{{ title }}</span>
        </p>
        <!-- Modal -->
        <span>
          <evolution-modal
            @reload-data="reloadData()"
            :patient_id="patient_id"
          ></evolution-modal>
        </span>
        <!-- /.Modal -->
      </div>
      <!-- Col -->

      <!-- Col -->
      <div class="col-12 mb-5">
        <!-- Lista de historia clinica -->
        <clinic-data-list :clinicData="clinicData" />
        <!-- /.Lista de historia clinica -->
      </div>
      <!-- /.Col -->
    </div>
    <!-- Row -->
  </div>
  <!-- Historia clínica -->
</template>

<script>
import EvolutionModal from "../EvolutionModal/Index.vue";
import ClinicDataList from "./ClinicList";

export default {
  name: "ClinicData",
  props: {
    clinicData: {
      type: Array,
    },
    patient_id: {
      type: String,
    },
  },
  components: {
    EvolutionModal,
    ClinicDataList,
  },
  data() {
    return {
      title: "Evoluciones",
      showEvolutions: null,
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
