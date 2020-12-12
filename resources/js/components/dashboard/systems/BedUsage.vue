<template>
  <!-- Flex -->
  <div class="d-flex align-items-center justify-content-between mb-4">
    <span class="mb-3 primary">Uso de camas</span>
    <span class="mb-3 w-600">
      <span :class="['w-600', classList]">{{ bed_percentage }}</span>
    </span>
  </div>
  <!-- /.Flex -->
</template>

<script>
export default {
  name: "BedUsage",
  props: {
    system: {
      type: Object,
    },
  },
  data() {
    return {
      bed_percentage: 0,
      classList: "black-alpha-50",
    };
  },
  mounted() {
    this.calcBedPercentage();
  },
  methods: {
    calcBedPercentage() {
      var numericValue = (
        (this.system.occupied_beds * 100) /
        this.system.total_beds
      ).toFixed(1);
      if (numericValue >= 75) {
        this.classList = "text-danger";
      } else if (numericValue >= 50) {
        this.classList = "text-warning";
      } else {
        this.classList = "text-success";
      }

      this.bed_percentage = numericValue + "%";
    },
  },
};
</script>
