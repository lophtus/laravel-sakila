<template>
  <b-alert variant="danger" show>
    <ul class="my-0">
      <li v-for="(value, key) in validationErrors" :key="key">{{ value }}</li>
    </ul>
  </b-alert>
</template>

<script setup lang="ts">
import { computed } from "vue";

const props = defineProps({
  errors: null,
});

const validationErrors = computed(() => {
  let errors = Object.values(props.errors);
  errors = errors.flat();
  return errors;
});
</script>

<style scoped>
</style>
