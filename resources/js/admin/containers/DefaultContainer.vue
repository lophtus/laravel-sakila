<template>
  <div class="c-app">
    <vue-progress-bar></vue-progress-bar>
    <DefaultSidebar />
    <div class="c-wrapper">
      <DefaultHeader />
      <div class="c-body">
        <main class="c-main">
          <CContainer fluid>
            <transition name="fade">
              <router-view></router-view>
            </transition>
          </CContainer>
        </main>
      </div>
      <DefaultFooter />
    </div>
  </div>
</template>

<script setup lang="ts">
import DefaultFooter from "./DefaultFooter.vue";
import DefaultHeader from "./DefaultHeader.vue";
import DefaultSidebar from "./DefaultSidebar.vue";
</script>

<style scoped>
</style>
