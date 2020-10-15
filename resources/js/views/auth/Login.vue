<template>
  <!-- Main -->
  <main>
    <!-- Navbar -->
    <navbar></navbar>
    <!-- Container -->
    <div class="container pt-5 mt-5">
        <!-- Row -->
        <div class="row justify-content-center">
            <!-- Col -->
            <section class="col-md-7 col-lg-6 col-xl-5">
                <!-- Card -->
                <div class="card">
                  <loading-overlay v-if="loading"/>
                  <!-- Card body -->
                  <div class="card-body py-5 px-4">
                    <!-- Title -->
                    <h1 class="text-center h3 mb-5">Iniciar sesión</h1>
                    <form method="POST" @submit.prevent="login">
                        <!-- Errors -->
                        <p v-if="error" class="text-center text-danger">
                          {{error.message}}
                          <!-- Los datos ingresados son incorrectos -->
                        </p>
                        <!-- /.Error -->
                        <!-- Email -->
                        <div class="form-group">
                          <v-input v-model="username" type="email" placeholder="Email" req/>
                        </div>
                        <!-- /.Email -->
                        <!-- Password -->
                        <div class="form-group">
                            <v-input v-model="password" type="password" placeholder="Contraseña" req/>
                        </div>
                        <!-- /.Password -->
                        <!-- Login button -->
                        <div class="form-group mt-5 mb-0">
                            <button type="submit" class="btn button-primary btn-block">
                              Entrar
                            </button>
                        </div>
                        <hr>
                      </form>
                      <!-- /.Form -->

                      <login-with-google></login-with-google>

                    </div>
                    <!-- /.Card body -->
                </div>
                <!-- /.Card -->
            </section>
            <!-- /.Col -->
        </div>
        <!-- /.Row -->
    </div>
    <!-- /.Container -->
  </main>
  <!-- /.Main -->
</template>

<script>
import loginWithGoogle from '../../components/LoginWithGoogle';

export default {
  name: 'loginPage',
  title: 'Login',
  components: {
    'login-with-google': loginWithGoogle
  },
  data() {
    return {
      username: null,
      password: null,
      error: null,
      loading: false
    };
  },
  methods: {
    login() {
      this.loading = true;
      this.$store
        .dispatch("retrieveToken", {
          username: this.username,
          password: this.password
        })
        .then(response => {
          this.$router.push({ name: "dataLoad" });
        })
        .catch(error => {
          this.error = error.response.data;
        })
        .finally(() => this.loading = false);
    },
    googleLogin() {
      this.$store
        .dispatch("retrieveTokenByGoogle")
        .then(response => {
          this.$router.push({ name: "dashboard" });
        })
        .catch(error => {
          this.error = error.response.data;
        });
    }
  }
};
</script>

<style scoped>
.top-content {
  background: white;
  height: 45vh !important;
}

.bottom-content {
  background: #060d1f;
  height: 55vh !important;
}

.outer-position {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  margin: 0;
}

.card {
  box-shadow: 0 .05em .5em .2em rgba(0,0,0,.08) !important;
}


@media (min-width: 992px) {
	.outer-position {
		top: 5em;
	}
}
@media (max-width: 992px) {
	.outer-position {
		top: 0em;
	}
}
</style>