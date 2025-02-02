import { createRouter, createWebHistory } from "vue-router";

import DefaultLayout from "@/admin/layouts/DefaultLayout.vue";
import CustomerEdit from "@/admin/views/customers/edit.vue";
import CustomerIndex from "@/admin/views/customers/index.vue";
import CustomerList from "@/admin/views/customers/list.vue";
import CustomerView from "@/admin/views/customers/view.vue";
import FilmCreate from "@/admin/views/films/create.vue";
import FilmIndex from "@/admin/views/films/index.vue";
import FilmEdit from "@/admin/views/films/edit.vue";
import FilmList from "@/admin/views/films/list.vue";
import FilmView from "@/admin/views/films/view.vue";
import InventoryIndex from "@/admin/views/inventory/index.vue";
import InventoryList from "@/admin/views/inventory/list.vue";
import InventoryView from "@/admin/views/inventory/view.vue";
import StoreCreate from "@/admin/views/stores/create.vue";
import StoreEdit from "@/admin/views/stores/edit.vue";
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
            props: true,
          },
          {
            path: ":id(\\d+)/edit",
            name: "customer-edit",
            component: CustomerEdit,
            props: true,
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
            path: "create",
            name: "film-create",
            component: FilmCreate,
          },
          {
            path: ":id(\\d+)",
            name: "film-view",
            component: FilmView,
            props: true,
          },
          {
            path: ":id(\\d+)/edit",
            name: "film-edit",
            component: FilmEdit,
            props: true,
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
            props: true,
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
            path: "create",
            name: "store-create",
            component: StoreCreate,
          },
          {
            path: ":id(\\d+)",
            name: "store-view",
            component: StoreView,
            props: true,
          },
          {
            path: ":id(\\d+)/edit",
            name: "store-edit",
            component: StoreEdit,
            props: true,
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
