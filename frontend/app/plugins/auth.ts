export default defineNuxtPlugin(async () => {
  const { fetchUser } = useAuth()

  // Automatikusan betölti a felhasználót az oldal indításakor
  await fetchUser()
})