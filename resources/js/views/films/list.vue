<template>
  <div>
    <h2>Films</h2>

    <b-row class="mb-4">
      <b-col>
        <b-button variant="success" size="sm" v-b-modal.create-modal>
          <i class="far fa-plus-square"></i>
          Create
        </b-button>
      </b-col>
    </b-row>

    <b-table
      :items="fetchData"
      :fields="fields"
      :current-page="currentPage"
      :per-page="perPage"
      :busy="isBusy"
      show-empty
      striped
    >
      <template v-slot:table-busy>
        <LoadingSpinner />
      </template>

      <template v-slot:cell(actions)="row">
        <b-button variant="primary" size="sm" :to="{name:'film-view', params: {id: row.item.id}}">
          <i class="far fa-edit"></i>
          View
        </b-button>
      </template>
    </b-table>

    <b-row>
      <b-col>Page {{ currentPage }} of {{ lastPage }} ({{ totalRows }} items)</b-col>
      <b-col>
        <b-pagination
          v-model="currentPage"
          :total-rows="totalRows"
          :per-page="perPage"
          align="right"
          size="sm"
        ></b-pagination>
      </b-col>
    </b-row>

    <CreateModal></CreateModal>
  </div>
</template>

<script>
import axios from "axios";
import LoadingSpinner from "../../components/LoadingSpinner";
import CreateModal from "./components/CreateModal";

export default {
  name: "FilmList",
  components: {
    LoadingSpinner,
    CreateModal
  },
  data() {
    return {
      isBusy: false,
      totalRows: 1,
      currentPage: 1,
      lastPage: 1,
      perPage: 30,
      fields: ["id", "title", "release_year", "length", "rating", "actions"],
      films: []
    };
  },
  methods: {
    async fetchData(ctx) {
      let vm = this;

      vm.isBusy = true;

      const promise = axios.get(
        "/films?page[number]=" + ctx.currentPage + "&page[size]=" + ctx.perPage
      );

      return promise.then(({ data }) => {
        const items = data.data;

        vm.currentPage = data.meta.current_page;
        vm.lastPage = data.meta.last_page;
        vm.totalRows = data.meta.total;

        vm.isBusy = false;

        return items || [];
      });
    }
  }
};
</script>

<style scoped>
</style>
