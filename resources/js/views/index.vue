<template>
  <div>
    <DefaultHeader />

    <CContainer fluid>
      <router-view class="mt-2"></router-view>
    </CContainer>
  </div>
</template>

<script>
import DefaultHeader from "@/containers/DefaultHeader";

export default {
  name: "IndexView",
  components: {
    DefaultHeader,
  }
};
</script>

<style lang="scss" scoped>
</style>
