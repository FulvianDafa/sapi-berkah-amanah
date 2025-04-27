import { createRouter, createWebHistory } from 'vue-router'
import Landing from '../pages/Landing.vue'
import Produk from '../pages/Produk.vue'
import Detail from '../pages/Detail.vue'
import Faq from '../pages/Faq.vue'

const routes = [
  { path: '/', component: Landing },
  { path: '/produk', component: Produk },
  { path: '/produk/:id', component: Detail },
  { path: '/faq', component: Faq },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
