<template>
  <div>
    <h1>{{ pageTitle }}</h1>

    <div>
      <template v-if="isLoaded">
        <b-row v-if="items.length">
          <b-col class="card-grid">
            <FilmSlide
              v-for="item in items"
              :key="item.id"
              v-bind:film="item"
              class="swiper-slide"
              @click="onSlideClick(item)"
            ></FilmSlide>
          </b-col>
        </b-row>

        <b-row v-else-if="! isBusy">
          <b-col>
            <p>No results found</p>
          </b-col>
        </b-row>

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
      @close="onModalClose"
    ></FilmModal>
  </div>
</template>

<script>
import api from "@/api";
import FilmModal from "@/components/FilmModal";
import FilmSlide from "@/components/FilmSlide";

let isRouted = false;

export default {
  name: "BrowseByCategoryView",
    components: {
    FilmModal,
    FilmSlide,
  },
  data() {
    return {
      isLoaded: false,
      isBusy: false,
      currentPage: 1,
      perPage: 12,
      category: {},
      items: [],
      currentItem: {},
      isModalVisible: false,
      canLoadMore: false,
    };
  },
  computed: {
    pageTitle: function () {
      const vm = this;

      return !vm.isLoaded ? "Loading" : vm.category.name;
    },
  },
  beforeRouteEnter(to, from, next) {
    const promise = api.getCategory(to.params.id);

    isRouted = true;

    return promise
      .then(({ data }) => {
        const category = data.data;

        next((vm) => {
          vm.category = category;
          vm.isLoaded = true;
          vm.fetchData(vm.currentPage);
        });
      })
      .catch(() => {
        next({ name: "not-found" });
      });
  },
  created() {
    const vm = this;

    if (!vm.isLoaded && !isRouted) {
      vm.init(vm.$route.params.id);
    }
  },
  methods: {
    init: function (id) {
      const vm = this;

      const promise = api.getCategory(id);

      return promise.then(({ data }) => {
        vm.category = data.data;
        vm.isLoaded = true;
        vm.fetchData(vm.currentPage);
      });
    },
    loadMore: function () {
      const vm = this;
      vm.fetchData(vm.currentPage + 1);
    },
    fetchData: function (page) {
      const vm = this;

      const promise = api.getFilmsByCategory(vm.category.id, page, vm.perPage);

      vm.isBusy = true;

      return promise.then(({ data }) => {
        data.data.forEach((element) => {
          vm.items.push(element);
        });

        vm.currentPage = data.meta.current_page;

        vm.canLoadMore = false;

        if (data.links.next != null) {
          vm.canLoadMore = true;
        }

        vm.isBusy = false;

        return vm.items || [];
      });
    },
    onSlideClick: function (film) {
      const vm = this;

      vm.currentItem = film;
      vm.isModalVisible = true;
    },
    onModalClose: function () {
      const vm = this;

      vm.currentItem = null;
      vm.isModalVisible = false;
    },
  },
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

.swiper-slide {
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
