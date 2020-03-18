<template>
  <div>
    <b-row class="mb-2">
      <b-col>
        <b-button variant="success" size="sm" v-b-modal.create-modal>
          <i class="far fa-plus-square"></i>
          Create
        </b-button>
      </b-col>
    </b-row>
    <b-table
      :items="fetchData"
      :fields="fields"
      :current-page="currentPage"
      :per-page="perPage"
      :busy="isBusy"
      show-empty
      striped
    >
      <template v-slot:table-busy>
        <LoadingSpinner />
      </template>

      <template v-slot:cell(name)="row">{{ row.item.first_name }} {{ row.item.last_name }}</template>

      <template v-slot:cell(address)="row">
        {{ row.item.address }}
        <br />
        <span v-if="row.item.address2">
          {{ row.item.address2 }}
          <br />
        </span>
        {{ row.item.city }}, {{ row.item.state }} {{ row.item.postal_code }}
      </template>

      <template v-slot:cell(actions)="row">
        <b-button
          variant="primary"
          size="sm"
          :to="{name:'customer-view', params: {id: row.item.id}}"
        >
          <i class="far fa-edit"></i>
          View
        </b-button>
      </template>
    </b-table>

    <b-row>
      <b-col>Page {{ currentPage }} of {{ lastPage }} ({{ totalRows }} items)</b-col>
      <b-col>
        <b-pagination
          v-model="currentPage"
          :total-rows="totalRows"
          :per-page="perPage"
          align="right"
          size="sm"
        ></b-pagination>
      </b-col>
    </b-row>

    <CreateModal :store="store"></CreateModal>
  </div>
</template>

<script>
import axios from "axios";
import CreateModal from "../../customers/components/CreateModal";
import LoadingSpinner from "../../../components/LoadingSpinner";

export default {
  name: "CustomerList",
  props: {
    store: Object
  },
  components: {
    CreateModal,
    LoadingSpinner
  },
  data() {
    return {
      isBusy: false,
      totalRows: 1,
      currentPage: 1,
      lastPage: 1,
      perPage: 30,
      fields: ["id", "name", "email", "address", "actions"]
    };
  },
  methods: {
    async fetchData(ctx) {
      let vm = this;

      const promise = axios.get(
        "/stores/" +
          vm.store.id +
          "/customers?page[number]=" +
          ctx.currentPage +
          "&page[size]=" +
          ctx.perPage
      );

      return promise.then(({ data }) => {
        const items = data.data;

        vm.currentPage = data.meta.current_page;
        vm.lastPage = data.meta.last_page;
        vm.totalRows = data.meta.total;

        vm.isBusy = false;

        return items || [];
      });
    }
  }
};
</script>

<style scoped>
</style>
