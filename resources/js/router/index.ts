import { createRouter, createWebHistory } from "vue-router";

import DefaultContainer from "@/containers/DefaultContainer.vue";
import IndexView from "@/views/index.vue";
import DashboardView from "@/views/dashboard.vue";
import BrowseView from "@/views/browse.vue";
import BrowseByCategoryView from "@/views/browseByCategory.vue";
import SearchView from "@/views/search.vue";
import LoginView from "@/views/auth/login.vue";
import LogoutView from "@/views/auth/logout.vue";

import NotFound from "@/errors/NotFound.vue";
import store from "@/store.js";

const routes = [
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
    path: '/:pathMatch(.*)*',
    name: 'not-found',
    component: NotFound,
    meta: {
      requiresAuth: false,
    }
  }
];

const router = createRouter({
  history: createWebHistory(),
  linkActiveClass: 'active',
//   scrollBehavior: () => ({ y: 0 }),
  routes
});


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
