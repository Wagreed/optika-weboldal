<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Hero -->
    <div class="bg-gradient-to-r from-blue-900 to-blue-700 text-white py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-bold mb-3">Szemüvegeink</h1>
        <p class="text-blue-200 text-lg">Találd meg a számodra tökéletes keretet</p>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="flex gap-8">

        <!-- Szűrő panel -->
        <aside class="hidden lg:block w-64 flex-shrink-0">
          <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 sticky top-24 space-y-6">

            <!-- Keresés -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Keresés</label>
              <input
                v-model="filters.search"
                type="text"
                placeholder="Név, márka..."
                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                @input="debouncedFetch"
              >
            </div>

            <!-- Típus -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Típus</label>
              <div class="space-y-2">
                <label v-for="opt in typeOptions" :key="opt.value" class="flex items-center gap-2 cursor-pointer">
                  <input
                    v-model="filters.type"
                    type="radio"
                    :value="opt.value"
                    class="text-blue-600"
                    @change="resetAndFetch"
                  >
                  <span class="text-sm text-gray-700">{{ opt.label }}</span>
                </label>
              </div>
            </div>

            <!-- Nem -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Nem</label>
              <div class="space-y-2">
                <label v-for="opt in genderOptions" :key="opt.value" class="flex items-center gap-2 cursor-pointer">
                  <input
                    v-model="filters.gender"
                    type="radio"
                    :value="opt.value"
                    class="text-blue-600"
                    @change="resetAndFetch"
                  >
                  <span class="text-sm text-gray-700">{{ opt.label }}</span>
                </label>
              </div>
            </div>

            <!-- Kategória -->
            <div v-if="categories.length > 0">
              <label class="block text-sm font-semibold text-gray-700 mb-2">Kategória</label>
              <select
                v-model="filters.category"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                @change="resetAndFetch"
              >
                <option value="">Összes kategória</option>
                <option v-for="cat in categories" :key="cat.id" :value="cat.slug">{{ cat.name }}</option>
              </select>
            </div>

            <!-- Árkategória -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Ár (RON)</label>
              <div class="flex gap-2 items-center">
                <input
                  v-model="filters.min_price"
                  type="number"
                  min="0"
                  placeholder="Min"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                  @change="resetAndFetch"
                >
                <span class="text-gray-400 flex-shrink-0">–</span>
                <input
                  v-model="filters.max_price"
                  type="number"
                  min="0"
                  placeholder="Max"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                  @change="resetAndFetch"
                >
              </div>
            </div>

            <!-- Szűrők törlése -->
            <button
              @click="clearFilters"
              class="w-full text-sm text-blue-600 hover:text-blue-800 font-medium text-center py-1"
            >
              Szűrők törlése
            </button>
          </div>
        </aside>

        <!-- Tartalom -->
        <div class="flex-1 min-w-0">

          <!-- Felső sáv: találatok száma + rendezés -->
          <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
            <p class="text-sm text-gray-500">
              <span v-if="!loading">{{ total }} termék</span>
              <span v-else>Betöltés...</span>
            </p>
            <div class="flex items-center gap-3">
              <!-- Mobil szűrő gomb -->
              <button
                class="lg:hidden flex items-center gap-2 px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 bg-white"
                @click="mobileFiltersOpen = true"
              >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z" />
                </svg>
                Szűrők
              </button>
              <select
                v-model="filters.sort"
                class="px-3 py-2 border border-gray-300 rounded-lg text-sm bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                @change="resetAndFetch"
              >
                <option value="newest">Legújabb</option>
                <option value="price_asc">Ár: növekvő</option>
                <option value="price_desc">Ár: csökkenő</option>
                <option value="name">Név: A-Z</option>
              </select>
            </div>
          </div>

          <!-- Loading skeleton -->
          <div v-if="loading && products.length === 0" class="grid grid-cols-2 md:grid-cols-3 gap-5">
            <div v-for="i in 6" :key="i" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden animate-pulse">
              <div class="h-48 bg-gray-200"></div>
              <div class="p-4 space-y-2">
                <div class="h-3 bg-gray-200 rounded w-1/3"></div>
                <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                <div class="h-4 bg-gray-200 rounded w-1/2"></div>
              </div>
            </div>
          </div>

          <!-- Termék grid -->
          <div v-else-if="products.length > 0" class="grid grid-cols-2 md:grid-cols-3 gap-5">
            <NuxtLink
              v-for="product in products"
              :key="product.id"
              :to="`/szemuvegek/${product.slug}`"
              class="group bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-200 no-underline"
            >
              <!-- Kép -->
              <div class="relative h-48 bg-gray-50 overflow-hidden">
                <img
                  v-if="product.primary_image_url"
                  :src="product.primary_image_url"
                  :alt="product.name"
                  class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                >
                <div v-else class="w-full h-full flex items-center justify-center">
                  <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                </div>
                <!-- Badgek -->
                <div class="absolute top-2 left-2 flex flex-col gap-1">
                  <span v-if="product.sale_price" class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">AKCIÓ</span>
                  <span v-if="product.is_sunglasses" class="bg-yellow-500 text-white text-xs font-bold px-2 py-0.5 rounded">NAP</span>
                  <span v-if="product.is_prescription" class="bg-blue-500 text-white text-xs font-bold px-2 py-0.5 rounded">DIOPTRIA</span>
                </div>
              </div>

              <!-- Info -->
              <div class="p-4">
                <p v-if="product.brand" class="text-xs text-gray-400 font-medium uppercase tracking-wide mb-1">{{ product.brand }}</p>
                <h3 class="text-sm font-semibold text-gray-900 mb-2 line-clamp-2 leading-snug">{{ product.name }}</h3>
                <div class="flex items-center justify-between">
                  <div>
                    <span v-if="product.sale_price" class="text-xs text-gray-400 line-through mr-1">{{ formatPrice(product.price) }}</span>
                    <span class="font-bold text-blue-700">{{ formatPrice(product.sale_price || product.price) }}</span>
                  </div>
                  <span class="text-xs text-gray-400">{{ genderLabel(product.gender) }}</span>
                </div>
              </div>
            </NuxtLink>
          </div>

          <!-- Üres állapot -->
          <div v-else class="text-center py-20">
            <svg class="mx-auto w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-gray-500 text-lg font-medium">Nincs találat</p>
            <p class="text-gray-400 text-sm mt-1">Próbálj más szűrőkkel keresni</p>
            <button @click="clearFilters" class="mt-4 text-blue-600 hover:underline text-sm font-medium">Szűrők törlése</button>
          </div>

          <!-- Több betöltése -->
          <div v-if="hasMore" class="mt-8 text-center">
            <button
              @click="loadMore"
              :disabled="loading"
              class="px-8 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 disabled:bg-gray-300 transition-colors"
            >
              {{ loading ? 'Betöltés...' : 'Több termék betöltése' }}
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Mobil szűrő modal -->
    <transition
      enter-active-class="transition ease-out duration-200"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition ease-in duration-150"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div v-if="mobileFiltersOpen" class="fixed inset-0 z-50 lg:hidden">
        <div class="absolute inset-0 bg-black/50" @click="mobileFiltersOpen = false"></div>
        <div class="absolute right-0 top-0 h-full w-80 bg-white shadow-xl overflow-y-auto p-6">
          <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold">Szűrők</h2>
            <button @click="mobileFiltersOpen = false" class="p-1 text-gray-500 hover:text-gray-800">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
          <div class="space-y-6">
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Keresés</label>
              <input v-model="filters.search" type="text" placeholder="Név, márka..." class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" @input="debouncedFetch">
            </div>
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Típus</label>
              <div class="space-y-2">
                <label v-for="opt in typeOptions" :key="opt.value" class="flex items-center gap-2 cursor-pointer">
                  <input v-model="filters.type" type="radio" :value="opt.value" class="text-blue-600" @change="resetAndFetch">
                  <span class="text-sm text-gray-700">{{ opt.label }}</span>
                </label>
              </div>
            </div>
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Nem</label>
              <div class="space-y-2">
                <label v-for="opt in genderOptions" :key="opt.value" class="flex items-center gap-2 cursor-pointer">
                  <input v-model="filters.gender" type="radio" :value="opt.value" class="text-blue-600" @change="resetAndFetch">
                  <span class="text-sm text-gray-700">{{ opt.label }}</span>
                </label>
              </div>
            </div>
            <div v-if="categories.length > 0">
              <label class="block text-sm font-semibold text-gray-700 mb-2">Kategória</label>
              <select v-model="filters.category" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" @change="resetAndFetch">
                <option value="">Összes kategória</option>
                <option v-for="cat in categories" :key="cat.id" :value="cat.slug">{{ cat.name }}</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Ár (RON)</label>
              <div class="flex gap-2 items-center">
                <input v-model="filters.min_price" type="number" min="0" placeholder="Min" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" @change="resetAndFetch">
                <span class="text-gray-400">–</span>
                <input v-model="filters.max_price" type="number" min="0" placeholder="Max" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" @change="resetAndFetch">
              </div>
            </div>
            <button @click="clearFilters; mobileFiltersOpen = false" class="w-full text-sm text-blue-600 font-medium text-center py-1">Szűrők törlése</button>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup lang="ts">
import type { Product, ProductFilters } from '~/composables/useProducts'

useHead({ title: 'Szemüvegek - Optika' })

const { fetchProducts, fetchCategories, formatPrice, genderLabel } = useProducts()

const products = ref<Product[]>([])
const categories = ref<{ id: number; name: string; slug: string }[]>([])
const loading = ref(false)
const total = ref(0)
const currentPage = ref(1)
const lastPage = ref(1)
const mobileFiltersOpen = ref(false)

const hasMore = computed(() => currentPage.value < lastPage.value)

const filters = ref<ProductFilters>({
  search: '',
  type: '',
  gender: '',
  category: '',
  min_price: '',
  max_price: '',
  sort: 'newest',
})

const typeOptions = [
  { value: '', label: 'Összes' },
  { value: 'sunglasses', label: 'Napszemüveg' },
  { value: 'prescription', label: 'Dioptriás' },
]

const genderOptions = [
  { value: '', label: 'Összes' },
  { value: 'male', label: 'Férfi' },
  { value: 'female', label: 'Női' },
  { value: 'unisex', label: 'Uniszex' },
  { value: 'kids', label: 'Gyerek' },
]

const loadProducts = async (append = false) => {
  loading.value = true
  try {
    const data = await fetchProducts({ ...filters.value, page: currentPage.value })
    if (append) {
      products.value = [...products.value, ...data.data]
    } else {
      products.value = data.data
    }
    total.value = data.total
    lastPage.value = data.last_page
  } catch (e) {
    console.error(e)
  } finally {
    loading.value = false
  }
}

const resetAndFetch = () => {
  currentPage.value = 1
  loadProducts(false)
}

const loadMore = () => {
  currentPage.value++
  loadProducts(true)
}

const clearFilters = () => {
  filters.value = { search: '', type: '', gender: '', category: '', min_price: '', max_price: '', sort: 'newest' }
  resetAndFetch()
}

let debounceTimer: ReturnType<typeof setTimeout>
const debouncedFetch = () => {
  clearTimeout(debounceTimer)
  debounceTimer = setTimeout(resetAndFetch, 400)
}

onMounted(async () => {
  const [, cats] = await Promise.all([loadProducts(), fetchCategories()])
  categories.value = cats.categories ?? []
})
</script>
