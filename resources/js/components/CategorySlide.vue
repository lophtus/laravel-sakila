<template>
  <div
    class="d-flex justify-content-center border border-light"
    style="background-image: url('https://via.placeholder.com/300x150')"
    @click="onClick"
  >
    <div class="mt-auto">{{ categoryName }}</div>
  </div>
</template>

<script>
export default {
  name: "CategorySlide",
  props: {
    category: Object,
  },
  computed: {
    categoryName() {
      return _.truncate(this.category.name, { length: 25 });
    },
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
