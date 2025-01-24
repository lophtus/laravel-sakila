<template>
  <div>
    <CRow class="mb-4">
      <CCol>
        <CButton color="success" size="sm">
          <i class="far fa-plus-square"></i>
          Create
        </CButton>
      </CCol>
    </CRow>

    <CRow>
      <CCol>
        <CFormLabel for="filterInput">Filter</CFormLabel>
        <CInputGroup size="sm">
          <CFormInput
            v-model="filter"
            type="search"
            id="filterInput"
            placeholder="Type to Search"
            debounce="500"
          />
          <CButton :disabled="!filter" @click="filter = ''">Clear</CButton>
        </CInputGroup>
      </CCol>
      <CCol>
        <CFormLabel for="perPageSelect">Per page</CFormLabel>
        <CFormSelect v-model="perPage" id="perPageSelect" size="sm" :options="pageOptions" />
      </CCol>
    </CRow>

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

      <template v-slot:cell(name)="row">{{ row.item.first_name }} {{ row.item.last_name }}</template>

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
        <CButton
          color="primary"
          size="sm"
          :to="{name:'customer-view', params: {id: row.item.id}}"
        >
          <i class="far fa-edit"></i>
          View
        </CButton>
      </template>
    </b-table>

    <CRow>
      <CCol>Page {{ currentPage }} of {{ lastPage }} ({{ totalRows }} items)</CCol>
      <CCol>
        <b-pagination
          v-model="currentPage"
          :total-rows="totalRows"
          :per-page="perPage"
          align="right"
          size="sm"
        ></b-pagination>
      </CCol>
    </CRow>

    <CreateModal :store="store"></CreateModal>
  </div>
</template>

<script setup lang="ts">
import axios from "axios";
import { ref } from "vue";
import CreateModal from "../../customers/components/CreateModal.vue";
import LoadingSpinner from "@/admin/components/LoadingSpinner.vue";

const props = defineProps({
  store: Object
});

const isBusy = ref(false);
const totalRows = ref(1);
const currentPage = ref(1);
const lastPage = ref(1);
const perPage = ref(30);
const pageOptions = [10, 20, 30];
const filter = ref("");
const fields = ["id", "name", "email", "address", "actions"];

const fetchData = async (ctx) => {
  const promise = axios.get(
    "/stores/" +
      props.store.id +
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
