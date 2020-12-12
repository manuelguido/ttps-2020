<template>
  <span class="grey-bar"></span>
</template>

<style scoped>
/* Loading */
.grey-bar {
  background: #ddd !important;
  border-radius: 4px !important;
  animation: 1s fadeLight infinite !important;
	padding: 7px 3em;
}
.grey-bar,
.grey-bar * {
  color: rgba(0, 0, 0, 0) !important;
}

@keyframes fadeLight {
  0% {
    opacity: 1;
  }
  50% {
    opacity: 0.4;
  }
  100% {
    opacity: 1;
  }
}
</style>