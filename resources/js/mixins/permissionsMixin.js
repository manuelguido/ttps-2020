/**
 * Mixin
 */
const permissionsMixin = {
  data() {
    return {
      // Información de usuario
      userData: JSON.parse(localStorage.getItem('user')),
      roleData: JSON.parse(localStorage.getItem('role')),
      systemData: JSON.parse(localStorage.getItem('system')),
      permissionData: JSON.parse(localStorage.getItem('permissions')),
      // Roles
      roleGuard: 'Jefe de Sistema',
      roleMedic: 'Médico',
      // Sistemas
      systemGuard: 'Guardia',
    }
  },
  methods: {
    // Ver si el usuario tiene el permiso determinado por parametro
    hasPermission(permission) {
      var has_permission = false;
      this.permissionData.forEach(element => {
        if (element.permission == permission) {
          has_permission = true;
        }
      });
      if (!has_permission) {
        this.$router.push({ path: '/403' });
      }
    },

    // Ver si el usuario puede editar la información del paciente.
    canEditPatient(patient) {
      if (this.roleData == this.roleGuard || this.roleData == this.roleMedic) {
        return (patient.system_id == this.systemData.system_id)
      } else {
        return false;
      }
    },

    /**
     * Tiene permitida la configuración de camas
     */
    allowedInfiniteBeds(system) {
      return (
        this.systemData.system === system &&
        this.systemData.system === this.systemGuard &&
        this.roleData === this.roleGuard
      );
    },

    // Ver si el usuario puede editar la información del paciente.
    canAddEntry() {
      return ((this.roleData == this.roleGuard || this.roleData == this.roleMedic) && (this.systemData.system == this.systemGuard));
    },
  },
}

export default permissionsMixin
