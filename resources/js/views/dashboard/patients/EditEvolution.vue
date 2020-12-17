<template>
  <!-- Dashboard card -->
  <dashboard-card>
    <!-- Row -->
    <div class="row">
      <div class="col-12">
        <evolution-edit-modal-content
          :evolution_id="evolution_id"
        ></evolution-edit-modal-content>
      </div>
    </div>
    <!-- /.Row -->
  </dashboard-card>
  <!-- /.Dashboard card -->
</template>

<script>
import EvolutionEditModalContent from "../../../components/dashboard/patients/EvolutionModal/EditContent";

export default {
  name: "PatientEvolutionAddView",
  props: ["evolution_id"],
  components: {
    EvolutionEditModalContent,
  },
  created() {
    this.hasPermission("patient_update");
  },
};
</script>