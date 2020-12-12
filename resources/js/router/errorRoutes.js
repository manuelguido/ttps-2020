import Error401 from '../views/error/401error';
import Error403 from '../views/error/403error';
import Error404 from '../views/error/404error';

const routes = [
  {
    path: '/401',
    name: 'Error401',
    component: Error401,
  },
  {
    path: '/403',
    name: 'Error403',
    component: Error403,
  },
  {
    path: '*',
    name: 'Error404',
    component: Error404,
  }
]

export default routes
