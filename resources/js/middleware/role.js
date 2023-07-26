import store from '~/store'



export default (to, from, next, roles) => {
  // Grab the user
  const user = store.getters['auth/user']

  // Split roles into an array
  roles = roles.split(',')
  //console.log(user.rol_id)
  //const currentrol=store.getters['auth/currentRolid']
  // Check if the user has one of the required roles...
  if (!roles.includes(user.rol_id.toString())) {
    next('/unauthorized')
  }

  next()
}
