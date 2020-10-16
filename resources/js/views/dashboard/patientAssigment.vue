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

          <!-- Hr -->
          <div class="col-12 mb-3">
            <hr>
          </div>

          <!-- Titulo -->
          <div class="col-12 mb-3">
            <dashboard-subtitle text="Asignar nuevo"></dashboard-subtitle>
          </div>

          <div class="col-9 mb-3 d-flex justify-content-between align-items-center">
            <select v-model="new_medic_id" class="form-control">
              <option value="0">Seleccionar</option>
              <option value="1">Dra. María</option>
              <option value="2">Dra. Juan</option>
            </select>
            <button class="btn btn-primary ml-4 mr-0 py-2">Asignar</button>
          </div>

          <!-- Titulo -->
          <div class="col-12 mb-3">
            <dashboard-subtitle text="Médicos asignados"></dashboard-subtitle>
          </div>

          <!-- Médicos -->
          <div class="col-9 mb-3">
            <mdb-list-group>
              <mdb-list-group-item v-for="m in medics" :key="m.medic_id"
                class="d-flex justify-content-between align-items-center">
                <span>{{m.name}} {{m.lastname}}</span>
                <span class="text-right"><i class="fas fa-times"></i></span>
              </mdb-list-group-item>
            </mdb-list-group>
          </div>

        </div>
        <!-- /.Row -->
      </div>
      <!-- /.Col -->
    </div>
    <!-- /.Row -->
  </div>
  <!-- Container -->
</template>

<script>
import { mdbListGroup, mdbListGroupItem } from 'mdbvue';

export default {
  name: 'patient',
  props: ['patient_id'],
  components: {
    mdbListGroup,
    mdbListGroupItem
  },
  data () {
    return {
      patient: {
        name: 'Juan',
        lastname: 'Perez',
        dni: '11111111',
        patient_state_id: 1,
        system_id: 1,
      },
      patient_states: [],
      systems: [],
      medics: [
        {
          medic_id: 1,
          name: 'Patricia',
          lastname: 'Lopez',
        }
      ],
      new_medic_id: 0,
    }
  },
  created () {
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
