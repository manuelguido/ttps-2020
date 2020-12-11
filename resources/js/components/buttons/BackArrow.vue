<template>
  <div class="d-flex align-items-baseline">
    <div @click="goBack" class="back-arrow-container mr-3">
      <i class="back-arrow fad fa-chevron-left fa-lg"></i>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    backLink: {
      type: Object,
      default: null,
    },
  },
  methods: {
    goBack() {
      if (this.backLink.url != '') {
        this.$router.push({ path: this.backLink.url });
      } else {
        this.$router.go(-1);
      }
    },
  },
};
</script>

<style scoped>
.back-arrow-container {
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 50px;
  height: 50px;
  width: 50px;
  cursor: pointer;
}
.back-arrow-container:hover {
  background: #f1f1f1;
  color: var(--primary) !important;
}
</style>
