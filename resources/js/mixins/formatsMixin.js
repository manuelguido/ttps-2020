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
    },

    formatDate(dateData) {
      // Crear fecha
      let date_ob = new Date(dateData);
      // Ajustar 0 antes del digito de fecha
      let day = ("0" + date_ob.getDate()).slice(-2);
      // Mes
      let month = ("0" + (date_ob.getMonth() + 1)).slice(-2);
      // Año
      let year = date_ob.getFullYear();
      // Formato completo
      return day + "/" + month + "/" + year;
    }
  },
}

export default formatsMixin
