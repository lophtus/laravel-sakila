<template>
  <div>
    <h2>{{ customer.first_name }} {{ customer.last_name }} (#{{ customer.id }})</h2>

    <address>
        {{ customer.address }}
        <br/>
        <span v-if="customer.address2">
            {{ customer.address2 }}
            <br/>
        </span>
        {{ customer.city }}, {{ customer.state }} {{ customer.country }} {{ customer.postal_code }}
    </address>

    <b-button variant="primary" size="sm" v-b-modal.edit-modal>
      <i class="far fa-edit"></i>
      Edit
    </b-button>

    <EditModal :populateWith="customer" @saved="onSave"></EditModal>
  </div>
</template>

<script setup lang="ts">
import axios from "axios";
import { onBeforeMount, ref } from "vue";
import { useRoute } from "vue-router/composables";
import EditModal from "./components/EditModal.vue";

const route = useRoute();

const isLoaded = ref(false);
const customer = ref({});

onBeforeMount(() => {
  const promise = axios.get("/customers/" + route.params.id);

  return promise.then(({ data }) => {
    const item = data.data;

    customer.value = item || {};
    isLoaded.value = true;
  });
});

const onSave = (customerObj) => {
  customer.value = customerObj;
}
</script>

<style scoped>
</style>
