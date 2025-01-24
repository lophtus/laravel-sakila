<template>
  <div>
    <CRow>
      <CCol>
        <h2>Inventory (#{{ inventory.id }})</h2>

        <router-link v-if="isLoaded" :to="{name: 'store-view', params: {id: store.id}}">{{ store.address }} {{ store.city }}, {{ store.state }} {{ store.postal_code }}</router-link>

        <h4>{{ film.title }} ({{ film.release_year }})</h4>

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
        <CImage src="https://dummyimage.com/300x300/e/5.png"></CImage>
      </CCol>
    </CRow>
  </div>
</template>

<script setup lang="ts">
import axios from "axios";
import { onBeforeMount, ref } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();

const isLoaded = ref(false);
const film = ref({});
const inventory = ref({});
const store = ref({});

onBeforeMount(() => {
    const promise = axios.get("/inventory/" + route.params.id + "?include=film,store");

    return promise.then(({ data }) => {
      const item = data.data;

      film.value = item.film || {};
      inventory.value = item || {};
      store.value = item.store || {};
      isLoaded.value = true;
    });
});
</script>

<style scoped>
</style>
