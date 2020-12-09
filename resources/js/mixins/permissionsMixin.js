/**
 * Mixin
 */
const permissionsMixin = {
  data () {
    return {
      userData: JSON.parse(localStorage.getItem('user')),
      roleData: JSON.parse(localStorage.getItem('role')),
      systemData: JSON.parse(localStorage.getItem('system')),
      roleGuard: 'Jefe de Sistema',
      roleMedic: 'Médico',
    }
  },
	methods: {
		// Ver si el usuario puede editar la información del paciente.
    canEditPatient(patient) {
      console.log('asd');
      if (this.roleData == this.roleGuard || this.roleData == this.roleMedic) {
        return (patient.system_id == this.systemData.system_id)
      } else {
        return false;
      }
    },
	},
}

export default permissionsMixin
