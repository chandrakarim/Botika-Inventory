import { createRouter, createWebHistory } from "vue-router";

// pages
import Login from "../pages/Login.vue";
import Dashboard from "../pages/Dashboard.vue";
import EditInventory from "../pages/EditInventory.vue";
import CreateInventory from "../pages/CreateInventory.vue";

import Members from "../pages/Members.vue";
import Inventories from "../pages/Inventories.vue";

// layout
import DashboardLayout from "../layouts/Dashboard.vue";

const routes = [
  // ================= LOGIN =================
  {
    path: "/login",
    name: "login",
    component: Login,
  },

  // ================= DASHBOARD AREA =================
  {
    path: "/dashboard",
    component: DashboardLayout,
    meta: { requiresAuth: true },

    children: [
      // dashboard home
      {
        path: "",
        name: "dashboard",
        component: Dashboard,
      },

      // members
      {
        path: "members",
        name: "members",
        component: Members,
      },

      // inventories list
      {
        path: "inventories",
        name: "inventories",
        component: Inventories,
      },

      //Edit Inventory
      {
        path: "inventories/edit/:id",
        name: "edit-inventory",
        component: EditInventory,
      },

      {
        path: "inventories/create",
        name: "create-inventory",
        component: CreateInventory,
        },

        {
        path: "members/edit/:id",
        name: "edit-member",
        component: () => import("../pages/EditMember.vue"),
        },

        {
        path: "members/create",
        name: "create-member",
        component: () => import("../pages/CreateMember.vue"),
        },

    ],
  },

  // redirect root ke dashboard
  {
    path: "/",
    redirect: "/dashboard",
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// ================= AUTH GUARD =================
router.beforeEach((to, from, next) => {
const token = localStorage.getItem("token");

// cek SEMUA parent + child route
const requiresAuth = to.matched.some(record => record.meta.requiresAuth);

if (requiresAuth && !token) {
next("/login");
} else {
next();
}
});


export default router;
