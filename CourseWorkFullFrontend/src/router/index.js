import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import MainPage from '@/views/MainPage.vue'
import ContactsPage from '@/views/ContactsPage.vue'
import CatalogPage from '@/views/CatalogPage.vue'
import ProfilePage from '@/views/ProfilePage.vue'
import AdminPanelPage from '@/views/AdminPanelPage.vue'
import FavouritesPage from '@/views/FavouritesPage.vue'
import FlatPage from '@/views/FlatPage.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: MainPage,
    },
    {
      path: '/contacts',
      name: 'contacts',
      component: ContactsPage,
    },
    {
      path: '/catalog',
      name: 'catalog',
      component: CatalogPage,
    },
    {
      path: '/flat/:id',
      name: 'flat',
      component: FlatPage,
    },
    {
      path: '/profile',
      name: 'profile',
      component: ProfilePage,
    },
    {
      path: '/profile/admin',
      name: 'admin',
      component: AdminPanelPage,
    },
    {
      path: '/profile/favourites',
      name: 'favourites',
      component: FavouritesPage,
    },
  ],
  scrollBehavior(to) {
    if (to.hash) {
      return {
        el: to.hash,
        behavior: 'smooth',
      }
    }
    return { top: 0 }
  },
})

router.beforeEach((to, from, next) => {
  const authStore = useAuthStore()

  if (to.path === '/profile' && !authStore.isAuthenticated) {
    next('/')
  } else {
    next()
  }
})

export default router
