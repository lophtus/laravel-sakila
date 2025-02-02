<template>
  <div>
    <CCard>
      <CCardHeader>Inventory (#{{ inventory.id }})</CCardHeader>
      <CCardBody>
        <CRow>
          <CCol>
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
      </CCardBody>
    </CCard>
  </div>
</template>

<script setup lang="ts">
import axios from "axios";
import { ref, watch } from "vue";
import { type EntityIdentifier, type FilmWithDefaults, type InventoryWithDefaults, type StoreWithDefaults } from "@/admin/types";

const props = defineProps({
  id: {
    type: String,
    required: true,
  }
});

const isLoaded = ref(false);
const film = ref<FilmWithDefaults>({});
const inventory = ref<InventoryWithDefaults>({});
const store = ref<StoreWithDefaults>({});

const fetchData = (id: EntityIdentifier) => {
  const promise = axios.get("/inventory/" + id + "?include=film,store");

  promise.then(({ data }) => {
    const item = data.data;

    film.value = item.film || {};
    inventory.value = item || {};
    store.value = item.store || {};
    isLoaded.value = true;
  });
}

watch(() => props.id, fetchData, { immediate: true });
</script>

<style scoped>
</style>
