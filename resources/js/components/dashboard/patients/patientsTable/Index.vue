<template>
  <div class="card p-0">
    <!-- Table -->
    <table class="table table-striped table-bordered my-0">
      <thead>
        <tr>
          <th scope="col">Paciente</th>
          <th scope="col">DNI</th>
          <th scope="col">Sistema</th>
          <th scope="col">Sala</th>
          <th scope="col">Cama</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="p in patients" v-if="p.show" :key="p.patient_id">
          <td>{{p.lastname}}, {{p.name}}</td>
          <td>{{p.dni}}</td>
          <td>{{p.sistem}}</td>
          <td>{{p.room}}</td>
          <td>{{p.bed}}</td>
          <td class="text-right">
            <router-link class="btn btn-outline-primary btn-sm" :to="'/dashboard/patient/'+p.patient_id">Ver</router-link>
            <router-link class="btn btn-outline-primary btn-sm" :to="'/dashboard/patient/'+p.patient_id+'/assignment'">Asignar</router-link>
          </td>
        </tr>
      </tbody>
    </table>
    <!-- /.Table -->
  </div>
</template>

<script>
export default {
  props: {
    patients: {
      type: Array,
      default: [],
    }
  }
}
</script>

<style scoped>

</style>
