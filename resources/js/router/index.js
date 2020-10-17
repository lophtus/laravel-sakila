import Vue from "vue";
import Router from "vue-router";

import DefaultContainer from "@/containers/DefaultContainer";
import IndexView from "@/views/index";
import DashboardView from "@/views/dashboard";
import BrowseView from "@/views/browse";
import BrowseByCategoryView from "@/views/browseByCategory";
import SearchView from "@/views/search";
import LoginView from "@/views/auth/login";
import LogoutView from "@/views/auth/logout";

import NotFound from "@/errors/NotFound";
import store from "../store";

Vue.use(Router);

const router = new Router({
  mode: 'history',
  linkActiveClass: 'active',
  scrollBehavior: () => ({ y: 0 }),
  routes: configRoutes()
});

function configRoutes() {
  return [
    {
      path: "/",
      component: DefaultContainer,
      children: [
        {
          path: "",
          redirect: "dashboard",
          name: "index",
          component: IndexView,
          meta: {
            requiresAuth: true,
          },
          children: [
            {
              path: "dashboard",
              name: "dashboard",
              component: DashboardView,
            },
            {
              path: "browse",
              name: "browse",
              component: BrowseView,
            },
            {
              path: "browse/:id",
              name: "browse-by-category",
              component: BrowseByCategoryView,
              props: true,
            },
            {
              path: "search",
              name: "search",
              component: SearchView,
            },
          ],
        },
        {
          path: "login",
          name: "login",
          component: LoginView,
          meta: {
            requiresAuth: false,
          }
        },
        {
          path: "logout",
          name: "logout",
          component: LogoutView,
          meta: {
            requiresAuth: true,
          }
        }
      ]
    },
    {
      path: '/404',
      alias: '*',
      name: 'not-found',
      component: NotFound,
      meta: {
        requiresAuth: false,
      }
    },
    {
      path: '*',
      redirect: { name: 'not-found' },
    }
  ];
}

router.beforeEach((to, from, next) => {
  // force login
  if (to.matched.some((route) => route.meta.requiresAuth && store.state.user === null)) {
    next({ name: "login" });
    return;
  }

  // redirect if already logged in
  if (to.path === "/login" && store.state.user != null) {
    next({ name: "dashboard" });
    return;
  }

  next();
});

export default router;
