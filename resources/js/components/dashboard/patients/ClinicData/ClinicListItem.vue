<template>
  <!-- List -->
  <div class="item p-4 d-flex justify-content-between align-items-top">
    
    <span>
      <p class="black-alpha-70">
        <!-- Title -->
        <span class="h5">{{ formatItemTitle(item) }}</span>
        <!-- Date -->
        <span class="black-alpha-50">
          ({{ item.created_at | formatDateFull }} -
        </span>
        <span class="black-alpha-50">
          {{ item.created_at | moment("h:mm a") }})
        </span>
      </p>
      <p v-if="item.hospitalization_id">Paso de sistema 1 a 2</p>
    </span>

    <!-- Right -->
    <span>
      <evolution-display v-if="item.evolution_id" :evolution="item"/>
    </span>

  </div>
  <!-- /.List -->
</template>

<script>
import EvolutionDisplay from './EvolutionDisplay.vue';

export default {
  name: "ClinicDataListItem",
  components: {
    EvolutionDisplay,
  },
  props: {
    item: {
      type: Object,
    },
  },
  methods: {
    formatItemTitle(item) {
      return item.evolution_id ? "Evolución" : "Cambio de sistema";
    },
  },
};
</script>

<style scoped>
.item {
  border-bottom: 1px solid #ddd !important;
  width: 100%;
  border-radius: 5px;
}
.item:last-child {
  border: 0 none !important;
}
</style>