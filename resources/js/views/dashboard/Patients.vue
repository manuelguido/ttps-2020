<template>
  <!-- Container -->
  <div class="container-fluid">
    <!-- Title -->
    <dashboard-title text="Pacientes" full></dashboard-title>
    <!-- Row -->
    <div class="row">
      <!-- Col -->
      <div class="col-12 text-right">
        <modal></modal>
      </div>
      <!-- /.Col -->
      <!-- Col -->
      <div class="col-12 text-left">
        <data-table></data-table>
      </div>
      <!-- /.Col -->
    </div>
    <!-- /.Row -->
  </div>
  <!-- Container -->
</template>

<script>
import modal from '../../components/dashboard/patients/NewPatientModal';

export default {
  components: {
    modal
  }
}
</script>
