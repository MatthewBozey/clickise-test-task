import {createRouter, createWebHashHistory} from 'vue-router';
import App from './App.vue';

const routes = [
  {
    path: '/',
    name: 'app',
    component: App,
    meta: {hasAuth: false},
    children: [
      {
        path: '/users',
        name: 'users',
        meta: {hasAuth: false},
        component: () => import('./pages/Users.vue')
      },
      {
        path: '/companies',
        name: 'companies',
        meta: {hasAuth: false},
        component: () => import('./pages/Companies.vue'),
      },
      {
        path: '/adds',
        name: 'adds',
        meta: {hasAuth: false},
        component: () => import('./pages/Adds.vue'),
      },
    ],
  },
  {
    path: '/login',
    name: 'login',
    meta: {hasAuth: false},
    component: () => {},
  },
  {
    path: '/reset-password',
    name: 'resetPassword',
    meta: {hasAuth: false},
    component: () => {},
    children: [
      {
        path: '/proof-identity',
        name: 'ProofIdentity',
        meta: {hasAuth: false},
        component: () => {},
      },
      {
        path: '/send-code',
        name: 'SendCode',
        meta: {hasAuth: false},
        component: () => {},
      },
      {
        path: '/validate-code',
        name: 'ValidateCode',
        meta: {hasAuth: false},
        component: () => {},
      },
      {
        path: '/change-password',
        name: 'ChangePassword',
        meta: {hasAuth: false},
        component: () => {},
      },
    ],
  },

];

const router = createRouter({
  history: createWebHashHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  function checkPermission(allPerm, perm) {
    let result = false;
    for (let index = 0; index < perm.length; index++) {
      result = (allPerm.includes(perm[index]) || result);
    }
    return result
  }

  // await store.restored;
  if (to.matched.some(record => record.meta.hasAuth)) {
    const token = localStorage.getItem('access_token');
    if (token) {
      if (to.matched.some(record => record.meta.permission)) {
        let permission = JSON.parse(localStorage.getItem('permissions'));
        if (!permission || !checkPermission(permission, to.meta.permission)) {
          router.push('/access-denied');
        } else {
          next();
        }
      } else {
        next();
      }
    } else {
      router.push({name: 'login'});
    }
  } else {
    next();
  }
});

export default router;
