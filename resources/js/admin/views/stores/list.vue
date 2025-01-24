<template>
  <div>
    <h2>Stores</h2>

    <CRow class="mb-4">
      <CCol>
        <CButton color="success" size="sm">
          <CIcon icon="cil-plus" /> Create
        </CButton>
      </CCol>
    </CRow>

    <CRow class="mb-4">
      <CCol></CCol>
      <CCol>
        <CFormLabel for="perPageSelect">Per page</CFormLabel>
        <CFormSelect v-model="perPage" id="perPageSelect" size="sm" :options="pageOptions" />
      </CCol>
    </CRow>

    <CTable
      :columns="columns"
      striped
    >
      <CTableBody>
        <CTableRow v-if="isBusy">
          <CTableDataCell colSpan="5" v-c-placeholder="{animation: 'glow'}">
            <CPlaceholder :lg="12"></CPlaceholder>
          </CTableDataCell>
        </CTableRow>
        <CTableRow v-else v-for="item in items">
          <CTableDataCell>{{ item.id }}</CTableDataCell>
          <CTableDataCell>
            <address>
              <span class="d-block">{{ item.address }}</span>
              <span v-if="item.address2" class="d-block">{{ item.address2 }}</span>
              <span class="d-block">{{ item.city }}, {{ item.state }} {{ item.postal_code }}</span>
            </address>
          </CTableDataCell>
          <CTableDataCell>
            <router-link :to="{name:'store-view', params: {id: item.id}}">
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

    <CreateModal></CreateModal>
  </div>
</template>

<script setup lang="ts">
import axios from "axios";
import { computed, ComputedRef, onMounted, ref } from "vue";
import CreateModal from "./components/CreateModal.vue";

const isBusy = ref(false);
const totalRows = ref(1);
const currentPage = ref(1);
const lastPage = ref(1);
const perPage = ref("30");
const pageOptions = [
  { label: "10", value: "10" },
  { label: "20", value: "20" },
  { label: "30", value: "30" },
];
const pageCount: ComputedRef<number> = computed(() => {
  return Math.ceil(totalRows.value / parseInt(perPage.value));
});
const filter = ref("");
const columns = [
  "id",
  "address",
  "actions"
];
const items = ref([]);

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
    "/stores?page[number]=" +
      currentPage.value +
      "&page[size]=" +
      perPage.value
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
