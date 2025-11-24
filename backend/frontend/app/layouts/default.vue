<template>
  <div class="min-h-screen flex flex-col">
    <!-- Navigation -->
    <nav class="bg-white shadow">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex">
            <div class="flex-shrink-0 flex items-center">
              <NuxtLink to="/" class="text-xl font-bold text-gray-900">
                Optika
              </NuxtLink>
            </div>
            <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
              <NuxtLink
                to="/"
                class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"
              >
                Főoldal
              </NuxtLink>
              <NuxtLink
                to="/about"
                class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"
              >
                Rólunk
              </NuxtLink>
              <NuxtLink
                to="/services"
                class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"
              >
                Szolgáltatások
              </NuxtLink>
              <NuxtLink
                to="/contact"
                class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"
              >
                Kapcsolat
              </NuxtLink>
            </div>
          </div>
          <div class="flex items-center">
            <div v-if="isLoggedIn" class="flex items-center space-x-4">
              <span class="text-sm text-gray-700">{{ user?.name }}</span>
              <NuxtLink
                to="/profile"
                class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium"
              >
                Profil
              </NuxtLink>
            </div>
            <div v-else class="flex items-center space-x-4">
              <NuxtLink
                to="/login"
                class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium"
              >
                Bejelentkezés
              </NuxtLink>
              <NuxtLink
                to="/register"
                class="bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded-md text-sm font-medium"
              >
                Regisztráció
              </NuxtLink>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow">
      <slot />
    </main>

    <!-- Footer -->
    <footer class="bg-gray-50 border-t border-gray-200">
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <p class="text-center text-gray-500 text-sm">
          © 2025 Optika. Minden jog fenntartva.
        </p>
      </div>
    </footer>
  </div>
</template>

<script setup lang="ts">
const { user, isLoggedIn } = useAuth()
</script>
