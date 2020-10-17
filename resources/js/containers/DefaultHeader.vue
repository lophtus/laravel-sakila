<template>
  <CHeader fixed colorScheme="light">
    <CHeaderBrand class="d-md-none">
      <CImg
        src="/img/brand/coreui-signet.svg"
        width="55"
        height="55"
        alt="Sakila"
      />
    </CHeaderBrand>
    <CHeaderBrand class="mx-2 d-sm-down-none">
      <CImg
        src="/img/brand/coreui-vue-logo.svg"
        width="190"
        height="46"
        alt="Sakila"
      />
    </CHeaderBrand>

    <CHeaderNav class="mr-auto">
      <CHeaderNavItem class="px-2">
        <CHeaderNavLink :to="{ name: 'dashboard' }" activeClass="active">
          Dashboard
        </CHeaderNavLink>
      </CHeaderNavItem>

      <CHeaderNavItem class="px-2">
        <CHeaderNavLink :to="{ name: 'browse' }" activeClass="active">
          Browse
        </CHeaderNavLink>
      </CHeaderNavItem>

      <CHeaderNavItem class="px-2">
        <CHeaderNavLink :to="{ name: 'search' }" activeClass="active">
          Search
        </CHeaderNavLink>
      </CHeaderNavItem>
    </CHeaderNav>

    <CHeaderNav class="mr-4">
      <CHeaderNavItem>
        {{ $store.getters.user.store.address }}
      </CHeaderNavItem>

      <CDropdown
        inNav
        class="c-header-nav-items"
        placement="bottom-end"
        add-menu-classes="pt-0"
      >
        <template #toggler>
          <CHeaderNavLink>
            <vue-initials-img class="c-avatar" :name="customerName" />
          </CHeaderNavLink>
        </template>

        <CDropdownHeader class="text-center" color="light">
          <strong>Settings</strong>
        </CDropdownHeader>
        <CDropdownItem> <CIcon name="cil-user" /> Profile </CDropdownItem>
        <CDropdownItem> <CIcon name="cil-settings" /> Settings </CDropdownItem>
        <CDropdownItem>
          <CIcon name="cil-account-logout" />
          <CLink :to="{ name: 'logout' }"> Logout </CLink>
        </CDropdownItem>
      </CDropdown>
    </CHeaderNav>
  </CHeader>
</template>

<script>
export default {
  name: "DefaultHeader",
  computed: {
    customerName: function () {
      const vm = this;
      const user = vm.$store.getters.user;

      return user.first_name + " " + user.last_name;
    },
  },
};
</script>

<style lang="scss" scoped>
.c-icon {
  margin-right: 0.3rem;
}
</style>
