<template>
  <!-- Step 1  -->
  <div class="step-content animated">
    <!-- Row -->
    <div class="row justify-content-center p-5">
      <!-- Col -->
      <form
        @submit.prevent="searchByDni()"
        class="col-12 col-lg-8 text-center d-flex flex-column align-items-center"
      >
        <!-- Icon and DNI -->
        <span
          class="my-5 d-flex flex-row align-items-center justify-content-between uns"
        >
          <i
            :class="[
              'fad fa-7x',
              dniInput == ''
                ? 'fa-address-card black-alpha-30'
                : 'fa-id-card primary',
            ]"
          ></i>
          <span
            v-if="dniInput != ''"
            class="h3-responsive w-400 black-alpha-50 ml-4"
            >DNI {{ formatDni(dniInput) }}</span
          >
        </span>
        <!-- /.Icon and DNI -->
        <!-- ID input -->
        <input
          type="number"
          min="0"
          max="9999999999"
          class="id-input mb-4"
          placeholder="Ingresa el DNI sin puntos ni espacios"
          v-model="dniInput"
          @keypress="isNumber($event)"
        />
        <!-- /.ID input -->
        <button type="submit" class="btn button-success btn-block">
          Buscar
        </button>
      </form>
      <!-- Col -->
    </div>
    <!-- Row -->
  </div>
  <!-- /.Step 1 -->
</template>

<script>
export default {
  name: "SearchPatientByDni",
  data() {
    return {
      dniInput: "",
    };
  },
  methods: {
    /**
     * Buscar paciente por dni.
     */
    searchByDni() {
      // this.$emit("loadingData", true);
      const path = "/api/patient/search";
      const AuthStr =
        "Bearer " + localStorage.getItem("access_token").toString();
      const formData = { dni: this.dniInput };

      axios
        .post(path, formData, {
          headers: {
            Accept: "application/json",
            Authorization: AuthStr,
          },
        })
        .then((res) => {
          if (res.data.status == 'warning') {
            this.new_alert(res.data);
          } else if (res.data.patient) {
            this.$emit("updateData", { patient: res.data.patient });
          } else {
            this.$emit("updateData", { dni: this.dniInput });
          }
          this.$emit("loadingData", false);
        })
        .catch((err) => {
          console.log(err);
          this.$emit("loadingData", false);
        });
    },
  },
  watch: {
    dniInput: function () {
      var maxChars = 9;
      if (this.dniInput.length > maxChars) {
        this.dniInput = this.dniInput.substr(0, maxChars);
      }
    },
  },
};
</script>

<style scoped>
.id-input {
  background: #eee;
  border: 0 none;
  border-radius: 5px;
  outline: none !important;
  padding: 0.8em 1em;
  width: 100%;
  color: #232323;
}
.id-input::placeholder {
  color: #444 !important;
}
</style>
