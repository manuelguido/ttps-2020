// Dashboard
import dashboard from '../layouts/Dashboard';
// Home
import home from '.././views/dashboard/Home';
// Nueva entrada al sistema
import NewEntryView from '../views/dashboard/NewEntry'
// Pacientes
import patients from '.././views/dashboard/Patients';
// Paciente
import patient from '.././views/dashboard/Patient';
// Asignación de medicos a pacientes
import patientAssigment from '.././views/dashboard/PatientAssigment';
// Medicos
import medics from '.././views/dashboard/Medics';
// Systems
import systems from '.././views/dashboard/Systems';
// Systems
import system from '.././views/dashboard/System';
// Settings
import settingsComponent from '.././views/dashboard/Settings';
// Data Load
import dataLoad from '.././views/auth/DataLoad';

const routes = [
  /**
   * Carga de informacion local del usuario
   */
  {
    path: '/dataload',
    name: 'dataLoad',
    component: dataLoad,
    meta: {
      requiresAuth: true,
    }
  },
  /**
   * Ruta base
   */
  { 
    path: '/admin',
    redirect: '/dashboard/home', //No necesita auth porque redirecciona a una ruta con auth siempre 
  },
  /**
   * Ruta base
   */
  {
    path: '/dashboard',
    name: 'dashboard',
    component: dashboard,
    redirect: '/dashboard/home',
    meta: {
      requiresAuth: true,
      progress: {
        func: [
          {call: 'color', modifier: 'temp', argument: '#ffb000'},
          {call: 'fail', modifier: 'temp', argument: '#6e0000'},
          {call: 'location', modifier: 'temp', argument: 'top'},
          {call: 'transition', modifier: 'temp', argument: {speed: '1.5s', opacity: '0.6s', termination: 400}}
        ]
      }
    },
    children: [
      /**
       * Inicio
       */
      {
        path: '/dashboard/home',
        name: 'dashboardHome',
        component: home
      },
      /**
       * Pacientes
       */
      {
        path: '/dashboard/patients',
        name: 'patients',
        component: patients,
      },
      /**
       * Paciente
       */
      {
        path: '/dashboard/patient/:patient_id',
        name: 'patient',
        component: patient,
        props: true,
      },
      /**
       * Asignaciíon de medicos a paciente
       */
      {
        path: '/dashboard/patient/assignment/:patient_id',
        name: 'patientAssigment',
        component: patientAssigment,
        props: true,
      },
      /**
       * Salas
       */
      // {
      //   path: '/dashboard/rooms',
      //   name: 'patients',
      //   component: patients
      // },
      /**
       * Camas
       */
      // {
      //   path: '/dashboard/beds',
      //   name: 'patients',
      //   component: patients
      // },
      /**
       * Nueva Entrada
       */
      {
        path: '/dashboard/new_entry',
        name: 'NewEntry',
        component: NewEntryView
      },
      /**
       * Medicos
       */
      {
        path: '/dashboard/medics',
        name: 'medics',
        component: medics
      },
      /**
       * Sistemas
       */
      {
        path: '/dashboard/systems',
        name: 'systems',
        component: systems
      },
      /**
       * Sistema
       */
      {
        path: '/dashboard/system/:system_id',
        name: 'system',
        component: system,
        props: true,
      },
      /**
       * Reportes
       */
      {
        path: '/dashboard/settings',
        name: 'Settings',
        component: settingsComponent
      },
    ]
  },
]

export default routes
