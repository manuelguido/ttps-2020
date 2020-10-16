<template>
  <!-- Container -->
  <div class="container-fluid">
    <!-- Title -->
    <dashboard-title text="Paciente" full></dashboard-title>
    <!-- Row -->
    <div class="row">
      <!-- Col -->
      <div class="col-12 text-right">
        {{systems}}
      </div>
      <div class="col-12 text-right">
        {{medical_ensurances}}
      </div>
      <div class="col-12 text-right">
        {{patient_states}}
      </div>
      <!-- /.Col -->
      <!-- Col -->
      <div class="col-12 col-lg-6 text-left">
        
      </div>
      <!-- /.Col -->
    </div>
    <!-- /.Row -->
  </div>
  <!-- Container -->
</template>

<script>
export default {
  name: 'patient',
  props: ['patient_id'],
  data () {
    return {
      patient: {
        name: 'Juan',
        lastname: 'Perez',
        dni: '11111111',
        phone: '123456',
        birth_date: new Date(),
        personal_background: 'Historial personal...',
        medical_ensurance_id: 1,
        patient_state_id: 1,
        system_id: 1,
      },
      medical_ensurances: [],
      patient_states: [],
      systems: [],
    }
  },
  created () {
    this.fetchMedicalEnsurances();
    this.fetchPatientStates();
    this.fetchSystems();
  },
  methods: {
    /**
     * Hace el formato de DNI
     */
    dni() {
      let val = (this.patient.dni/1).toFixed(0).replace('.')
      return "DNI " + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
    },

    /**
     * Obtiene las obras sociales
     */
    fetchMedicalEnsurances () {
      const path = '/api/medical_ensurance/index'
      const AuthStr = 'Bearer ' + localStorage.getItem('access_token').toString()

      axios.get(path, {
        headers: {
          'Accept': 'application/json',
          'Authorization': AuthStr
        }
      }).then((res) => {
        this.medical_ensurances = res.data
      }).catch((err) => {
        console.log(err)
      })
    },

    /**
     * Obtiene los estados posibles de un paciente
     */
    fetchPatientStates () {
      const path = '/api/patient_state/index'
      const AuthStr = 'Bearer ' + localStorage.getItem('access_token').toString()

      axios.get(path, {
        headers: {
          'Accept': 'application/json',
          'Authorization': AuthStr
        }
      }).then((res) => {
        this.patient_states = res.data
      }).catch((err) => {
        console.log(err)
      })
    },

    /**
     * Obtiene los sistemas
     */
    fetchSystems () {
      const path = '/api/system/index'
      const AuthStr = 'Bearer ' + localStorage.getItem('access_token').toString()

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
