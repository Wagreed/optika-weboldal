<template>
  <div class="min-h-screen bg-white">
    <!-- Loading -->
    <div v-if="loading" class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div class="animate-pulse">
        <div class="h-3.5 bg-slate-100 rounded-full w-48 mb-8"></div>
        <div class="grid md:grid-cols-2 gap-10">
          <div class="h-96 bg-slate-100 rounded-2xl"></div>
          <div class="space-y-4">
            <div class="h-3 bg-slate-100 rounded-full w-1/4"></div>
            <div class="h-7 bg-slate-100 rounded-full w-3/4"></div>
            <div class="h-5 bg-slate-100 rounded-full w-1/3"></div>
            <div class="h-24 bg-slate-100 rounded-xl"></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Hiba -->
    <div v-else-if="error" class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
      <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
      </div>
      <p class="text-slate-600 text-lg font-medium">A termék nem található.</p>
      <NuxtLink to="/szemuvegek" class="mt-4 inline-block text-blue-600 hover:text-blue-700 font-medium transition">← Vissza a termékekhez</NuxtLink>
    </div>

    <!-- Termék -->
    <div v-else-if="product" class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Breadcrumb -->
      <nav class="flex items-center gap-2 text-sm text-slate-400 mb-8">
        <NuxtLink to="/" class="hover:text-slate-600 no-underline transition">Főoldal</NuxtLink>
        <span class="text-slate-300">›</span>
        <NuxtLink to="/szemuvegek" class="hover:text-slate-600 no-underline transition">Szemüvegek</NuxtLink>
        <span class="text-slate-300">›</span>
        <span class="text-slate-600 font-medium">{{ product.name }}</span>
      </nav>

      <div class="grid md:grid-cols-2 gap-10">
        <!-- Kép galéria -->
        <div>
          <div class="bg-slate-50 rounded-2xl border border-slate-100 overflow-hidden h-80 md:h-96 flex items-center justify-center mb-3">
            <img
              v-if="activeImage"
              :src="activeImage.url"
              :alt="activeImage.alt_text || product.name"
              class="w-full h-full object-contain p-6"
            >
            <div v-else class="flex flex-col items-center text-slate-300">
              <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
              <p class="text-sm mt-2">Nincs kép</p>
            </div>
          </div>
          <div v-if="product.images.length > 1" class="flex gap-2 flex-wrap">
            <button
              v-for="img in product.images"
              :key="img.id"
              @click="activeImage = img"
              class="w-16 h-16 rounded-xl border-2 overflow-hidden transition-all"
              :class="activeImage?.id === img.id ? 'border-blue-500 shadow-sm' : 'border-slate-200 hover:border-slate-300'"
            >
              <img :src="img.url" :alt="img.alt_text || product.name" class="w-full h-full object-cover">
            </button>
          </div>
        </div>

        <!-- Termék info -->
        <div class="flex flex-col">
          <!-- Pastel badges -->
          <div class="flex gap-2 flex-wrap mb-3">
            <span v-if="product.is_sunglasses" class="bg-amber-50 text-amber-700 text-xs font-semibold px-3 py-1 rounded-full border border-amber-100">Napszemüveg</span>
            <span v-if="product.is_prescription" class="bg-blue-50 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full border border-blue-100">Dioptriás</span>
            <span v-if="product.featured" class="bg-violet-50 text-violet-700 text-xs font-semibold px-3 py-1 rounded-full border border-violet-100">Kiemelt</span>
          </div>

          <p v-if="product.brand" class="text-xs font-semibold text-slate-400 uppercase tracking-widest">{{ product.brand }}</p>
          <h1 class="text-2xl md:text-3xl font-bold text-blue-950 mt-1 mb-4 leading-tight">{{ product.name }}</h1>

          <!-- Ár -->
          <div class="flex items-baseline gap-3 mb-6">
            <span v-if="product.sale_price" class="text-slate-400 line-through text-base">{{ formatPrice(product.price) }}</span>
            <span class="text-3xl font-bold text-blue-700">{{ formatPrice(product.sale_price || product.price) }}</span>
            <span v-if="product.sale_price" class="bg-orange-50 text-orange-700 text-xs font-semibold px-2 py-0.5 rounded-full border border-orange-100">Akció</span>
          </div>

          <p v-if="product.short_description" class="text-slate-500 mb-6 leading-relaxed text-sm">{{ product.short_description }}</p>

          <!-- Termék adatok grid -->
          <div class="bg-slate-50 rounded-2xl border border-slate-100 p-4 mb-6 grid grid-cols-2 gap-3">
            <div v-if="product.brand">
              <p class="text-xs text-slate-400 uppercase tracking-wider mb-0.5">Márka</p>
              <p class="text-sm font-semibold text-slate-800">{{ product.brand }}</p>
            </div>
            <div>
              <p class="text-xs text-slate-400 uppercase tracking-wider mb-0.5">Nem</p>
              <p class="text-sm font-semibold text-slate-800">{{ genderLabel(product.gender) }}</p>
            </div>
            <div v-if="product.frame_material">
              <p class="text-xs text-slate-400 uppercase tracking-wider mb-0.5">Keret anyaga</p>
              <p class="text-sm font-semibold text-slate-800">{{ product.frame_material }}</p>
            </div>
            <div v-if="product.frame_color">
              <p class="text-xs text-slate-400 uppercase tracking-wider mb-0.5">Keret színe</p>
              <p class="text-sm font-semibold text-slate-800">{{ product.frame_color }}</p>
            </div>
            <div v-if="product.frame_size">
              <p class="text-xs text-slate-400 uppercase tracking-wider mb-0.5">Keret mérete</p>
              <p class="text-sm font-semibold text-slate-800">{{ product.frame_size }}</p>
            </div>
            <div v-if="product.lens_type">
              <p class="text-xs text-slate-400 uppercase tracking-wider mb-0.5">Lencse típusa</p>
              <p class="text-sm font-semibold text-slate-800">{{ product.lens_type }}</p>
            </div>
          </div>

          <NuxtLink
            to="/contact"
            class="w-full bg-blue-600 text-white text-center py-3.5 rounded-xl font-semibold hover:bg-blue-700 transition-colors no-underline block mb-3 shadow-sm"
          >
            Időpontot foglalok
          </NuxtLink>
          <NuxtLink
            to="/szemuvegek"
            class="w-full border border-slate-200 text-slate-600 text-center py-3 rounded-xl font-medium hover:bg-slate-50 hover:border-slate-300 transition-colors no-underline block text-sm"
          >
            ← Vissza a termékekhez
          </NuxtLink>
        </div>
      </div>

      <!-- Teljes leírás -->
      <div v-if="product.description" class="mt-12 bg-white rounded-2xl border border-slate-100 shadow-sm p-8">
        <h2 class="text-xl font-bold text-blue-950 mb-4">Részletes leírás</h2>
        <div class="text-slate-500 leading-relaxed whitespace-pre-line text-sm">{{ product.description }}</div>
      </div>

      <!-- Kategóriák -->
      <div v-if="product.categories && product.categories.length > 0" class="mt-4 flex items-center gap-2 flex-wrap">
        <span class="text-xs text-slate-400">Kategóriák:</span>
        <span
          v-for="cat in product.categories"
          :key="cat.id"
          class="text-xs bg-slate-50 text-slate-500 border border-slate-100 px-2.5 py-1 rounded-full"
        >{{ cat.name }}</span>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import type { Product, ProductImage } from '~/composables/useProducts'

const route = useRoute()
const { fetchProduct, formatPrice, genderLabel } = useProducts()

const product = ref<Product | null>(null)
const loading = ref(true)
const error = ref(false)
const activeImage = ref<ProductImage | null>(null)

useHead(computed(() => ({
  title: product.value ? `${product.value.name} - Optika` : 'Termék - Optika',
})))

onMounted(async () => {
  try {
    const data = await fetchProduct(route.params.slug as string)
    product.value = data.product
    const primary = product.value?.images.find(i => i.is_primary) ?? product.value?.images[0]
    activeImage.value = primary ?? null
  } catch {
    error.value = true
  } finally {
    loading.value = false
  }
})
</script>
