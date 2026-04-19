<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Loading -->
    <div v-if="loading" class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div class="animate-pulse">
        <div class="h-4 bg-gray-200 rounded w-48 mb-8"></div>
        <div class="grid md:grid-cols-2 gap-10">
          <div class="h-96 bg-gray-200 rounded-xl"></div>
          <div class="space-y-4">
            <div class="h-5 bg-gray-200 rounded w-1/4"></div>
            <div class="h-8 bg-gray-200 rounded w-3/4"></div>
            <div class="h-6 bg-gray-200 rounded w-1/3"></div>
            <div class="h-24 bg-gray-200 rounded"></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Hiba -->
    <div v-else-if="error" class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
      <svg class="mx-auto w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
      </svg>
      <p class="text-gray-500 text-lg">A termék nem található.</p>
      <NuxtLink to="/szemuvegek" class="mt-4 inline-block text-blue-600 hover:underline font-medium">← Vissza a termékekhez</NuxtLink>
    </div>

    <!-- Termék -->
    <div v-else-if="product" class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Breadcrumb -->
      <nav class="flex items-center gap-2 text-sm text-gray-400 mb-8">
        <NuxtLink to="/" class="hover:text-gray-600 no-underline">Főoldal</NuxtLink>
        <span>›</span>
        <NuxtLink to="/szemuvegek" class="hover:text-gray-600 no-underline">Szemüvegek</NuxtLink>
        <span>›</span>
        <span class="text-gray-700">{{ product.name }}</span>
      </nav>

      <div class="grid md:grid-cols-2 gap-10">
        <!-- Kép galéria -->
        <div>
          <!-- Fő kép -->
          <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden h-80 md:h-96 flex items-center justify-center mb-3">
            <img
              v-if="activeImage"
              :src="activeImage.url"
              :alt="activeImage.alt_text || product.name"
              class="w-full h-full object-contain p-4"
            >
            <div v-else class="flex flex-col items-center text-gray-300">
              <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
              <p class="text-sm mt-2">Nincs kép</p>
            </div>
          </div>
          <!-- Thumbnails -->
          <div v-if="product.images.length > 1" class="flex gap-2 flex-wrap">
            <button
              v-for="img in product.images"
              :key="img.id"
              @click="activeImage = img"
              class="w-16 h-16 rounded-lg border-2 overflow-hidden transition-colors"
              :class="activeImage?.id === img.id ? 'border-blue-500' : 'border-gray-200 hover:border-gray-400'"
            >
              <img :src="img.url" :alt="img.alt_text || product.name" class="w-full h-full object-cover">
            </button>
          </div>
        </div>

        <!-- Termék info -->
        <div class="flex flex-col">
          <!-- Badgek -->
          <div class="flex gap-2 flex-wrap mb-3">
            <span v-if="product.is_sunglasses" class="bg-yellow-100 text-yellow-700 text-xs font-bold px-2.5 py-1 rounded-full">Napszemüveg</span>
            <span v-if="product.is_prescription" class="bg-blue-100 text-blue-700 text-xs font-bold px-2.5 py-1 rounded-full">Dioptriás</span>
            <span v-if="product.featured" class="bg-purple-100 text-purple-700 text-xs font-bold px-2.5 py-1 rounded-full">Kiemelt</span>
          </div>

          <!-- Márka & Név -->
          <p v-if="product.brand" class="text-sm font-medium text-gray-400 uppercase tracking-wide">{{ product.brand }}</p>
          <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mt-1 mb-4">{{ product.name }}</h1>

          <!-- Ár -->
          <div class="flex items-baseline gap-3 mb-6">
            <span v-if="product.sale_price" class="text-gray-400 line-through text-lg">{{ formatPrice(product.price) }}</span>
            <span class="text-3xl font-bold text-blue-700">{{ formatPrice(product.sale_price || product.price) }}</span>
          </div>

          <!-- Rövid leírás -->
          <p v-if="product.short_description" class="text-gray-600 mb-6 leading-relaxed">{{ product.short_description }}</p>

          <!-- Gyors adatok -->
          <div class="bg-gray-50 rounded-xl p-4 mb-6 grid grid-cols-2 gap-3">
            <div v-if="product.brand">
              <p class="text-xs text-gray-400 uppercase tracking-wide">Márka</p>
              <p class="text-sm font-semibold text-gray-800">{{ product.brand }}</p>
            </div>
            <div>
              <p class="text-xs text-gray-400 uppercase tracking-wide">Nem</p>
              <p class="text-sm font-semibold text-gray-800">{{ genderLabel(product.gender) }}</p>
            </div>
            <div v-if="product.frame_material">
              <p class="text-xs text-gray-400 uppercase tracking-wide">Keret anyaga</p>
              <p class="text-sm font-semibold text-gray-800">{{ product.frame_material }}</p>
            </div>
            <div v-if="product.frame_color">
              <p class="text-xs text-gray-400 uppercase tracking-wide">Keret színe</p>
              <p class="text-sm font-semibold text-gray-800">{{ product.frame_color }}</p>
            </div>
            <div v-if="product.frame_size">
              <p class="text-xs text-gray-400 uppercase tracking-wide">Keret mérete</p>
              <p class="text-sm font-semibold text-gray-800">{{ product.frame_size }}</p>
            </div>
            <div v-if="product.lens_type">
              <p class="text-xs text-gray-400 uppercase tracking-wide">Lencse típusa</p>
              <p class="text-sm font-semibold text-gray-800">{{ product.lens_type }}</p>
            </div>
          </div>

          <!-- CTA: Időpontfoglalás -->
          <NuxtLink
            to="/contact"
            class="w-full bg-blue-600 text-white text-center py-3.5 rounded-xl font-semibold hover:bg-blue-700 transition-colors no-underline block mb-3"
          >
            Időpontot foglalok
          </NuxtLink>
          <NuxtLink
            to="/szemuvegek"
            class="w-full border border-gray-300 text-gray-700 text-center py-3 rounded-xl font-medium hover:bg-gray-50 transition-colors no-underline block text-sm"
          >
            ← Vissza a termékekhez
          </NuxtLink>
        </div>
      </div>

      <!-- Teljes leírás -->
      <div v-if="product.description" class="mt-12 bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Részletes leírás</h2>
        <div class="text-gray-600 leading-relaxed whitespace-pre-line">{{ product.description }}</div>
      </div>

      <!-- Kategóriák -->
      <div v-if="product.categories && product.categories.length > 0" class="mt-4 flex items-center gap-2">
        <span class="text-sm text-gray-400">Kategóriák:</span>
        <span
          v-for="cat in product.categories"
          :key="cat.id"
          class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full"
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
