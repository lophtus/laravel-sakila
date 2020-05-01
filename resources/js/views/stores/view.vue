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
        <b-img src="https://via.placeholder.com/300x300"></b-img>
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

<script>
import axios from "axios";
import CustomerList from "./components/CustomerList";
import EditModal from "./components/EditModal";
import FilmList from "./components/FilmList";
import InventoryList from "./components/InventoryList";

export default {
  name: "StoreView",
  components: {
    CustomerList,
    EditModal,
    FilmList,
    InventoryList
  },
  data() {
    return {
      isLoaded: false,
      store: {}
    };
  },
  beforeRouteEnter(to, from, next) {
    const promise = axios.get("/stores/" + to.params.id);

    return promise.then(({ data }) => {
      const store = data.data;

      next(vm => {
        vm.store = store || {};
        vm.isLoaded = true;
      });
    });
  },
  methods: {
    onSave(store) {
      this.store = store;
    },
    async onDelete() {
      let vm = this;

      vm.$bvModal
        .msgBoxConfirm("Do you really want to delete this store?", {})
        .then(value => {
          if (value) {
            const promise = axios.delete("/stores/" + vm.store.id);

            promise.then(() => {
              vm.$router.push({ name: "store-list" });
              vm.$toasted.show("Store was deleted successfully", {
                type: "success",
                icon: "far fa-check-circle"
              });
            });
          }
        });
    }
  }
};
</script>

<style scoped>
</style>
