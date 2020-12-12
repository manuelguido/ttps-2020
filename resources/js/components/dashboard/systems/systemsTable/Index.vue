<template>
  <div class="card c-card uns">
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
            <th scope="col">Uso de camas</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="s in systems" :key="s.system_id">
            <th scope="row">{{ s.system }}</th>
            <td class="w-600">{{ s.total_beds }}</td>
            <td class="w-700 text-success">{{ s.free_beds }}</td>
            <td class="w-700 text-warning">{{ s.occupied_beds }}</td>
            <td class="w-600 black-alpha-60">{{ calcBedPercentage(s) }}</td>
            <td class="text-right px-5 px-lg-3">
              <router-link
                :to="'/dashboard/system/' + s.system_id"
                class="btn btn-outline-primary btn-sm"
                >Ver</router-link
              >
            </td>
          </tr>
        </tbody>
      </table>
      <!-- /.Table -->
    </div>
  </div>
</template>

<script>
export default {
  name: "SystemsTable",
  props: {
    systems: {
      type: Array,
      default: [],
    },
    loading: {
      type: Boolean,
      default: true,
    },
  },
  methods: {
    calcBedPercentage(system) {
      return (
        ((system.occupied_beds * 100) / system.total_beds).toFixed(1) + "%"
      );
    },
  },
};
</script>