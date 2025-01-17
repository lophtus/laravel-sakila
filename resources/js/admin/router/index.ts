import Vue from "vue";
import Router from "vue-router";

import DefaultContainer from "@/admin/containers/DefaultContainer.vue";
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

Vue.use(Router);

const router = new Router({
    mode: 'history',
    linkActiveClass: 'active',
    // scrollBehavior: () => ({ y: 0 }),
    routes: configRoutes()
});

function configRoutes() {
    return [
        {
            path: "/",
            redirect: "/customers",
            name: "home",
            component: DefaultContainer,
            children: [
                {
                    path: "customers",
                    component: CustomerIndex,
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
}

export default router;
