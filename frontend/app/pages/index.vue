<template>
  <div>
    <!-- Hero szekció -->
    <section class="bg-gradient-to-r from-blue-900 to-blue-700 text-white py-20">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-5xl font-bold mb-6">
          Üdvözöljük az Optikánkban!
        </h1>
        <p class="text-xl mb-8">
          Professzionális szemészeti szolgáltatások és kiváló minőségű szemüvegek
        </p>
        <div class="flex gap-4 justify-center flex-wrap">
          <NuxtLink
            to="/contact"
            class="bg-white text-blue-900 no-underline px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition inline-block"
          >
            Foglaljon időpontot
          </NuxtLink>
          <NuxtLink
            v-if="!isLoggedIn"
            to="/register"
            class="bg-green-600 text-white no-underline px-8 py-3 rounded-lg font-semibold hover:bg-green-700 transition inline-block"
          >
            Regisztráció
          </NuxtLink>
          <a
            v-if="isLoggedIn && isAdminOrStaff"
            :href="adminPanelUrl"
            target="_blank"
            class="bg-purple-600 text-white no-underline px-8 py-3 rounded-lg font-semibold hover:bg-purple-700 transition inline-block"
          >
            Admin Panel
          </a>
          <NuxtLink
            v-else-if="isLoggedIn"
            to="/profile"
            class="bg-green-600 text-white no-underline px-8 py-3 rounded-lg font-semibold hover:bg-green-700 transition inline-block"
          >
            Profilom
          </NuxtLink>
        </div>
      </div>
    </section>

    <!-- Szolgáltatások előnézet -->
    <section class="py-16 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">
          Szolgáltatásaink
        </h2>
        <div class="grid md:grid-cols-3 gap-8">
          <div class="text-center p-6 border rounded-lg hover:shadow-lg transition">
            <div class="text-4xl mb-4">👁️</div>
            <h3 class="text-xl font-semibold mb-2">Látásvizsgálat</h3>
            <p class="text-gray-600">Precíz és alapos szemvizsgálat modern eszközökkel</p>
          </div>
          <div class="text-center p-6 border rounded-lg hover:shadow-lg transition">
            <div class="text-4xl mb-4">👓</div>
            <h3 class="text-xl font-semibold mb-2">Szemüveg készítés</h3>
            <p class="text-gray-600">Egyedi, stílusos és minőségi keretek</p>
          </div>
          <div class="text-center p-6 border rounded-lg hover:shadow-lg transition">
            <div class="text-4xl mb-4">🔍</div>
            <h3 class="text-xl font-semibold mb-2">Kontaktlencse</h3>
            <p class="text-gray-600">Széles választék és szakszerű tanácsadás</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Kiemelt termékek sáv -->
    <section v-if="featuredProducts.length > 0" class="py-14 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
          <h2 class="text-3xl font-bold text-gray-900">Kiemelt termékek</h2>
          <NuxtLink to="/szemuvegek" class="text-sm font-medium text-blue-600 hover:underline no-underline">
            Összes megtekintése →
          </NuxtLink>
        </div>
        <div class="overflow-x-auto scrollbar-hide -mx-4 px-4">
          <div class="flex gap-5 pb-2 featured-scroll">
            <NuxtLink
              v-for="(product, i) in [...featuredProducts, ...featuredProducts]"
              :key="`f-${i}-${product.id}`"
              :to="`/szemuvegek/${product.slug}`"
              class="flex-shrink-0 w-52 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow no-underline group"
            >
              <div class="h-40 bg-gray-50 flex items-center justify-center overflow-hidden">
                <img
                  v-if="product.primary_image_url"
                  :src="product.primary_image_url"
                  :alt="product.name"
                  class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                >
                <svg v-else class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
              </div>
              <div class="p-3">
                <p v-if="product.brand" class="text-xs text-gray-400 uppercase tracking-wide mb-0.5">{{ product.brand }}</p>
                <p class="text-sm font-semibold text-gray-900 truncate">{{ product.name }}</p>
                <p class="text-blue-600 font-bold text-sm mt-1">
                  <span v-if="product.sale_price" class="line-through text-gray-400 text-xs mr-1">{{ formatPrice(product.price) }}</span>
                  {{ formatPrice(product.sale_price || product.price) }}
                </p>
              </div>
            </NuxtLink>
          </div>
        </div>
      </div>
    </section>

    <!-- Miért válasszon minket -->
    <section class="py-16 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">
          Miért válasszon minket?
        </h2>
        <div class="grid md:grid-cols-2 gap-8">
          <div class="flex items-start">
            <div class="text-2xl mr-4">✓</div>
            <div>
              <h3 class="text-xl font-semibold mb-2">Tapasztalt szakemberek</h3>
              <p class="text-gray-600">Több évtizedes szakmai tapasztalat</p>
            </div>
          </div>
          <div class="flex items-start">
            <div class="text-2xl mr-4">✓</div>
            <div>
              <h3 class="text-xl font-semibold mb-2">Modern technológia</h3>
              <p class="text-gray-600">Legújabb diagnosztikai eszközök</p>
            </div>
          </div>
          <div class="flex items-start">
            <div class="text-2xl mr-4">✓</div>
            <div>
              <h3 class="text-xl font-semibold mb-2">Kiváló minőség</h3>
              <p class="text-gray-600">Csak minősített termékek és anyagok</p>
            </div>
          </div>
          <div class="flex items-start">
            <div class="text-2xl mr-4">✓</div>
            <div>
              <h3 class="text-xl font-semibold mb-2">Személyre szabott</h3>
              <p class="text-gray-600">Egyedi megoldások minden igényre</p>
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
</script>

<style scoped>
.scrollbar-hide {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
.scrollbar-hide::-webkit-scrollbar {
  display: none;
}

@keyframes featured-scroll {
  from { transform: translateX(0); }
  to { transform: translateX(-50%); }
}
.featured-scroll {
  width: max-content;
  animation: featured-scroll 40s linear infinite;
}
.featured-scroll:hover {
  animation-play-state: paused;
}
</style>