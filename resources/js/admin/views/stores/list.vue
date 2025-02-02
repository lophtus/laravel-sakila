<template>
  <div>
    <div class="d-grid gap-1 d-md-flex justify-content-md-end mb-2">
      <router-link :to="{ name: 'store-create' }">
        <CButton color="success" size="sm">
          <CIcon icon="cil-plus" /> Create
        </CButton>
      </router-link>
    </div>

    <CCard>
      <CCardHeader>Stores</CCardHeader>
      <CCardBody>

        <CRow class="mb-4">
          <CCol></CCol>
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
              <CTableDataCell colSpan="6" v-c-placeholder="{animation: 'glow'}">
                <CPlaceholder :lg="12"></CPlaceholder>
              </CTableDataCell>
            </CTableRow>
            <CTableRow v-else v-for="item in items">
              <CTableDataCell>{{ item.id }}</CTableDataCell>
              <CTableDataCell>
                <span class="d-block">{{ item.address }}</span>
                <span v-if="item.address2" class="d-block">{{ item.address2 }}</span>
              </CTableDataCell>
              <CTableDataCell>{{ item.city }}</CTableDataCell>
              <CTableDataCell>{{ item.state }}</CTableDataCell>
              <CTableDataCell>{{ item.postal_code }}</CTableDataCell>
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

      </CCardBody>
    </CCard>
  </div>
</template>

<script setup lang="ts">
import axios from "axios";
import { computed, ComputedRef, onMounted, ref } from "vue";
import { type Store } from "@/admin/types";

const isBusy = ref(false);
const totalRows = ref(1);
const currentPage = ref(1);
const lastPage = ref(1);
const perPage = ref("10");
const pageOptions = [
  { label: "10", value: "10" },
  { label: "20", value: "20" },
  { label: "30", value: "30" },
];
const pageCount: ComputedRef<number> = computed(() => {
  return Math.ceil(totalRows.value / parseInt(perPage.value));
});
const columns = [
  "id",
  "address",
  "city",
  "state",
  "postal_code",
  "actions"
];
const items = ref<Store[]>([]);

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
