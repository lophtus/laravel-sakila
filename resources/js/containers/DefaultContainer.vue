<template>
  <div>
    <div class="wrapper d-flex flex-column min-vh-100 bg-light">
      <div class="body flex-grow-1">
        <router-view :key="$route.path"></router-view>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
</script>

<style lang="scss" scoped>
</style>
