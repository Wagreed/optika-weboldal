<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Navigációs menü - Sticky -->
    <nav class="sticky top-0 z-50 bg-gradient-to-r from-blue-900 via-blue-800 to-blue-900 text-white shadow-lg">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <!-- Logo -->
          <div class="flex items-center">
            <NuxtLink
              to="/"
              class="text-2xl font-bold text-white no-underline px-3 py-2 rounded-lg hover:bg-blue-800 transition-all duration-300"
            >
              Optika
            </NuxtLink>
          </div>

          <!-- Desktop menü középen -->
          <div class="hidden md:flex items-center space-x-2">
            <NuxtLink
              to="/"
              class="text-white no-underline font-medium px-4 py-2 rounded-lg hover:bg-blue-800 hover:scale-105 transition-all duration-300"
              active-class="bg-blue-700 scale-105"
            >
              Főoldal
            </NuxtLink>
            <NuxtLink
              to="/about"
              class="text-white no-underline font-medium px-4 py-2 rounded-lg hover:bg-blue-800 hover:scale-105 transition-all duration-300"
              active-class="bg-blue-700 scale-105"
            >
              Rólunk
            </NuxtLink>
            <NuxtLink
              to="/services"
              class="text-white no-underline font-medium px-4 py-2 rounded-lg hover:bg-blue-800 hover:scale-105 transition-all duration-300"
              active-class="bg-blue-700 scale-105"
            >
              Szolgáltatások
            </NuxtLink>
            <NuxtLink
              to="/contact"
              class="text-white no-underline font-medium px-4 py-2 rounded-lg hover:bg-blue-800 hover:scale-105 transition-all duration-300"
              active-class="bg-blue-700 scale-105"
            >
              Kapcsolat
            </NuxtLink>
          </div>

          <!-- Auth dropdown jobbra -->
          <div class="hidden md:flex items-center relative">
            <button
              @click="userMenuOpen = !userMenuOpen"
              class="flex items-center gap-2 px-3 py-2 bg-blue-700 rounded-lg hover:bg-blue-600 transition-all duration-300"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
              <span v-if="isLoggedIn" class="text-white text-sm font-medium">{{ user?.name }}</span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white transition-transform duration-300" :class="{ 'rotate-180': userMenuOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>

            <!-- Dropdown menu -->
            <transition
              enter-active-class="transition ease-out duration-200"
              enter-from-class="opacity-0 scale-95"
              enter-to-class="opacity-100 scale-100"
              leave-active-class="transition ease-in duration-150"
              leave-from-class="opacity-100 scale-100"
              leave-to-class="opacity-0 scale-95"
            >
              <div
                v-if="userMenuOpen"
                class="absolute right-0 top-full mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50"
              >
                <template v-if="!isLoggedIn">
                  <NuxtLink
                    to="/login"
                    @click="userMenuOpen = false"
                    class="block px-4 py-2 text-gray-700 hover:bg-blue-50 transition-colors no-underline"
                  >
                    Bejelentkezés
                  </NuxtLink>
                  <NuxtLink
                    to="/register"
                    @click="userMenuOpen = false"
                    class="block px-4 py-2 text-gray-700 hover:bg-blue-50 transition-colors no-underline"
                  >
                    Regisztráció
                  </NuxtLink>
                </template>
                <template v-else>
                  <a
                    v-if="isAdminOrStaff"
                    :href="adminPanelUrl"
                    target="_blank"
                    @click="userMenuOpen = false"
                    class="block px-4 py-2 text-gray-700 hover:bg-blue-50 transition-colors no-underline"
                  >
                    Admin Panel
                  </a>
                  <NuxtLink
                    v-else
                    to="/profile"
                    @click="userMenuOpen = false"
                    class="block px-4 py-2 text-gray-700 hover:bg-blue-50 transition-colors no-underline"
                  >
                    Profil
                  </NuxtLink>
                  <button
                    @click="handleLogout"
                    class="block w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 transition-colors"
                  >
                    Kijelentkezés
                  </button>
                </template>
              </div>
            </transition>
          </div>

          <!-- Mobil hamburger gomb -->
          <div class="md:hidden flex items-center">
            <button
              @click="mobileMenuOpen = !mobileMenuOpen"
              class="text-white p-2 rounded-lg bg-blue-500 hover:bg-blue-800 transition-all duration-300 focus:outline-none border-0"
              aria-label="Menü megnyitása"
            >
              <svg
                class="w-6 h-6 transition-transform duration-300 text-white"
                :class="{ 'rotate-90': mobileMenuOpen }"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  v-if="!mobileMenuOpen"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"
                />
                <path
                  v-else
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Mobil menü -->
      <transition
        enter-active-class="transition-all duration-300 ease-out"
        enter-from-class="opacity-0 -translate-y-4"
        enter-to-class="opacity-100 translate-y-0"
        leave-active-class="transition-all duration-200 ease-in"
        leave-from-class="opacity-100 translate-y-0"
        leave-to-class="opacity-0 -translate-y-4"
      >
        <div
          v-if="mobileMenuOpen"
          class="md:hidden bg-blue-800 border-t border-blue-700"
        >
          <div class="px-4 py-3 space-y-2">
            <NuxtLink
              to="/"
              @click="mobileMenuOpen = false"
              class="block text-white no-underline font-medium px-4 py-3 rounded-lg hover:bg-blue-700 transition-all duration-300"
              active-class="bg-blue-700"
            >
              Főoldal
            </NuxtLink>
            <NuxtLink
              to="/about"
              @click="mobileMenuOpen = false"
              class="block text-white no-underline font-medium px-4 py-3 rounded-lg hover:bg-blue-700 transition-all duration-300"
              active-class="bg-blue-700"
            >
              Rólunk
            </NuxtLink>
            <NuxtLink
              to="/services"
              @click="mobileMenuOpen = false"
              class="block text-white no-underline font-medium px-4 py-3 rounded-lg hover:bg-blue-700 transition-all duration-300"
              active-class="bg-blue-700"
            >
              Szolgáltatások
            </NuxtLink>
            <NuxtLink
              to="/contact"
              @click="mobileMenuOpen = false"
              class="block text-white no-underline font-medium px-4 py-3 rounded-lg hover:bg-blue-700 transition-all duration-300"
              active-class="bg-blue-700"
            >
              Kapcsolat
            </NuxtLink>

            <!-- Auth linkek mobil -->
            <div class="border-t border-blue-700 pt-2 mt-2">
              <div class="flex items-center gap-2 px-4 py-3 bg-blue-700 rounded-lg mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span v-if="isLoggedIn" class="text-white text-sm font-medium">{{ user?.name }}</span>
                <span v-else class="text-white text-sm font-medium">Fiók</span>
              </div>

              <template v-if="!isLoggedIn">
                <NuxtLink
                  to="/login"
                  @click="mobileMenuOpen = false"
                  class="block text-white no-underline font-medium px-4 py-3 rounded-lg hover:bg-blue-700 transition-all duration-300"
                >
                  Bejelentkezés
                </NuxtLink>
                <NuxtLink
                  to="/register"
                  @click="mobileMenuOpen = false"
                  class="block text-white no-underline font-medium px-4 py-3 rounded-lg hover:bg-blue-700 transition-all duration-300"
                >
                  Regisztráció
                </NuxtLink>
              </template>
              <template v-else>
                <a
                  v-if="isAdminOrStaff"
                  :href="adminPanelUrl"
                  target="_blank"
                  @click="mobileMenuOpen = false"
                  class="block text-white no-underline font-medium px-4 py-3 rounded-lg hover:bg-blue-700 transition-all duration-300"
                >
                  Admin Panel
                </a>
                <NuxtLink
                  v-else
                  to="/profile"
                  @click="mobileMenuOpen = false"
                  class="block text-white no-underline font-medium px-4 py-3 rounded-lg hover:bg-blue-700 transition-all duration-300"
                >
                  Profil
                </NuxtLink>
                <button
                  @click="handleLogout"
                  class="block w-full text-white no-underline font-medium px-4 py-3 rounded-lg hover:bg-blue-700 transition-all duration-300 text-left"
                >
                  Kijelentkezés
                </button>
              </template>
            </div>
          </div>
        </div>
      </transition>
    </nav>

    <!-- Oldal tartalma -->
    <main>
      <slot />
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-auto py-8">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p>&copy; 2025 Optika. Minden jog fenntartva.</p>
      </div>
    </footer>
  </div>
</template>

<script setup>
// Mobil menü állapot
const mobileMenuOpen = ref(false)
const userMenuOpen = ref(false)

// Auth state
const { user, isLoggedIn, isAdminOrStaff, logout } = useAuth()
const config = useRuntimeConfig()
const adminPanelUrl = config.public.adminUrl

// Logout handler
const handleLogout = async () => {
  mobileMenuOpen.value = false
  userMenuOpen.value = false
  await logout()
}
</script>
