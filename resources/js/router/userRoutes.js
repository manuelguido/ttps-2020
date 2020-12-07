// Dashboard
import Dashboard from '../layouts/Dashboard'
// Profile
import Profile from '.././views/user/Profile'
// Notifications
import Notifications from '.././views/user/Notifications'
import NotificationsHistory from '.././views/user/NotificationsHistory'
const routes = [
  {
    path: '/user',
    name: 'User',
    component: Dashboard,
    redirect: '/user/profile',
    meta: {
      requiresAuth: true,
    },
    children: [
      {
        path: '/user/profile',
        name: 'Profile',
        component: Profile
      },
      {
        path: '/user/notifications',
        name: 'Notifications',
        component: Notifications
      },
      {
        path: '/user/notifications/history',
        name: 'NotificationsHistory',
        component: NotificationsHistory
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
