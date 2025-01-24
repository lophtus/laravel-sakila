<template>
  <div>
    <CRow>
      <CCol>
        <h2>{{ film.title }} ({{ film.release_year }})</h2>

        <p>{{ film.description }}</p>

        <CRow>
          <CCol>Length</CCol>
          <CCol>{{ film.length }}</CCol>
        </CRow>
        <CRow>
          <CCol>Rating</CCol>
          <CCol>{{ film.rating }}</CCol>
        </CRow>
        <CRow>
          <CCol>Special Features</CCol>
          <CCol>{{ film.special_features }}</CCol>
        </CRow>
        <CRow>
          <CCol>Rental Duration</CCol>
          <CCol>{{ film.rental_duration }}</CCol>
        </CRow>
        <CRow>
          <CCol>Rental Rate</CCol>
          <CCol>{{ film.rental_rate }}</CCol>
        </CRow>
        <CRow>
          <CCol>Replacement Cost</CCol>
          <CCol>{{ film.replacement_cost }}</CCol>
        </CRow>
      </CCol>
      <CCol cols="auto">
        <CImage src="https://dummyimage.com/300x300/e/5.png" />
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
import { onBeforeMount, ref } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();

const isLoaded = ref(false);
const film = ref({});

onBeforeMount(() => {
  const promise = axios.get("/films/" + route.params.id);

  return promise.then(({ data }) => {
    const item = data.data;

    film.value = item || {};
    isLoaded.value = true;
  });
});
</script>

<style scoped>
</style>
