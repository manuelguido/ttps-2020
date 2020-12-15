<template>
  <!-- Alert -->
  <div
    class="ls-alert uns"
    :class="[
      border,
      swipped ? 'swipped' : '',
      ]">
    <!-- Icon -->
    <span class="middle">
      <i class="fa-lg icon" :class="icon"></i>
    </span>
    <!-- /.Icon -->
    <!-- Message  -->
    <span class="middle px-3">
      <span class="message">
        {{alert.message}}
      </span>
    </span>
    <!-- /.Message -->
    <!-- Close button -->
    <span class="middle">
      <button class="close" @click='hide()'>&times;</button>
    </span>
    <!-- /.Close button -->
  </div>
  <!-- /.Alert -->
</template>

<script>
export default {
  props: {
    alert: Object,
    duration: {
      type: Number,
      default: 5000
    },
    bordered: {
      type: Boolean,
      default: true
    }
  },
  data () {
    return {
      swipped: false,
      border: 'ls-alert-primary',
      icon: 'fas fa-check-circle'
    }
  },
  methods: {
    destroyCurrents() {
      var alerts = document.getElementsByClassName("ls-alert")
      for (var index = 0; index < alerts.length; index++) {
        alerts[index].classList.add('display-none')
      }
    },

    loadAlert() {
      switch (this.alert.status) {
        case 'success':
          this.border = this.bordered ? "ls-alert-success" : '';
          this.icon = 'fas fa-check-circle success';
          break;
        case 'warning':
          this.border = this.bordered ? "ls-alert-warning" : '';
          this.icon = 'fas fa-exclamation-circle warning';
          break;
        case 'danger':
          this.border = this.bordered ? "ls-alert-danger" : '';
          this.icon = 'fas fa-exclamation-circle danger';
          break;
      }
    },

    swipeOut () {
      this.swipped = true;
    },

    hide () {
      this.swipeOut();
      var $this = this;
      setTimeout(function () {
        $this.$el.parentNode.removeChild($this.$el);
      }, 1000);
    },

    link () {
      this.$router.push({ path: this.link.url });
    },

    timeoutDestroy () {
      // this.$refs.asd.classList.add('mt-5')
      var $this = this
      setTimeout(function () {
        $this.hide()
      }, $this.duration)
    }
  },
  created () {
    this.destroyCurrents()
    this.loadAlert()
    this.timeoutDestroy()
  }
}
</script>

<style scoped>
.ls-alert {
  position: fixed;
  display: table;
  z-index: 1080 !important;
  width: auto;
  background: #fff;
  padding: 1.25em 1.5em;
  border-radius: 8px !important;
  box-shadow: 0 1px 4em 0 rgba(0,0,0,.25);
}
.ls-alert, .ls-alert * {
  transition: 1s all;
}
.ls-alert-card {
  background: #fff;
  border-radius: 6.2px;
  padding: 1.4rem;
}
@media(min-width: 992px) {
  .ls-alert {
    top: 20px;
    right: 20px;
  }
}
@media(max-width: 992px) {
  .ls-alert {
    top: 20px;
    right: 20px;
    left: 20px;
  }
}

.close {
  /* border: 0 none; */
  border-radius: 50px;
  height: 40px;
  width: 40px;
  text-align: center !important;
}
.close:hover {
  color: var(--black-a);
  background: #eee;
}
.close:active {
  color: var(--black-b);
  background: #f4f4f4;
}

.middle {
  display: table-cell;
  vertical-align: middle;
}

.ls-alert-primary {
  border-bottom: 6px solid #444BF8 !important;
}
.ls-alert-success {
  border-bottom: 6px solid #18cc8a !important;
}
.ls-alert-warning {
  border-bottom: 6px solid #F1BE25 !important;
}
.ls-alert-danger {
  border-bottom: 6px solid #F12559 !important;
}
.display-none {
  display: none !important;
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
