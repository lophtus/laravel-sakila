<template>
  <div>
    <CCard>
      <CCardHeader>{{ film.title }} ({{ film.release_year }})</CCardHeader>
      <CCardBody>
        <CRow>
          <CCol>
            <p>{{ film.description || "Description not available" }}</p>

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

        <div class="d-grid gap-1 d-md-flex justify-content-md-start mt-2">
          <router-link :to="{ name: 'film-edit', params: { id: film.id } }">
            <CButton color="primary" size="sm">
              <CIcon icon="cil-pencil" /> Edit
            </CButton>
          </router-link>

          <CButton color="danger" size="sm">
            <CIcon icon="cil-x-circle" /> Delete
          </CButton>
        </div>
      </CCardBody>
    </CCard>
  </div>
</template>

<script setup lang="ts">
import axios from "axios";
import { ref, watch } from "vue";
import { type EntityIdentifier, type FilmWithDefaults } from "@/admin/types";

const props = defineProps({
  id: {
    type: String,
    required: true,
  }
});

const isLoaded = ref(false);
const film = ref<FilmWithDefaults>({});

const fetchData = (id: EntityIdentifier) => {
  const promise = axios.get("/films/" + id);

  promise.then(({ data }) => {
    film.value = data.data || {};
    isLoaded.value = true;
  });
}

watch(() => props.id, fetchData, { immediate: true });
</script>

<style scoped>
</style>
