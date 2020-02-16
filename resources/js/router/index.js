import Vue from "vue";
import Router from "vue-router";

import DefaultContainer from "../containers/DefaultContainer";
import CustomerIndex from "../views/customers/index";
import CustomerList from "../views/customers/list";
import CustomerView from "../views/customers/view";
import FilmIndex from "../views/films/index";
import FilmCreate from "../views/films/create";
import FilmEdit from "../views/films/edit";
import FilmList from "../views/films/list";
import FilmView from "../views/films/view";
import StoreIndex from "../views/stores/index";
import StoreCreate from "../views/stores/create";
import StoreEdit from "../views/stores/edit";
import StoreList from "../views/stores/list";
import StoreView from "../views/stores/view";

Vue.use(Router);

export default new Router({
    mode: 'history',
    linkActiveClass: 'active',
    scrollBehavior: () => ({ y: 0 }),
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
                            path: "create",
                            name: "film-create",
                            component: FilmCreate,
                        },
                        {
                            path: ":id(\\d+)",
                            name: "film-view",
                            component: FilmView,
                        },
                        {
                            path: ":id(\\d+)/edit",
                            name: "film-edit",
                            component: FilmEdit,
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
                            path: "create",
                            name: "store-create",
                            component: StoreCreate,
                        },
                        {
                            path: ":id(\\d+)",
                            name: "store-view",
                            component: StoreView,
                        },
                        {
                            path: ":id(\\d+)/edit",
                            name: "store-edit",
                            component: StoreEdit,
                        },
                    ],
                }
            ],
        }
    ];
}
