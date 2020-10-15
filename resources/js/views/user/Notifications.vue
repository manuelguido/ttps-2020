<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-8">
        <dashboard-title text="Notificaciones"></dashboard-title>
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
        },
        {
          alert_id: 2,
          created_at: new Date(),
          patient: {
            patient_id: 1,
            name: 'Juan',
            lastname: 'Pérez',
          },
          text: 'Informe de lo que paso...',
          seen: true,
        },
        {
          alert_id: 3,
          created_at: new Date(),
          patient: {
            patient_id: 1,
            name: 'Juan',
            lastname: 'Pérez',
          },
          text: 'Informe de lo que paso...',
          seen: true,
        }
      ]
    }
  }
}
</script>
