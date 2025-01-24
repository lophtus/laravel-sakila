<template>
  <div>
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

      <template v-slot:cell(show_details)="row">
        <CButton size="sm" @click="row.toggleDetails" class="mr-2">
          <i :class="row.detailsShowing ? 'far fa-caret-square-up' : 'far fa-caret-square-down'"></i>
        </CButton>
      </template>

      <template v-slot:row-details="row">
        <b-card>
          <CRow>
            <CCol>
              <p>{{ row.item.description }}</p>

              <CRow>
                <CCol>Language</CCol>
                <CCol>{{ row.item.language }}</CCol>
              </CRow>
              <CRow>
                <CCol>Rating</CCol>
                <CCol>{{ row.item.rating }}</CCol>
              </CRow>
              <CRow>
                <CCol>Length</CCol>
                <CCol>{{ row.item.length }}</CCol>
              </CRow>
              <CRow>
                <CCol>Special Features</CCol>
                <CCol>{{ row.item.special_features }}</CCol>
              </CRow>
              <CRow>
                <CCol>Rental Duration</CCol>
                <CCol>{{ row.item.rental_duration }}</CCol>
              </CRow>
              <CRow>
                <CCol>Rental Rate</CCol>
                <CCol>{{ row.item.rental_rate }}</CCol>
              </CRow>
              <CRow>
                <CCol>Replacement Cost</CCol>
                <CCol>{{ row.item.replacement_cost }}</CCol>
              </CRow>
            </CCol>
            <CCol cols="auto">
              <CImage src="https://dummyimage.com/150x150/e/5.png" />
            </CCol>
          </CRow>
        </b-card>
      </template>

      <template v-slot:cell(actions)="row">
        <CButton
          color="primary"
          size="sm"
          :to="{name:'film-view', params: {id: row.item.id}}"
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
  </div>
</template>

<script setup lang="ts">
import axios from "axios";
import { ref } from "vue";
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
const fields = [
  "show_details",
  "id",
  "title",
  "release_year",
  "actions"
];

const fetchData = async (ctx) =>{
  const promise = axios.get(
    "/stores/" +
      props.store.id +
      "/films?page[number]=" +
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
