<template>
  <!-- Notifications -->
	<mdb-nav-item to="/notifications" class="d-flex align-items-center px-3 notification-badge mx-3 uns">
    <!-- <mdb-badge v-if="amount > 0" color="success" class="mr-1">{{amount}}</mdb-badge>
    <mdb-badge v-else color="default" class="mr-1">{{amount}}</mdb-badge> -->
    <i class="fad fa-bell fa-lg"></i>
	</mdb-nav-item>
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
        amount: 0,
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
  border-radius: 4px;
}
.notification-badge:hover {
  background: rgba(0,0,0,.04);
  cursor: pointer;
}
</style>

5f6368