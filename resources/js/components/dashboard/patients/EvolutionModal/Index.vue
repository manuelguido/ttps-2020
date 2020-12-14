<template>
  <!-- Div -->
  <div>
    <!-- Button -->
    <mdb-btn
      color="purple"
      @click.native="modal = true"
      class="mr-0 ml-5 py-2 px-1"
    >
      <!-- Icon -->
      <i class="fad fa-file-edit mr-3 fa-lg"></i>
      Agregar evolución
    </mdb-btn>
    <!-- /.Button -->
    <!-- Modal -->
    <mdb-modal :show="modal" size="xl" @close="modal = false">
      <!-- Modal header-->
      <mdb-modal-header>
        <mdb-modal-title>Agregar evolución al paciente</mdb-modal-title>
      </mdb-modal-header>
      <!-- Modal header-->
      <!-- Modal body -->
      <mdb-modal-body class="text-left p-3 p-lg-4">
        <!-- Content -->
        <evolution-modal-content
          @reload-data="reloadData"
          :patient_id="patient_id"
        ></evolution-modal-content>
        <!-- /.Content -->
      </mdb-modal-body>
      <!-- /.Modal body -->
    </mdb-modal>
    <!-- /.Modal -->
  </div>
  <!-- /.Div -->
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
import EvolutionModalContent from "./Content";

export default {
  name: "EvolutionModal",
  components: {
    mdbModal,
    mdbModalHeader,
    mdbModalTitle,
    mdbModalBody,
    mdbModalFooter,
    mdbBtn,
    EvolutionModalContent,
  },
  props: {
    patient_id: {
      type: String,
    },
  },
  data() {
    return {
      modal: false,
    };
  },
  methods: {
    reloadData() {
      this.modal = false;
      this.$emit("reload-data");
    },
  },
};
</script>
