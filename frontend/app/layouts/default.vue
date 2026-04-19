<template>
  <div class="min-h-screen bg-white">

    <!-- Floating navbar wrapper - pointer-events-none hogy az oldalon átlátszón klikelhető legyen -->
    <div class="fixed top-0 left-0 right-0 z-50 flex justify-center px-4 pt-3 pointer-events-none">
      <nav
        class="w-full max-w-5xl pointer-events-auto bg-gradient-to-r from-blue-900 to-blue-800 rounded-2xl shadow-xl transition-all duration-300 ease-in-out"
        :class="navVisible ? 'translate-y-0 opacity-100' : '-translate-y-[calc(100%+16px)] opacity-0'"
      >
        <div class="px-5 sm:px-6">
          <div class="flex justify-between items-center h-14">

            <!-- Logo -->
            <NuxtLink to="/" class="flex items-center rounded-lg hover:opacity-80 transition-opacity">
              <img src="/img/logo.png" alt="Optika Logo" class="h-6 w-auto object-contain" />
            </NuxtLink>

            <!-- Desktop linkek -->
            <div class="hidden md:flex items-center gap-1">
              <NuxtLink
                v-for="link in navLinks"
                :key="link.to"
                :to="link.to"
                class="text-blue-100 no-underline text-sm font-medium px-3.5 py-1.5 rounded-xl hover:bg-blue-800 hover:text-white transition-all"
                active-class="bg-blue-800 text-white"
              >
                {{ link.label }}
              </NuxtLink>
            </div>

            <!-- Auth gomb jobbra -->
            <div class="hidden md:flex items-center relative">
              <button
                @click="userMenuOpen = !userMenuOpen"
                class="flex items-center gap-2 px-3 py-1.5 rounded-xl bg-blue-800/60 hover:bg-blue-700 border border-blue-700/50 transition-all text-sm font-medium text-white"
              >
                <div class="w-5 h-5 bg-blue-600 rounded-full flex items-center justify-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                </div>
                <span v-if="isLoggedIn" class="max-w-24 truncate text-xs">{{ user?.name }}</span>
                <span v-else class="text-xs">Fiók</span>
                <svg class="h-3 w-3 text-blue-300 transition-transform duration-200" :class="{ 'rotate-180': userMenuOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </button>

              <!-- Dropdown -->
              <transition
                enter-active-class="transition ease-out duration-150"
                enter-from-class="opacity-0 -translate-y-1 scale-95"
                enter-to-class="opacity-100 translate-y-0 scale-100"
                leave-active-class="transition ease-in duration-100"
                leave-from-class="opacity-100 translate-y-0 scale-100"
                leave-to-class="opacity-0 -translate-y-1 scale-95"
              >
                <div
                  v-if="userMenuOpen"
                  class="absolute right-0 top-full mt-2 w-52 bg-white rounded-2xl shadow-xl border border-slate-100 py-1.5 z-50"
                >
                  <template v-if="!isLoggedIn">
                    <div class="px-4 py-2">
                      <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Fiók</p>
                    </div>
                    <NuxtLink to="/login" @click="userMenuOpen = false" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 transition no-underline">
                      <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                      </svg>
                      <span class="font-medium">Bejelentkezés</span>
                    </NuxtLink>
                    <NuxtLink to="/register" @click="userMenuOpen = false" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 transition no-underline">
                      <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                      </svg>
                      <span class="font-medium">Regisztráció</span>
                    </NuxtLink>
                  </template>
                  <template v-else>
                    <div class="px-4 py-2 border-b border-slate-100">
                      <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Bejelentkezve</p>
                    </div>
                    <a v-if="isAdminOrStaff" :href="adminPanelUrl" target="_blank" @click="userMenuOpen = false" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 hover:bg-violet-50 hover:text-violet-700 transition no-underline">
                      <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                      </svg>
                      <span class="font-medium">Admin Panel</span>
                    </a>
                    <NuxtLink v-else to="/profile" @click="userMenuOpen = false" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition no-underline">
                      <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                      </svg>
                      <span class="font-medium">Profil</span>
                    </NuxtLink>
                    <div class="border-t border-slate-100 mt-1 pt-1">
                      <button @click="handleLogout" class="flex items-center gap-3 w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition">
                        <svg class="h-4 w-4 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="font-medium">Kijelentkezés</span>
                      </button>
                    </div>
                  </template>
                </div>
              </transition>
            </div>

            <!-- Mobil hamburger -->
            <button
              @click="mobileMenuOpen = !mobileMenuOpen"
              class="md:hidden text-white p-2 rounded-xl hover:bg-blue-800 transition"
              aria-label="Menü"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path v-if="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>

        <!-- Mobil menü -->
        <transition
          enter-active-class="transition-all duration-200 ease-out"
          enter-from-class="opacity-0 max-h-0"
          enter-to-class="opacity-100 max-h-96"
          leave-active-class="transition-all duration-150 ease-in"
          leave-from-class="opacity-100 max-h-96"
          leave-to-class="opacity-0 max-h-0"
        >
          <div v-if="mobileMenuOpen" class="md:hidden overflow-hidden border-t border-blue-800/50 rounded-b-2xl">
            <div class="px-5 py-3 space-y-1">
              <NuxtLink
                v-for="link in navLinks"
                :key="link.to"
                :to="link.to"
                @click="mobileMenuOpen = false"
                class="block text-blue-100 no-underline text-sm font-medium px-3.5 py-2.5 rounded-xl hover:bg-blue-800 hover:text-white transition"
                active-class="bg-blue-800 text-white"
              >
                {{ link.label }}
              </NuxtLink>
              <div class="border-t border-blue-800/50 pt-2 mt-2 space-y-1">
                <template v-if="!isLoggedIn">
                  <NuxtLink to="/login" @click="mobileMenuOpen = false" class="block text-blue-100 no-underline text-sm font-medium px-3.5 py-2.5 rounded-xl hover:bg-blue-800 transition">Bejelentkezés</NuxtLink>
                  <NuxtLink to="/register" @click="mobileMenuOpen = false" class="block text-blue-100 no-underline text-sm font-medium px-3.5 py-2.5 rounded-xl hover:bg-blue-800 transition">Regisztráció</NuxtLink>
                </template>
                <template v-else>
                  <div class="px-3.5 py-1.5">
                    <p class="text-xs text-blue-400">{{ user?.name }}</p>
                  </div>
                  <a v-if="isAdminOrStaff" :href="adminPanelUrl" target="_blank" @click="mobileMenuOpen = false" class="block text-blue-100 no-underline text-sm font-medium px-3.5 py-2.5 rounded-xl hover:bg-blue-800 transition">Admin Panel</a>
                  <NuxtLink v-else to="/profile" @click="mobileMenuOpen = false" class="block text-blue-100 no-underline text-sm font-medium px-3.5 py-2.5 rounded-xl hover:bg-blue-800 transition">Profil</NuxtLink>
                  <button @click="handleLogout" class="block w-full text-left text-sm font-medium px-3.5 py-2.5 rounded-xl text-red-300 hover:bg-blue-800/50 transition">Kijelentkezés</button>
                </template>
              </div>
            </div>
          </div>
        </transition>
      </nav>
    </div>

    <!-- Floating navbar átfedi a tartalmat, ezért az oldalak saját maguk kezelik a top paddinget -->
    <main>
      <slot />
    </main>

    <footer class="bg-slate-900 text-slate-400 py-10 mt-auto">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p class="text-sm">&copy; 2025 Optika. Minden jog fenntartva.</p>
      </div>
    </footer>
  </div>
</template>

<script setup>
const mobileMenuOpen = ref(false)
const userMenuOpen = ref(false)
const isScrolled = ref(false)
const mouseNearTop = ref(false)

// Navbar látható ha az oldal tetején vagyunk, VAGY az egér a viewport tetején van
const navVisible = computed(() => !isScrolled.value || mouseNearTop.value)

const navLinks = [
  { to: '/', label: 'Főoldal' },
  { to: '/about', label: 'Rólunk' },
  { to: '/services', label: 'Szolgáltatások' },
  { to: '/szemuvegek', label: 'Szemüvegek' },
  { to: '/contact', label: 'Kapcsolat' },
]

const { user, isLoggedIn, isAdminOrStaff, logout } = useAuth()
const config = useRuntimeConfig()
const adminPanelUrl = config.public.adminUrl

const handleLogout = async () => {
  mobileMenuOpen.value = false
  userMenuOpen.value = false
  await logout()
}

onMounted(() => {
  const handleScroll = () => {
    isScrolled.value = window.scrollY > 80
  }

  const handleMouseMove = (e) => {
    // Ha az egér a viewport felső 72px-én van, mutasd a navbart
    mouseNearTop.value = e.clientY < 72
  }

  window.addEventListener('scroll', handleScroll, { passive: true })
  window.addEventListener('mousemove', handleMouseMove, { passive: true })

  onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll)
    window.removeEventListener('mousemove', handleMouseMove)
  })
})
</script>
