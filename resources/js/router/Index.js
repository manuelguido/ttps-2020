import Vue from 'vue'
import Router from 'vue-router'
import store from '../store';

import publicRoutes from './publicRoutes'
import authRoutes from './authRoutes'

Vue.use(Router)

var allRoutes = []
allRoutes = allRoutes.concat(
  publicRoutes,
  authRoutes,
)

const routes = allRoutes

let router = new Router({
  mode: 'history',
  routes,
})

/*--------------------------------------------------------------------------------------
|
| Router login check
|
--------------------------------------------------------------------------------------*/
// Requieres be authenticated
router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.
    if (!store.getters.loggedIn) {
      next({
        name: 'login',
      })
    } else {
      next()
    }
  } else {
    next()
  }
})

// Requires be a visitor
router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresVisitor)) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.
    if (store.getters.loggedIn) {
      next({
        name: 'dashboard',
      })
    } else {
      next()
    }
  } else {
    next()
  }
})

export default router