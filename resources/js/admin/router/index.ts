import { createRouter, createWebHistory } from "vue-router";

import DefaultLayout from "@/admin/layouts/DefaultLayout.vue";
import CustomerIndex from "@/admin/views/customers/index.vue";
import CustomerList from "@/admin/views/customers/list.vue";
import CustomerView from "@/admin/views/customers/view.vue";
import FilmIndex from "@/admin/views/films/index.vue";
import FilmList from "@/admin/views/films/list.vue";
import FilmView from "@/admin/views/films/view.vue";
import InventoryIndex from "@/admin/views/inventory/index.vue";
import InventoryList from "@/admin/views/inventory/list.vue";
import InventoryView from "@/admin/views/inventory/view.vue";
import StoreIndex from "@/admin/views/stores/index.vue";
import StoreList from "@/admin/views/stores/list.vue";
import StoreView from "@/admin/views/stores/view.vue";

const routes = [
  {
    path: "/",
    redirect: "/customers",
    name: "home",
    component: DefaultLayout,
    meta: {
      breadcrumb: "Home",
    },
    children: [
      {
        path: "customers",
        component: CustomerIndex,
        meta: {
          breadcrumb: "Customers",
        },
        children: [
          {
            path: "",
            name: "customer-list",
            component: CustomerList,
          },
          {
            path: ":id(\\d+)",
            name: "customer-view",
            component: CustomerView,
          },
        ],
      },
      {
        path: "films",
        component: FilmIndex,
        meta: {
          breadcrumb: "Films",
        },
        children: [
          {
            path: "",
            name: "film-list",
            component: FilmList,
          },
          {
            path: ":id(\\d+)",
            name: "film-view",
            component: FilmView,
          },
        ],
      },
      {
        path: "inventory",
        component: InventoryIndex,
        meta: {
          breadcrumb: "Inventory",
        },
        children: [
          {
            path: "",
            name: "inventory-list",
            component: InventoryList,
          },
          {
            path: ":id(\\d+)",
            name: "inventory-view",
            component: InventoryView,
          },
        ],
      },
      {
        path: "/stores",
        component: StoreIndex,
        meta: {
          breadcrumb: "Stores",
        },
        children: [
          {
            path: "",
            name: "store-list",
            component: StoreList,
          },
          {
            path: ":id(\\d+)",
            name: "store-view",
            component: StoreView,
          },
        ],
      }
    ],
  }
];

const router = createRouter({
  history: createWebHistory(),
  linkActiveClass: 'active',
  scrollBehavior() {
    // always scroll to top
    return { top: 0 }
  },
  routes
});

export default router;
