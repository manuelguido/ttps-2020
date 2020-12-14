<template>
  <!-- List container -->
  <div class="list d-flex flex-column">
    <!-- List -->
    <clinic-data-list-item v-for="c in clinicData" :key="c.created_at" :item="c"/>
    <!-- /.List -->
  </div>
  <!-- /.List container -->
</template>

<script>
import { mdbListGroup, mdbListGroupItem } from "mdbvue";
import ClinicDataListItem from './ClinicListItem.vue';

export default {
  name: "ClinicDataList",
  components: {
    mdbListGroup,
    mdbListGroupItem,
    ClinicDataListItem,
  },
  props: {
    clinicData: {
      type: Array,
    },
  },
};
</script>

<style scoped>
.list {
  border: 1px solid #ddd;
}
</style>