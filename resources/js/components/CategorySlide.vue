<template>
  <div
    class="d-flex justify-content-center border border-light"
    style="background-image: url('https://via.placeholder.com/300x150')"
    @click="onClick"
  >
    <div class="mt-auto">{{ category.name | truncate(25) }}</div>
  </div>
</template>

<script>
export default {
  name: "CategorySlide",
  props: {
    category: Object,
  },
  methods: {
    onClick: function () {
      const vm = this;
      vm.$emit("click");
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
