<template>
  <div>
    <h2>Store (#{{ store.id }})</h2>

    <b-row>
      <b-col>
        <address>
          {{ store.address }}
          <br />
          <span v-if="store.address2">
            {{ store.address2 }}
            <br />
          </span>
          {{ store.city }}, {{ store.state }} {{ store.country }} {{ store.postal_code }}
        </address>
      </b-col>
      <b-col cols="auto">
        <b-img src="https://dummyimage.com/300x300/e/5.png"></b-img>
      </b-col>
    </b-row>

    <b-button variant="primary" size="sm" v-b-modal.edit-modal>
      <i class="far fa-edit"></i>
      Edit
    </b-button>

    <b-button variant="danger" size="sm" @click="onDelete">
      <i class="far fa-times-circle"></i>
      Delete
    </b-button>

    <hr />

    <b-card no-body>
      <b-tabs card>
        <b-tab title="Customers">
          <CustomerList v-if="isLoaded" :store="store" />
        </b-tab>
        <b-tab title="Films" lazy>
          <FilmList v-if="isLoaded" :store="store" />
        </b-tab>
        <b-tab title="Inventory" lazy>
          <InventoryList v-if="isLoaded" :store="store" />
        </b-tab>
      </b-tabs>
    </b-card>

    <EditModal :populateWith="store" @saved="onSave"></EditModal>
  </div>
</template>

<script setup lang="ts">
import axios from "axios";
import { getCurrentInstance, onBeforeMount, ref, watch } from "vue";
import { useRoute, useRouter } from "vue-router/composables";
import CustomerList from "./components/CustomerList.vue";
import EditModal from "./components/EditModal.vue";
import FilmList from "./components/FilmList.vue";
import InventoryList from "./components/InventoryList.vue";

const { proxy } = getCurrentInstance();
const route = useRoute();
const router = useRouter();

const isRouted = ref(false);
const isLoaded = ref(false);
const store = ref({});

onBeforeMount(() => {
  watch(
    () => route,
    (newRoute, oldRoute) => {
      isRouted.value = true;

      fetchData(newRoute.params.id);
    },
    { deep: true }
  );

  if (!isLoaded.value && !isRouted.value) {
    fetchData(route.params.id);
  }
});

const fetchData = (id) => {
  const promise = axios.get("/stores/" + id);

  promise.then(({ data }) => {
    store.value = data.data || {};
    isLoaded.value = true;
  });
}

const onSave = (storeObj) => {
  store.value = storeObj;
}

const onDelete = async () => {
  proxy.$bvModal
    .msgBoxConfirm("Do you really want to delete this store?", {})
    .then(value => {
      if (value) {
        const promise = axios.delete("/stores/" + store.value.id);

        promise.then(() => {
          router.push({ name: "store-list" });
          proxy.$toasted.show("Store was deleted successfully", {
            type: "success",
            icon: "far fa-check-circle"
          });
        });
      }
    });
}
</script>

<style scoped>
</style>
