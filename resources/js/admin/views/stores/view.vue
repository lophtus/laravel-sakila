<template>
  <div>
    <CCard>
      <CCardHeader>Store #{{ store.id }}</CCardHeader>
      <CCardBody>
        <CSpinner v-if="!isLoaded" />

        <template v-else>
          <CRow>
            <CCol>
              Phone: {{  store.phone || "Not provided" }}
              <address>
                <span class="d-block">{{ store.address }}</span>
                <span v-if="store.address2" class="d-block">{{ store.address2 }}</span>
                <span class="d-block">{{ store.city }}, {{ store.state }} {{ store.country }} {{ store.postal_code }}</span>
              </address>
            </CCol>
            <CCol cols="auto">
              <CImage src="https://dummyimage.com/300x300/e/5.png"></CImage>
            </CCol>
          </CRow>

          <div class="d-grid gap-1 d-md-flex justify-content-md-start mt-2">
            <router-link :to="{ name: 'store-edit', params: { id: store.id } }">
              <CButton color="primary" size="sm">
                <CIcon icon="cil-pencil" /> Edit
              </CButton>
            </router-link>

            <CButton color="danger" size="sm" @click="() => { showConfirm = true; }">
              <CIcon icon="cil-x-circle" /> Delete
            </CButton>
          </div>
        </template>
      </CCardBody>
    </CCard>

    <Confirm
      :visible="showConfirm"
      @closed="() => { showConfirm = false; }"
      @confirmed="onDelete"
    >
      Are you sure you want to delete '{{ store.address }} (#{{ store.id }})'?
    </Confirm>
  </div>
</template>

<script setup lang="ts">
import axios from "axios";
import { ref, watch } from "vue";
import { useRouter } from "vue-router";
import { type EntityIdentifier, type StoreWithDefaults } from "@/admin/types";
import Confirm from "@/admin/components/Confirm.vue";
import { toastError, toastSuccess } from "@/admin/components/Toast";
import useNotFoundRedirect from "@/admin/composables/useNotFoundRedirect";

const props = defineProps({
  id: {
    type: String,
    required: true,
  }
});

const router = useRouter();
const { redirectToNotFound } = useNotFoundRedirect();

const isLoaded = ref(false);
const showConfirm = ref(false);
const store = ref<StoreWithDefaults>({});

const fetchData = (id: EntityIdentifier) => {
  const promise = axios.get("/stores/" + id);

  promise.then(({ data }) => {
    store.value = data.data || {};
    isLoaded.value = true;
  }).catch((error) => {
    if (error.response) {
      if(error.response.status === 404) {
        redirectToNotFound();
      }
    }
  });
}

watch(() => props.id, fetchData, { immediate: true });

const onDelete = () => {
  const promise = axios.delete("/films/" + props.id);

  promise
    .then(({ data }) => {
      toastSuccess("Store was updated successfully");

      router.push({
        name: "store-list",
      });
    })
    .catch(error => {
      toastError("Failed to delete store");
    })
    .finally(() => {
      showConfirm.value = false;
    });
}
</script>

<style scoped>
</style>
