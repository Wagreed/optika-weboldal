<template>
  <div>
    <!-- Hero - háttérkép: /img/hero-bg.jpg, ha nincs fájl, a sötét gradient marad -->
    <section class="relative overflow-hidden bg-blue-950 pt-20 pb-24 min-h-[480px] flex items-center">
      <img
        src="/img/hero-bg.jpg"
        alt=""
        aria-hidden="true"
        class="absolute inset-0 w-full h-full object-cover opacity-50"
        @error="($event.target as HTMLImageElement).style.display = 'none'"
      >
      <div class="absolute inset-0 bg-gradient-to-br from-blue-950/70 via-blue-900/50 to-blue-800/40"></div>

      <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center w-full">
        <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 text-blue-100 text-xs font-semibold px-3 py-1.5 rounded-full mb-6 backdrop-blur-sm">
          <span class="w-1.5 h-1.5 bg-blue-300 rounded-full"></span>
          Professzionális optikai szolgáltatások
        </div>
        <h1 class="text-5xl md:text-6xl font-bold text-white mb-6 leading-tight">
          Üdvözöljük az<br>
          <span class="text-blue-300">Optikánkban!</span>
        </h1>
        <p class="text-blue-100/80 text-lg md:text-xl mb-10 max-w-xl mx-auto leading-relaxed">
          Professzionális szemészeti szolgáltatások és kiváló minőségű szemüvegek egy helyen.
        </p>
        <div class="flex gap-3 justify-center flex-wrap">
          <NuxtLink
            to="/contact"
            class="bg-blue-500 text-white no-underline px-7 py-3.5 rounded-xl font-semibold hover:bg-blue-400 transition-colors shadow-sm inline-block"
          >
            Időpont foglalás
          </NuxtLink>
          <NuxtLink
            v-if="!isLoggedIn"
            to="/register"
            class="bg-white/10 text-white no-underline px-7 py-3.5 rounded-xl font-semibold hover:bg-white/20 border border-white/25 transition-colors inline-block backdrop-blur-sm"
          >
            Regisztráció
          </NuxtLink>
          <a
            v-if="isLoggedIn && isAdminOrStaff"
            :href="adminPanelUrl"
            target="_blank"
            class="bg-white/10 text-violet-200 no-underline px-7 py-3.5 rounded-xl font-semibold hover:bg-white/20 border border-violet-300/30 transition-colors inline-block backdrop-blur-sm"
          >
            Admin Panel
          </a>
          <NuxtLink
            v-else-if="isLoggedIn"
            to="/profile"
            class="bg-white/10 text-white no-underline px-7 py-3.5 rounded-xl font-semibold hover:bg-white/20 border border-white/25 transition-colors inline-block backdrop-blur-sm"
          >
            Profilom
          </NuxtLink>
        </div>
      </div>
    </section>

    <!-- Szolgáltatások -->
    <section class="py-20 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-bold text-blue-950 mb-3">Szolgáltatásaink</h2>
          <p class="text-slate-500">Minden, amire a látásodnak szüksége van</p>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
          <div class="bg-white border border-slate-100 rounded-2xl p-7 shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300 text-center">
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center mx-auto mb-4">
              <span class="text-2xl">👁️</span>
            </div>
            <h3 class="text-lg font-semibold text-blue-950 mb-2">Látásvizsgálat</h3>
            <p class="text-slate-500 text-sm leading-relaxed">Precíz és alapos szemvizsgálat modern eszközökkel</p>
          </div>
          <div class="bg-white border border-slate-100 rounded-2xl p-7 shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300 text-center">
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center mx-auto mb-4">
              <span class="text-2xl">👓</span>
            </div>
            <h3 class="text-lg font-semibold text-blue-950 mb-2">Szemüveg készítés</h3>
            <p class="text-slate-500 text-sm leading-relaxed">Egyedi, stílusos és minőségi keretek széles választéka</p>
          </div>
          <div class="bg-white border border-slate-100 rounded-2xl p-7 shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300 text-center">
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center mx-auto mb-4">
              <span class="text-2xl">🔍</span>
            </div>
            <h3 class="text-lg font-semibold text-blue-950 mb-2">Kontaktlencse</h3>
            <p class="text-slate-500 text-sm leading-relaxed">Széles választék és szakszerű tanácsadás</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Kiemelt termékek -->
    <section v-if="featuredProducts.length > 0" class="py-16 bg-slate-50 border-y border-slate-100">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
          <div>
            <h2 class="text-2xl font-bold text-blue-950">Kiemelt termékek</h2>
            <p class="text-slate-500 text-sm mt-1">Legkedveltebb szemüvegeink</p>
          </div>
          <NuxtLink to="/szemuvegek" class="text-sm font-semibold text-blue-600 hover:text-blue-700 no-underline transition flex items-center gap-1">
            Összes megtekintése
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
          </NuxtLink>
        </div>
        <div
          ref="carouselRef"
          class="overflow-x-hidden -mx-4 px-4 select-none"
          :class="isDragging ? 'cursor-grabbing' : 'cursor-grab'"
          @mouseenter="isHovered = true"
          @mouseleave="isHovered = false; onDragEnd()"
          @mousedown="onDragStart"
          @mousemove="onDragMove"
          @mouseup="onDragEnd"
          @touchstart.passive="onTouchStart"
          @touchmove.passive="onTouchMove"
          @touchend="onDragEnd"
        >
          <div class="flex gap-4 pb-2">
            <NuxtLink
              v-for="(product, i) in [...featuredProducts, ...featuredProducts]"
              :key="`${i}-${product.id}`"
              :to="`/szemuvegek/${product.slug}`"
              class="flex-shrink-0 w-52 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden hover:-translate-y-1 hover:shadow-md transition-all duration-300 no-underline group"
              :draggable="false"
            >
              <div class="h-40 bg-slate-50 flex items-center justify-center overflow-hidden">
                <img
                  v-if="product.primary_image_url"
                  :src="product.primary_image_url"
                  :alt="product.name"
                  class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                >
                <svg v-else class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
              </div>
              <div class="p-3.5">
                <p v-if="product.brand" class="text-xs text-slate-400 font-medium uppercase tracking-wider mb-0.5">{{ product.brand }}</p>
                <p class="text-sm font-semibold text-slate-800 truncate">{{ product.name }}</p>
                <p class="text-blue-700 font-bold text-sm mt-1">
                  <span v-if="product.sale_price" class="line-through text-slate-400 text-xs mr-1 font-normal">{{ formatPrice(product.price) }}</span>
                  {{ formatPrice(product.sale_price || product.price) }}
                </p>
              </div>
            </NuxtLink>
          </div>
        </div>
      </div>
    </section>

    <!-- Miért válasszon minket -->
    <section class="py-20 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-bold text-blue-950 mb-3">Miért válasszon minket?</h2>
          <p class="text-slate-500">Több évtizedes tapasztalat az Ön szolgálatában</p>
        </div>
        <div class="grid md:grid-cols-2 gap-5">
          <div class="flex items-start gap-4 bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">
            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
              <svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
              </svg>
            </div>
            <div>
              <h3 class="text-base font-semibold text-blue-950 mb-1">Tapasztalt szakemberek</h3>
              <p class="text-slate-500 text-sm leading-relaxed">Több évtizedes szakmai tapasztalat</p>
            </div>
          </div>
          <div class="flex items-start gap-4 bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">
            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
              <svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
              </svg>
            </div>
            <div>
              <h3 class="text-base font-semibold text-blue-950 mb-1">Modern technológia</h3>
              <p class="text-slate-500 text-sm leading-relaxed">Legújabb diagnosztikai eszközök</p>
            </div>
          </div>
          <div class="flex items-start gap-4 bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">
            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
              <svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
              </svg>
            </div>
            <div>
              <h3 class="text-base font-semibold text-blue-950 mb-1">Kiváló minőség</h3>
              <p class="text-slate-500 text-sm leading-relaxed">Csak minősített termékek és anyagok</p>
            </div>
          </div>
          <div class="flex items-start gap-4 bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">
            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
              <svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
              </svg>
            </div>
            <div>
              <h3 class="text-base font-semibold text-blue-950 mb-1">Személyre szabott</h3>
              <p class="text-slate-500 text-sm leading-relaxed">Egyedi megoldások minden igényre</p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup lang="ts">
import type { Product } from '~/composables/useProducts'

const { isLoggedIn, isAdminOrStaff } = useAuth()
const config = useRuntimeConfig()
const adminPanelUrl = config.public.adminUrl

const { fetchFeatured, formatPrice } = useProducts()
const featuredProducts = ref<Product[]>([])

useHead({ title: 'Főoldal - Optika' })

onMounted(async () => {
  try {
    const data = await fetchFeatured()
    featuredProducts.value = data.products ?? []
  } catch {
    // Ha nincs termék, nem gond, a sáv nem jelenik meg
  }
})

// --- Carousel: auto-scroll + drag-to-scroll ---
const carouselRef = ref<HTMLDivElement | null>(null)
const isDragging = ref(false)
const isHovered = ref(false)
const dragStartX = ref(0)
const dragScrollLeft = ref(0)
let rafId: number | null = null

// rAF loop: lassan tolja a scrollLeft-et, egér hoverre/dragre megáll
const startAutoScroll = () => {
  const tick = () => {
    const el = carouselRef.value
    if (el && !isDragging.value && !isHovered.value) {
      el.scrollLeft += 0.6
      // Seamless loop: amikor elért a duplikált lista feléhez, visszaugrik
      if (el.scrollLeft >= el.scrollWidth / 2) {
        el.scrollLeft -= el.scrollWidth / 2
      }
    }
    rafId = requestAnimationFrame(tick)
  }
  rafId = requestAnimationFrame(tick)
}

onMounted(() => startAutoScroll())
onUnmounted(() => { if (rafId) cancelAnimationFrame(rafId) })

const onDragStart = (e: MouseEvent) => {
  if (!carouselRef.value) return
  isDragging.value = true
  dragStartX.value = e.pageX - carouselRef.value.offsetLeft
  dragScrollLeft.value = carouselRef.value.scrollLeft
}

const onDragMove = (e: MouseEvent) => {
  if (!isDragging.value || !carouselRef.value) return
  const x = e.pageX - carouselRef.value.offsetLeft
  carouselRef.value.scrollLeft = dragScrollLeft.value - (x - dragStartX.value)
}

const onDragEnd = () => { isDragging.value = false }

const onTouchStart = (e: TouchEvent) => {
  if (!carouselRef.value) return
  isDragging.value = true
  dragStartX.value = e.touches[0].pageX - carouselRef.value.offsetLeft
  dragScrollLeft.value = carouselRef.value.scrollLeft
}

const onTouchMove = (e: TouchEvent) => {
  if (!isDragging.value || !carouselRef.value) return
  const x = e.touches[0].pageX - carouselRef.value.offsetLeft
  carouselRef.value.scrollLeft = dragScrollLeft.value - (x - dragStartX.value)
}
</script>

<style scoped>
.scrollbar-hide {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
.scrollbar-hide::-webkit-scrollbar {
  display: none;
}
</style>
