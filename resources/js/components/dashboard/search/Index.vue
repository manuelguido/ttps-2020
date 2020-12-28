<template>
  <!-- Container -->
  <div>
    <!-- Stepper content -->
    <div class="stepper-content">
      <!-- Step 1: Buscar paciente por dni -->
      <search-box
        v-if="currentStep == 1"
        @updateData="updateData"
        @loadingData="loadingData"
      ></search-box>
      <!-- /.Step 1 -->

      <!-- Step 2: Crear nuevo paciente o actualizar  -->
      <div v-else-if="currentStep == 2">
        <div class="black-alpha-60 mb-4">
          <button
            @click="searchAgain()"
            class="btn btn-outline-primary p-1 m-0"
          >
            Buscar de nuevo <i class="fad fa-redo-alt ml-3"></i>
          </button>
        </div>
        <search-result
          :results="searchResult"
        ></search-result>
      </div>
      <!-- /.Step 2 -->
    </div>
    <!-- /.Stepper content -->
  </div>
  <!-- Container -->
</template>

<script>
import { mdbListGroup, mdbListGroupItem } from "mdbvue";
import SearchResult from "./SearchResult.vue";
import SearchBox from "./SearchBox.vue";
export default {
  name: "Search",
  components: {
    SearchResult,
    SearchBox,
  },
  data() {
    return {
      currentStep: 1,
      searchResult: [],
    };
  },
  methods: {
    /**
     * Cambiar de estado la variable de carga.
     */
    loadingData(newStatus) {
      this.loading = newStatus;
    },

    searchAgain() {
      this.currentStep = 1;
      this.searchResult = null;
    },

    updateData(data) {
      this.searchResult = data.data;
      this.currentStep = 2;
    },
  },
};
</script>
