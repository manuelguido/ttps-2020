<template>
  <!-- Container -->
  <dashboard-card :title="cardTitle" noBack>
    <!-- Row -->
    <div class="row justify-content-center">
      <!-- Col -->
      <div class="col-12 col-lg-10 py-lg-5">
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
import NewEntry from "../../components/dashboard/newEntry/Index";

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
};
</script>
