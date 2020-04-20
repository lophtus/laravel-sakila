<template>
  <div>
    <h2>Customers</h2>

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

      <template v-slot:cell(actions)="row">
        <b-button
          variant="primary"
          size="sm"
          :to="{name:'customer-view', params: {id: row.item.id}}"
        >
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
  </div>
</template>

<script>
import axios from "axios";
import LoadingSpinner from "../../components/LoadingSpinner";

export default {
  name: "CustomerList",
  components: {
    LoadingSpinner
  },
  data() {
    return {
      isBusy: false,
      totalRows: 1,
      currentPage: 1,
      lastPage: 1,
      perPage: 30,
      pageOptions: [10, 20, 30],
      filter: "",
      fields: ["id", "first_name", "last_name", "email", "actions"],
      customers: []
    };
  },
  methods: {
    async fetchData(ctx) {
      let vm = this;

      vm.isBusy = true;

      const promise = axios.get(
        "/customers?page[number]=" +
          ctx.currentPage +
          "&page[size]=" +
          ctx.perPage +
          "&filter[search]=" +
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
