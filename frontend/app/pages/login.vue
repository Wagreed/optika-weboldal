<template>
  <div class="min-h-screen flex" style="background:linear-gradient(135deg,#0f172a 0%,#1e3a8a 50%,#1d4ed8 100%);">

    <!-- Bal oldal: Dekoráció -->
    <div class="hidden lg:flex flex-1 items-center justify-center relative overflow-hidden p-12">
      <!-- Lens SVG dekoráció -->
      <div class="absolute inset-0 flex items-center justify-center opacity-10">
        <svg viewBox="0 0 600 600" fill="none" style="width:600px;height:600px;">
          <circle cx="300" cy="300" r="280" stroke="white" stroke-width="1.5"/>
          <circle cx="300" cy="300" r="230" stroke="white" stroke-width="1"/>
          <circle cx="300" cy="300" r="175" stroke="white" stroke-width="1.5"/>
          <circle cx="300" cy="300" r="120" stroke="white" stroke-width="1"/>
          <circle cx="300" cy="300" r="65" stroke="white" stroke-width="2"/>
          <circle cx="300" cy="300" r="20" fill="white" opacity=".5"/>
          <line x1="300" y1="0" x2="300" y2="600" stroke="white" stroke-width=".5"/>
          <line x1="0" y1="300" x2="600" y2="300" stroke="white" stroke-width=".5"/>
        </svg>
      </div>

      <div class="relative z-10 text-white max-w-sm">
        <img src="/img/logo.png" alt="Optika" class="h-10 w-auto object-contain mb-8" style="filter:brightness(0) invert(1);" />
        <h2 class="mb-4 leading-tight" style="font-family:'Outfit',sans-serif;font-size:2.5rem;font-weight:800;">Látásunk<br>a jövőbe mutat.</h2>
        <p class="text-blue-200/80 leading-relaxed text-sm">Több mint két évtizedes tapasztalattal állunk pácienseink szolgálatában. Professzionális szemészeti ellátás, prémium minőségű szemüvegek.</p>
        <div class="mt-10 grid grid-cols-2 gap-4">
          <div class="bg-white/10 rounded-2xl p-4 backdrop-blur-sm border border-white/10">
            <p class="text-2xl font-bold" style="font-family:'Outfit',sans-serif;">20+</p>
            <p class="text-xs text-blue-200/70 mt-1">Év tapasztalat</p>
          </div>
          <div class="bg-white/10 rounded-2xl p-4 backdrop-blur-sm border border-white/10">
            <p class="text-2xl font-bold" style="font-family:'Outfit',sans-serif;">3 000+</p>
            <p class="text-xs text-blue-200/70 mt-1">Elégedett páciens</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Jobb oldal: Form -->
    <div class="w-full lg:w-[480px] flex items-center justify-center p-8 lg:p-12" style="background:rgba(255,255,255,0.04);backdrop-filter:blur(40px);border-left:1px solid rgba(255,255,255,0.08);">
      <div class="w-full max-w-sm">

        <!-- Logo (mobil) -->
        <div class="lg:hidden flex justify-center mb-8">
          <img src="/img/logo.png" alt="Optika" class="h-8 w-auto object-contain" style="filter:brightness(0) invert(1);" />
        </div>

        <!-- Header -->
        <div class="mb-8">
          <h1 class="text-white mb-2" style="font-family:'Outfit',sans-serif;font-size:1.875rem;font-weight:800;letter-spacing:-.02em;">Bejelentkezés</h1>
          <p class="text-sm" style="color:rgba(148,163,184,1);">
            Még nincs fiókja?
            <NuxtLink to="/register" class="font-semibold no-underline transition-colors" style="color:#60a5fa;">Regisztráljon most</NuxtLink>
          </p>
        </div>

        <!-- Error -->
        <div v-if="errorMessage" class="mb-5 rounded-xl p-4 flex items-start gap-3" style="background:rgba(239,68,68,.12);border:1px solid rgba(239,68,68,.25);">
          <svg class="h-5 w-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20" style="color:#f87171;"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
          <span class="text-sm" style="color:#fca5a5;">{{ errorMessage }}</span>
        </div>

        <!-- Form -->
        <form class="space-y-4" @submit.prevent="handleLogin">
          <div>
            <label for="email" class="block text-sm font-medium mb-2" style="color:rgba(203,213,225,1);">Email cím</label>
            <input
              id="email"
              v-model="form.email"
              type="email"
              required
              class="w-full px-4 py-3 rounded-xl text-sm outline-none transition-all"
              style="background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.12);color:#f1f5f9;font-family:'DM Sans',sans-serif;"
              placeholder="pelda@email.com"
            >
          </div>
          <div>
            <label for="password" class="block text-sm font-medium mb-2" style="color:rgba(203,213,225,1);">Jelszó</label>
            <input
              id="password"
              v-model="form.password"
              type="password"
              required
              class="w-full px-4 py-3 rounded-xl text-sm outline-none transition-all"
              style="background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.12);color:#f1f5f9;font-family:'DM Sans',sans-serif;"
              placeholder="••••••••"
            >
          </div>

          <button
            type="submit"
            :disabled="loading"
            class="w-full flex justify-center items-center py-3.5 px-4 rounded-xl text-white font-semibold transition-all mt-2"
            style="background:linear-gradient(135deg,#2563eb,#1d4ed8);box-shadow:0 4px 20px rgba(37,99,235,.4);font-family:'DM Sans',sans-serif;"
          >
            <svg v-if="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            {{ loading ? 'Bejelentkezés...' : 'Bejelentkezés' }}
          </button>
        </form>

        <div class="mt-6 pt-6 text-center" style="border-top:1px solid rgba(255,255,255,0.08);">
          <NuxtLink to="/" class="text-sm no-underline transition-colors" style="color:rgba(148,163,184,1);">← Vissza a főoldalra</NuxtLink>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ middleware: 'guest', layout: false })
const { login } = useAuth()
const router = useRouter()
const form = ref({ email: '', password: '' })
const loading = ref(false)
const errorMessage = ref('')

const handleLogin = async () => {
  loading.value = true
  errorMessage.value = ''
  const result = await login(form.value)
  if (result.success) {
    if (!result.redirectToAdmin) router.push('/profile')
  } else {
    errorMessage.value = result.message || 'Bejelentkezés sikertelen'
  }
  loading.value = false
}
</script>

<style>
input:focus { border-color: rgba(96,165,250,.6) !important; box-shadow: 0 0 0 3px rgba(37,99,235,.15); }
button[type="submit"]:hover:not(:disabled) { transform: translateY(-1px); box-shadow: 0 6px 28px rgba(37,99,235,.55) !important; }
button[type="submit"]:disabled { opacity: .55; cursor: not-allowed; }
</style>
