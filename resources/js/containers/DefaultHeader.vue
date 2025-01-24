<template>
  <CHeader position="sticky" class="mb-4">
    <CContainer fluid>
      <CHeaderBrand class="mx-2">
        <CImage
          src="/img/brand/coreui-vue-logo.svg"
          width="190"
          height="46"
          alt="Sakila"
        />
      </CHeaderBrand>

      <CHeaderNav class="d-none d-md-flex me-auto">
        <CNavItem class="px-2">
          <router-link :to="{ name: 'dashboard' }" class="nav-link">
            Dashboard
          </router-link>
        </CNavItem>

        <CNavItem class="px-2">
          <router-link :to="{ name: 'browse' }" class="nav-link">
            Browse
          </router-link>
        </CNavItem>

        <CNavItem class="px-2">
          <router-link :to="{ name: 'search' }" class="nav-link">
            Search
          </router-link>
        </CNavItem>
      </CHeaderNav>

      <CHeaderNav>
        <CNavItem class="my-auto">
          {{ storeAddress }}
        </CNavItem>

        <CDropdown variant="nav-item">
          <CDropdownToggle placement="bottom-end" class="py-0" :caret="false">
            <CAvatar color="primary" class="fw-bold">{{ userInitials }}</CAvatar>
          </CDropdownToggle>

          <CDropdownMenu class="pt-0">
            <CDropdownHeader component="h6" class="bg-light fw-semibold py-2">
              Settings
            </CDropdownHeader>
            <CDropdownItem> <CIcon name="cil-user" /> Profile </CDropdownItem>
            <CDropdownItem> <CIcon name="cil-settings" /> Settings </CDropdownItem>
            <CDropdownItem>
              <CIcon name="cil-account-logout" />
              <router-link :to="{ name: 'logout' }"> Logout </router-link>
            </CDropdownItem>
          </CDropdownMenu>
        </CDropdown>
      </CHeaderNav>
    </CContainer>
  </CHeader>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

const storeAddress = computed(() => {
  return store.getters.user.store.address;
});

const userInitials = computed(() => {
  const user = store.getters.user;
  return user.first_name.substring(0, 1) + " " + user.last_name.substring(0, 1);
});
</script>

<style lang="scss" scoped>
.c-icon {
  margin-right: 0.3rem;
}
</style>
