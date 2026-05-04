<template>
  <div>
    <!-- HERO -->
    <section class="relative overflow-hidden bg-blue-950 flex items-center" style="min-height:100vh;padding-top:7rem;padding-bottom:5rem;">
      <div class="absolute inset-0" style="background:linear-gradient(135deg,rgba(15,23,42,.8) 0%,rgba(30,58,138,.55) 60%,rgba(37,99,235,.3) 100%);"></div>
      <div class="absolute right-0 top-1/2 -translate-y-1/2 pointer-events-none" style="width:520px;height:520px;opacity:.18;">
        <svg viewBox="0 0 500 500" fill="none" class="w-full h-full">
          <circle cx="250" cy="250" r="230" stroke="white" stroke-width="1"/>
          <circle cx="250" cy="250" r="185" stroke="white" stroke-width="1"/>
          <circle cx="250" cy="250" r="140" stroke="white" stroke-width="1.5"/>
          <circle cx="250" cy="250" r="95" stroke="white" stroke-width="1.5"/>
          <circle cx="250" cy="250" r="50" stroke="white" stroke-width="2"/>
          <circle cx="250" cy="250" r="15" fill="white" opacity=".4"/>
          <line x1="250" y1="10" x2="250" y2="490" stroke="white" stroke-width=".5"/>
          <line x1="10" y1="250" x2="490" y2="250" stroke="white" stroke-width=".5"/>
        </svg>
      </div>
      <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="max-w-2xl">
          <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 text-blue-100 text-xs font-semibold px-3 py-1.5 rounded-full mb-7 backdrop-blur-sm">
            <span class="w-1.5 h-1.5 bg-blue-300 rounded-full"></span>Professzionális optikai szolgáltatások
          </div>
          <h1 class="mb-6 leading-none text-white" style="font-family:'Outfit',sans-serif;font-size:clamp(3rem,7vw,5.5rem);font-weight:800;letter-spacing:-.02em;">
            Üdvözöljük az<br><span class="text-blue-300">Optikánkban!</span>
          </h1>
          <p class="mb-10 leading-relaxed text-blue-100/80 max-w-lg" style="font-size:1.125rem;">Professzionális szemészeti szolgáltatások és kiváló minőségű szemüvegek egy helyen, több évtizedes tapasztalattal.</p>
          <div class="flex gap-3 flex-wrap">
            <NuxtLink to="/contact" class="btn-primary">Időpont foglalás</NuxtLink>
            <NuxtLink v-if="!isLoggedIn" to="/register" class="btn-ghost">Regisztráció</NuxtLink>
            <a v-if="isLoggedIn && isAdminOrStaff" :href="adminPanelUrl" target="_blank" class="btn-ghost">Admin Panel</a>
            <NuxtLink v-else-if="isLoggedIn" to="/profile" class="btn-ghost">Profilom</NuxtLink>
          </div>
          <div class="flex items-center gap-3 mt-16 text-blue-200/50">
            <div class="w-6 h-10 rounded-full flex items-start justify-center pt-2" style="border:1px solid rgba(255,255,255,.2);">
              <div class="w-1 h-2 rounded-full bg-blue-300 scroll-dot"></div>
            </div>
            <span class="text-xs uppercase tracking-widest">Görgess le</span>
          </div>
        </div>
      </div>
    </section>

    <!-- SERVICES -->
    <section class="py-24 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
          <div class="section-label mb-5">Mire számíthat nálunk</div>
          <h2 class="mb-3 text-blue-950" style="font-family:'Outfit',sans-serif;font-size:clamp(2rem,4vw,2.75rem);font-weight:800;letter-spacing:-.02em;">Szolgáltatásaink</h2>
          <p class="text-slate-500">Minden, amire a látásodnak szüksége van</p>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
          <div v-for="service in services" :key="service.title" class="glass-card p-7 text-center">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-5" :style="`background:${service.iconBg}`">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" :style="`color:${service.iconColor}`">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" :d="service.icon"/>
              </svg>
            </div>
            <h3 class="font-semibold text-blue-950 mb-2">{{ service.title }}</h3>
            <p class="text-slate-500 text-sm leading-relaxed">{{ service.desc }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- FEATURED PRODUCTS -->
    <section v-if="featuredProducts.length > 0" class="py-16 bg-slate-50 border-y border-slate-100">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
          <div>
            <h2 class="font-bold text-blue-950 mb-1" style="font-family:'Outfit',sans-serif;font-size:1.6rem;">Kiemelt termékek</h2>
            <p class="text-slate-500 text-sm">Legkedveltebb szemüvegeink</p>
          </div>
          <NuxtLink to="/szemuvegek" class="flex items-center gap-1.5 text-sm font-semibold text-blue-600 hover:text-blue-700 no-underline transition-colors">
            Összes megtekintése
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
          </NuxtLink>
        </div>
        <div ref="carouselRef" class="overflow-x-hidden -mx-4 px-4 select-none" :class="isDragging?'cursor-grabbing':'cursor-grab'" @mouseenter="isHovered=true" @mouseleave="isHovered=false;onDragEnd()" @mousedown="onDragStart" @mousemove="onDragMove" @mouseup="onDragEnd" @touchstart.passive="onTouchStart" @touchmove.passive="onTouchMove" @touchend="onDragEnd">
          <div class="flex gap-4 pb-2">
            <NuxtLink v-for="(product,i) in [...featuredProducts,...featuredProducts]" :key="`${i}-${product.id}`" :to="`/szemuvegek/${product.slug}`" class="flex-shrink-0 w-52 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden hover:-translate-y-1 hover:shadow-md hover:border-blue-100 transition-all duration-300 no-underline group" :draggable="false">
              <div class="h-40 bg-slate-50 flex items-center justify-center overflow-hidden">
                <img v-if="product.primary_image_url" :src="product.primary_image_url" :alt="product.name" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                <svg v-else class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
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

    <!-- STATS -->
    <section class="py-20 bg-blue-950">
      <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
          <div v-for="stat in stats" :key="stat.label">
            <p class="font-extrabold text-blue-300 mb-2 tabular-nums" style="font-family:'Outfit',sans-serif;font-size:clamp(2.5rem,5vw,3.5rem);line-height:1;">{{ stat.value }}</p>
            <p class="text-sm text-blue-200/70">{{ stat.label }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- WHY US -->
    <section class="py-24 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
          <div class="section-label mb-5">Biztos döntés</div>
          <h2 class="mb-3 text-blue-950" style="font-family:'Outfit',sans-serif;font-size:clamp(2rem,4vw,2.75rem);font-weight:800;letter-spacing:-.02em;">Miért válasszon minket?</h2>
          <p class="text-slate-500">Több évtizedes tapasztalat az Ön szolgálatában</p>
        </div>
        <div class="grid md:grid-cols-2 gap-5">
          <div v-for="reason in reasons" :key="reason.title" class="glass-card p-6 flex items-start gap-4">
            <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5 border border-blue-100">
              <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div>
              <h3 class="font-semibold text-blue-950 mb-1">{{ reason.title }}</h3>
              <p class="text-slate-500 text-sm leading-relaxed">{{ reason.desc }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section class="py-20 bg-gradient-to-br from-blue-900 to-blue-800">
      <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="font-bold text-white mb-4" style="font-family:'Outfit',sans-serif;font-size:clamp(1.8rem,4vw,2.5rem);">Készen állsz a jobb látásra?</h2>
        <p class="text-blue-200/80 mb-8 leading-relaxed">Foglalj időpontot még ma — csapatunk örömmel fogad és segít megtalálni a számodra legjobb megoldást.</p>
        <div class="flex gap-3 justify-center flex-wrap">
          <NuxtLink to="/contact" class="bg-white text-blue-900 no-underline px-7 py-3.5 rounded-xl font-semibold hover:bg-blue-50 transition-colors shadow-sm inline-block">Időpont foglalás</NuxtLink>
          <NuxtLink to="/szemuvegek" class="btn-ghost">Termékeink</NuxtLink>
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
onMounted(async () => { try { const data = await fetchFeatured(); featuredProducts.value = data.products ?? [] } catch {} })
const services = [
  { title: 'Látásvizsgálat', desc: 'Precíz és alapos szemvizsgálat modern diagnosztikai eszközökkel.', icon: 'M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z', iconBg: '#eff6ff', iconColor: '#2563eb' },
  { title: 'Szemüveg készítés', desc: 'Egyedi, stílusos és minőségi keretek széles választéka prémium márkáktól.', icon: 'M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v10m0 0h10M9 13H5m0 0a2 2 0 01-2-2V9m2 4v4a2 2 0 002 2h2m0 0h4m-4 0v-4m4 4v-4m0 0h2a2 2 0 002-2v-4', iconBg: '#f0f9ff', iconColor: '#0284c7' },
  { title: 'Kontaktlencse', desc: 'Széles választék és szakszerű személyes tanácsadás minden igényre.', icon: 'M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-4a4 4 0 100 8 4 4 0 000-8zm0 2a2 2 0 110 4 2 2 0 010-4z', iconBg: '#f0fdf4', iconColor: '#16a34a' },
]
const stats = [{ value: '20+', label: 'Év tapasztalat' }, { value: '3 000+', label: 'Elégedett páciens' }, { value: '500+', label: 'Szemüveg típus' }, { value: '4', label: 'Szakember' }]
const reasons = [{ title: 'Tapasztalt szakemberek', desc: 'Több évtizedes szakmai tapasztalat és folyamatos képzés.' }, { title: 'Modern technológia', desc: 'Legújabb diagnosztikai eszközök a pontos eredményekért.' }, { title: 'Kiváló minőség', desc: 'Csak minősített termékek és elismert márkák.' }, { title: 'Személyre szabott', desc: 'Egyedi megoldások minden páciens egyedi igényeire.' }]
const carouselRef = ref<HTMLDivElement | null>(null)
const isDragging = ref(false), isHovered = ref(false), dragStartX = ref(0), dragScrollLeft = ref(0)
let rafId: number | null = null
const startAutoScroll = () => { const tick = () => { const el = carouselRef.value; if (el && !isDragging.value && !isHovered.value) { el.scrollLeft += 0.6; if (el.scrollLeft >= el.scrollWidth / 2) el.scrollLeft -= el.scrollWidth / 2 }; rafId = requestAnimationFrame(tick) }; rafId = requestAnimationFrame(tick) }
onMounted(() => startAutoScroll())
onUnmounted(() => { if (rafId) cancelAnimationFrame(rafId) })
const onDragStart = (e: MouseEvent) => { if (!carouselRef.value) return; isDragging.value = true; dragStartX.value = e.pageX - carouselRef.value.offsetLeft; dragScrollLeft.value = carouselRef.value.scrollLeft }
const onDragMove = (e: MouseEvent) => { if (!isDragging.value || !carouselRef.value) return; carouselRef.value.scrollLeft = dragScrollLeft.value - (e.pageX - carouselRef.value.offsetLeft - dragStartX.value) }
const onDragEnd = () => { isDragging.value = false }
const onTouchStart = (e: TouchEvent) => { if (!carouselRef.value || !e.touches[0]) return; isDragging.value = true; dragStartX.value = e.touches[0].pageX - carouselRef.value.offsetLeft; dragScrollLeft.value = carouselRef.value.scrollLeft }
const onTouchMove = (e: TouchEvent) => { if (!isDragging.value || !carouselRef.value || !e.touches[0]) return; carouselRef.value.scrollLeft = dragScrollLeft.value - (e.touches[0].pageX - carouselRef.value.offsetLeft - dragStartX.value) }
</script>
<style scoped>
.scroll-dot { animation: sb 1.8s ease-in-out infinite; }
@keyframes sb { 0%,100%{transform:translateY(0);opacity:1} 50%{transform:translateY(6px);opacity:.4} }
</style>
