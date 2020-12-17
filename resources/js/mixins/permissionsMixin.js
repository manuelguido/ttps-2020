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
      systemCovidFloor: 'Piso Covid',
      systemUTI: 'UTI',
      systemHotel: 'Hotel',
      systemHome: 'Domicilio',
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

    // Ver si el usuario tiene el permiso determinado por parametro
    hasPermissionDisplay(permission) {
      var has_permission = false;
      this.permissionData.forEach(element => {
        if (element.permission == permission) {
          has_permission = true;
        }
      });
      return has_permission;
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
      if (!this.systemData) {
        return false;
      } else {
        return (
          this.systemData.system === system &&
          this.systemData.system === this.systemGuard &&
          this.roleData === this.roleGuard
        );
      }
    },

    // Ver si el usuario puede editar la información del paciente.
    canAddEntry() {
      return ((this.roleData == this.roleGuard || this.roleData == this.roleMedic) && (this.systemData.system == this.systemGuard));
    },

    // Ver si el usuario tiene el rol determinado por parametro
    hasRole(role) {
      return (this.roleData == role);
    },

    // Ver si el paciente esta hospitalizado
    patientIsHospitalized(patient)
    {
      return (patient.patient_state === "En internación");
    },

    patientCanExit(patient)
    {
      const system = patient.system;
      return (system == this.systemCovidFloor || system == this.systemHotel || system == this.systemHome);
    }
  },
}

export default permissionsMixin
