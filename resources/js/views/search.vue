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

<script>
import api from "@/api";
import FilmModal from "@/components/FilmModal";
import FilmSlide from "@/components/FilmSlide";

export default {
  name: "SearchView",
  components: {
    FilmModal,
    FilmSlide,
  },
  data() {
    return {
      search: "",
      isBusy: false,
      currentPage: 1,
      perPage: 12,
      items: [],
      currentItem: {},
      isModalVisible: false,
      canLoadMore: false,
      hasSearched: false,
    };
  },
  mounted() {
    const vm = this;
  },
  methods: {
    onSlideClick: function (film) {
      const vm = this;

      vm.currentItem = film;
      vm.isModalVisible = true;
    },
    onClose: function () {
      const vm = this;

      vm.currentItem = null;
      vm.isModalVisible = false;
    },
    clearSearch: function () {
      const vm = this;
      vm.search = "";
      vm.currentPage = 0;
      vm.items = [];
      vm.hasSearched = false;
    },
    onSubmit: function (evt) {
      evt.preventDefault();

      const vm = this;
      vm.items = [];
      vm.fetchData(vm.currentPage);
    },
    loadMore: function () {
      const vm = this;
      vm.fetchData(vm.currentPage + 1);
    },
    fetchData: function (page) {
      const vm = this;

      vm.isBusy = true;

      const promise = api.searchFilms(vm.search, page, vm.perPage);

      return promise.then(({ data }) => {
        data.data.forEach((element) => {
          vm.items.push(element);
        });

        vm.hasSearched = true;

        vm.currentPage = data.meta.current_page;

        vm.canLoadMore = false;

        if (data.links.next != null) {
          vm.canLoadMore = true;
        }

        vm.isBusy = false;

        return vm.items || [];
      });
    },
  },
};
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
