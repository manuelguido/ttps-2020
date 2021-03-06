// Dashboard
import Dashboard from '../layouts/Dashboard.vue';

// Reportes
import Settings from '../views/dashboard/settings/Index.vue';

// Nueva entrada al sistema
import NewEntry from '../views/dashboard/entries/New.vue'
import Search from '../views/dashboard/Search/Index.vue'
import SearchResult from '../views/dashboard/Search/Result.vue'

// Pacientes
import Patients from '../views/dashboard/patients/Index.vue';
import PatientsAssigned from '../views/dashboard/patients/IndexAssigned.vue';
import Patient from '../views/dashboard/patients/Show.vue';
import EditPatient from '../views/dashboard/patients/Edit.vue';
import AssigmentPatient from '../views/dashboard/patients/Assigment.vue';
import ChangeSystemPatient from '../views/dashboard/patients/ChangeSystem.vue';
import AddEvolutionPatient from '../views/dashboard/patients/AddEvolution.vue';
import EditEvolutionPatient from '../views/dashboard/patients/EditEvolution.vue';


// Medicos
import Medics from '../views/dashboard/medics/Index.vue';

// Usuarios
import Users from '../views/dashboard/users/Index.vue';
import NewUser from '../views/dashboard/users/New.vue';
import EditUser from '../views/dashboard/users/Edit.vue';

// Sistemas
import Systems from '../views/dashboard/systems/Index.vue';
import System from '../views/dashboard/systems/Show.vue';

// Settings
import RulesSettings from '../views/dashboard/RulesSettings.vue';

// Data Load
import DataLoad from '../views/auth/DataLoad.vue';

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
    redirect: dashboardHome(),  //No necesita auth porque redirecciona a una ruta con auth siempre 
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
       * Pacientes assignados.
       */
      {
        path: '/dashboard/assigned',
        name: 'PatientsAssigned',
        component: PatientsAssigned
      },
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
       * Edición de paciente.
       */
      {
        path: '/dashboard/patient/edit/:patient_id',
        name: 'EditPatient',
        component: EditPatient,
        props: true,
      },
      /**
       * Asignaciíon de medicos a paciente.
       */
      {
        path: '/dashboard/patient/assignment/:patient_id',
        name: 'AssigmentPatient',
        component: AssigmentPatient,
        props: true,
      },
      /**
       * Cambiar paciente de sistema.
       */
      {
        path: '/dashboard/patient/system/change/:patient_id',
        name: 'ChangeSystemPatient',
        component: ChangeSystemPatient,
        props: true,
      },
      /**
       * Agregar evolución a paciente.
       */
      {
        path: '/dashboard/patient/evolution/add/:patient_id',
        name: 'AddEvolutionPatient',
        component: AddEvolutionPatient,
        props: true,
      },
      /**
       * Editar evolución.
       */
      {
        path: '/dashboard/evolution/edit/:evolution_id',
        name: 'EditEvolutionPatient',
        component: EditEvolutionPatient,
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
       * Buscar pacientes.
       */
      {
        path: '/dashboard/search',
        name: 'Search',
        component: Search,
      },
      /**
       * Buscar pacientes.
       */
      {
        path: '/dashboard/search_result/:patient_id',
        name: 'SearchResult',
        component: SearchResult,
        props: true,
      },
      /**
       * Medico1s.
       */
      {
        path: '/dashboard/medics',
        name: 'Medics',
        component: Medics
      },
      /**
       * Usuarios.
       */
      {
        path: '/dashboard/users',
        name: 'Users',
        component: Users
      },
      /**
       * Nuevo usuario.
       */
      {
        path: '/dashboard/user/new',
        name: 'NewUser',
        component: NewUser
      },
      /**
       * Editar usuario.
       */
      {
        path: '/dashboard/user/:user_id',
        name: 'EditUser',
        component: EditUser
      },
      /**
       * Configuración.
       */
      {
        path: '/dashboard/settings',
        name: 'Settings',
        component: Settings
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
        path: '/dashboard/rules_settings',
        name: 'RulesSettings',
        component: RulesSettings,
      },
    ]
  },
]

export default routes
