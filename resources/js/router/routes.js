function page(path) {
  return () => import(/* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
}

export default [
  { path: '/', redirect: { name: 'login' } },

  { path: '/login', name: 'login', component: page('auth/login.vue') },

  { path: '/home', name: 'home', component: page('home.vue') },

  { path: '/register', name: 'register', component: page('auth/register.vue') },
  { path: '/password/reset', name: 'password.request', component: page('auth/password/email.vue') },
  { path: '/password/reset/:token', name: 'password.reset', component: page('auth/password/reset.vue') },
  { path: '/email/verify/:id', name: 'verification.verify', component: page('auth/verification/verify.vue') },
  { path: '/email/resend', name: 'verification.resend', component: page('auth/verification/resend.vue') },

  {
    path: '/settings',
    component: page('settings/index.vue'),
    children: [
      { path: '', redirect: { name: 'settings.profile' } },
      { path: 'profile', name: 'settings.profile', component: page('settings/profile.vue') },
      { path: 'password', name: 'settings.password', component: page('settings/password.vue') }
    ]
  },
  {
    path: '/socio',
    component: page('socio/index.vue'),
    children: [
      { path: '', redirect: { name: 'dash.socio' } },
      { path: 'dashboard', name: 'dash.socio', component: page('socio/dashboard.vue') },
    ]
  },
  {
    path: '/controlador',
    component: page('controlador/index.vue'),
    children: [
      { path: '', redirect: { name: 'dash.controlador' } },
      { path: 'dashboard', name: 'dash.controlador', component: page('controlador/dashboard.vue') },
    ]
  },
  {
    path: '/administrador',
    component: page('admin/index.vue'),
    children: [
      { path: '', redirect: { name: 'dash.admin' } },
      { path: 'dashboard', name: 'dash.admin', component: page('admin/dashboard.vue') },
    ]
  },

  { path: '*', component: page('errors/404.vue') },

]
