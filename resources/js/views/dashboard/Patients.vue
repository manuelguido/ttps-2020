<template>
  <!-- Container -->
  <div class="container-fluid">
    <!-- Title -->
    <dashboard-title text="Pacientes" full></dashboard-title>
    <!-- Row -->
    <div class="row">
      <!-- Col -->
      <div class="col-12 col-lg-8 col-xl-6">
        <div class="row d-flex align-items-center">

          <!-- Search form -->
          <div class="col-12 mb-4">
            <form class="search-form mx-auto my-3 my-lg-1 shadow-sm">
              <div class="input-group">
                <input type="text" class="form-control" v-model="input_search" placeholder="Buscar paciente" aria-label="Buscar" aria-describedby="search-addon">
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
      <div class="col-12 col-lg-8 col-xl-6">
        <!-- Tabla de pacientes -->
        <patients-table></patients-table>
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