<template>
  <tr>
    <th scope="row">{{medic.lastname}}, {{medic.name}}</th>
    <td>{{dni()}}</td>
  </tr>
</template>

<script>
export default {
  props: {
    medic: {
      type: Object,
    },
  },
  methods: {
    /**
     * Hace el formato de DNI
     */
    dni() {
      return (this.medic.dni/1).toFixed(0).replace('.').toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
    }
  }
}
</script>
