import { createRouter, createWebHistory } from "vue-router";
import Landing from "../pages/Landing.vue";
import Produk from "../pages/Produk.vue";
import Detail from "../pages/Detail.vue";
import DaftarReseller from "../pages/DaftarReseller.vue";
import Faq from "../pages/Faq.vue";

const routes = [
  // Route untuk normal user
  { path: "/", component: Landing },
  { path: "/daftarreseller", component: DaftarReseller },
  { path: "/produk", component: Produk },
  { path: "/produk/:id", component: Detail },
  { path: "/faq", component: Faq },

  // Route untuk admin
  {
    path: "/admin-login",
    name: "AdminLogin",
    component: () => import("../pages/dashboard/login.vue"),
  },
  {
    path: "/dashboard",
    component: () => import("../pages/dashboard/index.vue"),
    meta: { requiresAuth: true },
    children: [
      {
        path: "hewan",
        name: "HewanKurbanList",
        component: () => import("../pages/dashboard/hewan-kurban/list.vue"),
      },
      {
        path: "hewan/tambah",
        name: "HewanKurbanTambah",
        component: () => import("../pages/dashboard/hewan-kurban/form.vue"),
      },
      {
        path: "hewan/edit/:id",
        name: "HewanKurbanEdit",
        component: () => import("../pages/dashboard/hewan-kurban/form.vue"),
      },
    ],
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
