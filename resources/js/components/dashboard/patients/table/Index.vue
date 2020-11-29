<template>
  <div class="card c-card">
    <loading-dots v-if="loading"></loading-dots>
    <div v-else class="table-responsive text-nowrap">
      <!-- Table -->
      <table class="table my-0 table-hover">
        <thead>
          <tr>
            <th scope="col">Paciente</th>
            <th scope="col">DNI</th>
            <th scope="col">Sala</th>
            <th scope="col">Cama</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <item 
            v-for="p in patients"
            :key="p.patient_id"
            v-if="p.show"
            :patient="p"
            :systems="systems"
            @reload-data="reloadData()"
          ></item>
        </tbody>
      </table>
      <!-- /.Table -->
    </div>
  </div>
</template>

<script>
import item from './Item';

export default {
  props: {
    patients: {
      type: Array,
      default: [],
    },
    loading: {
      type: Boolean,
      default: true,
    }
  },
  components: {
    'item': item
  },
  data () {
    return {
      systems: [],
    }
  },
  created () {
    this.fetchSystems();
  },
  methods: {
    fetchSystems () {
      const path = '/api/system/index';
      const AuthStr = 'Bearer ' + localStorage.getItem('access_token').toString();

      axios.get(path, {
        headers: {
          'Accept': 'application/json',
          'Authorization': AuthStr
        }
      }).then((res) => {
        this.systems = res.data;
      }).catch((err) => {
        console.log(err)
      });
    },

    reloadData () {
      this.$emit('reload-data');
    }
  }
}
</script>
