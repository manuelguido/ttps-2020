<template>
  <div>
    <h1 class="h5-responsive">Sistemas</h1>
  
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th scope="col">Nombre</th>
          <th scope="col">Camas usadas</th>
          <th scope="col">Camas libres</th>
          <th scope="col">Camas totales</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="s in systems" :key="s.system_id">
          <td>{{s.system}}</td>
          <td>20</td>
          <td>10</td>
          <td>30</td>
          <td class="text-right">
            <button class="btn btn-outline-primary btn-sm">Ver</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  data () {
    return {
      systems: [
        {
          system_id: 1,
          system: 'Guardia',
        },
        {
          system_id: 2,
          system: 'Piso Covid',
        },
        {
          system_id: 3,
          name: 'UTI',
        },
        {
          system_id: 4,
          system: 'Hotel',
        },
        {
          system_id: 5,
          system: 'Domicilio',
        }
      ]
    }
  }
}
</script>

<style scoped>

</style>