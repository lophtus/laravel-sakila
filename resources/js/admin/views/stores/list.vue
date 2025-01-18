<template>
  <div>
    <h2>Stores</h2>

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

      <template v-slot:cell(address)="row">
        {{ row.item.address }}
        <br />
        <span v-if="row.item.address2">
          {{ row.item.address2 }}
          <br />
        </span>
        {{ row.item.city }}, {{ row.item.state }} {{ row.item.postal_code }}
      </template>

      <template v-slot:cell(actions)="row">
        <b-button variant="primary" size="sm" :to="{name:'store-view', params: {id: row.item.id}}">
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

<script setup lang="ts">
import axios from "axios";
import { ref } from "vue";
import LoadingSpinner from "@/admin/components/LoadingSpinner.vue";
import CreateModal from "./components/CreateModal.vue";

const isBusy = ref(false);
const totalRows = ref(1);
const currentPage = ref(1);
const lastPage = ref(1);
const perPage = ref(30);
const fields = ["id", "address", "actions"];

const fetchData = async (ctx) => {
  isBusy.value = true;

  const promise = axios.get(
    "/stores?page[number]=" + ctx.currentPage + "&page[size]=" + ctx.perPage
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
