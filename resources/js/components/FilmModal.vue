<template>
  <CModal
    size="lg"
    :visible="visible"
    @show="onModalShow"
    @close="onModalClose"
  >
    <CModalHeader>
      <CModalTitle>{{ modalTitle }}</CModalTitle>
    </CModalHeader>

    <CModalBody>
      <CSpinner v-if="isBusy"></CSpinner>

      <CRow v-show="!isBusy">
        <CCol cols="auto">
          <CImage src="https://dummyimage.com/300x300/e/5.png"></CImage>
        </CCol>
        <CCol>
          <CRow class="h-100">
            <CCol class="d-flex flex-column">
              <CAlert color="danger" :show="!inStock"
                >This title is not available at the selected store.</CAlert
              >

              <p v-if="film.description">{{ film.description }}</p>

              <CRow v-if="film.rating">
                <CCol>Rating</CCol>
                <CCol>{{ film.rating }}</CCol>
              </CRow>
              <CRow v-if="film.length">
                <CCol>Length</CCol>
                <CCol>{{ film.length }}</CCol>
              </CRow>
              <CRow v-if="film.language">
                <CCol>Language</CCol>
                <CCol>{{ film.language }}</CCol>
              </CRow>
              <CRow v-if="film.original_language">
                <CCol>Original Language</CCol>
                <CCol>{{ film.original_language }}</CCol>
              </CRow>
              <CRow v-if="film.special_features">
                <CCol>Special Features</CCol>
                <CCol>{{ film.special_features }}</CCol>
              </CRow>
              <CRow>
                <CCol>Rental</CCol>
                <CCol
                  >${{ film.rental_rate }} /
                  {{ film.rental_duration }} days</CCol
                >
              </CRow>

              <div v-if="inStock" class="mt-auto">
                <div v-if="!rental">
                  <CButton
                    v-if="!isUnavailable"
                    color="success"
                    block
                    @click="doReserve(film)"
                  >
                    <CSpinner v-if="isReserving" small></CSpinner>Reserve Now!
                  </CButton>

                  <div v-if="isUnavailable">
                    <CAlert color="danger" class="my-0" show
                      >This title is currently unavailable.</CAlert
                    >
                  </div>
                </div>

                <div v-else>
                  <CAlert color="success" class="my-0" show
                    >Your reservation request was processed successfully.</CAlert
                  >
                </div>
              </div>

              <div v-else>
                This is in stock at the following locations.

                <CRow
                  v-for="inventory in film.in_stock_inventory"
                  :key="inventory.id"
                >
                  <CCol>{{ inventory.store.address }}</CCol>
                </CRow>
              </div>
            </CCol>
          </CRow>
        </CCol>
      </CRow>
    </CModalBody>
  </CModal>
</template>

<script setup lang="ts">
import api from "@/api";
import { computed, ref } from 'vue';
import { useStore } from "vuex";

const props = defineProps({
  filmId: Number,
  visible: Boolean,
});

const emit = defineEmits([ 'close' ]);

const store = useStore();

const isBusy = ref(false);
const isReserving = ref(false);
const isUnavailable = ref(false);
const rental = ref(null);
const inStock = ref(false);
const film = ref({});

const modalTitle = computed(() => {
  return isBusy.value
    ? "Loading..."
    : film.value.title + " (" + film.value.release_year + ")";
});

const onModalShow = () => {
  isBusy.value = false;
  isReserving.value = false;
  isUnavailable.value = false;
  rental.value = null;

  fetchData(props.filmId).then(() => {
    inStock.value = checkInStock(film.value);
  });
}

const onModalClose = () => {
    emit('close');
}

const checkInStock = (film) => {
  if (!film.value || !film.value.in_stock_inventory) {
    return false;
  }

  return (
    film.value.in_stock_inventory.filter((inventory) => {
      return inventory.store.id == store.getters.user.store.id;
    }).length > 0
  );
}

const fetchData = (filmId) => {
  isBusy.value = true;

  const promise = api.getFilm(filmId, "inStockInventory.store");

  return promise.then(({ data }) => {
    film.value = data.data;

    isBusy.value = false;

    return film.value || [];
  });
}

const doReserve = (film) => {
  isReserving.value = true;

  const promise = api.reserveFilm(film.id, store.getters.user.store.id);

  return promise
    .then(({ data }) => {
      rental.value = data.data;

      isReserving.value = false;

      return rental.value || {};
    })
    .catch(({ err }) => {
      isReserving.value = false;
      isUnavailable.value = true;
    });
}
</script>

<style lang="scss" scoped>
</style>
