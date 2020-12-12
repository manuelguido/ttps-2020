/**
 * Mixin
 */
const formatsMixin = {
  methods: {
    formatDni(value) {
      return (value / 1).toFixed(0).replace('.').toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },

    // Fomatear el lugar donde se encuentra el paciente (Sistema, cama, sala).
    patientPlace(patient) {
      var aux_room = patient.room != null ? ", " + patient.room : "";
      var aux_bed =
        patient.bed_number != null
          ? ", Cama " + patient.bed_number
          : "";
      return patient.system + aux_room + aux_bed;
    },

    formatString(value) {
      return value.toString();
    }
  },
}

export default formatsMixin
