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
        <b-img src="https://via.placeholder.com/300x300"></b-img>
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

<script>
import api from "@/api";

export default {
  name: "FilmModal",
  props: {
    filmId: Number,
    visible: Boolean,
  },
  data() {
    return {
      isBusy: false,
      isReserving: false,
      isUnavailable: false,
      rental: null,
      inStock: false,
      film: {},
    };
  },
  computed: {
    modalTitle: function () {
      const vm = this;

      return vm.isBusy
        ? "Loading..."
        : vm.film.title + " (" + vm.film.release_year + ")";
    },
  },
  methods: {
    onModalShow: function () {
      const vm = this;

      vm.isBusy = false;
      vm.isReserving = false;
      vm.isUnavailable = false;
      vm.rental = null;

      vm.fetchData(vm.filmId).then(() => {
        vm.inStock = vm.checkInStock(vm.film);
      });
    },
    onModalClose: function () {
      const vm = this;

      vm.$emit("close");
    },
    checkInStock: function (film) {
      const vm = this;

      if (!film || !film.in_stock_inventory) {
        return false;
      }

      return (
        film.in_stock_inventory.filter((inventory) => {
          return inventory.store.id == vm.$store.getters.user.store.id;
        }).length > 0
      );
    },
    fetchData: function (filmId) {
      const vm = this;

      vm.isBusy = true;

      const promise = api.getFilm(filmId, "in_stock_inventory.store");

      return promise.then(({ data }) => {
        vm.film = data.data;

        vm.isBusy = false;

        return vm.film || [];
      });
    },
    doReserve: function (film) {
      const vm = this;

      vm.isReserving = true;

      const promise = api.reserveFilm(film.id, vm.$activeStore);

      return promise
        .then(({ data }) => {
          vm.rental = data.data;

          vm.isReserving = false;

          return vm.rental || {};
        })
        .catch(({ err }) => {
          vm.isReserving = false;
          vm.isUnavailable = true;
        });
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
