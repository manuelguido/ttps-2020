<template>
  <!-- Container -->
  <div class="container-fluid">
    <!-- Row -->
    <div class="row justify-content-center">
      <!-- Col -->
      <div class="col-12 col-lg-10 text-left">
        <!-- Title -->
        <dashboard-title text="Sistemas"></dashboard-title>
      </div>
      <!-- /.Col -->

      <!-- Col -->
      <div class="col-12 col-lg-10 text-left">
        <systems-table></systems-table>
      </div>
      <!-- /.Col -->
    </div>
    <!-- /.Row -->
  </div>
  <!-- Container -->
</template>

<script>
import systemsTable from '../../components/dashboard/systems/systemsTable/Index';

export default {
  components: {
    'systems-table': systemsTable
  },
}
</script>
