<template>
  <div class="card c-card">
    <loading-dots v-if="loading"></loading-dots>
    <div v-else class="table-responsive text-nowrap">
      <!-- Table -->
      <table class="table my-0 table-hover">
        <thead>
          <tr>
            <th scope="col">Médico</th>
            <th scope="col">DNI</th>
            <th scope="col">Email</th>
            <th scope="col">Teléfono</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <item 
            v-for="m in medics"
            :key="m.medic_id"
            v-if="m.show"
            :medic="m"
            :systems="systems"
            @reload-medics="reloadMedics()"
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
    medics: {
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

    reloadMedics () {
      this.$emit('reload-medics');
    }
  }
}
</script>
