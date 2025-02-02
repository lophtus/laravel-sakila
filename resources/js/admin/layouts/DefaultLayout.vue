<template>
  <div>
    <AppSidebar />
    <div class="wrapper d-flex flex-column min-vh-100 bg-light">
      <AppHeader />
      <div class="body flex-grow-1 px-3">
        <CContainer lg>
          <router-view />
        </CContainer>
      </div>
      <AppFooter />
    </div>
  </div>
</template>
<script setup lang="ts">
import AppFooter from "@/admin/components/AppFooter.vue";
import AppHeader from "@/admin/components/AppHeader.vue";
import AppSidebar from "@/admin/components/AppSidebar.vue";
</script>
