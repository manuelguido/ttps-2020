<template>
  <div>
    <!-- <h1 class="h5-responsive">Sistemas</h1> -->
  
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th scope="col">Nombre</th>
          <th scope="col">Camas totales</th>
          <th scope="col">Camas libres</th>
          <th scope="col">Camas ocupadas</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="s in systems" :key="s.system_id">
          <td>{{s.system}}</td>
          <td>{{s.total_beds}}</td>
          <td>{{s.free_beds}}</td>
          <td>{{s.occupied_beds}}</td>
          <td class="text-right">
            <router-link :to="'/dashboard/system/'+s.system_id" class="btn btn-outline-primary btn-sm">Ver</router-link>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data () {
    return {
      systems: []
    }
  },
  mounted () {
    this.fetchSystems();
  },
  methods: {
    /**
     * Obtiene el sistema con su información
     */
    fetchSystems () {
      const path = '/api/system/index/full';
      const AuthStr = 'Bearer ' + localStorage.getItem('access_token').toString();

      axios.get(path, {
        headers: {
          'Accept': 'application/json',
          'Authorization': AuthStr
        }
      }).then((res) => {
        this.systems = res.data
      }).catch((err) => {
        console.log(err)
      })
    }
  }
}
</script>

<style scoped>

</style>