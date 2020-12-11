import Error401 from '../views/error/401error'
import Error404 from '../views/error/404error'

const routes = [
  {
    path: '/401',
    name: 'Error401',
    component: Error401,
  },
  {
    path: '*',
    name: 'Error404',
    component: Error404,
  }
]

export default routes
