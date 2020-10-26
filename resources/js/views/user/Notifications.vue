<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-8 d-flex align-items-center justify-content-between">
        <dashboard-title text="Notificaciones"></dashboard-title>
        <router-link to="/user/notifications/history">Ver historial (leídas)</router-link>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-12 col-lg-8">
        <notifications :notifications="notifications"></notifications>
      </div>
    </div>
  </div>
</template>

<script>
import notifications from '../../components/dashboard/user/Notifications';

export default {
  components: {
    notifications
  },
  data () {
    return {
      notifications: [
        {
          alert_id: 1,
          created_at: new Date(),
          patient: {
            patient_id: 1,
            name: 'Juan',
            lastname: 'Pérez',
          },
          text: 'Informe de lo que paso...',
          seen: false,
        }
      ]
    }
  }
}
</script>
