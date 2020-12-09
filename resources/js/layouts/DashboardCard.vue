<template>
  <!-- Container -->
  <div class="container-fluid">
    <!-- Row -->
    <div class="row justify-content-center">
      <!-- Col -->
      <div class="col-12 col-lg-10">
        <!-- Card -->
        <div class="card c-card">
          <!-- Card Body -->
          <div class="card-body p-md-4 p-lg-5">
            <div class="d-flex align-items-baseline">
              <back-arrow v-if="backLink" :backLink="backLink"/>
              <h1 v-if="title" class="h4 black-alpha-50 mb-3">{{ title }}</h1>
            </div>
            <hr v-if="title" class="mb-5" />
            <!-- Slot -->
            <slot></slot>
            <!-- /.Slot -->
          </div>
          <!-- /.Card Body -->
        </div>
        <!-- /.Card -->
      </div>
      <!-- /.Col -->
    </div>
    <!-- /.Row -->
  </div>
  <!-- Container -->
</template>

<script>
export default {
  name: "DashboardCard",
  props: {
    title: {
      type: String,
      default: null,
    },
    backLink: {
      type: Object,
      default: null,
    },
  },
};
</script>