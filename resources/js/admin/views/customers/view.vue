<template>
  <div>
    <h2>{{ customer.first_name }} {{ customer.last_name }} (#{{ customer.id }})</h2>

    <address>
      <span class="d-block">{{ customer.address }}</span>
      <span v-if="customer.address2" class="d-block">{{ customer.address2 }}</span>
      <span class="d-block">
        {{ customer.city }}, {{ customer.state }} {{ customer.country }} {{ customer.postal_code }}
      </span>
    </address>

    <CButton color="primary" size="sm">
      <CIcon icon="cil-pencil" /> Edit
    </CButton>
  </div>
</template>

<script setup lang="ts">
import axios from "axios";
import { onBeforeMount, ref } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();

const isLoaded = ref(false);
const customer = ref({});

onBeforeMount(() => {
  const promise = axios.get("/customers/" + route.params.id);

  return promise.then(({ data }) => {
    const item = data.data;

    customer.value = item || {};
    isLoaded.value = true;
  });
});
</script>

<style scoped>
</style>
