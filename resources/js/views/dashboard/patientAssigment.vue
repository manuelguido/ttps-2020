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
            
            <loading-dots v-if="loading_patient" message="Buscando paciente"></loading-dots>
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
                <info-data data="Se encuentra en" :value="place()"></info-data>
                <info-data data="Estado" :value="patient.patient_state"></info-data>
              </div>
              <!-- /.Información -->

              <!-- Hr -->
              <div class="col-12 mb-3">
                <hr>
              </div>

              <!-- Titulo -->
              <div class="col-12 mb-3">
                <dashboard-subtitle text="Asignar nuevo médico"></dashboard-subtitle>
              </div>

              <div class="col-12 mb-5">
                <div class="row align-items-center">
                  <div class="col-12 col-lg-7 col-xl-8">
                    <select v-model="new_medic_id" class="form-control">
                      <option value="0">Seleccionar</option>
                      <option v-for="m in posible_medics" :key="m.user_id" :value="m.user_id">{{ m.name+' '+m.lastname }}</option>
                    </select>
                  </div>
                  <div class="col-12 col-lg-5 col-xl-4 text-right">
                    <button class="btn btn-block btn-primary ml-lg-4 mt-3 mt-lg-0 mr-0 py-2" @click="addMedic()">Asignar</button>
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
                    <span>{{ m.name+' '+m.lastname }}</span>
                    <div class="text-right action-button" @click="removeMedic(m.user_id)"><i class="fas fa-times"></i></div>
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
      loading_patient: true,
      loading_medics: true,
      new_medic_id: 0,
      medics: []
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
        this.loading_patient = false;
        this.fetchMedics();
      }).catch((err) => {
        console.log(err)
      })
    },

    /**
     * Obtiene las obras sociales
     */
    fetchMedics () {
      const path = '/api/patient/medics/' + this.patient_id;
      const AuthStr = 'Bearer ' + localStorage.getItem('access_token').toString();

      axios.get(path, {
        headers: {
          'Accept': 'application/json',
          'Authorization': AuthStr
        }
      }).then((res) => {
        this.medics = res.data.medics
        this.posible_medics = res.data.posible_medics
        this.loading_medics = false;
        this.$Progress.finish();
      }).catch((err) => {
        console.log(err)
      })
    },

    addMedic() {
      const path = '/api/patient/medic/add'
      const AuthStr = 'Bearer ' + localStorage.getItem('access_token').toString()

      var formData = new FormData()
      formData.append('patient_id', this.patient_id)
      formData.append('user_id', this.new_medic_id)
      console.log(this.new_medic_id)
      axios.post(path, formData, {
        headers: {
          'Accept': 'application/json',
          'Authorization': AuthStr,
        }
      }).then((res) => {
        this.new_alert(res.data)
        if (res.data.status == 'success') {
          this.fetchMedics();
          this.new_medic_id = 0;
        }
        console.log(res)
      }).catch((err) => {
        console.log(err)
      })
    },

    removeMedic(userId) {
      const path = '/api/patient/medic/remove'
      const AuthStr = 'Bearer ' + localStorage.getItem('access_token').toString()

      var formData = new FormData()
      formData.append('patient_id', this.patient_id)
      formData.append('user_id', userId)
      axios.post(path, formData, {
        headers: {
          'Accept': 'application/json',
          'Authorization': AuthStr,
        }
      }).then((res) => {
        this.new_alert(res.data)
        if (res.data.status == 'success') {
          this.fetchMedics();
        }
        console.log(res)
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
    },

    place() {
      var aux_room = (this.patient.room != null) ? (', '+this.patient.room) : '';
      var aux_bed = (this.patient.bed_number != null) ? (', Cama '+ this.patient.bed_number) : '';
      return this.patient.system + aux_room + aux_bed;
    }
  }
}
</script>

<style scoped>
.action-button {
  border-radius: 50px;
  width: 30px !important;
  height: 30px !important;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #eee;
  margin: 0;
  transition: 0.1s all !important;
  cursor: pointer;
}
.action-button:hover {
  background: #f8f8f8;
  box-shadow: 0px 0px 2px 1px rgba(0, 0, 0, 0.3);
}

.action-button:last-child {
  margin: 0;
}
</style>