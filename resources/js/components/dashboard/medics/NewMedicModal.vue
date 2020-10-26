<template>
  <div>
    <mdb-btn color="primary" @click.native="modal = true" class="mr-0 ml-5">
      <i class="fad fa-user-plus mr-2"></i>
      Nuevo médico
    </mdb-btn>
    <mdb-modal :show="modal"  size="lg" @close="modal = false">
      <mdb-modal-header>
        <mdb-modal-title>Registrar médico en el sistema</mdb-modal-title>
      </mdb-modal-header>
      <mdb-modal-body class="text-left p-md-2 p-lg-4 p-xl-5">
        <!-- Form -->
        <form method="POST" @submit.prevent="newMedic">
          
          <!-- Row -->
          <div class="row">
            <!-- Nombre -->
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label>Nombre (*)</label>
                <input type="text" class="form-control mb-3" v-model="name" placeholder="Ingrese el nombre" required>
              </div>
            </div>
            <!-- Apellido -->
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label>Apellido (*)</label>
                <input type="text" class="form-control mb-3" v-model="lastname" placeholder="Ingrese el apellido" required>
              </div>
            </div>
          </div>
          <!-- /.Row -->

          <!-- Row -->
          <div class="row">
            <!-- DNI -->
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label>DNI (*)</label>
                <input type="number" min="0" class="form-control mb-3" v-model="dni" placeholder="Ingrese solo números" required>
              </div>
            </div>
          </div>
          <!-- /.Row -->

          <!-- Row -->
          <div class="row">
            <!-- Teléfono -->
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label>Teléfono (*)</label>
                <input type="number" min="0" class="form-control mb-3" v-model="phone" placeholder="Ingrese solo números" required>
              </div>
            </div>
            <!-- Email -->
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label>Email (*)</label>
                <input type="email" class="form-control mb-3" v-model="email" placeholder="Ingrese el email" required>
              </div>
            </div>
          </div>
          <!-- /.Row -->

          <button class="btn btn-primary btn-block mt-4 mt-lg-5" type="submit">Cargar</button>
        </form>
        <!-- Form -->
      </mdb-modal-body>
    </mdb-modal>
  </div>
</template>

<script>
  import { mdbModal, mdbModalHeader, mdbModalTitle, mdbModalBody, mdbModalFooter, mdbBtn } from 'mdbvue';
  export default {
    components: {
      mdbModal,
      mdbModalHeader,
      mdbModalTitle,
      mdbModalBody,
      mdbModalFooter,
      mdbBtn
    },
    data() {
      return {
        modal: false,
        name: '',
        lastname: '',
        dni: '',
        phone: '',
        email: '',
      }
    },
    methods: {
      resetForm () {
        this.name = '';
        this.lastname = '';
        this.dni = '',
        this.phone = '';
        this.email = '';
      },

      newMedic () {
        const path = '/api/medic/store'
        const AuthStr = 'Bearer ' + localStorage.getItem('access_token').toString()

        var formData = new FormData()
        formData.append('name', this.name)
        formData.append('lastname', this.lastname)
        formData.append('dni', this.dni)
        formData.append('phone', this.phone)
        formData.append('email', this.email)

        axios.post(path, formData, {
          headers: {
            'Accept': 'application/json',
            'Authorization': AuthStr,
          }
        }).then((res) => {
          this.new_alert(res.data)
          if (res.data.status == 'success') {
            this.resetForm();
            this.modal = false;
            this.$emit('reload-medics');
          }
          console.log(res)
        }).catch((err) => {
          console.log(err)
        })
      }
    }
  };
</script>
