// Dashboard
import Dashboard from '../layouts/Dashboard'
// Profile
import Profile from '../views/user/Profile'
// Alertas
import Alerts from '../views/user/Alerts'
import AlertsHistory from '../views/user/AlertsHistory'

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
        path: '/user/alerts',
        name: 'Alerts',
        component: Alerts
      },
      {
        path: '/user/alerts/history',
        name: 'AlertsHistory',
        component: AlertsHistory
      }
    ],
  },
]

export default routes
