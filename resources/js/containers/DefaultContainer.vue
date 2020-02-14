<template>
  <div class="c-app">
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

<script>
import DefaultFooter from "./DefaultFooter";
import DefaultHeader from "./DefaultHeader";
import DefaultSidebar from "./DefaultSidebar";

export default {
  name: "DefaultContainer",
  components: {
    DefaultFooter,
    DefaultHeader,
    DefaultSidebar
  }
};
</script>

<style scoped>
</style>
