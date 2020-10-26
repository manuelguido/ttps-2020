<template>
  <tr>
    <th scope="row">{{medic.lastname}}, {{medic.name}}</th>
    <td>{{dni()}}</td>
    <td>{{medic.system}}</td>
    <td>{{medic.email}}</td>
    <td>{{medic.phone}}</td>
    <td class="text-lg-right">
      <change-system-modal :medic="medic" :systems="systems" @reload-medics="reloadMedics()"></change-system-modal>
    </td>
  </tr>
</template>

<script>
import changeSystemModal from '../ChangeSystemModal';

export default {
  props: {
    medic: {
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
    reloadMedics () {
      this.$emit('reload-medics');
    },
    /**
     * Hace el formato de DNI
     */
    dni() {
      let val = (this.medic.dni/1).toFixed(0).replace('.')
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
    }
  }
}
</script>
