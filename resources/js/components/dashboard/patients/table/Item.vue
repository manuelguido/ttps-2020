<template>
  <tr>
    <th scope="row">{{patient.lastname}}, {{patient.name}}</th>
    <td>{{patient.dni}}</td>
    <td>
      <span v-if="patient.room">{{patient.room}}</span>
      <span v-else class="text-danger">No asignada</span>
    </td>
    <td>
      <span v-if="patient.bed_number">Cama {{patient.bed_number}}</span>
      <span v-else class="text-danger">No asignada</span>
    </td>
    <td class="text-right px-5 px-lg-3 py-1">
      <router-link class="btn btn-sm btn-outline-primary " :to="'/dashboard/patient/'+patient.patient_id">Ver</router-link>
      <router-link class="btn btn-sm btn-outline-primary" :to="'/dashboard/patient/assignment/'+patient.patient_id">Asignar</router-link>
      <change-system-modal :patient="patient" :systems="systems" @reload-data="reloadData()"></change-system-modal>
    </td>
  </tr>
</template>

<script>
import changeSystemModal from '../ChangeSystemModal';

export default {
  props: {
    patient: {
      type: Object,
    },
    systems: {
      type: Array,
    }
  },
  components: {
    'change-system-modal': changeSystemModal
  },
  methods: {
    reloadData () {
      this.$emit('reload-data');
    }
  }
}
</script>
