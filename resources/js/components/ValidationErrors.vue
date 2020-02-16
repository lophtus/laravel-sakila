<template>
  <b-alert variant="danger" show>
    <ul class="my-0">
      <li v-for="(value, key) in validationErrors" :key="key">{{ value }}</li>
    </ul>
  </b-alert>
</template>

<script>
export default {
  props: {
    errors: null,
  },
  computed: {
    validationErrors() {
      let errors = Object.values(this.errors);
      errors = errors.flat();
      return errors;
    }
  }
};
</script>

<style scoped>
</style>
