<template>
  <!-- Container -->
  <div class="container-fluid">
    <!-- Row -->
    <div class="row">
      <!-- Col -->
      <div class="col-12 d-flex justify-content-between align-items-center mb-4">
        <span>
          <dashboard-title :text="title" :margin="false"></dashboard-title>
        </span>
        <!-- Modal de carga de paciente -->
        <!-- <span> -->
          <!-- <modal @reload-patients="fetchPatients()"></modal> -->
        <!-- </span> -->
        <!-- /.Modal de carga de paciente -->
      </div>
      <!-- /.Col -->

      <!-- Col -->
      <div class="col-12">
        <div class="row d-flex align-items-center">

          <!-- Search form -->
          <div class="col-12 mb-4">
            <form class="search-form mx-auto my-3 my-lg-1 c-card">
              <div class="input-group">
                <input type="text" class="form-control" v-model="input_data" placeholder="Buscar paciente: dni, nombre, apellido ..." aria-label="Buscar" aria-describedby="search-addon">
                <div class="input-group-append">
                  <span class="input-group-text" id="search-addon"><i class="fas fa-search"></i></span>
                </div>
              </div>
            </form>
          </div>
          <!-- /.Search form -->

        </div>
      </div>
      <!-- /.Col -->
    </div>
    <!-- /.Row -->

    <!-- Row -->
    <div class="row">
      <!-- Col -->
      <div class="col-12">
        <!-- Tabla de pacientes -->
        <patients-table :patients="patients" :loading="loading" @reload-data="fetchPatients()"></patients-table>
      </div>
      <!-- /.Col -->
    </div>
    <!-- /.Row -->

  </div>
  <!-- Container -->
</template>

<script>
// import modal from '../../components/dashboard/patients/NewEntryModal/Index';

export default {
  // components: {
  //   modal,
  // },
  props: {
    system_id: {
      default: null,
    }
  },
  data () {
    return {
      title: 'Pacientes',
      loading: true,
      patients: [],
      input_data: '',
    }
  },
  created () {
    this.$Progress.start();
    this.fetchPatients();
  },
  methods: {
    loadPatients (data) {
      var maindata = data;
      maindata.forEach(element => {
        element.show = true;
      });
      this.patients = maindata;
    },

    fetchPatients () {
      const path = '/api/patient/assigned/index';
      const AuthStr = 'Bearer ' + localStorage.getItem('access_token').toString();

      axios.get(path, {
        headers: {
          'Accept': 'application/json',
          'Authorization': AuthStr
        }
      }).then((res) => {
        this.loadPatients(res.data);
        console.log(res.data);
        this.$Progress.finish();
        this.loading = false;
      }).catch((err) => {
        this.errorHandler(err.response.status);
        console.log(err);
      });
    },

    matchData (value) {
      return (value.toLowerCase().match(this.input_data.toLowerCase()))
    },
    
    mathSearch (patient) {
      var aux_room = (patient.room != null) ? patient.room : '';
      var aux_bed = (patient.bed_number != null) ? ('Cama '+ patient.bed_number) : '';
      return (
        this.matchData(patient.name) ||
        this.matchData(patient.lastname) ||
        this.matchData(patient.name+' '+patient.lastname) ||
        this.matchData(patient.lastname+' '+patient.name) ||
        this.matchData(patient.system) ||
        this.matchData(aux_room) ||
        this.matchData(aux_bed) ||
        this.matchData(patient.dni.toString())
      );
    }
  },
  watch: {
    // Search function
		input_data: function() {
      // Query
      this.patients.forEach(patient => {
        patient.show = this.mathSearch(patient);
      });
    }
  }
}
</script>

<style scoped>
/* Searchbar */
.search-form {
  /* background: var(--black-alpha-03); */
  background: #fff;
	border-radius: 8px;
	border: 0 none;
	padding: 10px;
}

.search-form input {
	width: 100%;
	height: 100%;
}

.search-form input,
.search-form input:focus {
	color: var(--white-a);
}

.search-form input:focus,
.search-form * {
	box-shadow: none;
	background: none;
	border: 0 none;
	outline: none ;
}
</style>