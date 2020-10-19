<template>
  <!-- Main -->
	<main>
    <!-- Navigation -->
    <navigation sidebar></navigation>

    <!-- Dashboard layout -->
    <div class="container-fluid">
      <!-- Row -->
      <div class="row justify-content-center">
        <!-- Panel content -->
        <section class="panel-container py-4 px-0 px-md-1 px-lg-3 px-xl-4">
          <!-- Rotative content -->
          <!-- <section> -->
            <!-- Router view -->
            <router-view></router-view>
          <!-- </section> -->
          <!-- /.Rotative content -->
        </section>
        <!-- /.Panel content -->
      </div>
      <!-- /.Row -->
    </div>
    <!-- /.Dashboard layout -->
	</main>
  <!-- /.Main -->
</template>

<script>
import navigation from '../components/dashboard/navigation/Navigation' 

export default {
	name: 'dashboard',
	components: {
		'navigation': navigation
  },
  created () {
    this.inactivityTime(); 
  },
  methods: {
    inactivityTime () {
      var time;
      window.onload = resetTimer;
      // DOM Events
      document.onmousemove = resetTimer;
      document.onkeypress = resetTimer;

      function logout() {
        // localStorage.clear();
        window.location.href = "/logout"
        console.log("Has salido del sistema.")            
      }

      function resetTimer() {
        clearTimeout(time);
        time = setTimeout(logout, 60000)
      }
    }
  }
}
</script>

<style scoped>
.panel-container {
  width: 100% !important;
}
@media(min-width: 992px) {
  .panel-container {
    margin-left: 280px !important;
  }
}
@media(max-width: 992px) {
  .panel-container {
    margin-top: 80px !important;
  }
}
</style>
