<template>
  <tr>
    <th scope="row">{{patient.lastname}}, {{patient.name}}</th>
    <td>{{patient.dni}}</td>
    <td>{{patient.system}}</td>
    <td>{{patient.room}}</td>
    <td>Cama {{patient.number}}</td>
    <td class="text-right px-5 px-lg-3">
      <router-link class="btn btn-sm btn-outline-primary " :to="'/dashboard/patient/'+patient.patient_id">Ver</router-link>
      <router-link class="btn btn-sm btn-outline-primary" :to="'/dashboard/patient/assignment/'+patient.patient_id">Asignar</router-link>
      <change-system-modal :patient="patient" :systems="systems" @reload-patients="reloadPatients()"></change-system-modal>
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
    reloadPatients () {
      this.$emit('reload-patients');
    }
  }
}
</script>
