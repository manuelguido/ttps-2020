// Dashboard
import dashboard from '../layouts/Dashboard'
// Profile
import profile from '.././views/user/Profile'
// Notifications
import notifications from '.././views/user/Notifications'

const routes = [
  {
    path: '/user',
    name: 'user',
    component: dashboard,
    redirect: '/user/profile',
    meta: {
      requiresAuth: true,
    },
    children: [
      {
        path: '/user/profile',
        name: 'profile',
        component: profile
      },
      {
        path: '/user/notifications',
        name: 'notifications',
        component: notifications
      }
    ]
  }
]

export default routes
