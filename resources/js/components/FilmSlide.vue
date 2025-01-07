<template>
  <div
    class="d-flex justify-content-center border border-light"
    style="background-image:url('https://via.placeholder.com/300x150')"
    @click="onClick"
  >
    <div class="mt-auto">{{ filmTitle }} ({{ filmReleaseYear }})</div>
  </div>
</template>

<script>
export default {
  name: "FilmSlide",
  props: {
    film: Object,
  },
  computed: {
    filmTitle() {
      return _.truncate(this.film.title, { length: 25 });
    },
    filmReleaseYear() {
      return this.film.release_year;
    },
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
