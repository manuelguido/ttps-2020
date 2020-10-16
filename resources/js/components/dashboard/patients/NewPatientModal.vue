<template>
  <div>
    <mdb-btn color="primary" @click.native="modal = true" class="mr-0 ml-5">Registrar paciente</mdb-btn>
    <mdb-modal :show="modal" @close="modal = false">
      <mdb-modal-header>
        <mdb-modal-title>Cargar paciente</mdb-modal-title>
      </mdb-modal-header>
      <mdb-modal-body class="text-left">
        <!-- Form -->
        <form method="POST" @submit.prevent="newPatient">
          
          <div class="form-group">
            <label>Nombre</label>
            <input type="text" class="form-control mb-3" v-model="name" placeholder="Nombre del paciente" required>
          </div>
          
          <div class="form-group">
            <label>Apellido</label>
            <input type="text" class="form-control mb-3" v-model="lastname" placeholder="Apellido paciente" required>
          </div>

          <div class="form-group">
            <label>Dirección</label>
            <input type="text" class="form-control mb-3" v-model="address" placeholder="Dirección del paciente" required>
          </div>

          <div class="form-group">
            <label>Teléfono</label>
            <input type="number" min="0" class="form-control mb-3" v-model="phone" placeholder="Solo números sin simbolos" required>
          </div>

          <div class="form-group col-6 px-0">
            <label>Fecha de nacimiento</label>
            <input type="date" class="form-control mb-3" v-model="birth_date" required>
          </div>

          <div class="form-group">
            <label>Antecedentes personales</label>
            <textarea rows="3" class="form-control mb-3" v-model="personal_background" placeholder="Antecedentes del paciente"></textarea>
          </div>

          <div class="form-group">
            <label>Obra social</label>
            <select v-model="medical_ensurance_id" class="custom-select">
              <option value="0" disabled>Seleccionar</option>
              <option v-for="m in medical_ensurances" :key="m.medical_ensurance_id" :value="m.medical_ensurance_id">{{m.medical_ensurance}}</option>
            </select>
          </div>

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
        address: '',
        phone: '',
        birth_date: '',
        personal_background: '',
        medical_ensurance_id: 0,
        medical_ensurances: '',
      }
    },
    created () {
      this.getMedicalEnsurances();
    },
    methods: {
      resetForm () {
        this.name = '';
        this.lastname = '';
        this.address = '';
        this.phone = '';
        this.birth_date = '';
        this.personal_background = '';
        this.medical_ensurance_id = 0;
      },

      newPatient () {
        const path = '/api/patient/store'
        const AuthStr = 'Bearer ' + localStorage.getItem('access_token').toString()

        var formData = new FormData()
        formData.append('name', this.name)
        formData.append('lastname', this.lastname)
        formData.append('address', this.address)
        formData.append('phone', this.phone)
        formData.append('birth_date', this.birth_date)
        formData.append('personal_background', this.personal_background)
        formData.append('medical_ensurance_id', this.medical_ensurance_id)

        axios.post(path, formData, {
          headers: {
            'Accept': 'application/json',
            'Authorization': AuthStr,
          }
        }).then((res) => {
          this.new_alert(res.data)
          if (res.data.status == 200) {
            this.resetForm();
          }
          console.log(res)
        }).catch((err) => {
          console.log(err)
        })
      },

      getMedicalEnsurances () {
        const path = '/api/medical_ensurance/index'
        const AuthStr = 'Bearer ' + localStorage.getItem('access_token').toString()

        axios.get(path, {
          headers: {
            'Accept': 'application/json',
            'Authorization': AuthStr
          }
        }).then((res) => {
          this.medical_ensurances = res.data
        }).catch((err) => {
          console.log(err)
        })
      }
    }
  };
</script>
