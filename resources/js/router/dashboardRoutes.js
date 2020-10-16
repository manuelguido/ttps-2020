// Dashboard
import dashboard from '../layouts/Dashboard'
// Home
import home from '.././views/dashboard/Home'
// reportes
import reports from '.././views/dashboard/Reports'
// Pacientes
import patients from '.././views/dashboard/Patients'
// Paciente
import patient from '.././views/dashboard/Patient'
// Medicos
import medics from '.././views/dashboard/Medics'
// Systems
import systems from '.././views/dashboard/Systems'
// Data Load
import dataLoad from '.././views/auth/DataLoad'

const routes = [
  {
    path: '/dataload',
    name: 'dataLoad',
    component: dataLoad,
    meta: {
      requiresAuth: true,
    }
  },
  { 
    path: '/admin',
    redirect: '/dashboard/home', //No necesita auth porque redirecciona a una ruta con auth siempre 
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
        path: '/dashboard/patient/:patient_id',
        name: 'patient',
        component: patient,
        props: true,
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
      },
      {
        path: '/dashboard/systems',
        name: 'systems',
        component: systems
      }
    ]
  },
]

export default routes
