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
            <div v-if="!noBack" class="d-flex align-items-baseline">
              <back-link />
            </div>
            <div class="d-flex align-items-baseline">
              <h1
                v-if="title"
                :class="[
                  'h4 mb-3 w-600',
                  colored ? 'primary' : 'black-alpha-50',
                ]"
              >
                {{ title }}
              </h1>
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
  name: "DashboardCardLayout",
  props: {
    title: {
      type: String,
      default: null,
    },
    noBack: {
      type: Boolean,
      default: false,
    },
    colored: {
      type: Boolean,
      default: false,
    },
  },
};
</script>
