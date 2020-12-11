<template>
  <mdb-list-group-item :class="['border-light', alert.seen ? 'seen' : '', swipped ? 'swipped' : '']">
    <!-- Container -->
    <div class="container-fluid">
      <!-- Row -->
      <div class="row">
        <!-- Informacion -->
        <div class="col-9">
          <div class="row">
            <div class="col-12 d-flex flex-column">
              <span class="mb-1 black-alpha-50 w-400">{{
                alert.created_at | moment("DD/MM/YYYY")
              }}</span>
              <span class="mb-1 h5 black-alhpa-40 w-400"
                >Paciente: {{ alert.name }} {{ alert.lastname }}</span
              >
            </div>
            <div class="col-12">
              <span class="mb-1 black-alpha-70 w-400">{{
                alert.description
              }}</span>
            </div>
          </div>
        </div>
        <!-- /.Informacion -->
        <!-- Acciones -->
        <div class="col-3 d-flex align-items-center justify-content-end">
          <span
            v-if="!alert.seen"
            class="action-button waves-effect"
            @click="markAsRead()"
            title="Marcar como leída"
            ><i class="far fa-check"></i
          ></span>
        </div>
        <!-- /.Acciones -->
      </div>
      <!-- /.Row -->
    </div>
    <!-- /.Container -->
  </mdb-list-group-item>
</template>

<script>
import { mdbListGroupItem } from "mdbvue";

export default {
  name: "AlertsElement",
  components: {
    mdbListGroupItem,
  },
  props: {
    alert: {
      type: Object,
      default: null,
    },
  },
  data () {
    return {
      swipped: false,
    }
  },
  methods: {
    markAsRead() {
      const path = "/api/alert/read";
      const AuthStr =
        "Bearer " + localStorage.getItem("access_token").toString();

      var formData = {
        alert_id: this.alert.alert_id,
      };

      axios
        .post(path, formData, {
          headers: {
            Accept: "application/json",
            Authorization: AuthStr,
          },
        })
        .then((res) => {
          if (res.data.status == "success") {
            this.$emit("reloadData", this.alert_id);
            this.deleteAlert();
          }
        })
        .catch((err) => {
          var $this = this;
          setTimeout(function () {
            $this.markAsRead();
          }, 20);
          console.log(err);
        });
    },

    deleteAlert() {
      this.swipeOut();
      this.destroy();
    },

    swipeOut() {
      this.swipped = true;
    },

    destroy() {
      var $this = this;
      setTimeout(function () {
        $this.$el.parentNode.removeChild($this.$el);
      }, 500);
    },
  },
};
</script>

<style scoped>
.seen {
  background-color: #fcfcfc !important;
}

.action-button {
  border-radius: 50px;
  width: 40px !important;
  height: 40px !important;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #eee;
  margin: 0 2px;
  transition: 0.1s all !important;
}
.action-button:hover {
  background: #f8f8f8;
  box-shadow: 0px 0px 2px 1px rgba(0, 0, 0, 0.3);
}

.action-button:last-child {
  margin: 0;
}

.border-light {
  border-color: #ebeefb !important;
}

/* Animation */
.swipped {
  animation: 1s swipeOut !important;
}
@keyframes swipeOut {
 0%{
   transform: translateX(0);
   opacity: 1;
 }
 100%{
   transform: translateX(2000px);
   opacity: 0;
 }
}
</style>