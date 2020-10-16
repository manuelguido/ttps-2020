<template>
  <!-- Container -->
  <div class="container-fluid">
    <!-- Title -->
    <dashboard-title text="Pacientes" full></dashboard-title>
    <!-- Row -->
    <div class="row">
      <!-- Col -->
      <div class="col-12 col-lg-8 col-xl-6">
        <div class="row d-flex align-items-center">
          <div class="col-12 col-lg-6">
            <select class="form-control">
              <option>Sala G1</option>
              <option>Sala G2</option>
            </select>
          </div>
          <div class="col-12 col-lg-6 text-right">
            <modal></modal>
          </div>
        </div>
      </div>
      <!-- /.Col -->
    </div>
    <!-- /.Row -->
    <!-- Row -->
    <div class="row">
      <!-- Col -->
      <div class="col-12 col-lg-8 col-xl-6">
        <!-- Tabla de pacientes -->
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
