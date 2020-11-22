<template>
  <!-- Sidenav -->
  <div class="sidebar pt-4 mobile-hide uns shadow-sm">
    <!--Header-->
    <user-data :user="user"></user-data>

    <!-- Items -->
    <items :routes=routes></items>
    <!-- /.Items -->
  </div>
  <!-- /.Sidenav -->
</template>

<script>
import items from './Items';
import userData from './Userdata';

export default {
  name: 'sideNav',
  props: {
    routes: Array,
    user: Object
  },
  components: {
    'items': items,
    'user-data': userData
  },
  data () {
    return {
      sidebar_title: 'SeCo'
    }
  }
}
</script>

<style scoped>
@media (min-width: 992px) {
  /* Sidebar */
  .sidebar {
    height: 100vh !important;
    position: fixed;
    background: #fff;
    /* box-shadow: 0 .07em .425em 0 rgba(0,0,0,.225) !important; */
    width: 280px;
    left: 0;
    top: 0;
    z-index: 1030;
    padding-top: 10vh !important;
    border-right: 1px solid #eee !important;
  }
}
@media (max-width: 992px) {
  .sidebar {
    display: none !important;
  }
}

.navbar-brand,
.navbar-brand * {
  color: var(--primary) !important;
}
</style>
