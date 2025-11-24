<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Navigációs menü - Sticky -->
    <nav class="sticky top-0 z-50 bg-gradient-to-r from-blue-900 via-blue-800 to-blue-900 text-white shadow-lg">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <NuxtLink
              to="/"
              class="text-2xl font-bold text-white no-underline px-3 py-2 rounded-lg hover:bg-blue-800 transition-all duration-300"
            >
              Optika
            </NuxtLink>
          </div>

          <!-- Desktop menü -->
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

            <!-- Auth linkek -->
            <div class="flex items-center space-x-2 ml-4 pl-4 border-l border-blue-700">
              <template v-if="isLoggedIn">
                <span class="text-white text-sm">{{ user?.name }}</span>
                <NuxtLink
                  to="/profile"
                  class="text-white no-underline font-medium px-4 py-2 rounded-lg bg-green-600 hover:bg-green-700 hover:scale-105 transition-all duration-300"
                >
                  Profilom
                </NuxtLink>
              </template>
              <template v-else>
                <NuxtLink
                  to="/login"
                  class="text-white no-underline font-medium px-4 py-2 rounded-lg hover:bg-blue-800 hover:scale-105 transition-all duration-300"
                >
                  Bejelentkezés
                </NuxtLink>
                <NuxtLink
                  to="/register"
                  class="text-white no-underline font-medium px-4 py-2 rounded-lg bg-green-600 hover:bg-green-700 hover:scale-105 transition-all duration-300"
                >
                  Regisztráció
                </NuxtLink>
              </template>
            </div>
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
              <template v-if="isLoggedIn">
                <div class="px-4 py-2 text-white text-sm">
                  {{ user?.name }}
                </div>
                <NuxtLink
                  to="/profile"
                  @click="mobileMenuOpen = false"
                  class="block text-white no-underline font-medium px-4 py-3 rounded-lg bg-green-600 hover:bg-green-700 transition-all duration-300"
                >
                  Profilom
                </NuxtLink>
              </template>
              <template v-else>
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
                  class="block text-white no-underline font-medium px-4 py-3 rounded-lg bg-green-600 hover:bg-green-700 transition-all duration-300"
                >
                  Regisztráció
                </NuxtLink>
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

// Auth state
const { user, isLoggedIn } = useAuth()
</script>
