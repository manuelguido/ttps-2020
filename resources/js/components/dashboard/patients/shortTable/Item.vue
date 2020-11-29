<template>
  <tr>
    <th scope="row">{{patient.lastname}}, {{patient.name}}</th>
    <td>{{patient.dni}}</td>
    <td class="text-right px-5 px-lg-3 py-1">
      <router-link class="btn btn-sm btn-outline-primary " :to="'/dashboard/patient/'+patient.patient_id">Ver</router-link>
    </td>
  </tr>
</template>

<script>
export default {
  props: {
    patient: {
      type: Object,
    },
  },
}
</script>
