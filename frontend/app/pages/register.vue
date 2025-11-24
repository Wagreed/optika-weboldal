<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
      <div>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
          Regisztráció
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
          Vagy
          <NuxtLink to="/login" class="font-medium text-blue-600 hover:text-blue-500">
            jelentkezz be a fiókodba
          </NuxtLink>
        </p>
      </div>

      <form class="mt-8 space-y-6" @submit.prevent="handleRegister">
        <div v-if="errorMessage" class="rounded-md bg-red-50 p-4">
          <div class="text-sm text-red-700">
            {{ errorMessage }}
          </div>
        </div>

        <div class="space-y-4">
          <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Név *</label>
            <input
              id="name"
              v-model="form.name"
              type="text"
              required
              class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
              placeholder="Teljes név"
            >
          </div>

          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
            <input
              id="email"
              v-model="form.email"
              type="email"
              required
              class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
              placeholder="email@pelda.hu"
            >
          </div>

          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Jelszó *</label>
            <input
              id="password"
              v-model="form.password"
              type="password"
              required
              minlength="8"
              class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
              placeholder="Minimum 8 karakter"
            >
          </div>

          <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
              Jelszó megerősítése *
            </label>
            <input
              id="password_confirmation"
              v-model="form.password_confirmation"
              type="password"
              required
              minlength="8"
              class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
              placeholder="Jelszó újra"
            >
          </div>

          <div>
            <label for="phone" class="block text-sm font-medium text-gray-700">Telefonszám</label>
            <input
              id="phone"
              v-model="form.phone"
              type="tel"
              class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
              placeholder="+36 30 123 4567"
            >
          </div>
        </div>

        <div>
          <button
            type="submit"
            :disabled="loading"
            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:bg-gray-400"
          >
            {{ loading ? 'Regisztráció...' : 'Regisztráció' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({
  middleware: 'guest',
  layout: false,
})

const { register } = useAuth()
const router = useRouter()

const form = ref({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  phone: '',
})

const loading = ref(false)
const errorMessage = ref('')

const handleRegister = async () => {
  if (form.value.password !== form.value.password_confirmation) {
    errorMessage.value = 'A jelszavak nem egyeznek meg'
    return
  }

  loading.value = true
  errorMessage.value = ''

  const result = await register(form.value)

  if (result.success) {
    router.push('/profile')
  } else {
    errorMessage.value = result.message || 'Regisztráció sikertelen'
  }

  loading.value = false
}
</script>
