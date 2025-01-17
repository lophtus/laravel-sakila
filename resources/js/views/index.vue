<template>
  <div>
    <DefaultHeader />

    <CContainer fluid>
      <router-view class="mt-2"></router-view>
    </CContainer>
  </div>
</template>

<script setup lang="ts">
import DefaultHeader from "@/containers/DefaultHeader.vue";

</script>

<style lang="scss" scoped>
</style>
