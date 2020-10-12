// Dashboard
import dashboard from '../layouts/Dashboard'
// Home
import home from '.././views/dashboard/Home'
// Reports
import reports from '.././views/dashboard/Reports'
// Patients
import patients from '.././views/dashboard/Patients'
// Patients
import medics from '.././views/dashboard/Medics'

const routes = [
  { 
    path: '/admin',
    redirect: '/dashboard/home', 
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: dashboard,
    redirect: '/dashboard/home',
    meta: {
      requiresAuth: true,
    },
    children: [
      {
        path: '/dashboard/home',
        name: 'dashboardHome',
        component: home
      },
      {
        path: '/dashboard/patients',
        name: 'patients',
        component: patients
      },
      {
        path: '/dashboard/rooms',
        name: 'patients',
        component: patients
      },
      {
        path: '/dashboard/beds',
        name: 'patients',
        component: patients
      },
      {
        path: '/dashboard/reports',
        name: 'reports',
        component: reports
      },
      {
        path: '/dashboard/medics',
        name: 'medics',
        component: medics
      }
    ]
  },
]

export default routes
