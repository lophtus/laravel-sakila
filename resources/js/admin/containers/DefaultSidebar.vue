<template>
  <CSidebar fixed :minimize="minimize" :show.sync="show">
    <CSidebarBrand class="d-md-down-none" to="/">
      <CImg class="c-sidebar-brand-full" width="118" height="46" src="/img/brand/coreui-base-white.svg" />
      <CImg class="c-sidebar-brand-minimized" width="118" height="46" src="/img/brand/coreui-signet-white.svg" />
    </CSidebarBrand>
    <CRenderFunction flat :content-to-render="nav" />
    <CSidebarMinimizer class="d-md-down-none" @click.native="minimize = !minimize" />
  </CSidebar>
</template>

<script setup lang="ts">
import { getCurrentInstance, onMounted, ref } from "vue";
import nav from "./_nav";

const { proxy } = getCurrentInstance();

const minimize = ref(false);
const show = ref("responsive");

onMounted(() => {
  proxy.$on("toggle-sidebar", () => {
    const sidebarOpened = show.value === true || show.value === "responsive";
    show.value = sidebarOpened ? false : "responsive";
  });
  proxy.$on("toggle-sidebar-mobile", () => {
    const sidebarClosed = show.value === "responsive" || show.value === false;
    show.value = sidebarClosed ? true : "responsive";
  });
});
</script>

<style scoped>
</style>
