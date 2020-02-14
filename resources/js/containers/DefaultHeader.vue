<template>
  <CHeader fixed light>
    <CToggler in-header class="ml-3 d-lg-none" v-c-emit-root-event:toggle-sidebar-mobile />
    <CToggler in-header class="ml-3 d-md-down-none" v-c-emit-root-event:toggle-sidebar />
    <CHeaderBrand
      class="mx-auto d-lg-none"
      src="/img/brand/coreui-vue-logo.svg"
      width="190"
      height="46"
      alt="CoreUI Logo"
    />
    <CHeaderNav class="ml-auto mr-4">
      <CHeaderNavItem class="d-md-down-none mx-2">
        <CHeaderNavLink>
          <CIcon name="cil-bell" />
        </CHeaderNavLink>
      </CHeaderNavItem>
      <CHeaderNavItem class="d-md-down-none mx-2">
        <CHeaderNavLink>
          <CIcon name="cil-list" />
        </CHeaderNavLink>
      </CHeaderNavItem>
      <CHeaderNavItem class="d-md-down-none mx-2">
        <CHeaderNavLink>
          <CIcon name="cil-envelope-open" />
        </CHeaderNavLink>
      </CHeaderNavItem>
    </CHeaderNav>
  </CHeader>
</template>

<script>
export default {
  name: "DefaultHeader"
};
</script>

<style scoped>
</style>
