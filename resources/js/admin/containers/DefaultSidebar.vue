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

<script>
import nav from "./_nav";

export default {
  name: "DefaultSidebar",
  data() {
    return {
      minimize: false,
      nav,
      show: "responsive"
    };
  },
  mounted() {
    this.$root.$on("toggle-sidebar", () => {
      const sidebarOpened = this.show === true || this.show === "responsive";
      this.show = sidebarOpened ? false : "responsive";
    });
    this.$root.$on("toggle-sidebar-mobile", () => {
      const sidebarClosed = this.show === "responsive" || this.show === false;
      this.show = sidebarClosed ? true : "responsive";
    });
  }
};
</script>

<style scoped>
</style>
