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
      <div class="col-12 col-lg-6 text-left">
        <!-- <data-table></data-table> -->
        <!-- <patients-table
          v-for="r in rooms"
          :key="r.room_id"
          :patients=r.patients
        ></patients-table> -->
        <patients-table></patients-table>
      </div>
      <!-- /.Col -->
    </div>
    <!-- /.Row -->
  </div>
  <!-- Container -->
</template>

<script>
import modal from '../../components/dashboard/patients/NewPatientModal';
import patientsTable from '../../components/dashboard/patients/PatientsTable/Index';

export default {
  components: {
    modal,
    'patients-table': patientsTable
  }
}
</script>
