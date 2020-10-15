<template>
  <mdb-list-group>
    <mdb-list-group-item v-for="n in notifications" :key="n.alert_id" :class="{ 'seen' : n.seen }">
      <!-- Container -->
      <div class="container-fluid">
        <!-- Row -->
        <div class="row">
          <!-- Informacion -->
          <div class="col-8">
            <div class="row">
              <div class="col-12">
                <span class="mb-1">Paciente: {{n.patient.name}} {{n.patient.lastname}}</span>
              </div>
              <div class="col-12">
                <span class="mb-1">{{n.text}}</span>
              </div>
            </div>
          </div>
          <!-- /.Informacion -->
          <!-- Acciones -->
          <div class="col-4 d-flex align-items-center justify-content-end">
            <a class="action-button" v-if="!n.seen" title="Ocultar"><i class="fad fa-envelope"></i></a>
            <a class="action-button" v-else title="Mostrar"><i class="fad fa-envelope-open-text"></i></a>
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
  }
}
</script>

<style scoped>
.seen {
  background-color: #ddd !important;
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