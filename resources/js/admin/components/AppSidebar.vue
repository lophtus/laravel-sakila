<template>
  <CSidebar
    position="fixed"
    :unfoldable="sidebarUnfoldable"
    :visible="sidebarVisible"
    @visible-change="
      (event) =>
        $store.commit({
          type: 'updateSidebarVisible',
          value: event,
        })
    "
  >
    <CSidebarBrand>
      <CIcon
        custom-class-name="sidebar-brand-full"
        :icon="logoNegative"
        :height="35"
      />
      <CIcon
        custom-class-name="sidebar-brand-narrow"
        :icon="sygnet"
        :height="35"
      />
    </CSidebarBrand>
    <AppSidebarNav />
    <CSidebarToggler
      class="d-none d-lg-flex"
      @click="$store.commit('toggleUnfoldable')"
    />
  </CSidebar>
</template>

<script setup lang="ts">
import { computed } from "vue";
import { useStore } from "vuex"
import { AppSidebarNav } from "./AppSidebarNav";
import { logoNegative } from "@/admin/assets/brand/logo-negative";
import { sygnet } from "@/admin/assets/brand/sygnet";

const store = useStore()

const sidebarUnfoldable = computed(() => store.state.sidebarUnfoldable);
const sidebarVisible = computed(() => store.state.sidebarVisible);
</script>
