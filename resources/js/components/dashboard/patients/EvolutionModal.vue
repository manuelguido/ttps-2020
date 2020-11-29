<template>
  <div>
    <mdb-btn color="secondary" @click.native="modal = true" class="mr-0 ml-5 py-2 px-1">
      <i class="fad fa-file-edit mr-3 fa-lg"></i>
      Agregar evolución
    </mdb-btn>
    <mdb-modal :show="modal" size="lg" @close="modal = false">
      <mdb-modal-header>
        <mdb-modal-title>Agregar evolución</mdb-modal-title>
      </mdb-modal-header>
      <mdb-modal-body class="text-left p-3 p-lg-4">
        <evolution-modal-content :patient_id="patient_id"></evolution-modal-content>
      </mdb-modal-body>
    </mdb-modal>
  </div>
</template>

<script>
  import { mdbModal, mdbModalHeader, mdbModalTitle, mdbModalBody, mdbModalFooter, mdbBtn } from 'mdbvue';
  import evolutionModalContent from './EvolutionModalContent';

  export default {
    components: {
      mdbModal,
      mdbModalHeader,
      mdbModalTitle,
      mdbModalBody,
      mdbModalFooter,
      mdbBtn,
      'evolution-modal-content': evolutionModalContent,
    },
    props: {
      patient_id: {
        type: Number,
      }
    },
    data() {
      return {
        modal: false,
      }
    }
  };
</script>
