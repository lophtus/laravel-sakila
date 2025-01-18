<template>
  <b-modal
    ref="film-modal"
    id="film-modal"
    :title="modalTitle"
    size="lg"
    hide-footer
    :visible="visible"
    @show="onModalShow"
    @hide="onModalClose"
    @close="onModalClose"
  >
    <b-spinner v-if="isBusy"></b-spinner>

    <b-row v-show="!isBusy">
      <b-col cols="auto">
        <b-img src="https://dummyimage.com/300x300/e/5.png"></b-img>
      </b-col>
      <b-col>
        <b-row class="h-100">
          <b-col class="d-flex flex-column">
            <b-alert variant="danger" :show="!inStock"
              >This title is not available at the selected store.</b-alert
            >

            <p v-if="film.description">{{ film.description }}</p>

            <b-row v-if="film.rating">
              <b-col>Rating</b-col>
              <b-col>{{ film.rating }}</b-col>
            </b-row>
            <b-row v-if="film.length">
              <b-col>Length</b-col>
              <b-col>{{ film.length }}</b-col>
            </b-row>
            <b-row v-if="film.language">
              <b-col>Language</b-col>
              <b-col>{{ film.language }}</b-col>
            </b-row>
            <b-row v-if="film.original_language">
              <b-col>Original Language</b-col>
              <b-col>{{ film.original_language }}</b-col>
            </b-row>
            <b-row v-if="film.special_features">
              <b-col>Special Features</b-col>
              <b-col>{{ film.special_features }}</b-col>
            </b-row>
            <b-row>
              <b-col>Rental</b-col>
              <b-col
                >${{ film.rental_rate }} /
                {{ film.rental_duration }} days</b-col
              >
            </b-row>

            <div v-if="inStock" class="mt-auto">
              <div v-if="!rental">
                <b-button
                  v-if="!isUnavailable"
                  variant="success"
                  block
                  @click="doReserve(film)"
                >
                  <b-spinner v-if="isReserving" small></b-spinner>Reserve Now!
                </b-button>

                <div v-if="isUnavailable">
                  <b-alert variant="danger" class="my-0" show
                    >This title is currently unavailable.</b-alert
                  >
                </div>
              </div>

              <div v-else>
                <b-alert variant="success" class="my-0" show
                  >Your reservation request was processed successfully.</b-alert
                >
              </div>
            </div>

            <div v-else>
              This is in stock at the following locations.

              <b-row
                v-for="inventory in film.in_stock_inventory"
                :key="inventory.id"
              >
                <b-col>{{ inventory.store.address }}</b-col>
              </b-row>
            </div>
          </b-col>
        </b-row>
      </b-col>
    </b-row>
  </b-modal>
</template>

<script setup lang="ts">
import api from "@/api";
import { useStore } from "@/store.js";
import { computed, ref } from 'vue';

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
