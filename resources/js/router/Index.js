import Vue from 'vue'
import Router from 'vue-router'
import store from '../store';

import dashboardRoutes from './dashboardRoutes'
import publicRoutes from './publicRoutes'
import errorRoutes from './errorRoutes'
import authRoutes from './authRoutes'
import userRoutes from './userRoutes'

Vue.use(Router)

var allRoutes = []
allRoutes = allRoutes.concat(
  publicRoutes,
  authRoutes,
  dashboardRoutes,
  userRoutes,
  errorRoutes
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
        name: 'Login',
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
        name: 'Dashboard',
      })
    } else {
      next()
    }
  } else {
    next()
  }
})

export default router
