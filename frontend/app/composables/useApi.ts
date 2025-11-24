export const useApi = () => {
  const config = useRuntimeConfig()
  const token = useCookie('auth_token')

  const apiUrl = config.public.apiUrl || 'http://localhost:8000/api'

  const api = $fetch.create({
    baseURL: apiUrl,
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json',
    },
    onRequest({ options }) {
      if (token.value) {
        options.headers = {
          ...options.headers,
          Authorization: `Bearer ${token.value}`,
        }
      }
    },
    onResponseError({ response }) {
      // Handle 401 errors (unauthorized)
      if (response.status === 401) {
        token.value = null
        navigateTo('/login')
      }
    },
  })

  return {
    api,
    apiUrl,
  }
}