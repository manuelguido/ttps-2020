import Login from '../views/auth/Login'
import Logout from '../views/auth/Logout'
import SocialLoginToken from '../views/auth/SocialLoginToken'

const routes = [
  {
    path: '/login',
    name: 'login',
    component: Login,
    meta: {
      requiresVisitor: true,
    }
  },
  {
    path: '/logout',
    name: 'logout',
    component: Logout,
    meta: {
      requiresAuth: true,
    }
  },
  {
    path: '/social_login_token',
    name: 'social_login_token',
    component: SocialLoginToken,
    meta: {
      requiresVisitor: true,
    }
  },
]

export default routes
