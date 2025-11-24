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
              enter-from-class="opacity-0 -translate-y-2"
              enter-to-class="opacity-100 translate-y-0"
              leave-active-class="transition ease-in duration-150"
              leave-from-class="opacity-100 translate-y-0"
              leave-to-class="opacity-0 -translate-y-2"
            >
              <div
                v-if="userMenuOpen"
                class="absolute right-0 top-full mt-3 w-56 bg-white rounded-xl shadow-2xl border border-gray-100 py-2 z-50 overflow-hidden"
              >
                <template v-if="!isLoggedIn">
                  <div class="px-3 py-2 border-b border-gray-100">
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Fiók kezelés</p>
                  </div>
                  <div class="py-1">
                    <NuxtLink
                      to="/login"
                      @click="userMenuOpen = false"
                      class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-all duration-150 no-underline group"
                    >
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-400 group-hover:text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                      </svg>
                      <span class="font-medium">Bejelentkezés</span>
                    </NuxtLink>
                    <NuxtLink
                      to="/register"
                      @click="userMenuOpen = false"
                      class="flex items-center px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-700 transition-all duration-150 no-underline group"
                    >
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-400 group-hover:text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                      </svg>
                      <span class="font-medium">Regisztráció</span>
                    </NuxtLink>
                  </div>
                </template>
                <template v-else>
                  <div class="px-3 py-2 border-b border-gray-100">
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Bejelentkezve</p>
                  </div>
                  <div class="py-1">
                    <a
                      v-if="isAdminOrStaff"
                      :href="adminPanelUrl"
                      target="_blank"
                      @click="userMenuOpen = false"
                      class="flex items-center px-4 py-3 text-gray-700 hover:bg-purple-50 hover:text-purple-700 transition-all duration-150 no-underline group"
                    >
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-400 group-hover:text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                      </svg>
                      <span class="font-medium">Admin Panel</span>
                    </a>
                    <NuxtLink
                      v-else
                      to="/profile"
                      @click="userMenuOpen = false"
                      class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-all duration-150 no-underline group"
                    >
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-400 group-hover:text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                      </svg>
                      <span class="font-medium">Profil</span>
                    </NuxtLink>
                  </div>
                  <div class="border-t border-gray-100 py-1">
                    <button
                      @click="handleLogout"
                      class="flex items-center w-full text-left px-4 py-3 text-red-600 hover:bg-red-50 transition-all duration-150 group"
                    >
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-red-400 group-hover:text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                      </svg>
                      <span class="font-medium">Kijelentkezés</span>
                    </button>
                  </div>
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
