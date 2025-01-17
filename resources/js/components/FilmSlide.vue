<template>
  <div
    class="d-flex justify-content-center border border-light"
    style="background-image:url('https://dummyimage.com/300x150/e/5.png')"
    @click="onClick"
  >
    <div class="mt-auto">{{ filmTitle }} ({{ filmReleaseYear }})</div>
  </div>
</template>

<script setup type="ts">
import { computed } from 'vue';

const props = defineProps({
  film: Object,
});

const emit = defineEmits([ 'click' ]);

const filmTitle = computed(() => {
  return _.truncate(props.film.title, { length: 25 });
});

const filmReleaseYear = computed(() => {
  return props.film.release_year;
});

const onClick = () => {
  emit('click');
}
</script>

<style lang="scss" scoped>
</style>
