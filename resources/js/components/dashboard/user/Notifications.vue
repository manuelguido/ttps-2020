<template>
  <mdb-list-group>
    <mdb-list-group-item v-for="n in notifications" :key="n.alert_id" :class="{ 'seen' : n.seen }">
      <!-- Container -->
      <div class="container-fluid">
        <!-- Row -->
        <div class="row">
          <!-- Informacion -->
          <div class="col-9">
            <div class="row">
              <div class="col-12 d-flex flex-column">
                <span class="mb-1 black-alpha-40 w-600">{{n.created_at | moment("DD/MM/YYYY") }}</span>
                <span class="mb-1 h5-responsive w-400">Paciente: {{n.patient.name}} {{n.patient.lastname}}</span>
              </div>
              <div class="col-12">
                <span class="mb-1 black-alpha-80 w-300">{{n.text}}</span>
              </div>
            </div>
          </div>
          <!-- /.Informacion -->
          <!-- Acciones -->
          <div class="col-3 d-flex align-items-center justify-content-end">
            <span v-if="!n.seen" class="action-button waves-effect" @click="markAsRead(n.alert_id)" title="Marcar como leída"><i class="far fa-check"></i></span>
          </div>
          <!-- /.Acciones -->
        </div>
        <!-- /.Row -->
      </div>
      <!-- /.Container -->
    </mdb-list-group-item>
  </mdb-list-group>
</template>

<script>
import { mdbListGroup, mdbListGroupItem } from 'mdbvue';

export default {
  components: {
    mdbListGroup,
    mdbListGroupItem
  },
  props: {
    notifications: {
      type: Array,
      default: []
    }
  },
  methods: {
    markAsRead(id) {
      console.log('Marco como leída '+id);
    }
  }
}
</script>

<style scoped>
.seen {
  background-color: #eee !important;
}

.action-button {
  border-radius: 50px;
  width: 40px !important;
  height: 40px !important;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #eee;
  margin: 0 2px;
  transition: 0.1s all !important;
}
.action-button:hover {
  background: #f8f8f8;
  box-shadow: 0px 0px 2px 1px rgba(0, 0, 0, 0.3);
}

.action-button:last-child {
  margin: 0;
}

</style>