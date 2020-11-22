<template>
  <!-- Items -->
  <div class="list-group">
    <!-- Link -->
    <router-link
      v-for="route in routes"
      :key="route.name"
      :to="route.url"
      class="item waves-effect">
      <span class="icon mr-2"><i :class="route.icon + ' mx-auto'"></i></span>  
      {{route.name}} 
    </router-link>
    <!-- /.Link -->
  </div>
  <!-- /.Items -->
</template>

<script>
export default {
  name: 'sidenav-items',
  props: {
    routes: Array
  }
}
</script>

<style scoped>
.icon {
  display: inline-block;
  width: 35px;
  text-align: center;
}

.list-group {
  padding: 0;
}

.item {
  border-left: 6px solid transparent;
  color: #5f6368;
  font-size: 18px;
  font-weight: 400;
  padding: 1em 1em;
  transition: .4s all !important;
  margin: 0 !important;
}

.item:hover {
  background: var(--black-alpha-03);
}

.item.router-link-active,
.item.router-link-exact-active {
  background: var(--black-alpha-06);
  color: var(--primary);
  border-left: 6px solid var(--primary);
  /* box-shadow: 0 2px 20px 0 rgba(0, 0, 0, 0.125); */
}
.item.router-link-active .icon,
.item.router-link-exact-active .icon {
  color: var(--primary);
}

.item .icon {
  color: rgba(95, 99, 104, 0.5);
}
</style>
