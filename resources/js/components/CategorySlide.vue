<template>
  <div
    class="d-flex justify-content-center border border-light"
    style="background-image: url('https://dummyimage.com/300x150/e/5.png')"
    @click="onClick"
  >
    <div class="mt-auto">{{ categoryName }}</div>
  </div>
</template>

<script setup lang="ts">
import { computed } from  "vue";

const props = defineProps({
  category: Object,
});

const emit = defineEmits([ 'click' ]);

const categoryName = computed(() => {
  return _.truncate(props.category.name, { length: 25 });
});

const onClick = () => {
  emit('click');
}
</script>

<style lang="scss" scoped>
</style>
