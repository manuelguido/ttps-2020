<template>
  <router-link to="/user/profile" class="user-data mb-4 py-3 px-4" v-waves>
    <div class="d-flex justify-content-star align-items-center">
      <span class="user-image">
        <img v-if="user.image" :src="user.image">
        <img v-else :src="asset_path() + 'img/person.png'">
      </span>
      <span class="pl-3">
        <span class="black-alpha-40">
        {{user.name}}
        {{user.lastname}}
        </span>
        <br>
        <span>{{role}}</span>
      </span>
    </div>
  </router-link>
</template>

<script>
export default {
  name: 'userData',
  data () {
    return {
      user: JSON.parse(localStorage.getItem('user')),
      role: JSON.parse(localStorage.getItem('role')),
    }
  }
}
</script>

<style scoped>
.user-data,
.user-data * {
  transition: 0s all !important;
}

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
