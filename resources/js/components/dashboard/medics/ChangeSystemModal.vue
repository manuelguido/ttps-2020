<template>
  <div class="d-inline-block">
    <mdb-btn outline="secondary" @click.native="modal = true" class="btn-sm">Cambiar sistema</mdb-btn>
    <mdb-modal :show="modal" @close="modal = false">
      <mdb-modal-header>
        <mdb-modal-title>Cambiar paciente de sistema</mdb-modal-title>
      </mdb-modal-header>
      <mdb-modal-body class="text-left p-md-2 p-lg-4 p-xl-5">
        <!-- Form -->
        <form method="POST" @submit.prevent="changeSystem">

          <div class="row">
            <!-- Información -->
            <div class="col-12 mb-4">
              <h1 class="primary h5-responsive">{{medic.name+' '+medic.lastname}}</h1>
              <p>DNI {{dni()}}</p>
            </div>
            <!-- /.Información -->

            <div class="col-12">
              <div class="form-group">
                <label class="d-block">Sistema</label>
                <select v-model="system_id" class="custom-select" required>
                  <option value="0" disabled>Seleccionar</option>
                  <option v-for="s in systems" :key="s.system_id" :value="s.system_id">{{s.system}}</option>
                </select>
              </div>
            </div>
          </div>

          <button class="btn btn-primary btn-block mt-4 mt-lg-5" type="submit">Cambiar</button>
        </form>
        <!-- Form -->
      </mdb-modal-body>
    </mdb-modal>
  </div>
</template>

<script>
  import { mdbModal, mdbModalHeader, mdbModalTitle, mdbModalBody, mdbModalFooter, mdbBtn } from 'mdbvue';
  export default {
    name: 'ChangeSystemModal',
    components: {
      mdbModal,
      mdbModalHeader,
      mdbModalTitle,
      mdbModalBody,
      mdbModalFooter,
      mdbBtn
    },
    props: {
      medic: {
        type: Object
      },
      systems: {
        type: Array
      }
    },
    data() {
      return {
        modal: false,
        system_id: this.medic.system_id,
      }
    },
    methods: {
      changeSystem () {
        const path = '/api/medic/change_system'
        const AuthStr = 'Bearer ' + localStorage.getItem('access_token').toString()

        var formData = new FormData()
        formData.append('medic_id', this.medic.medic_id)
        formData.append('system_id', this.system_id)

        axios.post(path, formData, {
          headers: {
            'Accept': 'application/json',
            'Authorization': AuthStr,
          }
        }).then((res) => {
          this.new_alert(res.data)
          if (res.data.status == 'success') {
            this.modal = false;
            this.$emit('reload-medics');
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
        let val = (this.medic.dni/1).toFixed(0).replace('.')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
      }
    }
  };
</script>
