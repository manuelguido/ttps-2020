<template>
  <div>
    <h1 class="h5-responsive">Sala: G2</h1>
  
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th scope="col">Cama</th>
          <th scope="col">Paciente</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="p in patients" :key="p.patient_id">
          <td>Cama 1</td>
          <td>{{p.lastname}}, {{p.name}} ({{p.dni}})</td>
          <td class="text-right">
            <router-link :to="'/dashboard/patient/'+p.patient_id" class="btn btn-outline-primary btn-sm">Ver</router-link>
            <button class="btn btn-outline-primary btn-sm">Asignar</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  props: {
    p_patients: {
      type: Array
    }
  },
  data () {
    return {
      patients: [
        {
          patient_id: 1,
          name: 'Bernardo',
          lastname: 'Juez',
          dni: '11111111',
        },
        {
          patient_id: 2,
          name: 'Bernardo',
          lastname: 'Juez',
          dni: '22222222',
        },
        {
          patient_id: 3,
          name: 'Bernardo',
          lastname: 'Juez',
          dni: '33333333',
        },
        {
          patient_id: 4,
          name: 'Bernardo',
          lastname: 'Juez',
          dni: '4444444',
        },
        {
          patient_id: 5,
          name: 'Bernardo',
          lastname: 'Juez',
          dni: '5555555',
        }
      ]
    }
  }
}
</script>

<style scoped>

</style>