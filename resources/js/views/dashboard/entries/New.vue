<template>
  <!-- Container -->
  <dashboard-card :title="cardTitle" noBack>
    <!-- Row -->
    <div class="row justify-content-center">
      <!-- Col -->
      <div class="col-12 col-lg-10">
        <!-- New entry -->
        <new-entry />
        <!-- /.New entry -->
      </div>
      <!-- /.Col -->
    </div>
    <!-- /.Row -->
  </dashboard-card>
  <!-- Container -->
</template>

<script>
import NewEntry from "../../../components/dashboard/newEntry/Index.vue";

export default {
  name: "NewEntryView",
  components: {
    NewEntry,
  },
  data() {
    return {
      cardTitle: "Registra una nueva internación",
    };
  },
  created() {
    if (!this.canAddEntry()) {
      this.handle403();
    }
  },
};
</script>
