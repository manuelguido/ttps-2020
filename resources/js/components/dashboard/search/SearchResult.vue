<template>
  <mdb-list-group>
    <mdb-list-group-item
      v-for="result in results"
      :key="result.patient_id"
      class="d-flex justify-content-between p-3"
    >
      <!-- Left side -->
      <span>
        <h1 class="black-alpha-60 h5 m-0">
          {{ result.name }} {{ result.lastname }}
        </h1>
        <h2 class="black-alpha-50 h6 m-0">DNI {{ formatDni(result.dni) }}</h2>
      </span>
      <!-- /.Left side -->
      <!-- Right side -->
      <span>
        <router-link
          class="btn btn-primary btn-sm"
          :to="'/dashboard/search_result/' + result.patient_id"
        >
          Ver <i class="fad fa-chevron-right ml-3"></i>
        </router-link>
      </span>
      <!-- /.Right side -->
    </mdb-list-group-item>
  </mdb-list-group>
</template>

<script>
import { mdbListGroup, mdbListGroupItem } from "mdbvue";
export default {
  name: "Result",
  components: {
    mdbListGroup,
    mdbListGroupItem,
  },
  props: {
    results: {
      type: Array,
    },
  },
};
</script>