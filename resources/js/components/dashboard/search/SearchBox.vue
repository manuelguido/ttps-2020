<template>
  <!-- Step 1  -->
  <div class="step-content animated">
    <!-- Row -->
    <div class="row justify-content-center p-5">
      <!-- Col -->
      <form @submit.prevent="searchPatient()" class="col-12 col-lg-8 text-center d-flex flex-column align-items-center">
        <!-- ID input -->
        <input
          class="id-input mb-4"
          placeholder="Buscar por nombre, apellido, dni..."
          v-model="inputData"
        />
        <!-- /.ID input -->
        <button type="submit" class="btn button-success">
          <i class="fad fa-search mr-3"></i> Buscar
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
  name: "SearchPatient",
  data() {
    return {
      inputData: "",
    };
  },
  methods: {
    /**
     * Buscar paciente por dni.
     */
    searchPatient() {
      const path = "/api/patient/search/complete";
      const AuthStr =
        "Bearer " + localStorage.getItem("access_token").toString();
      const formData = { input_data: this.inputData };

      axios
        .post(path, formData, {
          headers: {
            Accept: "application/json",
            Authorization: AuthStr,
          },
        })
        .then((res) => {
          console.log(res.data.result);
          this.$emit("updateData", { data: res.data.result });
        })
        .catch((err) => {
          console.log(err);
        });
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
