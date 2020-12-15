<template>
  <span
    :class="[
      'nav-item d-flex align-items-center mr-3 px-4 toggle-outer uns',
      online.bg_color,
    ]"
    @click="toggleOnline"
  >
    <span>
      <i :class="['fa-lg mr-3 my-2', online.icon, online.color]"></i>
    </span>
    <span :class="['w-600', online.color]">
      {{ online.text }}
    </span>
  </span>
</template>

<script>
import { mdbDropdownItem } from "mdbvue";
export default {
  name: "OnlineToggler",
  components: {
    mdbDropdownItem,
  },
  data() {
    return {
      online: JSON.parse(localStorage.getItem("online")),
      valueOnline: {
        text: "Online",
        color: "text-success",
        bg_color: "bg-white",
        value: true,
        icon: "fad fa-toggle-on",
      },
      valueOffline: {
        text: "Offline",
        color: "text-warning",
        bg_color: "bg-black-alpha-10",
        value: false,
        icon: "fad fa-toggle-off",
      },
    };
  },
  methods: {
    toggleOnline() {
      if (this.online.value) {
        localStorage.setItem("online", JSON.stringify(this.valueOffline));
        this.online = this.valueOffline;
      } else {
        localStorage.setItem("online", JSON.stringify(this.valueOnline));
        this.online = this.valueOnline;
      }
    },
  },
};
</script>

<style scoped>
.toggle-outer {
  border-radius: 50px;
  color: #fff;
}
.toggle-outer:hover {
  cursor: pointer;
}
.toggle-outer:active {
  opacity: 0.7;
  cursor: pointer;
}
</style>