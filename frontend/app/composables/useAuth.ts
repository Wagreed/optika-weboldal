export interface User {
  id: number
  name: string
  email: string
  phone?: string
  birth_date?: string
  address?: string
  is_active: boolean
  profile?: UserProfile
}

export interface UserProfile {
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

// Az ofetch/`$fetch` hibák .data mezőbe rakják a Laravel által visszaadott JSON-t
interface ApiError {
  data?: {
    message?: string
    errors?: Record<string, string[]>
  }
}

interface AuthResponse {
  user: User
  roles: string[]
  token: string
  message: string
}

interface UserResponse {
  user: User
  roles: string[]
}

interface ProfileUpdateResponse {
  user: User
  message: string
}

interface AvatarUploadResponse {
  avatar_url: string
  message: string
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
      const response = await api<AuthResponse>('/register', {
        method: 'POST',
        body: data,
      })

      token.value = response.token
      user.value = response.user
      userRoles.value = response.roles

      // Admin/staff felhasználókat a Filament panelre irányítjuk session-alapú auth-al
      if (response.roles.some(role => ['admin', 'staff', 'super_admin'].includes(role.toLowerCase()))) {
        const backendUrl = config.public.apiUrl.replace('/api', '')
        window.location.href = `${backendUrl}/auth/admin-session/${response.token}`
        return { success: true, message: response.message, redirectToAdmin: true }
      }

      return { success: true, message: response.message, redirectToAdmin: false }
    } catch (error: unknown) {
      const apiError = error as ApiError
      return {
        success: false,
        message: apiError.data?.message ?? 'Regisztráció sikertelen',
        errors: apiError.data?.errors ?? {},
        redirectToAdmin: false,
      }
    }
  }

  const login = async (data: LoginData) => {
    try {
      const response = await api<AuthResponse>('/login', {
        method: 'POST',
        body: data,
      })

      token.value = response.token
      user.value = response.user
      userRoles.value = response.roles

      // Admin/staff felhasználókat a Filament panelre irányítjuk session-alapú auth-al
      if (response.roles.some(role => ['admin', 'staff', 'super_admin'].includes(role.toLowerCase()))) {
        const backendUrl = config.public.apiUrl.replace('/api', '')
        window.location.href = `${backendUrl}/auth/admin-session/${response.token}`
        return { success: true, message: response.message, redirectToAdmin: true }
      }

      return { success: true, message: response.message, redirectToAdmin: false }
    } catch (error: unknown) {
      const apiError = error as ApiError
      return {
        success: false,
        message: apiError.data?.message ?? 'Bejelentkezés sikertelen',
        errors: apiError.data?.errors ?? {},
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
      // A timestamp param megakadályozza, hogy a böngésző a régi választ cache-elje
      const response = await api<UserResponse>(`/user?_=${Date.now()}`)
      user.value = response.user
      userRoles.value = response.roles
    } catch (error) {
      console.error('Fetch user error:', error)
      token.value = null
      user.value = null
      userRoles.value = []
    }
  }

  const updateProfile = async (data: Partial<User & UserProfile>) => {
    try {
      const response = await api<ProfileUpdateResponse>('/profile', {
        method: 'PUT',
        body: data,
      })

      user.value = response.user

      // A fetchUser() meghívása biztosítja, hogy a profile reláció is frissüljön
      await fetchUser()

      return { success: true, message: response.message }
    } catch (error: unknown) {
      const apiError = error as ApiError
      return {
        success: false,
        message: apiError.data?.message ?? 'Profil frissítés sikertelen',
        errors: apiError.data?.errors ?? {},
      }
    }
  }

  const uploadAvatar = async (file: File) => {
    try {
      const formData = new FormData()
      formData.append('avatar', file)

      const response = await $fetch<AvatarUploadResponse>('/profile/avatar', {
        baseURL: useApi().apiUrl,
        method: 'POST',
        body: formData,
        headers: {
          Authorization: `Bearer ${token.value}`,
        },
      })

      await fetchUser()

      return { success: true, message: response.message, avatar_url: response.avatar_url }
    } catch (error: unknown) {
      const apiError = error as ApiError
      return {
        success: false,
        message: apiError.data?.message ?? 'Profilkép feltöltés sikertelen',
        errors: apiError.data?.errors ?? {},
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
