<template>
  <!-- Container -->
  <div class="container-fluid">
    <!-- Title -->
    <dashboard-title text="Reportes" full></dashboard-title>
    <!-- Content -->
    <div class="row">
      <!-- Col -->
      <div class="col-auto mb-4">
        <div class="card">
          <div class="card-body">
            <line-chart />
          </div>
        </div>
      </div>
      <!-- Col -->
      <!-- Col -->
      <div class="col-auto mb-4">
        <div class="card">
          <div class="card-body">
            <scatter-chart />
          </div>
        </div>
      </div>
      <!-- Col -->
      <!-- Col -->
      <div class="col-auto mb-4">
        <div class="card">
          <div class="card-body">
            <scatter-chart />
          </div>
        </div>
      </div>
      <!-- Col -->
      <!-- Col -->
      <div class="col-auto mb-4">
        <div class="card">
          <div class="card-body">
            <line-chart />
          </div>
        </div>
      </div>
      <!-- Col -->
      <!-- Col -->
      <div class="col-auto mb-4">
        <div class="card">
          <div class="card-body">
            <line-chart />
          </div>
        </div>
      </div>
      <!-- Col -->
      <!-- Col -->
      <div class="col-auto mb-4">
        <div class="card">
          <div class="card-body">
            <line-chart />
          </div>
        </div>
      </div>
      <!-- Col -->
    </div>
    <!-- Content -->
  </div>
  <!-- Container -->
</template>

<script>
export default {
  name: "ReportsView",
};
</script>