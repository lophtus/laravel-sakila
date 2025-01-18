<template>
  <div>
    <b-form @submit="onSubmit($event)">
      <b-input-group size="lg">
        <b-input v-model="search" class="form-control" />

        <b-input-group-append>
          <b-button variant="success" type="submit">Search</b-button>
          <b-button variant="danger" @click="clearSearch()">Clear</b-button>
        </b-input-group-append>
      </b-input-group>
    </b-form>

    <div class="my-4">
      <template v-if="hasSearched">
        <b-row v-if="items.length">
          <b-col class="card-grid">
            <FilmSlide
              v-for="item in items"
              :key="item.id"
              v-bind:film="item"
              class="card-slide"
              @click="onSlideClick(item)"
            ></FilmSlide>
          </b-col>
        </b-row>

        <div v-else-if="!isBusy">
          <p>No results found</p>
        </div>

        <b-row v-if="canLoadMore">
          <b-col class="text-center">
            <b-button variant="dark" @click="loadMore()">Load More</b-button>
          </b-col>
        </b-row>
      </template>

      <b-spinner v-show="isBusy"></b-spinner>
    </div>

    <FilmModal
      v-if="currentItem"
      :visible="isModalVisible"
      :filmId="currentItem.id"
      @close="onClose"
    ></FilmModal>
  </div>
</template>

<script setup lang="ts">
import api from "@/api";
import FilmModal from "@/components/FilmModal";
import FilmSlide from "@/components/FilmSlide";
import { ref } from "vue";

const search = ref("");
const isBusy = ref(false);
const currentPage = ref(1);
const perPage = 12;
const items = ref([]);
const currentItem = ref({});
const isModalVisible = ref(false);
const canLoadMore = ref(false);
const hasSearched = ref(false);

const onSlideClick = (film) => {
  currentItem.value = film;
  isModalVisible.value = true;
}

const onClose = () => {
  currentItem.value = null;
  isModalVisible.value = false;
}

const clearSearch = () => {
  search.value = "";
  currentPage.value = 0;
  items.value = [];
  hasSearched.value = false;
}

const onSubmit = (evt) => {
  evt.preventDefault();

  items.value = [];
  fetchData(currentPage.value);
}

const loadMore = () => {
  const vm = this;
  vm.fetchData(vm.currentPage + 1);
}

const fetchData = (page) => {
  isBusy.value = true;

  const promise = api.searchFilms(search.value, page, perPage);

  return promise.then(({ data }) => {
    data.data.forEach((element) => {
      items.value.push(element);
    });

    hasSearched.value = true;

    currentPage.value = data.meta.current_page;

    canLoadMore.value = false;

    if (data.links.next != null) {
      canLoadMore.value = true;
    }

    isBusy.value = false;

    return items.value || [];
  });
}
</script>

<style lang="scss" scoped>
.card-grid {
  display: grid;
  justify-items: left;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  grid-gap: 0;
  grid-row-gap: 0;
}

$itemGrow: 1.2;
$duration: 250ms;

.card-slide {
  width: 300px;
  height: 150px;
  margin: 30px 0;
  transition: $duration all;

  &:hover {
    z-index: 9999;
    transform: scale($itemGrow);
  }
}
</style>
