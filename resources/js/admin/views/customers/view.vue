<template>
  <div>
    <CCard>
      <CCardHeader>{{ customer.first_name }} {{ customer.last_name }} (#{{ customer.id }})</CCardHeader>
      <CCardBody>
        <CSpinner v-if="!isLoaded" />

        <template v-else>
          Email: {{ customer.email || "Not provided" }}

          <address>
            <span class="d-block">{{ customer.address }}</span>
            <span v-if="customer.address2" class="d-block">{{ customer.address2 }}</span>
            <span class="d-block">
              {{ customer.city }}, {{ customer.state }} {{ customer.country }} {{ customer.postal_code }}
            </span>
          </address>

          <div class="d-grid gap-1 d-md-flex justify-content-md-start mt-2">
            <router-link :to="{ name: 'customer-edit', params: { id: customer.id } }">
              <CButton color="primary" size="sm">
                <CIcon icon="cil-pencil" /> Edit
              </CButton>
            </router-link>
          </div>
        </template>
      </CCardBody>
    </CCard>
  </div>
</template>

<script setup lang="ts">
import axios from "axios";
import { ref, watch } from "vue";
import { type CustomerWithDefaults, type EntityIdentifier } from "@/admin/types";
import useNotFoundRedirect from "@/admin/composables/useNotFoundRedirect";

const { redirectToNotFound } = useNotFoundRedirect();

const isLoaded = ref(false);
const customer = ref<CustomerWithDefaults>({});

const props = defineProps({
  id: {
    type: String,
    required: true,
  }
});

const fetchData = (id: EntityIdentifier) => {
  const promise = axios.get("/customers/" + id);

  return promise.then(({ data }) => {
    const item = data.data;

    customer.value = Object.assign(item || {});
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

</script>

<style scoped>
</style>
