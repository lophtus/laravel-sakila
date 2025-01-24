<template>
  <div>
    <h2>Store (#{{ store.id }})</h2>

    <CRow>
      <CCol>
        <address>
          <span class="d-block">{{ store.address }}</span>
          <span v-if="store.address2" class="d-block">{{ store.address2 }}</span>
          <span class="d-block">{{ store.city }}, {{ store.state }} {{ store.country }} {{ store.postal_code }}</span>
        </address>
      </CCol>
      <CCol cols="auto">
        <CImage src="https://dummyimage.com/300x300/e/5.png"></CImage>
      </CCol>
    </CRow>

    <CButton color="primary" size="sm">
      <CIcon icon="cil-pencil" /> Edit
    </CButton>

    <CButton color="danger" size="sm">
      <CIcon icon="cil-x-circle" /> Delete
    </CButton>
  </div>
</template>

<script setup lang="ts">
import axios from "axios";
import { onBeforeMount, ref, watch } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();

const isRouted = ref(false);
const isLoaded = ref(false);
const store = ref({});

onBeforeMount(() => {
  watch(
    () => route.params.id,
    (newValue, oldValue) => {
      isRouted.value = true;

      fetchData(newValue);
    },
    { deep: true }
  );

  if (!isLoaded.value && !isRouted.value) {
    fetchData(route.params.id);
  }
});

const fetchData = (id) => {
  const promise = axios.get("/stores/" + id);

  promise.then(({ data }) => {
    store.value = data.data || {};
    isLoaded.value = true;
  });
}
</script>

<style scoped>
</style>
