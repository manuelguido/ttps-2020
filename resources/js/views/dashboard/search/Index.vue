<template>
  <!-- Container -->
  <dashboard-card :title="cardTitle" noBack>
    <!-- Row -->
    <div class="row justify-content-center">
      <!-- Col -->
      <div class="col-12 col-lg-10">
        <!-- New entry -->
        <search-box />
        <!-- /.New entry -->
      </div>
      <!-- /.Col -->
    </div>
    <!-- /.Row -->
  </dashboard-card>
  <!-- Container -->
</template>

<script>
import SearchBox from "../../../components/dashboard/search";

export default {
  name: "NewEntryView",
  components: {
    SearchBox,
  },
  data() {
    return {
      cardTitle: "Buscar paciente",
    };
  },
};
</script>
