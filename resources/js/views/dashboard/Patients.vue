<template>
  <!-- Container -->
  <div class="container-fluid">
    <!-- Title -->
    <dashboard-title text="Pacientes" full></dashboard-title>
    <!-- Row -->
    <div class="row">
      <!-- Col -->
      <div class="col-12 col-lg-8 mb-4">
        <div class="row d-flex align-items-center">

          <!-- Search form -->
          <div class="col-12 mb-4">
            <form class="search-form mx-auto my-3 my-lg-1 shadow-sm">
              <div class="input-group">
                <input type="text" class="form-control" v-model="input_data" placeholder="Buscar paciente: dni, nombre, apellido ..." aria-label="Buscar" aria-describedby="search-addon">
                <div class="input-group-append">
                  <span class="input-group-text" id="search-addon"><i class="fas fa-search"></i></span>
                </div>
              </div>
            </form>
          </div>
          <!-- /.Search form -->

          <!-- Salas -->
          <div class="col-12 col-lg-6">
            <select class="form-control">
              <option>Sala G1</option>
              <option>Sala G2</option>
            </select>
          </div>
          <!-- /.Salas -->

          <!-- Modal de carga de paciente -->
          <div class="col-12 col-lg-6 text-right">
            <modal></modal>
          </div>
          <!-- /.Modal de carga de paciente -->

        </div>
      </div>
      <!-- /.Col -->
    </div>
    <!-- /.Row -->

    <!-- Row -->
    <div class="row">
      <!-- Col -->
      <div class="col-12 col-lg-8">
        <!-- Tabla de pacientes -->
        <patients-table :patients="patients"></patients-table>
      </div>
      <!-- /.Col -->
    </div>
    <!-- /.Row -->

  </div>
  <!-- Container -->
</template>

<script>
import modal from '../../components/dashboard/patients/NewPatientModal';
import patientsTable from '../../components/dashboard/patients/PatientsTable/Index';

export default {
  components: {
    modal,
    'patients-table': patientsTable
  },
  data () {
    return {
      patients: [],
      input_data: '',
    }
  },
  created () {
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
      const path = '/api/patient/index';
      const AuthStr = 'Bearer ' + localStorage.getItem('access_token').toString();

      axios.get(path, {
        headers: {
          'Accept': 'application/json',
          'Authorization': AuthStr
        }
      }).then((res) => {
        this.loadPatients(res.data);
      }).catch((err) => {
        console.log(err)
      })
    },

    matchData (value) {
      return (value.toLowerCase().match(this.input_data.toLowerCase()))
    },
    
    mathSearch (patient) {
      return (
        this.matchData(patient.name) ||
        this.matchData(patient.lastname) ||
        this.matchData(patient.name+' '+patient.lastname) ||
        this.matchData(patient.lastname+' '+patient.name)
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
    },

    // Room filter
    room_filter: function() {
      // // Elements
			for (let i = 0; i < this.products.length; i++) {
        let condition = (this.products[i].category_id == this.category_filer || this.category_filer == 0)
        condition ? this.updateProduct(this.products[i], i, true) : this.updateProduct(this.products[i], i, false) 
      }
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