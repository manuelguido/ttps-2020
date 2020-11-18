<template>
  <!-- Notifications -->
	<router-link to="/notifications" class="nav-item d-flex align-items-center mx-3 px-4 notification-badge uns">
    <mdb-badge v-if="amount > 0" color="success" class="mr-1" style="border-radius: 50px;">{{amount}}</mdb-badge>
    <mdb-badge v-else color="default" class="mr-1">{{amount}}</mdb-badge>
    <i class="fas fa-bell fa-lg"></i>
	</router-link>
	<!-- /.Notifications -->
</template>

<script>
  import { mdbNavItem, mdbBadge, mdbBtn } from 'mdbvue';
  export default {
    components: {
      mdbNavItem,
      mdbBadge,
      mdbBtn
    },
    data () {
      return {
        amount: 1,
      }
    },
    created () {
      // this.fetchNotifications();
    },
    methods: {
      /**
       * Obtener notificaciones
       */
      fetchNotifications () {
        
        var $this = this;
        setTimeout(function(){
          console.log('busco'); // Reemplazar por axios
          $this.fetchNotifications();
        }, 2000)
      },

    }
  }
</script>

<style scoped>
.notification-badge {
  border-radius: 8px;
  color: #fff;
}
.notification-badge:hover {
  background: rgba(0,0,0,.1);
  cursor: pointer;
}
.notification-badge:active {
  background: rgba(0,0,0,.2);
  cursor: pointer;
}
</style>
