<template>
  <div>
    <div class="my-4">
      <div v-if="items.length">
        <b-row v-for="item in items" :key="item.id">
          <b-col>
            <CategoryDashboardWidget :category="item" @click="onSlideClick"></CategoryDashboardWidget>
          </b-col>
        </b-row>
      </div>

      <div v-else-if="isBusy">
        <b-spinner></b-spinner>
      </div>

      <div v-else>
        <p>No results found</p>
      </div>
    </div>

    <FilmModal v-if="currentItem" :visible="isModalVisible" :filmId="currentItem.id" @close="onModalClose"></FilmModal>

  </div>
</template>

<script>
import api from "@/api";
import CategoryDashboardWidget from "@/components/CategoryDashboardWidget";
import FilmModal from "@/components/FilmModal";

export default {
  name: "DashboardView",
  components: {
    CategoryDashboardWidget,
    FilmModal,
  },
  data() {
    return {
      isBusy: false,
      currentItem: {},
      items: [],
      isModalVisible: false,
    };
  },
  mounted() {
    const vm = this;

    this.fetchData();
  },
  methods: {
    fetchData: function () {
      const vm = this;

      vm.isBusy = true;

      const promise = api.getSuggestions();

      return promise.then(({ data }) => {
        vm.items = data.data;

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
    }
  },
};
</script>

<style lang="scss" scoped>
</style>
