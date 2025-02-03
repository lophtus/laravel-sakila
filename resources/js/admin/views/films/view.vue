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

          <CButton color="danger" size="sm" @click="() => { showConfirm = true; }">
            <CIcon icon="cil-x-circle" /> Delete
          </CButton>
        </div>
      </CCardBody>
    </CCard>

    <ConfirmModal
      :visible="showConfirm"
      @closed="() => { showConfirm = false; }"
      @confirmed="onDelete"
    >
      Are you sure you want to delete '{{ film.title }} ({{ film.release_year }})'?
    </ConfirmModal>
  </div>
</template>

<script setup lang="ts">
import axios from "axios";
import { ref, watch } from "vue";
import { useRouter } from "vue-router";
import ConfirmModal from "@/admin/components/ConfirmModal.vue";
import useToast from "@/admin/composables/useToast";
import useNotFoundRedirect from "@/admin/composables/useNotFoundRedirect";
import { type EntityIdentifier, type FilmWithDefaults } from "@/admin/types";

const props = defineProps({
  id: {
    type: String,
    required: true,
  }
});

const router = useRouter();
const { redirectToNotFound } = useNotFoundRedirect();
const { toastError, toastSuccess } = useToast();

const isLoaded = ref(false);
const showConfirm = ref(false);
const film = ref<FilmWithDefaults>({});

const fetchData = (id: EntityIdentifier) => {
  const promise = axios.get("/films/" + id);

  promise.then(({ data }) => {
    film.value = data.data || {};
    isLoaded.value = true;
  }).catch((error) => {
    if (error.response) {
      if(error.response.status === 404) {
        redirectToNotFound();
      }
    }
  });
}

watch(() => props.id, fetchData, { immediate: true });

const onDelete = () => {
  const promise = axios.delete("/films/" + props.id);

  promise
    .then(({ data }) => {
      toastSuccess("Film was updated successfully");

      router.push({
        name: "film-list",
      });
    })
    .catch(error => {
      toastError("Failed to delete film");
    })
    .finally(() => {
      showConfirm.value = false;
    });
}
</script>

<style scoped>
</style>
