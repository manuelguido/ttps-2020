// Dashboard
import Dashboard from '../layouts/Dashboard';
// Home
import Home from '../views/dashboard/Home';
// Nueva entrada al sistema
import NewEntry from '../views/dashboard/NewEntry'
// Pacientes
import Patients from '../views/dashboard/Patients';
// Paciente
import Patient from '../views/dashboard/Patient';
// Asignación de medicos a pacientes
import PatientAssigment from '../views/dashboard/PatientAssigment';
// Patient Evolution Add
import PatientChangeSystem from '../views/dashboard/PatientChangeSystem';
// Patient Evolution Add
import PatientEvolutionAdd from '../views/dashboard/PatientEvolutionAdd';
// Medicos
import Medics from '../views/dashboard/Medics';
// Systems
import Systems from '../views/dashboard/Systems';
// Systems
import System from '../views/dashboard/System';
// Settings
import Settings from '../views/dashboard/Settings';
// Data Load
import DataLoad from '../views/auth/DataLoad';

function dashboardHome() {
  if (localStorage.routes) {
    return JSON.parse(localStorage.getItem("routes"))[0].url;
  } else {
    '/';
  }
}

const routes = [
  /**
   * Carga de informacion local del usuario
   */
  {
    path: '/dataload',
    name: 'DataLoad',
    component: DataLoad,
    meta: {
      requiresAuth: true,
    }
  },
  /**
   * Ruta base.
   */
  {
    path: '/admin',
    redirect: '/dashboard/home', //No necesita auth porque redirecciona a una ruta con auth siempre 
  },
  /**
   * Ruta base.
   */
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: Dashboard,
    redirect: dashboardHome(),
    meta: {
      requiresAuth: true,
      progress: {
        func: [
          { call: 'color', modifier: 'temp', argument: '#ffb000' },
          { call: 'fail', modifier: 'temp', argument: '#6e0000' },
          { call: 'location', modifier: 'temp', argument: 'top' },
          { call: 'transition', modifier: 'temp', argument: { speed: '2.5s', opacity: '0.6s', termination: 400 } }
        ]
      }
    },
    children: [
      /**
       * Pacientes.
       */
      {
        path: '/dashboard/patients',
        name: 'Patients',
        component: Patients,
      },
      /**
       * Paciente.
       */
      {
        path: '/dashboard/patient/:patient_id',
        name: 'Patient',
        component: Patient,
        props: true,
      },
      /**
       * Asignaciíon de medicos a paciente.
       */
      {
        path: '/dashboard/patient/assignment/:patient_id',
        name: 'PatientAssigment',
        component: PatientAssigment,
        props: true,
      },
      /**
       * Cambiar paciente de sistema.
       */
      {
        path: '/dashboard/patient/system/change/:patient_id',
        name: 'PatientChangeSystem',
        component: PatientChangeSystem,
        props: true,
      },
      /**
       * Agregar evolución a paciente.
       */
      {
        path: '/dashboard/patient/evolution/add/:patient_id',
        name: 'PatientEvolutionAdd',
        component: PatientEvolutionAdd,
        props: true,
      },
      /**
       * Nueva Entrada al hospital.
       */
      {
        path: '/dashboard/new_entry',
        name: 'NewEntry',
        component: NewEntry
      },
      /**
       * Medicos.
       */
      {
        path: '/dashboard/medics',
        name: 'Medics',
        component: Medics
      },
      /**
       * Sistemas.
       */
      {
        path: '/dashboard/systems',
        name: 'Systems',
        component: Systems
      },
      /**
       * Sistema.
       */
      {
        path: '/dashboard/system/:system_id',
        name: 'System',
        component: System,
        props: true,
      },
      /**
       * Configuración.
       */
      {
        path: '/dashboard/settings',
        name: 'Settings',
        component: Settings,
      },
    ]
  },
]

export default routes
