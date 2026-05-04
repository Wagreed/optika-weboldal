<template>
  <div class="min-h-screen bg-slate-50 py-12 px-4 sm:px-6 lg:px-8" style="padding-top:7rem;">
    <div class="max-w-4xl mx-auto">

      <!-- Page header -->
      <div class="mb-8">
        <div class="flex items-center gap-4">
          <div class="w-14 h-14 rounded-2xl bg-blue-600 flex items-center justify-center shadow-lg">
            <span class="text-xl font-bold text-white">{{ user?.name?.charAt(0).toUpperCase() }}</span>
          </div>
          <div>
            <h1 class="text-2xl font-bold text-blue-950" style="font-family:'Outfit',sans-serif;">{{ user?.name }}</h1>
            <p class="text-sm text-slate-500">{{ user?.email }}</p>
          </div>
        </div>
      </div>

      <!-- Tab navigation -->
      <div class="flex gap-1 bg-white border border-slate-200 rounded-2xl p-1.5 mb-8 w-fit">
        <button
          @click="activeTab = 'profile'"
          class="px-5 py-2 text-sm font-semibold rounded-xl transition-all"
          :class="activeTab === 'profile' ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-500 hover:text-slate-800'"
        >
          Személyes adatok
        </button>
        <button
          @click="activeTab = 'appointments'; loadAppointments()"
          class="px-5 py-2 text-sm font-semibold rounded-xl transition-all relative"
          :class="activeTab === 'appointments' ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-500 hover:text-slate-800'"
        >
          Időpontjaim
          <span
            v-if="pendingCount > 0"
            class="absolute -top-1 -right-1 w-5 h-5 bg-yellow-400 text-yellow-900 text-xs font-bold rounded-full flex items-center justify-center"
          >
            {{ pendingCount }}
          </span>
        </button>
      </div>

      <!-- Profile tab -->
      <div v-if="activeTab === 'profile'" class="bg-white shadow-sm border border-slate-100 rounded-2xl overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center">
          <div>
            <h2 class="text-lg font-bold text-slate-900">Profilbeállítások</h2>
            <p class="text-sm text-slate-500 mt-0.5">Kezeld a személyes adataidat</p>
          </div>
          <button
            @click="handleLogout"
            class="inline-flex items-center gap-2 px-4 py-2 border border-red-200 text-sm font-medium rounded-xl text-red-600 hover:bg-red-50 transition"
          >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            Kijelentkezés
          </button>
        </div>

        <div v-if="successMessage" class="mx-6 mt-4 rounded-xl bg-green-50 border border-green-200 p-4">
          <p class="text-sm text-green-700">{{ successMessage }}</p>
        </div>
        <div v-if="errorMessage" class="mx-6 mt-4 rounded-xl bg-red-50 border border-red-200 p-4">
          <p class="text-sm text-red-700">{{ errorMessage }}</p>
        </div>

        <form @submit.prevent="handleUpdate" class="px-6 py-6 space-y-6">
          <!-- Avatar -->
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-3">Profilkép</label>
            <div class="flex items-center gap-4">
              <div class="h-20 w-20 rounded-2xl bg-blue-50 border border-blue-100 flex items-center justify-center overflow-hidden">
                <img
                  v-if="user?.profile?.avatar"
                  :src="`${config.public.apiUrl.replace('/api', '')}/storage/${user.profile.avatar}`"
                  alt="Avatar"
                  class="h-full w-full object-cover"
                >
                <span v-else class="text-2xl font-bold text-blue-400">
                  {{ user?.name?.charAt(0).toUpperCase() }}
                </span>
              </div>
              <input ref="avatarInput" type="file" accept="image/*" class="hidden" @change="handleAvatarUpload">
              <button
                type="button"
                @click="avatarInput?.click()"
                class="px-4 py-2 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-50 transition"
              >
                Kép feltöltése
              </button>
            </div>
          </div>

          <!-- Basic info -->
          <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-1.5">Név *</label>
              <input
                v-model="form.name"
                type="text"
                required
                class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
              >
            </div>
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-1.5">Telefonszám</label>
              <input
                v-model="form.phone"
                type="tel"
                class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
              >
            </div>
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-1.5">Születési dátum</label>
              <input
                v-model="form.birth_date"
                type="text"
                placeholder="NN/HH/ÉÉÉÉ"
                maxlength="10"
                @input="handleDateInput"
                class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
              >
              <p class="mt-1 text-xs text-slate-400">Formátum: NN/HH/ÉÉÉÉ (pl. 15/03/1990)</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-1.5">Biztosítási szám</label>
              <input
                v-model="form.insurance_number"
                type="text"
                class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
              >
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Cím</label>
            <textarea
              v-model="form.address"
              rows="2"
              class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition resize-none"
            ></textarea>
          </div>

          <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-1.5">Vészhelyzeti kapcsolattartó neve</label>
              <input
                v-model="form.emergency_contact_name"
                type="text"
                class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
              >
            </div>
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-1.5">Vészhelyzeti telefonszáma</label>
              <input
                v-model="form.emergency_contact_phone"
                type="tel"
                class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
              >
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Egészségügyi megjegyzések</label>
            <textarea
              v-model="form.medical_notes"
              rows="3"
              placeholder="Allergiák, gyógyszerek, stb."
              class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition resize-none"
            ></textarea>
          </div>

          <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-1.5">Preferált nyelv</label>
              <select
                v-model="form.preferred_language"
                class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
              >
                <option value="hu">Magyar</option>
                <option value="en">English</option>
                <option value="ro">Română</option>
              </select>
            </div>
            <div class="flex items-center pt-7">
              <input
                id="newsletter"
                v-model="form.newsletter_subscription"
                type="checkbox"
                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-slate-300 rounded"
              >
              <label for="newsletter" class="ml-2 text-sm text-slate-700">Hírlevél feliratkozás</label>
            </div>
          </div>

          <div class="flex justify-end pt-2">
            <button
              type="submit"
              :disabled="loading"
              class="btn-primary text-sm"
            >
              {{ loading ? 'Mentés...' : 'Változások mentése' }}
            </button>
          </div>
        </form>
      </div>

      <!-- Appointments tab -->
      <div v-if="activeTab === 'appointments'">
        <div class="bg-white shadow-sm border border-slate-100 rounded-2xl overflow-hidden">
          <div class="px-6 py-5 border-b border-slate-100">
            <h2 class="text-lg font-bold text-slate-900">Időpontjaim</h2>
            <p class="text-sm text-slate-500 mt-0.5">Összes időpont kérésed és azok státusza</p>
          </div>

          <div v-if="appointmentsLoading" class="px-6 py-12 text-center">
            <div class="w-8 h-8 border-2 border-blue-500 border-t-transparent rounded-full animate-spin mx-auto mb-3"></div>
            <p class="text-sm text-slate-400">Betöltés...</p>
          </div>

          <div v-else-if="appointments.length === 0" class="px-6 py-16 text-center">
            <div class="w-14 h-14 bg-slate-50 border border-slate-200 rounded-2xl flex items-center justify-center mx-auto mb-4">
              <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
              </svg>
            </div>
            <p class="text-sm font-medium text-slate-600 mb-1">Még nincs foglalásod</p>
            <p class="text-xs text-slate-400 mb-5">Foglalj időpontot a kapcsolat oldalon</p>
            <NuxtLink to="/contact" class="btn-primary text-sm">Időpont foglalás</NuxtLink>
          </div>

          <div v-else class="divide-y divide-slate-100">
            <div
              v-for="appt in appointments"
              :key="appt.id"
              class="px-6 py-5 flex items-start gap-5"
            >
              <!-- Date badge -->
              <div class="flex-shrink-0 w-14 text-center bg-blue-50 border border-blue-100 rounded-xl py-2.5">
                <p class="text-xs font-semibold text-blue-500 uppercase">
                  {{ formatMonth(appt.appointment_date) }}
                </p>
                <p class="text-xl font-bold text-blue-900 leading-none mt-0.5">
                  {{ formatDay(appt.appointment_date) }}
                </p>
              </div>

              <!-- Info -->
              <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between gap-3">
                  <div>
                    <p class="text-sm font-semibold text-slate-800">
                      {{ appt.appointment_type?.name ?? 'Időpont foglalás' }}
                    </p>
                    <p class="text-xs text-slate-400 mt-0.5">
                      {{ formatDate(appt.appointment_date) }}
                      <span v-if="appt.start_time"> · {{ appt.start_time.slice(0, 5) }}</span>
                    </p>
                    <p v-if="appt.customer_notes" class="text-xs text-slate-500 mt-1.5 italic">
                      "{{ appt.customer_notes }}"
                    </p>
                  </div>
                  <span
                    class="flex-shrink-0 inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold"
                    :class="statusBadgeClass(appt.status)"
                  >
                    {{ statusLabel(appt.status) }}
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="mt-6 text-center">
          <NuxtLink to="/contact" class="btn-primary text-sm">
            Új időpont foglalása
          </NuxtLink>
        </div>
      </div>

    </div>
  </div>
</template>

<script setup lang="ts">
import type { UserProfile } from '~/composables/useAuth'

definePageMeta({
  middleware: 'auth',
})

interface ProfileForm {
  name: string
  phone: string
  birth_date: string
  address: string
  insurance_number: string
  emergency_contact_name: string
  emergency_contact_phone: string
  medical_notes: string
  preferred_language: UserProfile['preferred_language']
  newsletter_subscription: boolean
}

interface AppointmentItem {
  id: number
  appointment_date: string
  start_time: string | null
  status: string
  customer_notes: string | null
  appointment_type: { name: string } | null
  created_at: string
}

const { user, fetchUser, updateProfile, uploadAvatar, logout, isAdminOrStaff } = useAuth()
const { api } = useApi()
const config = useRuntimeConfig()
const avatarInput = ref<HTMLInputElement | null>(null)

const activeTab = ref<'profile' | 'appointments'>('profile')
const appointments = ref<AppointmentItem[]>([])
const appointmentsLoading = ref(false)
const appointmentsLoaded = ref(false)

const pendingCount = computed(() =>
  appointments.value.filter(a => a.status === 'pending').length
)

const form = ref<ProfileForm>({
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

const formatDateForDisplay = (dateString: string) => {
  if (!dateString) return ''
  if (dateString.includes('T')) dateString = dateString.split('T')[0] ?? dateString
  const parts = dateString.split('-')
  if (parts.length === 3) {
    const [year, month, day] = parts
    return `${day}/${month}/${year}`
  }
  return dateString
}

const formatDateForBackend = (dateString: string) => {
  if (!dateString) return ''
  if (dateString.match(/^\d{4}-\d{2}-\d{2}$/)) return dateString
  const parts = dateString.split('/')
  if (parts.length === 3) return `${parts[2]}-${parts[1]}-${parts[0]}`
  return dateString
}

const handleDateInput = (event: Event) => {
  const input = event.target as HTMLInputElement
  let value = input.value.replace(/\D/g, '')
  if (value.length >= 2) value = value.slice(0, 2) + '/' + value.slice(2)
  if (value.length >= 5) value = value.slice(0, 5) + '/' + value.slice(5, 9)
  form.value.birth_date = value
}

const loadFormData = () => {
  if (user.value) {
    form.value = {
      name: user.value.name || '',
      phone: user.value.phone || '',
      birth_date: user.value.birth_date ? formatDateForDisplay(user.value.birth_date) : '',
      address: user.value.address || '',
      insurance_number: user.value.profile?.insurance_number || '',
      emergency_contact_name: user.value.profile?.emergency_contact_name || '',
      emergency_contact_phone: user.value.profile?.emergency_contact_phone || '',
      medical_notes: user.value.profile?.medical_notes || '',
      preferred_language: user.value.profile?.preferred_language || 'hu',
      newsletter_subscription: user.value.profile?.newsletter_subscription || false,
    }
  }
}

async function loadAppointments() {
  if (appointmentsLoaded.value) return
  appointmentsLoading.value = true
  try {
    const data = await api<{ appointments: AppointmentItem[] }>('/appointments/my')
    appointments.value = data.appointments
    appointmentsLoaded.value = true
  } catch {
    // Ha nem sikerül betölteni, üres lista marad
  } finally {
    appointmentsLoading.value = false
  }
}

const monthShort = ['jan','feb','már','ápr','máj','jún','júl','aug','sze','okt','nov','dec']

function formatMonth(dateStr: string): string {
  const d = new Date(dateStr)
  return monthShort[d.getMonth()] ?? ''
}

function formatDay(dateStr: string): string {
  return String(new Date(dateStr).getDate())
}

function formatDate(dateStr: string): string {
  const d = new Date(dateStr)
  return `${d.getFullYear()}. ${monthShort[d.getMonth()]}. ${d.getDate()}.`
}

function statusLabel(status: string): string {
  const labels: Record<string, string> = {
    pending:     'Függőben',
    scheduled:   'Foglalva',
    confirmed:   'Megerősítve',
    in_progress: 'Folyamatban',
    completed:   'Teljesítve',
    cancelled:   'Törölve',
    no_show:     'Nem jelent meg',
  }
  return labels[status] ?? status
}

function statusBadgeClass(status: string): string {
  const classes: Record<string, string> = {
    pending:     'bg-yellow-100 text-yellow-800',
    scheduled:   'bg-blue-100 text-blue-800',
    confirmed:   'bg-blue-600 text-white',
    in_progress: 'bg-indigo-100 text-indigo-800',
    completed:   'bg-green-100 text-green-800',
    cancelled:   'bg-red-100 text-red-800',
    no_show:     'bg-slate-100 text-slate-600',
  }
  return classes[status] ?? 'bg-slate-100 text-slate-600'
}

watch(user, () => loadFormData(), { deep: true })

onMounted(async () => {
  await fetchUser()

  if (isAdminOrStaff.value) {
    const token = useCookie('auth_token')
    const backendUrl = config.public.apiUrl.replace('/api', '')
    window.location.href = `${backendUrl}/auth/admin-session/${token.value}`
    return
  }

  loadFormData()
})

const handleUpdate = async () => {
  loading.value = true
  successMessage.value = ''
  errorMessage.value = ''

  const dataToSend = {
    ...form.value,
    birth_date: formatDateForBackend(form.value.birth_date),
  }

  const result = await updateProfile(dataToSend)

  if (result.success) {
    successMessage.value = result.message
  } else {
    errorMessage.value = result.message || 'Profil frissítés sikertelen'
  }

  loading.value = false

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

  setTimeout(() => {
    successMessage.value = ''
    errorMessage.value = ''
  }, 5000)
}

const handleLogout = async () => {
  await logout()
}
</script>
