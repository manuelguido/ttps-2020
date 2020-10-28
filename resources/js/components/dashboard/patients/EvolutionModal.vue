<template>
  <div>
    <mdb-btn color="primary" @click.native="modal = true" class="btn-sm mr-0 ml-5">Agregar evolución</mdb-btn>
    <mdb-modal :show="modal" centered size="md" @close="modal = false">
      <mdb-modal-header>
        <mdb-modal-title>Agregar evolución (Falta información)</mdb-modal-title>
      </mdb-modal-header>
      <mdb-modal-body class="text-left p-md-2 p-lg-4 p-xl-5">
        <!-- Form -->
        <form method="POST" @submit.prevent="newEvolution">

          <!-- Row -->
          <div class="row">
            <!-- DNI -->
            <div class="col-12">
              <div class="form-group">
                <label>Enfermedad actual</label>
                <input type="number" min="0" class="form-control mb-3" v-model="actual_disease" placeholder="Ingrese solo números" required>
              </div>
            </div>
            <!-- Dirección -->
            <div class="col-12">   
              <div class="form-group">
                <label>Antecedentes de enfermedad actual</label>
                <textarea rows="3" class="form-control mb-3" v-model="disease_background" placeholder="Ingresar antecedentes personales del paciente"></textarea>
              </div>
            </div>
          </div>
          <!-- /.Row -->

          <h1 class="h2-responsive text-center text-primary">
            agregar información faltante
          </h1>

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
        actual_disease: '',
        disease_background: '',


        lastname: '',
        dni: '',
        address: '',
        phone: '',
        birth_date: '',
        
        family_data: '',
        medical_ensurance_id: 0,
        medical_ensurances: '',
      }
    },
    methods: {
      resetForm () {
        this.name = '';
      },

      newEvolution () {
        const path = '/api/evolution/store'
        const AuthStr = 'Bearer ' + localStorage.getItem('access_token').toString()

        var formData = new FormData()
        formData.append('patient_id', this.patient_id)
        formData.append('lastname', this.lastname)

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
            this.$emit('reload-evolutions');
          }
          console.log(res)
        }).catch((err) => {
          console.log(err)
        })
      }
    }
  };
</script>
