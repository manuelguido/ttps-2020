<template>
  <!-- Container -->
  <div class="container-fluid">
    <!-- Title -->
    <dashboard-title text="Sistemas" full></dashboard-title>
    <!-- Row -->
    <div class="row">
      <!-- /.Col -->
      <!-- Col -->
      <div class="col-12 col-lg-6 text-left">
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
  }
}
</script>
