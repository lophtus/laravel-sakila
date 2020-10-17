<template>
  <div class="c-app">
    <div class="c-wrapper">
      <div class="c-body">
        <main class="c-main p-0">
          <router-view :key="$route.path"></router-view>
        </main>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "DefaultContainer",
};
</script>

<style lang="scss" scoped>
</style>
