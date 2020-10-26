<template>
  <!-- Container -->
  <div class="container-fluid">
    <!-- Row -->
    <div class="row">
      <!-- Col -->
      <div class="col-12 col-lg-8">
        <!-- Card -->
        <div class="card">
          <!-- Card Body -->
          <div class="card-body p-md-4 p-lg-5">
            <!-- Title -->
            
            <loading-dots v-if="loading" message="Buscando paciente"></loading-dots>
            <!-- Row -->
            <div v-else class="row">
              <div class="col-12">
                <backlink></backlink>
              </div>
              
              <!-- Nombre -->
              <div class="col-12 mb-3">
                <p class="h4-responsive">
                  <span class="black-alpha-50">Paciente: </span>
                  <span class="primary">{{patient.name}} {{patient.lastname}}</span>
                </p>
              </div>
              
              <!-- Información -->
              <div class="col-12">
                <info-data data="DNI" :value="dni()"></info-data>
                <info-data data="Se encuentra en" :value="patient.system+' || Sala G1 || Cama 4'"></info-data>
                <info-data data="Estado" :value="patient.patient_state"></info-data>
              </div>
              <!-- /.Información -->

              <!-- Hr -->
              <div class="col-12 mb-3">
                <hr>
              </div>

              <!-- Titulo -->
              <div class="col-12 mb-3">
                <dashboard-subtitle text="Asignar nuevo"></dashboard-subtitle>
              </div>

              <div class="col-12 mb-5">
                <div class="row align-items-center">
                  <div class="col-12 col-lg-7 col-xl-8">
                    <select v-model="new_medic_id" class="form-control">
                      <option value="0">Seleccionar</option>
                      <option value="1">Dra. María</option>
                      <option value="2">Dra. Juan</option>
                    </select>
                  </div>
                  <div class="col-12 col-lg-5 col-xl-4 text-right">
                    <button class="btn btn-block btn-primary ml-lg-4 mt-3 mt-lg-0 mr-0 py-2">Asignar</button>
                  </div>
                </div>
              </div>

              <!-- Titulo -->
              <div class="col-12 mb-3">
                <dashboard-subtitle text="Médicos asignados"></dashboard-subtitle>
              </div>

              <!-- Médicos -->
              <div class="col-12 col-md-9 mb-3">
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
        </div>
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
      patient: {},
      loading: true,
      new_medic_id: 0,
      medics: [
        {
          medic_id: 1,
          name: 'Patricia',
          lastname: 'Lopez',
        },
        {
          medic_id: 2,
          name: 'Marcos',
          lastname: 'Antonio',
        }
      ]
    }
  },
  created () {
    this.$Progress.start();
    this.fetchPatient();
  },
  methods: {
    /**
     * Obtiene las obras sociales
     */
    fetchPatient () {
      const path = '/api/patient/show/' + this.patient_id;
      const AuthStr = 'Bearer ' + localStorage.getItem('access_token').toString();

      axios.get(path, {
        headers: {
          'Accept': 'application/json',
          'Authorization': AuthStr
        }
      }).then((res) => {
        this.patient = res.data
        this.loading = false;
        this.$Progress.finish();
      }).catch((err) => {
        console.log(err)
      })
    },

    /**
     * Hace el formato de DNI
     */
    dni() {
      let val = (this.patient.dni/1).toFixed(0).replace('.')
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
    }
  }
}
</script>
