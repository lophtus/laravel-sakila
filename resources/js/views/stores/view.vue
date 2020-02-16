<template>
  <div>
    <h2>Store (#{{ store.id }})</h2>

    <address>
      {{ store.address }}
      <br />
      <span v-if="store.address2">
        {{ store.address2 }}
        <br />
      </span>
      {{ store.city }}, {{ store.state }} {{ store.country }} {{ store.postal_code }}
    </address>

    <b-button variant="primary" :to="{name: 'store-edit', params: {id: store.id}}">
      <i class="far fa-edit"></i>
      Edit
    </b-button>

    <b-button variant="danger" @click="onDelete">
      <i class="far fa-times-circle"></i>
      Delete
    </b-button>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "StoreView",
  data() {
    return {
      store: {}
    };
  },
  beforeRouteEnter(to, from, next) {
    const promise = axios.get("/stores/" + to.params.id);

    return promise.then(({ data }) => {
      const store = data.data;

      next(vm => {
        vm.store = store || {};
      });
    });
  },
  methods: {
    async onDelete() {
      let vm = this;

      vm.$bvModal.msgBoxConfirm("Do you really want to delete this store?", {}).then(value => {
        if (value) {
          const promise = axios.delete("/stores/" + vm.store.id);

          promise.then(() => {
            vm.$router.push({ name: "store-list" });
            vm.$toasted.show("Store was deleted successfully", { type: "success", icon: "far fa-check-circle" });
          });
        }
      });
    }
  }
};
</script>

<style scoped>
</style>
