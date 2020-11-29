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
        <span>
          <modal @reload-medics="fetchMedics()"></modal>
        </span>
        <!-- /.Modal de carga de paciente -->
      </div>
      <!-- /.Col -->

      <!-- Col -->
      <div class="col-12 mb-4">
        <!-- Search form -->
        <form class="search-form mx-auto my-3 my-lg-1 c-card">
          <div class="input-group">
            <input type="text" class="form-control" v-model="input_data" placeholder="Buscar médico: dni, nombre, apellido ..." aria-label="Buscar" aria-describedby="search-addon">
            <div class="input-group-append">
              <span class="input-group-text" id="search-addon"><i class="fas fa-search"></i></span>
            </div>
          </div>
        </form>
        <!-- /.Search form -->
      </div>
      <!-- /.Col -->

      <!-- Col -->
      <div class="col-12">
        <!-- Tabla de pacientes -->
        <medics-table :medics="medics" :loading="loading" @reload-medics="fetchMedics()"></medics-table>
      </div>
      <!-- /.Col -->
    </div>
    <!-- /.Row -->

  </div>
  <!-- Container -->
</template>

<script>
import modal from '../../components/dashboard/medics/NewMedicModal';

export default {
  components: {
    modal,
  },
  props: {
    system_id: {
      default: null,
    }
  },
  data () {
    return {
      title: '',
      loading: true,
      medics: [],
      input_data: '',
      system: null,
    }
  },
  created () {
    this.$Progress.start();
    this.fetchMedics();

    if (this.system_id) {
      this.fetchSystem();
    } else {
      this.title = "Médicos";
    }
  },
  methods: {
    loadMedics (data) {
      var maindata = data;
      maindata.forEach(element => {
        element.show = true;
      });
      this.medics = maindata;
    },

    fetchMedics () {
      const path = '/api/medic/assigned/index';
      const AuthStr = 'Bearer ' + localStorage.getItem('access_token').toString();

      axios.get(path, {
        headers: {
          'Accept': 'application/json',
          'Authorization': AuthStr
        }
      }).then((res) => {
        this.loadMedics(res.data);
        this.$Progress.finish();
        this.loading = false;
      }).catch((err) => {
        this.errorHandler(err.response.status);
        console.log(err)
      });
    },

    matchData (value) {
      return (value.toLowerCase().match(this.input_data.toLowerCase()))
    },
    
    mathSearch (medic) {
      return (
        this.matchData(medic.name) ||
        this.matchData(medic.lastname) ||
        this.matchData(medic.name+' '+medic.lastname) ||
        this.matchData(medic.system) ||
        this.matchData(medic.dni.toString())
      );
    }
  },
  watch: {
    // Search function
		input_data: function() {
      // Query
      this.medics.forEach(medic => {
        medic.show = this.mathSearch(medic);
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