<template>
  <div class="min-h-screen flex" style="background:linear-gradient(135deg,#0f172a 0%,#1e3a8a 50%,#1d4ed8 100%);">

    <!-- Bal oldal: Dekoráció -->
    <div class="hidden lg:flex flex-1 items-center justify-center relative overflow-hidden p-12">
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
        <h2 class="mb-4 leading-tight" style="font-family:'Outfit',sans-serif;font-size:2.5rem;font-weight:800;">Csatlakozz<br>hozzánk ma.</h2>
        <p class="text-blue-200/80 leading-relaxed text-sm">Regisztráljon és foglaljon időpontot online, kövesse nyomon szemészeti ellátását, és értesüljön legújabb ajánlatainkról.</p>
        <div class="mt-10 space-y-3">
          <div v-for="feature in features" :key="feature" class="flex items-center gap-3 text-sm text-blue-100/80">
            <div class="w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0" style="background:rgba(37,99,235,.4);">
              <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
            </div>
            {{ feature }}
          </div>
        </div>
      </div>
    </div>

    <!-- Jobb oldal: Form -->
    <div class="w-full lg:w-[520px] flex items-center justify-center p-8 lg:p-12" style="background:rgba(255,255,255,0.04);backdrop-filter:blur(40px);border-left:1px solid rgba(255,255,255,0.08);">
      <div class="w-full max-w-sm">

        <!-- Logo (mobil) -->
        <div class="lg:hidden flex justify-center mb-8">
          <img src="/img/logo.png" alt="Optika" class="h-8 w-auto object-contain" style="filter:brightness(0) invert(1);" />
        </div>

        <!-- Header -->
        <div class="mb-8">
          <h1 class="text-white mb-2" style="font-family:'Outfit',sans-serif;font-size:1.875rem;font-weight:800;letter-spacing:-.02em;">Regisztráció</h1>
          <p class="text-sm" style="color:rgba(148,163,184,1);">
            Már van fiókja?
            <NuxtLink to="/login" class="font-semibold no-underline transition-colors" style="color:#60a5fa;">Jelentkezzen be</NuxtLink>
          </p>
        </div>

        <!-- Error -->
        <div v-if="errorMessage" class="mb-5 rounded-xl p-4 flex items-start gap-3" style="background:rgba(239,68,68,.12);border:1px solid rgba(239,68,68,.25);">
          <svg class="h-5 w-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20" style="color:#f87171;"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
          <span class="text-sm" style="color:#fca5a5;">{{ errorMessage }}</span>
        </div>

        <!-- Form -->
        <form class="space-y-4" @submit.prevent="handleRegister">
          <div>
            <label for="name" class="block text-sm font-medium mb-2" style="color:rgba(203,213,225,1);">Teljes név *</label>
            <input id="name" v-model="form.name" type="text" required class="w-full px-4 py-3 rounded-xl text-sm outline-none transition-all form-input" placeholder="Kovács János">
          </div>
          <div>
            <label for="email" class="block text-sm font-medium mb-2" style="color:rgba(203,213,225,1);">Email cím *</label>
            <input id="email" v-model="form.email" type="email" required class="w-full px-4 py-3 rounded-xl text-sm outline-none transition-all form-input" placeholder="pelda@email.com">
          </div>
          <div class="grid grid-cols-2 gap-3">
            <div>
              <label for="password" class="block text-sm font-medium mb-2" style="color:rgba(203,213,225,1);">Jelszó *</label>
              <input id="password" v-model="form.password" type="password" required minlength="8" class="w-full px-4 py-3 rounded-xl text-sm outline-none transition-all form-input" placeholder="Min. 8 kar.">
            </div>
            <div>
              <label for="password_confirmation" class="block text-sm font-medium mb-2" style="color:rgba(203,213,225,1);">Megerősítés *</label>
              <input id="password_confirmation" v-model="form.password_confirmation" type="password" required minlength="8" class="w-full px-4 py-3 rounded-xl text-sm outline-none transition-all form-input" placeholder="Jelszó újra">
            </div>
          </div>
          <div>
            <label for="phone" class="block text-sm font-medium mb-2" style="color:rgba(203,213,225,1);">Telefonszám <span style="color:rgba(100,116,139,1);">(opcionális)</span></label>
            <input id="phone" v-model="form.phone" type="tel" class="w-full px-4 py-3 rounded-xl text-sm outline-none transition-all form-input" placeholder="+40 7XX XXX XXX">
          </div>

          <button
            type="submit"
            :disabled="loading"
            class="w-full flex justify-center items-center py-3.5 px-4 rounded-xl text-white font-semibold transition-all mt-2 submit-btn"
          >
            <svg v-if="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            {{ loading ? 'Regisztráció...' : 'Regisztráció' }}
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
const { register } = useAuth()
const router = useRouter()
const form = ref({ name: '', email: '', password: '', password_confirmation: '', phone: '' })
const loading = ref(false)
const errorMessage = ref('')
const features = ['Online időpontfoglalás', 'Személyes fiók kezelés', 'Akciók és ajánlatok értesítők', 'Páciens előzmények']

const handleRegister = async () => {
  if (form.value.password !== form.value.password_confirmation) {
    errorMessage.value = 'A jelszavak nem egyeznek meg'
    return
  }
  loading.value = true
  errorMessage.value = ''
  const result = await register(form.value)
  if (result.success) {
    if (!result.redirectToAdmin) router.push('/profile')
  } else {
    errorMessage.value = result.message || 'Regisztráció sikertelen'
  }
  loading.value = false
}
</script>

<style>
.form-input {
  background: rgba(255,255,255,0.06);
  border: 1px solid rgba(255,255,255,0.12);
  color: #f1f5f9;
  font-family: 'DM Sans', sans-serif;
}
.form-input:focus { border-color: rgba(96,165,250,.6) !important; box-shadow: 0 0 0 3px rgba(37,99,235,.15); }
.form-input::placeholder { color: rgba(100,116,139,.7); }
.submit-btn { background: linear-gradient(135deg,#2563eb,#1d4ed8); box-shadow: 0 4px 20px rgba(37,99,235,.4); font-family: 'DM Sans', sans-serif; }
.submit-btn:hover:not(:disabled) { transform: translateY(-1px); box-shadow: 0 6px 28px rgba(37,99,235,.55) !important; }
.submit-btn:disabled { opacity: .55; cursor: not-allowed; }
</style>
