// Dashboard
import dashboard from '../layouts/Dashboard'
// Profile
import profile from '.././views/user/Profile'
// Notifications
import notifications from '.././views/user/Notifications'
import notificationsHistory from '.././views/user/NotificationsHistory'
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
      },
      {
        path: '/user/notifications/history',
        name: 'notifications',
        component: notificationsHistory
      }
    ]
  },
  {
    path: '/profile',
    redirect: '/user/profile',
  },
  {
    path: '/notifications',
    redirect: '/user/notifications',
  }
]

export default routes
