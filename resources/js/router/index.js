import Vue from "vue";
import Router from "vue-router";

import DefaultContainer from "@/containers/DefaultContainer";

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
            name: "home",
            component: DefaultContainer,
            children: []
        }
    ];
}
