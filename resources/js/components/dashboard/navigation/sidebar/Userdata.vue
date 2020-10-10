<template>
  <router-link to="/user/profile" class="user-data mb-4 py-3 px-4" v-waves>
    <div class="d-flex justify-content-star align-items-center">
      <span class="user-image">
        <img v-if="user.image" :src="user.image">
        <img v-else :src="asset_path() + 'img/person.png'">
      </span>
      <span class="pl-3">
        <!-- <i class="fad fa-user-alt mr-2"></i> -->
        {{user.name}}
        {{user.lastname}}
      </span>
      <!-- <span><i class="fas fa-chevron-down"></i></span> -->
    </div>
  </router-link>
</template>

<script>
import axios from 'axios';

export default {
  data () {
    return {
      user: {}
    }
  },
  created () {
    this.updateUser();
  },
  methods: {
    setUser(user) {
      this.user = user;
    },

    fetchUser () {
      const path = '/api/user'
      const AuthStr = 'Bearer ' + localStorage.getItem('access_token').toString()
      axios.get(path, {
        'headers': {
          'Accept': 'application/json',
          'Authorization': AuthStr
          }
      }).then((res) => {
        this.setUser(res.data)
        localStorage.setItem('user', JSON.stringify(res.data));
      }).catch((err) => {
        // var $this = this;
        // setTimeout(function () { $this.fetchProducts() }, 1000);
        console.log(err);
      })
    },

    updateUser () {
      if (localStorage.user) {
        var loc = localStorage.getItem('user');
        var result = JSON.parse(loc);
        this.user = result;
      }
      this.fetchUser();
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
  width: 40px;
  height: 40px;
  overflow: hidden;
  border-radius: 100px;
}
.user-image img {
  width: 100%;
}
</style>
