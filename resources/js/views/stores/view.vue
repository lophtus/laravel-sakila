<template>
  <div>
    <h2>Store (#{{ store.id }})</h2>

    <address>
        {{ store.address }}
        <br/>
        <span v-if="store.address2">
            {{ store.address2 }}
            <br/>
        </span>
        {{ store.city }}, {{ store.state }} {{ store.country }} {{ store.postal_code }}
    </address>
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
  }
};
</script>

<style scoped>
</style>
