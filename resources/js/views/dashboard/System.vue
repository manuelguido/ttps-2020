<template>
  <!-- Container -->
  <div class="container-fluid">
    <backlink></backlink>
    <!-- Row -->
    <div class="row">
      <!-- Col -->
      <div class="col-12 col-lg-6 col-xl-5">
        <!-- Row -->
        <div class="row">

          <!-- Sytema -->
          <div class="col-12 mb-3">
            <p class="h3-responsive primary">{{system.system}}</p>
          </div>
          <!-- /.Systema -->

          <!-- Camas ilimitadas -->
          <div v-if="system.system == 'Guardia'" class="col-12 mb-3">
            <div class="row d-flex align-items-center">

              <!-- Total de camas -->
              <div class="col-3 primary">
                Camas ilimitadas
              </div>

              <!-- Activado / Descativado -->
              <div class="col-9">
                <span class="d-flex align-items-center" v-if="system.infinite_beds">
                  Activado
                  <button class="btn btn-sm button-primary">Desactivar</button>
                </span>
                <span class="d-flex align-items-center" v-else>
                  Descactivado
                  <button class="btn btn-sm button-primary">Activar</button>
                </span>
              </div>
            </div>
          </div>
          <!-- ./Camas ilimitadas -->

          <div class="col-12 mb-3">
            <hr>
          </div>

          <!-- Total de camas -->
          <div class="col-3 mb-3 primary">
            Cantidad de salas
          </div>
          <div class="col-9 mb-3">
            <p class="mb-2">{{system.total_rooms}}</p>
          </div>

          <!-- Total de camas -->
          <div class="col-3 mb-3 primary">
            Camas totales
          </div>
          <div class="col-9 mb-3">
            <p class="mb-2">{{system.total_beds}}</p>
          </div>

          <!-- Obra social -->
          <div class="col-3 mb-3 primary">
            Camas disponibles
          </div>
          <div class="col-9 mb-3">
            <p class="mb-2">{{system.free_beds}}</p>
          </div>

          <!-- Obra social -->
          <div class="col-3 mb-3 primary">
            Camas ocupadas
          </div>
          <div class="col-9 mb-3">
            <p class="mb-2">{{system.occupied_beds}}</p>
          </div>

        </div>
        <!-- /.Row -->
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
  name: 'system',
  props: ['system_id'],
  data () {
    return {
      loading: true,
      system: {},
      rooms: [],
    }
  },
  created () {
    this.fetchSystem();
  },
  methods: {
    /**
     * Obtiene el sistema con sus habitaciones y camas
     */
    fetchSystem () {
      const path = '/api/system/full';
      const AuthStr = 'Bearer ' + localStorage.getItem('access_token').toString();

      axios.get(path, {
        params: {
          system_id: this.system_id,
        },
        headers: {
          'Accept': 'application/json',
          'Authorization': AuthStr
        }
      }).then((res) => {
        this.system = res.data
        this.loading = false;
      }).catch((err) => {
        console.log(err)
      })
    }
  }

}
</script>
