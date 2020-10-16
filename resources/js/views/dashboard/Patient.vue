<template>
  <!-- Container -->
  <div class="container-fluid">
    <backlink></backlink>
    <!-- Title -->
    <dashboard-title text="Paciente" full></dashboard-title>
    <!-- Row -->
    <div class="row">
      <!-- Col -->
      <div class="col-12 col-lg-6 col-xl-5">
        <!-- Row -->
        <div class="row">
          
          <!-- Nombre -->
          <div class="col-12 mb-3">
            <p class="h3-responsive primary">{{patient.name}} {{patient.lastname}}</p>
          </div>
          
          <!-- DNI -->
          <div class="col-3 mb-3 primary">
            DNI
          </div>
          <div class="col-9 mb-3">
            <p class="mb-2">{{dni()}}</p>
          </div>

          <!-- Teléfono -->
          <div class="col-3 mb-3 primary">
            Teléfono
          </div>
          <div class="col-9 mb-3">
            <p class="mb-2">{{patient.phone}}</p>
          </div>

          <!-- Fecha -->
          <div class="col-3 mb-3 primary">
            Fecha de nacimiento
          </div>
          <div class="col-9 mb-3">
            <p class="mb-2">{{patient.birth_date | formatDateFull}}</p>
          </div>

          <!-- Atecedentes personales -->
          <div class="col-3 mb-3 primary">
            Antecedentes personales
          </div>
          <div class="col-9 mb-3">
            <p class="mb-2">{{patient.personal_background}}</p>
          </div>

          <div class="col-12 mb-3">
            <hr>
          </div>

          <!-- Obra social -->
          <div class="col-3 mb-3 primary">
            Obra social
          </div>
          <div class="col-9 mb-3">
            <p class="mb-2">{{getMedicalEnsurance()}}</p>
          </div>

          <!-- Obra social -->
          <div class="col-3 mb-3 primary">
            Se encuentra en
          </div>
          <div class="col-9 mb-3">
            <p class="mb-2">{{getSystem()}}</p>
          </div>

          <!-- Obra social -->
          <div class="col-3 mb-3 primary">
            Estado
          </div>
          <div class="col-9 mb-3">
            <p class="mb-2">{{getPatientState()}}</p>
          </div>

        </div>
        <!-- /.Row -->
      </div>
      <!-- /.Col -->
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
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
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
    },

    /**
     * Retorna la obra social del paciente
     */
    getMedicalEnsurance () {
      for (let i = 0; i < this.medical_ensurances.length; i++) {
        if (this.medical_ensurances[i].medical_ensurance_id == this.patient.medical_ensurance_id) {
          return this.medical_ensurances[i].medical_ensurance;
        }
      }
    },

    /**
     * Retorna el sistema del paciente
     */
    getSystem () {
      for (let i = 0; i < this.systems.length; i++) {
        if (this.systems[i].system_id == this.patient.system_id) {
          return this.systems[i].system;
        }
      }
    },

    /**
     * Retorna la obra social del paciente
     */
    getPatientState () {
      for (let i = 0; i < this.patient_states.length; i++) {
        if (this.patient_states[i].patient_state_id == this.patient.patient_state_id) {
          return this.patient_states[i].patient_state;
        }
      }
    },
  }

}
</script>
