<template>
  <div>
    <div v-if="system" class="div w-600 h5-responsive black-alpha-60 pl-4 mb-4">
      {{system}}
    </div>
    <router-link to="/user/profile" class="user-data mb-4 py-3 px-4 waves-effect">
      <div class="d-flex justify-content-start align-items-center">

        <div class="user-image">
          <img v-if="user.image" :src="user.image">
          <img v-else :src="asset_path() + 'img/person.png'">
        </div>

        <div class="pl-3 d-flex align-items-start flex-column">
          <div class="black-alpha-60 w-400">
            {{user.name}}
            {{user.lastname}}
          </div>
          <!-- <div>{{role}}</div> -->
        </div>

      </div>
    </router-link>
  </div>
</template>

<script>
export default {
  name: 'userData',
  data () {
    return {
      user: null,
      role: null,
      system: null,
    }
  },
  created() {
    this.user = JSON.parse(localStorage.getItem('user'));
    this.role = JSON.parse(localStorage.getItem('role'));
    if (localStorage.system) {
      this.system = JSON.parse(localStorage.getItem('system')).system;
    }
  }
}
</script>

<style scoped>
.user-data {
  color: var(--primary);
  display: block;
}
.user-data:hover {
  background: var(--primary-light) !important;
}
.user-data.router-link-active,
.user-data.router-link-exact-active {
  background: var(--primary-light) !important;
}

.user-image {
  width: 34px;
  height: 34px;
  overflow: hidden;
  border-radius: 100px;
}
.user-image img {
  width: 100%;
}
</style>
