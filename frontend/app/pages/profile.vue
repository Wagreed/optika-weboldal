<template>
  <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
      <div class="bg-white shadow rounded-lg">
        <!-- Header -->
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200 flex justify-between items-center">
          <div>
            <h1 class="text-2xl font-bold text-gray-900">Profil beállítások</h1>
            <p class="mt-1 text-sm text-gray-500">Kezeld a személyes adataidat</p>
          </div>
          <button
            @click="handleLogout"
            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700"
          >
            Kijelentkezés
          </button>
        </div>

        <!-- Success Message -->
        <div v-if="successMessage" class="mx-4 mt-4 rounded-md bg-green-50 p-4">
          <div class="text-sm text-green-700">
            {{ successMessage }}
          </div>
        </div>

        <!-- Error Message -->
        <div v-if="errorMessage" class="mx-4 mt-4 rounded-md bg-red-50 p-4">
          <div class="text-sm text-red-700">
            {{ errorMessage }}
          </div>
        </div>

        <!-- Form -->
        <form @submit.prevent="handleUpdate" class="px-4 py-5 sm:p-6 space-y-6">
          <!-- Avatar Upload -->
          <div>
            <label class="block text-sm font-medium text-gray-700">Profilkép</label>
            <div class="mt-2 flex items-center space-x-4">
              <div class="h-20 w-20 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden">
                <img
                  v-if="user?.profile?.avatar"
                  :src="`http://localhost:8000/storage/${user.profile.avatar}`"
                  alt="Avatar"
                  class="h-full w-full object-cover"
                >
                <span v-else class="text-2xl text-gray-400">
                  {{ user?.name?.charAt(0).toUpperCase() }}
                </span>
              </div>
              <input
                ref="avatarInput"
                type="file"
                accept="image/*"
                class="hidden"
                @change="handleAvatarUpload"
              >
              <button
                type="button"
                @click="$refs.avatarInput.click()"
                class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50"
              >
                Profilkép feltöltése
              </button>
            </div>
          </div>

          <!-- Basic Info -->
          <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div>
              <label for="name" class="block text-sm font-medium text-gray-700">Név *</label>
              <input
                id="name"
                v-model="form.name"
                type="text"
                required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
              >
            </div>

            <div>
              <label for="phone" class="block text-sm font-medium text-gray-700">Telefonszám</label>
              <input
                id="phone"
                v-model="form.phone"
                type="tel"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
              >
            </div>

            <div>
              <label for="birth_date" class="block text-sm font-medium text-gray-700">Születési dátum</label>
              <input
                id="birth_date"
                v-model="form.birth_date"
                type="date"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
              >
            </div>

            <div>
              <label for="insurance_number" class="block text-sm font-medium text-gray-700">
                Biztosítási szám
              </label>
              <input
                id="insurance_number"
                v-model="form.insurance_number"
                type="text"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
              >
            </div>
          </div>

          <!-- Address -->
          <div>
            <label for="address" class="block text-sm font-medium text-gray-700">Cím</label>
            <textarea
              id="address"
              v-model="form.address"
              rows="2"
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
            ></textarea>
          </div>

          <!-- Emergency Contact -->
          <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div>
              <label for="emergency_contact_name" class="block text-sm font-medium text-gray-700">
                Vészhelyzeti kapcsolattartó neve
              </label>
              <input
                id="emergency_contact_name"
                v-model="form.emergency_contact_name"
                type="text"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
              >
            </div>

            <div>
              <label for="emergency_contact_phone" class="block text-sm font-medium text-gray-700">
                Vészhelyzeti kapcsolattartó telefonszáma
              </label>
              <input
                id="emergency_contact_phone"
                v-model="form.emergency_contact_phone"
                type="tel"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
              >
            </div>
          </div>

          <!-- Medical Notes -->
          <div>
            <label for="medical_notes" class="block text-sm font-medium text-gray-700">
              Egészségügyi megjegyzések
            </label>
            <textarea
              id="medical_notes"
              v-model="form.medical_notes"
              rows="3"
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
              placeholder="Allergiák, gyógyszerek, stb."
            ></textarea>
          </div>

          <!-- Preferences -->
          <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div>
              <label for="preferred_language" class="block text-sm font-medium text-gray-700">
                Preferált nyelv
              </label>
              <select
                id="preferred_language"
                v-model="form.preferred_language"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
              >
                <option value="hu">Magyar</option>
                <option value="en">English</option>
                <option value="ro">Română</option>
              </select>
            </div>

            <div class="flex items-center h-full pt-6">
              <input
                id="newsletter_subscription"
                v-model="form.newsletter_subscription"
                type="checkbox"
                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
              >
              <label for="newsletter_subscription" class="ml-2 block text-sm text-gray-900">
                Hírlevél feliratkozás
              </label>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="flex justify-end">
            <button
              type="submit"
              :disabled="loading"
              class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:bg-gray-400"
            >
              {{ loading ? 'Mentés...' : 'Változások mentése' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({
  middleware: 'auth',
})

const { user, fetchUser, updateProfile, uploadAvatar, logout } = useAuth()
const router = useRouter()

const form = ref({
  name: '',
  phone: '',
  birth_date: '',
  address: '',
  insurance_number: '',
  emergency_contact_name: '',
  emergency_contact_phone: '',
  medical_notes: '',
  preferred_language: 'hu',
  newsletter_subscription: false,
})

const loading = ref(false)
const successMessage = ref('')
const errorMessage = ref('')

// Load user data on mount
onMounted(async () => {
  await fetchUser()
  if (user.value) {
    form.value = {
      name: user.value.name || '',
      phone: user.value.phone || '',
      birth_date: user.value.birth_date || '',
      address: user.value.address || '',
      insurance_number: user.value.profile?.insurance_number || '',
      emergency_contact_name: user.value.profile?.emergency_contact_name || '',
      emergency_contact_phone: user.value.profile?.emergency_contact_phone || '',
      medical_notes: user.value.profile?.medical_notes || '',
      preferred_language: user.value.profile?.preferred_language || 'hu',
      newsletter_subscription: user.value.profile?.newsletter_subscription || false,
    }
  }
})

const handleUpdate = async () => {
  loading.value = true
  successMessage.value = ''
  errorMessage.value = ''

  const result = await updateProfile(form.value)

  if (result.success) {
    successMessage.value = result.message
  } else {
    errorMessage.value = result.message || 'Profil frissítés sikertelen'
  }

  loading.value = false

  // Clear messages after 5 seconds
  setTimeout(() => {
    successMessage.value = ''
    errorMessage.value = ''
  }, 5000)
}

const handleAvatarUpload = async (event: Event) => {
  const target = event.target as HTMLInputElement
  const file = target.files?.[0]

  if (!file) return

  successMessage.value = ''
  errorMessage.value = ''

  const result = await uploadAvatar(file)

  if (result.success) {
    successMessage.value = result.message
  } else {
    errorMessage.value = result.message || 'Profilkép feltöltés sikertelen'
  }

  // Clear messages after 5 seconds
  setTimeout(() => {
    successMessage.value = ''
    errorMessage.value = ''
  }, 5000)
}

const handleLogout = async () => {
  await logout()
}
</script>
