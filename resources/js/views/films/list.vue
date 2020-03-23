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

    <b-row>
      <b-col>
        <b-form-group label="Filter">
          <b-input-group size="sm">
            <b-input
              v-model="filter"
              type="search"
              id="filterInput"
              placeholder="Type to Search"
              debounce="500"
            ></b-input>
            <b-input-group-append>
              <b-button :disabled="!filter" @click="filter = ''">Clear</b-button>
            </b-input-group-append>
          </b-input-group>
        </b-form-group>
      </b-col>
      <b-col>
        <b-form-group label="Per page">
          <b-select v-model="perPage" id="perPageSelect" size="sm" :options="pageOptions"></b-select>
        </b-form-group>
      </b-col>
    </b-row>

    <b-table
      :items="fetchData"
      :fields="fields"
      :current-page="currentPage"
      :per-page="perPage"
      :filter="filter"
      :busy="isBusy"
      show-empty
      striped
    >
      <template v-slot:table-busy>
        <LoadingSpinner />
      </template>

      <template v-slot:cell(show_details)="row">
        <b-button size="sm" @click="row.toggleDetails" class="mr-2">
          <i :class="row.detailsShowing ? 'far fa-caret-square-up' : 'far fa-caret-square-down'"></i>
        </b-button>
      </template>

      <template v-slot:row-details="row">
        <b-card>
          <b-row>
            <b-col>
              <p>{{ row.item.description }}</p>

              <b-row>
                <b-col>Language</b-col>
                <b-col>{{ row.item.language }}</b-col>
              </b-row>
              <b-row>
                <b-col>Rating</b-col>
                <b-col>{{ row.item.rating }}</b-col>
              </b-row>
              <b-row>
                <b-col>Length</b-col>
                <b-col>{{ row.item.length }}</b-col>
              </b-row>
              <b-row>
                <b-col>Special Features</b-col>
                <b-col>{{ row.item.special_features }}</b-col>
              </b-row>
              <b-row>
                <b-col>Rental Duration</b-col>
                <b-col>{{ row.item.rental_duration }}</b-col>
              </b-row>
              <b-row>
                <b-col>Rental Rate</b-col>
                <b-col>{{ row.item.rental_rate }}</b-col>
              </b-row>
              <b-row>
                <b-col>Replacement Cost</b-col>
                <b-col>{{ row.item.replacement_cost }}</b-col>
              </b-row>
            </b-col>
            <b-col cols="auto">
              <b-img src="https://via.placeholder.com/150x150"></b-img>
            </b-col>
          </b-row>
        </b-card>
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
      perPage: 10,
      pageOptions: [10, 20, 30],
      filter: "",
      fields: [
        "show_details",
        "id",
        "title",
        "release_year",
        "actions"
      ]
    };
  },
  methods: {
    async fetchData(ctx) {
      let vm = this;

      vm.isBusy = true;

      const promise = axios.get(
        "/films?page[number]=" +
          ctx.currentPage +
          "&page[size]=" +
          ctx.perPage +
          "&filter[title]=" +
          ctx.filter
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
