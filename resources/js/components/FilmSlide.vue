<template>
  <div
    class="d-flex justify-content-center border border-light"
    style="background-image:url('https://via.placeholder.com/300x150')"
    @click="onClick"
  >
    <div class="mt-auto">{{ film.title | truncate(25) }} ({{ film.release_year }})</div>
  </div>
</template>

<script>
export default {
  name: "FilmSlide",
  props: {
    film: Object,
  },
  methods: {
    onClick: function () {
      const vm = this;
      vm.$emit('click');
    }
  }
};
</script>

<style lang="scss" scoped>
</style>
