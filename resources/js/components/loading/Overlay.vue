<template>
  <div class="loading-overlay">
    <spinner class="inner-spinner"></spinner>
  </div>
</template>

<style scoped>
.loading-overlay {
  height: 100%;
  position: absolute;
  background: rgba(255, 255, 255, 0.95);
  width: 100%;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: 1010 !important;
  display: flex;
  justify-content: center;
  align-items: center;
}

.loading-overlay,
.loading-overlay * {
  transition: 30s all !important;
}
</style>