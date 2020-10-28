<template>
  <!-- Container -->
  <div class="container-fluid">
    <!-- Row -->
    <div class="row justify-content-center">
      <!-- Col -->
      <div class="col-12 col-lg-10">
        <!-- Card -->
        <div class="card">
          <!-- Card Body -->
          <div class="card-body p-md-4 p-lg-5">
            <!-- Title -->

            <loading-dots v-if="loading" message="Cargando paciente"></loading-dots>
            <!-- Row -->
            <div v-else class="row">
              <div class="col-12">
                <backlink></backlink>
              </div>

              <!-- Nombre -->
              <div class="col-12 d-flex justify-content-between mb-3">
                <p class="h4-responsive">
                  <span class="black-alpha-50">Paciente: </span>
                  <span class="primary">{{patient.name}} {{patient.lastname}}</span>
                </p>
                <span>
                  <router-link class="btn btn-outline-primary btn-sm" :to="'/dashboard/patient/assignment/'+patient.patient_id">Asignar médicos</router-link>
                  <change-system-modal :patient="patient" :systems="systems" @reload-data="fetchHospitalizations()"></change-system-modal>
                </span>
              </div>

              <!-- Información -->
              <div class="col-12">
                <info-data data="DNI" :value="dni()"></info-data>
                <info-data data="Teléfono" :value="patient.phone"></info-data>
                <info-data data="Fecha de nacimiento" :value="patient.birth_date | formatDateFull"></info-data>
                <info-data data="Antecedentes personales" :value="patient.personal_background"></info-data>
                <info-data data="Información familiar" :value="patient.family_data"></info-data>
                <hr class="mb-4">
                <info-data data="Obra social" :value="patient.medical_ensurance"></info-data>
                <info-data data="Se encuentra en" :value="place()"></info-data>
                <info-data data="Estado" :value="patient.patient_state"></info-data>
              </div>
              <!-- /.Información -->

              <div class="col-12 mb-4">
                <hr>
              </div>

              <!-- Hospitalizaciones -->
              <div class="col-12 d-flex justify-content-between mb-4">
                <p class="h4-responsive">
                  <span class="black-alpha-50">Hospitalizaciones</span>
                </p>
                <span>
                  <evolution-modal></evolution-modal>
                </span>
              </div>
              <!-- /.Hospitalizaciones -->

              <!-- Hospitalizaciones (Listado) -->
              <!-- Son cambios de sistema + evoluciones -->
              <div class="col-12 mb-3">
                <mdb-list-group class="list shadow-sm">
                  <mdb-list-group-item v-for="h in hospitalizations" :key="h.created_at" class="d-flex justify-content-between align-items-center">
                    
                    <!-- Cambio de sistema -->
                    <span v-if="h.system_change_id" class="d-flex flex-column">
                      <span class="black-alhpa-50">{{h.created_at | formatDate}}</span>
                      <span>Cambio de sistema {{h.old_system}} a {{h.new_system}}.</span>
                    </span>
                    <!-- Cambio de sistema -->

                    <!-- Evolución -->
                    <span v-else>
                      {{h.created_at}}
                    </span>
                    <!-- /.Evolución -->

                  </mdb-list-group-item>
                </mdb-list-group>
              </div>
              <!-- /.Hospitalizaciones -->

            </div>
            <!-- /.Row -->
          </div>
          <!-- /.Card Body -->
        </div>
        <!-- /.Card -->
      </div>
      <!-- /.Col -->
    </div>
    <!-- /.Row -->
  </div>
  <!-- Container -->
</template>

<script>
import { mdbListGroup, mdbListGroupItem } from 'mdbvue';
import evolutionModal from '../../components/dashboard/patients/EvolutionModal';
import changeSystemModal from '../../components/dashboard/patients/ChangeSystemModal';

export default {
  name: 'Patient',
  props: ['patient_id'],
  components: {
    mdbListGroup,
    mdbListGroupItem,
    'evolution-modal': evolutionModal,
    'change-system-modal': changeSystemModal
  },
  data () {
    return {
      patient: {},
      systems: [],
      loading: true,
      /**
       * Type 1 es cambio de sistema
       * Type 2 es evolución
       */
      hospitalizations: []
    }
  },
  created () {
    this.$Progress.start();
    this.fetchPatient();
    this.fetchSystems();
    this.fetchHospitalizations();
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
     * Obtener sistemas.
     */
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


    /** 
     * Obtener hospitalizaciones.
     */
    fetchHospitalizations () {
      const path = '/api/patient/hospitalizations/' + this.patient_id;
      const AuthStr = 'Bearer ' + localStorage.getItem('access_token').toString();

      axios.get(path, {
        headers: {
          'Accept': 'application/json',
          'Authorization': AuthStr
        }
      }).then((res) => {
        this.hospitalizations = res.data;
      }).catch((err) => {
        console.log(err)
      });
    },

    /**
     * Hace el formato de DNI
     */
    dni() {
      let val = (this.patient.dni/1).toFixed(0).replace('.')
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
    },

    place() {
      var aux_room = (this.patient.room != null) ? (', '+this.patient.room) : '';
      var aux_bed = (this.patient.bed_number != null) ? (', Cama '+ this.patient.bed_number) : '';
      return this.patient.system + aux_room + aux_bed;
    }
  }

}
</script>
