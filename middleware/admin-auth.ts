export default defineNuxtRouteMiddleware((to) => {
  if (!to.path.startsWith('/admin')) return

  // La page login est exclue
  if (to.path === '/admin/login') return

  const token = useCookie('admin_token')
  if (!token.value) {
    return navigateTo('/admin/login')
  }
})
