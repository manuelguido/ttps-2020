<template>
  <!-- Container -->
  <div class="container-fluid">
    <!-- Row -->
    <div class="row justify-content-center">
      <div class="col-12 col-lg-8 mb-5">
        <span>
          <dashboard-title :text="title" :margin="false"></dashboard-title>
        </span>
      </div>
      <!-- Col -->
      <div class="col-12 col-lg-8">
        <!-- Card -->
        <div class="card c-card">
          <!-- Card Body -->
          <div class="card-body p-md-4 p-lg-5">
            <!-- New entry -->
            <new-entry></new-entry>
            <!-- /.New entry -->
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
import { mdbListGroup, mdbListGroupItem } from "mdbvue";
import newEntry from "../../components/dashboard/newEntry/Index";
export default {
  name: "NewEntry",
  components: {
    "new-entry": newEntry,
  },
  data() {
    return {
      title: "Registra una nueva internación",
    };
  },
};
</script>
