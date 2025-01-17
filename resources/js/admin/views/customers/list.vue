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

<script setup lang="ts">
import axios from "axios";
import { ref } from "vue";
import LoadingSpinner from "@/admin/components/LoadingSpinner.vue";

const isBusy = ref(false);
const totalRows = ref(1);
const currentPage = ref(1);
const lastPage = ref(1);
const perPage = ref(30);
const pageOptions = [10, 20, 30];
const filter = ref("");
const fields = ["id", "first_name", "last_name", "email", "actions"];
const customers = ref([]);

const fetchData = async (ctx) => {
  isBusy.value = true;

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

    currentPage.value = data.meta.current_page;
    lastPage.value = data.meta.last_page;
    totalRows.value = data.meta.total;

    isBusy.value = false;

    return items || [];
  });
}
</script>

<style scoped>
</style>
