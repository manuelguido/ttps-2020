<template>
  <div class="row">
    <div class="col-6 col-lg-3 mb-3 primary">
      {{data}}
    </div>
    <div class="col-6 col-lg-9 mb-3">
      <p class="mb-2">
        {{value}}
      </p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'InfoData',
  props: {
    data: {
      type: String,
    },
    value: {
      type: String,
    }
  }
}
</script>
