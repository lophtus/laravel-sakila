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
          <CButton color="secondary" :disabled="!filter" @click="filter = ''">Clear</CButton>
        </CInputGroup>
      </CCol>
      <CCol>
        <CFormLabel for="perPageSelect">Per page</CFormLabel>
        <CFormSelect v-model="perPage" id="perPageSelect" size="sm" :options="pageOptions" />
      </CCol>
    </CRow>

    <CTable
      :columns="columns"
      hover
    >
      <CTableBody>
        <CTableRow v-if="isBusy">
          <CTableDataCell colSpan="5" v-c-placeholder="{animation: 'glow'}">
            <CPlaceholder :lg="12"></CPlaceholder>
          </CTableDataCell>
        </CTableRow>
        <CTableRow v-else v-for="item in items">
          <CTableDataCell>
            <CImage src="https://dummyimage.com/75x75/e/5.png" />
          </CTableDataCell>
          <CTableDataCell>{{ item.id }}</CTableDataCell>
          <CTableDataCell>{{ item.film?.title }}</CTableDataCell>
          <CTableDataCell>{{ item.film?.release_year }}</CTableDataCell>
          <CTableDataCell>{{ item.film?.rating }}</CTableDataCell>
          <CTableDataCell>
            <router-link :to="{name:'customer-view', params: {id: item.id}}">
              <CButton
                color="primary"
                size="sm"
              >
                <CIcon icon="cil-arrow-circle-right" /> View
              </CButton>
            </router-link>
          </CTableDataCell>
        </CTableRow>
      </CTableBody>
    </CTable>

    <CRow>
      <CCol>Page {{ currentPage }} of {{ lastPage }} ({{ totalRows }} items)</CCol>
      <CCol>
        <CPagination align="end">
          <CPaginationItem aria-label="Previous" @click="prevPage" :disabled="currentPage <= 1"><span aria-hidden="true">&laquo;</span></CPaginationItem>
          <template v-for="page in pageCount">
            <CPaginationItem :active="page === currentPage" @click="changePage(page)">{{ page }}</CPaginationItem>
          </template>
          <CPaginationItem aria-label="Next" @click="nextPage" :disabled="currentPage >= pageCount"><span aria-hidden="true">&raquo;</span></CPaginationItem>
        </CPagination>
      </CCol>
    </CRow>
  </div>
</template>

<script setup lang="ts">
import axios from "axios";
import { computed, ComputedRef, onMounted, PropType, ref } from "vue";
import { Inventory, Store } from "@/admin/types";

const props = defineProps({
  store: {
    type: Object as PropType<Store>,
    required: true,
  }
});

const isBusy = ref(false);
const totalRows = ref(1);
const currentPage = ref(1);
const lastPage = ref(1);
const perPage = ref("10");
const pageOptions = [
  { label: "10", value: "10"},
  { label: "20", value: "20" },
  { label: "30", value: "30" }
];
const pageCount: ComputedRef<number> = computed(() => {
  return Math.ceil(totalRows.value / parseInt(perPage.value));
});
const filter = ref("");
const columns = [
  "",
  "id",
  "title",
  "release_year",
  "rating",
  "actions"
];
const items = ref<Inventory[]>([]);

onMounted(() => {
  fetchData();
});

const changePage = (page: number) => {
  if (page > pageCount.value) {
    return;
  }

  currentPage.value = page;
  fetchData();
}

const nextPage = () => {
  changePage(++currentPage.value);
}

const prevPage = () => {
  changePage(--currentPage.value);
}

const fetchData = async () => {
  isBusy.value = true;

  const promise = axios.get(
    "/stores/" +
      props.store.id +
      "/inventory?page[number]=" +
      currentPage.value +
      "&page[size]=" +
      perPage.value +
      "&include=film" +
      "&filter[search]=" +
      filter.value
  );

  return promise.then(({ data }) => {
    const loadedItems = data.data;

    currentPage.value = data.meta.current_page;
    lastPage.value = data.meta.last_page;
    totalRows.value = data.meta.total;

    isBusy.value = false;

    items.value = loadedItems || [];
  });
}
</script>

<style scoped>
</style>
