<template>
  <div class="card shadow-sm uns">
    <loading-dots v-if="loading"></loading-dots>
    <div v-else class="table-responsive text-nowrap">
      <!-- Table -->
      <table class="table my-0 table-hover">
        <thead>
          <tr>
            <th scope="col">Sistema</th>
            <th scope="col">Camas totales</th>
            <th scope="col">Camas libres</th>
            <th scope="col">Camas ocupadas</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="s in systems" :key="s.system_id">
            <th scope="row">{{s.system}}</th>
            <td class="w-600">{{s.total_beds}}</td>
            <td class="w-700 text-success">{{s.free_beds}}</td>
            <td class="w-700 text-warning">{{s.occupied_beds}}</td>
            <td class="text-right px-5 px-lg-3">
              <router-link :to="'/dashboard/system/'+s.system_id" class="btn btn-outline-primary btn-sm">Ver</router-link>
              <router-link :to="'/dashboard/patients/'+s.system_id" class="btn btn-outline-primary btn-sm">Ver pacientes</router-link>
              <router-link class="btn btn-outline-primary btn-sm mr-3 mr-lg-0" :to="'/dashboard/medics/'+s.system_id">Ver médicos</router-link>
            </td>
          </tr>
        </tbody>
      </table>
      <!-- /.Table -->
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data () {
    return {
      loading: true,
      systems: []
    }
  },
  mounted () {
    this.fetchSystems();
  },
  created () {
    this.$Progress.start();
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
        this.systems = res.data;
        this.loading = false;
        this.$Progress.finish();
      }).catch((err) => {
        console.log(err)
      })
    }
  }
}
</script>

<style scoped>

</style>