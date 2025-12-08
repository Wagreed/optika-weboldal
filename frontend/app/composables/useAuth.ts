interface User {
  id: number
  name: string
  email: string
  phone?: string
  birth_date?: string
  address?: string
  is_active: boolean
  profile?: UserProfile
}

interface UserProfile {
  id: number
  user_id: number
  avatar?: string
  insurance_number?: string
  emergency_contact_name?: string
  emergency_contact_phone?: string
  medical_notes?: string
  preferred_language: 'hu' | 'en' | 'ro'
  newsletter_subscription: boolean
}

interface RegisterData {
  name: string
  email: string
  password: string
  password_confirmation: string
  phone?: string
  birth_date?: string
  address?: string
}

interface LoginData {
  email: string
  password: string
}

export const useAuth = () => {
  const { api } = useApi()
  const config = useRuntimeConfig()
  const user = useState<User | null>('user', () => null)
  const userRoles = useState<string[]>('userRoles', () => [])
  const token = useCookie('auth_token')
  const isLoggedIn = computed(() => !!token.value && !!user.value)
  const isAdminOrStaff = computed(() => {
    return userRoles.value.some(role => ['admin', 'staff', 'super_admin'].includes(role.toLowerCase()))
  })

  const register = async (data: RegisterData) => {
    try {
      const response = await api('/register', {
        method: 'POST',
        body: data,
      })

      token.value = response.token
      user.value = response.user
      userRoles.value = response.roles || []

      // Redirect to admin panel if user has admin or staff role
      if (response.roles && response.roles.some((role: string) => ['admin', 'staff', 'super_admin'].includes(role.toLowerCase()))) {
        // Redirect to special route that creates session and redirects to admin
        const backendUrl = config.public.apiUrl.replace('/api', '')
        window.location.href = `${backendUrl}/auth/admin-session/${response.token}`
        return { success: true, message: response.message, redirectToAdmin: true }
      }

      return { success: true, message: response.message, redirectToAdmin: false }
    } catch (error: any) {
      return {
        success: false,
        message: error.data?.message || 'Regisztráció sikertelen',
        errors: error.data?.errors || {},
        redirectToAdmin: false,
      }
    }
  }

  const login = async (data: LoginData) => {
    try {
      const response = await api('/login', {
        method: 'POST',
        body: data,
      })

      token.value = response.token
      user.value = response.user
      userRoles.value = response.roles || []

      // Redirect to admin panel if user has admin or staff role
      if (response.roles && response.roles.some((role: string) => ['admin', 'staff', 'super_admin'].includes(role.toLowerCase()))) {
        // Redirect to special route that creates session and redirects to admin
        const backendUrl = config.public.apiUrl.replace('/api', '')
        window.location.href = `${backendUrl}/auth/admin-session/${response.token}`
        return { success: true, message: response.message, redirectToAdmin: true }
      }

      return { success: true, message: response.message, redirectToAdmin: false }
    } catch (error: any) {
      return {
        success: false,
        message: error.data?.message || 'Bejelentkezés sikertelen',
        errors: error.data?.errors || {},
        redirectToAdmin: false,
      }
    }
  }

  const logout = async () => {
    try {
      await api('/logout', { method: 'POST' })
    } catch (error) {
      console.error('Logout error:', error)
    } finally {
      token.value = null
      user.value = null
      userRoles.value = []
      navigateTo('/')
    }
  }

  const fetchUser = async () => {
    if (!token.value) {
      user.value = null
      userRoles.value = []
      return
    }

    try {
      // Hozzáadunk egy timestamp paramétert, hogy elkerüljük a cache-elést
      const response = await api(`/user?_=${Date.now()}`)
      user.value = response.user
      userRoles.value = response.roles || []
    } catch (error) {
      console.error('Fetch user error:', error)
      token.value = null
      user.value = null
      userRoles.value = []
    }
  }

  const updateProfile = async (data: Partial<User & UserProfile>) => {
    try {
      const response = await api('/profile', {
        method: 'PUT',
        body: data,
      })

      user.value = response.user

      // Frissítjük a user adatokat a fetchUser() hívásával is,
      // hogy biztosítsuk a cache-mentes friss adatokat
      await fetchUser()

      return { success: true, message: response.message }
    } catch (error: any) {
      return {
        success: false,
        message: error.data?.message || 'Profil frissítés sikertelen',
        errors: error.data?.errors || {},
      }
    }
  }

  const uploadAvatar = async (file: File) => {
    try {
      const formData = new FormData()
      formData.append('avatar', file)

      const response = await $fetch('/profile/avatar', {
        baseURL: useApi().apiUrl,
        method: 'POST',
        body: formData,
        headers: {
          Authorization: `Bearer ${token.value}`,
        },
      })

      // Fetch updated user data
      await fetchUser()

      return { success: true, message: response.message, avatar_url: response.avatar_url }
    } catch (error: any) {
      return {
        success: false,
        message: error.data?.message || 'Profilkép feltöltés sikertelen',
        errors: error.data?.errors || {},
      }
    }
  }

  return {
    user,
    userRoles,
    isLoggedIn,
    isAdminOrStaff,
    register,
    login,
    logout,
    fetchUser,
    updateProfile,
    uploadAvatar,
  }
}