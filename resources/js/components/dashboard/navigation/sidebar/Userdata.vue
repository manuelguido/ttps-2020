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
import axios from 'axios';

export default {
  data () {
    return {
      user: {},
      role: '',
    }
  },
  created () {
    this.updateUser();
    this.updateRole();
  },
  methods: {
    setUser(user) {
      this.user = user;
    },

    setRole(role) {
      this.role = role;
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
        console.log(err);
      })
    },

    fetchRole () {
      const path = '/api/user/role'
      const AuthStr = 'Bearer ' + localStorage.getItem('access_token').toString()
      axios.get(path, {
        'headers': {
          'Accept': 'application/json',
          'Authorization': AuthStr
          }
      }).then((res) => {
        this.setRole(res.data)
        localStorage.setItem('role', JSON.stringify(res.data));
      }).catch((err) => {
        console.log(err);
      })
    },

    updateUser () {
      if (localStorage.user) {
        var loc = localStorage.getItem('user');
        this.user = JSON.parse(loc);
      }
      this.fetchUser();
    },

    updateRole () {
      if (localStorage.role) {
        var loc = localStorage.getItem('role');
        this.role = JSON.parse(loc);
      }
      this.fetchRole();
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
