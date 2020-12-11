<template>
  <mdb-list-group>
    <!-- Alertas -->
    <alert v-for="a in alerts" :key="a.alert_id" :alert="a" @reloadData="reloadData" />
  </mdb-list-group>
</template>

<script>
import { mdbListGroup, mdbListGroupItem } from "mdbvue";
import Alert from './Alert.vue';

export default {
  name: "AlertsList",
  components: {
    mdbListGroup,
    mdbListGroupItem,
    Alert,
  },
  props: {
    alerts: {
      type: Array,
      default: [],
    },
  },
  methods: {
    reloadData(alertId) {
      this.$emit("reloadData", alertId);
    }
  }
};
</script>
