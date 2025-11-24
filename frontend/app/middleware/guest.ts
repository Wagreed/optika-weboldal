export default defineNuxtRouteMiddleware(async (to, from) => {
  const token = useCookie('auth_token')

  if (token.value) {
    const { user, userRoles, fetchUser, isAdminOrStaff } = useAuth()
    const config = useRuntimeConfig()

    // Várjuk meg a felhasználó betöltését ha még nincs betöltve
    if (!user.value) {
      await fetchUser()
    }

    // Ha admin vagy staff, irányítsuk az admin panelre
    if (isAdminOrStaff.value) {
      const backendUrl = config.public.apiUrl.replace('/api', '')
      return navigateTo(`${backendUrl}/auth/admin-session/${token.value}`, { external: true })
    }

    // Különben profilra
    return navigateTo('/profile')
  }
})
