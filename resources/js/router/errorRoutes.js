import Error404 from '../views/error/404error'

const routes = [
  {
    path: '*',
    name: 'Error',
    component: Error404
  }
]

export default routes
