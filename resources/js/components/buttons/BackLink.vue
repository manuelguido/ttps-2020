<template>
  <div :class="margin ? 'mb-5' : 'mb-0'">
    <span class="align-middle">
      <button v-on:click="goBack()" class="backlink btn shadow-none m-0 p-3">
        <i class="fad fa-chevron-left color-a my-0"></i>
        <span v-if="text" class="color-a w600 ls03 ml-2 my-0">{{ text }}</span>
      </button>
    </span>
  </div>
</template>

<script>
export default {
  props: {
    url: {
      type: String,
      default: null,
    },
    text: {
      type: String,
      default: "Atrás",
    },
    margin: {
      type: Boolean,
      default: true,
    },
  },
  methods: {
    goBack() {
      if (this.url) {
        this.$router.push({ path: this.url });
      } else {
        this.$router.go(-1);
      }
    },
  },
};
</script>

<style scoped>
.backlink {
  background: #fff;
  color: var(--primary);
}
.backlink:hover {
  opacity: 0.85 !important;
  box-shadow: 0 0.07em 0.325em 0 rgba(0, 0, 0, 0.09) !important;
}
</style>
