<template>
  <div class="min-h-screen bg-white">

    <!-- ── LOADING ── -->
    <div v-if="loading" class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-28 py-12">
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

    <!-- ── HIBA ── -->
    <div v-else-if="error" class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-28 py-20 text-center">
      <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
        </svg>
      </div>
      <p class="text-slate-600 text-lg font-medium mb-4">A termék nem található.</p>
      <NuxtLink to="/szemuvegek" class="text-sm font-medium text-blue-600 no-underline hover:text-blue-700">← Vissza a termékekhez</NuxtLink>
    </div>

    <!-- ── TERMÉK ── -->
    <div v-else-if="product">

      <!-- Hero sáv -->
      <div class="bg-gradient-to-b from-slate-50 to-white border-b border-slate-100 pt-20">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

          <!-- Breadcrumb -->
          <nav class="flex items-center gap-2 text-sm text-slate-400 mb-6" aria-label="Breadcrumb">
            <NuxtLink to="/" class="hover:text-slate-600 no-underline transition">Főoldal</NuxtLink>
            <span>›</span>
            <NuxtLink to="/szemuvegek" class="hover:text-slate-600 no-underline transition">Szemüvegek</NuxtLink>
            <span>›</span>
            <span class="text-slate-700 font-medium truncate max-w-48">{{ product.name }}</span>
          </nav>

          <!-- Fő grid -->
          <div class="grid md:grid-cols-2 gap-10 pb-10">

            <!-- Kép galéria -->
            <div>
              <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden h-80 md:h-[420px] flex items-center justify-center mb-3">
                <img
                  v-if="activeImage"
                  :src="activeImage.url"
                  :alt="activeImage.alt_text || product.name"
                  class="w-full h-full object-contain p-8 transition-opacity duration-300"
                >
                <div v-else class="flex flex-col items-center gap-3 text-slate-300">
                  <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                  </svg>
                  <p class="text-sm">Nincs kép</p>
                </div>
              </div>
              <div v-if="product.images.length > 1" class="flex gap-2 flex-wrap">
                <button
                  v-for="img in product.images"
                  :key="img.id"
                  @click="activeImage = img"
                  class="w-16 h-16 rounded-xl overflow-hidden transition-all"
                  :class="activeImage?.id === img.id ? 'ring-2 ring-blue-500 ring-offset-1' : 'border border-slate-200 hover:border-blue-200'"
                >
                  <img :src="img.url" :alt="img.alt_text || product.name" class="w-full h-full object-cover">
                </button>
              </div>
            </div>

            <!-- Termék info -->
            <div class="flex flex-col">

              <!-- Badges -->
              <div class="flex gap-2 flex-wrap mb-4">
                <span v-if="product.is_sunglasses" class="bg-amber-50 text-amber-700 text-xs font-semibold px-3 py-1 rounded-full border border-amber-100">☀ Napszemüveg</span>
                <span v-if="product.is_prescription" class="bg-blue-50 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full border border-blue-100">👁 Dioptriás</span>
                <span v-if="product.featured" class="bg-violet-50 text-violet-700 text-xs font-semibold px-3 py-1 rounded-full border border-violet-100">★ Kiemelt</span>
                <span v-if="product.sale_price" class="bg-red-50 text-red-700 text-xs font-semibold px-3 py-1 rounded-full border border-red-100">Akció</span>
              </div>

              <p v-if="product.brand" class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">{{ product.brand }}</p>
              <h1 style="font-family:'Outfit',sans-serif;font-size:clamp(1.5rem,3vw,2rem);font-weight:800;color:#0f172a;line-height:1.2;" class="mb-2">
                {{ product.name }}
              </h1>
              <p v-if="product.model" class="text-sm text-slate-400 mb-4">Modell: {{ product.model }}</p>

              <!-- Ár -->
              <div class="flex items-baseline gap-3 mb-5">
                <span v-if="product.sale_price" class="line-through text-slate-400 text-base">{{ formatPrice(product.price) }}</span>
                <span class="font-extrabold text-blue-700" style="font-family:'Outfit',sans-serif;font-size:2rem;line-height:1;">{{ formatPrice(product.sale_price || product.price) }}</span>
              </div>

              <!-- Rövid leírás -->
              <p v-if="product.short_description" class="text-slate-600 text-sm leading-relaxed mb-5 border-l-2 border-blue-100 pl-3">{{ product.short_description }}</p>

              <!-- Spec grid -->
              <div class="grid grid-cols-2 gap-3 mb-6">
                <div v-for="spec in visibleSpecs" :key="spec.label" class="bg-slate-50 rounded-xl px-4 py-3 border border-slate-100">
                  <p class="text-xs text-slate-400 uppercase tracking-wider mb-0.5">{{ spec.label }}</p>
                  <p class="text-sm font-semibold text-slate-800">{{ spec.value }}</p>
                </div>
              </div>

              <!-- CTA -->
              <NuxtLink to="/contact" class="btn-primary w-full mb-3 text-center" style="font-size:1rem;padding:14px 24px;">
                Időpontot foglalok — ingyenes próbálás
              </NuxtLink>
              <NuxtLink to="/szemuvegek" class="block text-center text-sm text-slate-500 hover:text-blue-600 no-underline transition py-2">
                ← Vissza az összes szemüveghez
              </NuxtLink>

              <!-- Trust badges -->
              <div class="grid grid-cols-3 gap-2 mt-5 pt-5 border-t border-slate-100">
                <div v-for="badge in trustBadges" :key="badge.text" class="text-center">
                  <div class="text-xl mb-1">{{ badge.icon }}</div>
                  <p class="text-xs text-slate-500 leading-tight">{{ badge.text }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ── TARTALOM SZEKCIÓK ── -->
      <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-10">

        <!-- Kinek ajánljuk -->
        <section class="bg-white rounded-2xl border border-slate-100 shadow-sm p-8">
          <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center border border-blue-100">
              <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
              </svg>
            </div>
            <div>
              <h2 style="font-family:'Outfit',sans-serif;font-weight:800;color:#0f172a;font-size:1.25rem;">Kinek ajánljuk ezt a szemüveget?</h2>
              <p class="text-sm text-slate-400">A termék jellemzői alapján</p>
            </div>
          </div>
          <div class="grid sm:grid-cols-2 gap-4">
            <div v-for="rec in recommendedFor" :key="rec.title" class="flex gap-3 p-4 rounded-xl bg-slate-50 border border-slate-100">
              <span class="text-2xl flex-shrink-0">{{ rec.icon }}</span>
              <div>
                <p class="text-sm font-semibold text-slate-800 mb-1">{{ rec.title }}</p>
                <p class="text-xs text-slate-500 leading-relaxed">{{ rec.desc }}</p>
              </div>
            </div>
          </div>
        </section>

        <!-- Keret anyag info -->
        <section v-if="frameMaterialInfo" class="bg-white rounded-2xl border border-slate-100 shadow-sm p-8">
          <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center border" :style="`background:${frameMaterialInfo.iconBg};border-color:${frameMaterialInfo.iconBorder};`">
              <span class="text-xl">{{ frameMaterialInfo.icon }}</span>
            </div>
            <div>
              <h2 style="font-family:'Outfit',sans-serif;font-weight:800;color:#0f172a;font-size:1.25rem;">{{ frameMaterialInfo.title }}</h2>
              <p class="text-sm text-slate-400">Keret anyag részletei</p>
            </div>
          </div>
          <p class="text-slate-600 text-sm leading-relaxed mb-5">{{ frameMaterialInfo.desc }}</p>
          <div class="grid sm:grid-cols-3 gap-3">
            <div v-for="pro in frameMaterialInfo.pros" :key="pro" class="flex items-start gap-2 p-3 rounded-xl bg-green-50 border border-green-100">
              <svg class="w-4 h-4 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
              <span class="text-xs text-green-800 font-medium leading-tight">{{ pro }}</span>
            </div>
          </div>
        </section>

        <!-- Lencse info -->
        <section v-if="lensInfo" class="bg-white rounded-2xl border border-slate-100 shadow-sm p-8">
          <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center border border-indigo-100">
              <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
              </svg>
            </div>
            <div>
              <h2 style="font-family:'Outfit',sans-serif;font-weight:800;color:#0f172a;font-size:1.25rem;">{{ lensInfo.title }}</h2>
              <p class="text-sm text-slate-400">Lencse típus információ</p>
            </div>
          </div>
          <p class="text-slate-600 text-sm leading-relaxed mb-5">{{ lensInfo.desc }}</p>
          <div class="grid sm:grid-cols-2 gap-3">
            <div v-for="feat in lensInfo.features" :key="feat.label" class="p-4 rounded-xl border border-slate-100 bg-slate-50">
              <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">{{ feat.label }}</p>
              <p class="text-sm text-slate-700">{{ feat.value }}</p>
            </div>
          </div>
        </section>

        <!-- Teljes leírás -->
        <section v-if="product.description" class="bg-white rounded-2xl border border-slate-100 shadow-sm p-8">
          <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center border border-blue-100">
              <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
              </svg>
            </div>
            <h2 style="font-family:'Outfit',sans-serif;font-weight:800;color:#0f172a;font-size:1.25rem;">Részletes leírás</h2>
          </div>
          <div class="prose-custom text-slate-600 text-sm leading-relaxed whitespace-pre-line">{{ product.description }}</div>
        </section>

        <!-- Ápolási tippek -->
        <section class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl border border-blue-100 p-8">
          <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center border border-blue-100 shadow-sm">
              <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
              </svg>
            </div>
            <div>
              <h2 style="font-family:'Outfit',sans-serif;font-weight:800;color:#0f172a;font-size:1.25rem;">Ápolási tippek</h2>
              <p class="text-sm text-slate-500">Hogy sokáig tartson a szemüveged</p>
            </div>
          </div>
          <div class="grid sm:grid-cols-2 gap-4">
            <div v-for="tip in careTips" :key="tip.title" class="flex gap-3 bg-white/70 rounded-xl p-4 border border-blue-100/50">
              <span class="text-xl flex-shrink-0">{{ tip.icon }}</span>
              <div>
                <p class="text-sm font-semibold text-slate-800 mb-0.5">{{ tip.title }}</p>
                <p class="text-xs text-slate-500 leading-relaxed">{{ tip.desc }}</p>
              </div>
            </div>
          </div>
        </section>

        <!-- CTA section -->
        <section class="bg-gradient-to-br from-blue-900 to-blue-800 rounded-2xl p-8 text-center">
          <h3 class="text-white font-bold mb-2" style="font-family:'Outfit',sans-serif;font-size:1.5rem;">Tetszik ez a szemüveg?</h3>
          <p class="text-blue-200/80 text-sm mb-6 leading-relaxed">Foglalj ingyenes időpontot — szakértőink segítenek a személyre szabott kiválasztásban és az optimális dioptria beállításban.</p>
          <NuxtLink to="/contact" class="inline-block bg-white text-blue-900 no-underline px-8 py-3.5 rounded-xl font-semibold hover:bg-blue-50 transition-colors shadow-sm">Ingyenes időpont foglalás</NuxtLink>
        </section>

        <!-- Kategóriák -->
        <div v-if="product.categories && product.categories.length > 0" class="flex items-center gap-2 flex-wrap">
          <span class="text-xs text-slate-400">Kategóriák:</span>
          <span v-for="cat in product.categories" :key="cat.id" class="text-xs bg-blue-50 text-blue-700 border border-blue-100 px-2.5 py-1 rounded-full">{{ cat.name }}</span>
        </div>
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

// ── SEO ──────────────────────────────────────────────────────────────
useHead(computed(() => {
  if (!product.value) return { title: 'Termék - Optika' }

  const p = product.value
  const title = `${p.name}${p.brand ? ` - ${p.brand}` : ''} | Optika`
  const description = p.short_description
    || `${p.name} szemüveg${p.brand ? ` a ${p.brand} márkától` : ''}. ${p.frame_material ? `Keret anyaga: ${p.frame_material}.` : ''} ${p.is_sunglasses ? 'UV védelemmel ellátott napszemüveg.' : ''} ${p.is_prescription ? 'Dioptriával rendelhető.' : ''} Tekintse meg optikánkban.`
  const image = p.primary_image_url ?? ''

  return {
    title,
    meta: [
      { name: 'description', content: description },
      { property: 'og:title', content: title },
      { property: 'og:description', content: description },
      { property: 'og:image', content: image },
      { property: 'og:type', content: 'product' },
      { property: 'og:site_name', content: 'Optika' },
      { name: 'twitter:card', content: 'summary_large_image' },
      { name: 'twitter:title', content: title },
      { name: 'twitter:description', content: description },
      { name: 'twitter:image', content: image },
      // Termékoldalon nem indexelünk duplikált tartalmakat
      { name: 'robots', content: 'index, follow' },
    ],
    script: [
      {
        type: 'application/ld+json',
        innerHTML: JSON.stringify({
          '@context': 'https://schema.org/',
          '@type': 'Product',
          name: p.name,
          description: p.short_description || p.description,
          brand: p.brand ? { '@type': 'Brand', name: p.brand } : undefined,
          image: image || undefined,
          sku: p.sku,
          offers: {
            '@type': 'Offer',
            priceCurrency: 'RON',
            price: p.sale_price ?? p.price,
            availability: 'https://schema.org/InStock',
            seller: { '@type': 'Organization', name: 'Optika' },
          },
          additionalProperty: [
            p.frame_material && { '@type': 'PropertyValue', name: 'Keret anyaga', value: p.frame_material },
            p.frame_color && { '@type': 'PropertyValue', name: 'Keret színe', value: p.frame_color },
            p.frame_size && { '@type': 'PropertyValue', name: 'Keret mérete', value: p.frame_size },
            p.lens_type && { '@type': 'PropertyValue', name: 'Lencse típusa', value: p.lens_type },
            { '@type': 'PropertyValue', name: 'Nem', value: genderLabel(p.gender) },
          ].filter(Boolean),
        }),
      },
      // BreadcrumbList schema
      {
        type: 'application/ld+json',
        innerHTML: JSON.stringify({
          '@context': 'https://schema.org',
          '@type': 'BreadcrumbList',
          itemListElement: [
            { '@type': 'ListItem', position: 1, name: 'Főoldal', item: 'https://optika.ro/' },
            { '@type': 'ListItem', position: 2, name: 'Szemüvegek', item: 'https://optika.ro/szemuvegek' },
            { '@type': 'ListItem', position: 3, name: p.name },
          ],
        }),
      },
    ],
  }
}))

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

// ── Spec grid (csak a kitöltött mezők) ───────────────────────────────
const visibleSpecs = computed(() => {
  const p = product.value
  if (!p) return []
  return [
    p.brand && { label: 'Márka', value: p.brand },
    { label: 'Nem', value: genderLabel(p.gender) },
    p.frame_material && { label: 'Keret anyaga', value: p.frame_material },
    p.frame_color && { label: 'Keret színe', value: p.frame_color },
    p.frame_size && { label: 'Keret mérete', value: p.frame_size },
    p.lens_type && { label: 'Lencse típusa', value: p.lens_type },
    p.model && { label: 'Modell', value: p.model },
    p.age_group && { label: 'Korosztály', value: ageLabel(p.age_group) },
  ].filter(Boolean) as { label: string; value: string }[]
})

// ── Trust badges ─────────────────────────────────────────────────────
const trustBadges = [
  { icon: '✅', text: 'Ingyenes próbálás' },
  { icon: '🔒', text: 'Biztonságos vásárlás' },
  { icon: '🏆', text: '20+ év tapasztalat' },
]

// ── Kinek ajánljuk ───────────────────────────────────────────────────
const recommendedFor = computed(() => {
  const p = product.value
  if (!p) return []
  const recs: { icon: string; title: string; desc: string }[] = []

  // Nem alapján
  const genderMap: Record<string, { icon: string; title: string; desc: string }> = {
    male: { icon: '👔', title: 'Férfiaknak', desc: 'Erős vonalak és masszív keretek, amelyek illenek az aktív, magabiztos megjelenéshez.' },
    female: { icon: '👒', title: 'Nőknek', desc: 'Elegáns forma és kidolgozás, amely kiegészíti a nőies megjelenést minden alkalomra.' },
    unisex: { icon: '🤝', title: 'Mindkét nemnek', desc: 'Univerzális, letisztult dizájn, amely férfiaknak és nőknek egyaránt jól áll.' },
    kids: { icon: '🎒', title: 'Gyerekeknek', desc: 'Gyermekekre méretezett, tartós kialakítás, amely biztonságos és kényelmes az iskolai mindennapokban is.' },
  }
  if (genderMap[p.gender]) recs.push(genderMap[p.gender])

  // Korosztály alapján
  if (p.age_group === 'senior') {
    recs.push({ icon: '🧓', title: 'Idősebb korosztálynak', desc: 'Könnyű kialakítás és könnyen megfogható keret, ideális az idősebb viselők számára is.' })
  }
  if (p.age_group === 'child') {
    recs.push({ icon: '👶', title: 'Kisgyermekeknek', desc: 'Rugalmas, sérülésbiztos anyag, amely megfelel a gyermekek aktív életmódjának.' })
  }

  // Napszemüveg
  if (p.is_sunglasses) {
    recs.push({ icon: '🏖️', title: 'Nyári, szabadtéri aktívoknak', desc: 'UV400-as vagy polarizált lencse védelmet nyújt a káros napsugárzással szemben strandon, hegyekben és a városban egyaránt.' })
    recs.push({ icon: '🚗', title: 'Autóvezetőknek', desc: 'Csökkenti a szélvédőről visszaverődő fényt, javítja a kontrasztot és csökkenti a szemfáradtságot hosszú utazásokon.' })
  }

  // Dioptriás
  if (p.is_prescription) {
    recs.push({ icon: '📚', title: 'Rövidlátóknak, távolbalátóknak', desc: 'Dioptriával rendelhető, így az egyéni látásromláshoz igazítható. Ideális a mindennapos viselésre irodában és iskolában.' })
    recs.push({ icon: '💻', title: 'Képernyő előtt dolgozóknak', desc: 'Kék fény szűrős lencsével kombinálva tökéletes védelmet nyújt a digitális szemfáradtság ellen, home office esetén is.' })
  }

  // Anyag alapján
  const mat = (p.frame_material ?? '').toLowerCase()
  if (mat.includes('titan')) {
    recs.push({ icon: '🏃', title: 'Aktív életmódot élőknek', desc: 'A titánkeret kiválóan ellenáll a hajlításnak, és rendkívül könnyű, így tökéletes sportolók és aktív emberek számára.' })
  }
  if (mat.includes('acet')) {
    recs.push({ icon: '🎨', title: 'Stílusérzékenyeknek', desc: 'Az acetát keret gazdag színválasztékban készül, egyedi mintákkal. Divatérzékeny viselők kedvenc anyaga.' })
  }
  if (mat.includes('fa') || mat.includes('wood') || mat.includes('bamb')) {
    recs.push({ icon: '🌿', title: 'Környezettudatos vásárlóknak', desc: 'Természetes, fenntartható anyag, amely egyedi évgyűrű-mintájával mindenki máshogy néz ki — garanciált eredetiség.' })
  }
  if (mat.includes('tr') || mat.includes('flex') || mat.includes('rugg') || mat.includes('rugalmas')) {
    recs.push({ icon: '⚽', title: 'Gyerekeknek és sportolóknak', desc: 'A rugalmas keret nem törik el eséskor sem, így ideális az aktív, mozgalmas napokhoz.' })
  }

  return recs.slice(0, 6)
})

// ── Keret anyag info ─────────────────────────────────────────────────
const frameMaterialInfo = computed(() => {
  if (!product.value?.frame_material) return null
  const mat = product.value.frame_material.toLowerCase()

  if (mat.includes('titan')) return {
    icon: '⚙️', iconBg: '#f0f9ff', iconBorder: '#bae6fd', title: 'Titánium keret',
    desc: 'A titánium az egyik legerősebb és legkönnyebb anyag, amelyből keretet készítenek. Korrózióálló, hipoallergén és rendkívül tartós — ideális azok számára, akik egész nap viselik a szemüvegüket. A titán keretek tömege kb. 30-40%-kal kisebb, mint az acélkereté, így szinte alig érezni az orron.',
    pros: ['Rendkívül könnyű', 'Hipoallergén anyag', 'Korrózióálló', 'Hajlításálló', 'Hosszú élettartam', 'Prémium megjelenés'],
  }
  if (mat.includes('acet')) return {
    icon: '🎨', iconBg: '#faf5ff', iconBorder: '#e9d5ff', title: 'Acetát keret',
    desc: 'Az acetát (cellulóz-acetát) egy természetes alapanyagú, kiváló minőségű műanyag, amelyből a prémium szemüvegkeretek nagy részét készítik. Rugalmas, könnyen alakítható, és szinte korlátlan lehetőséget kínál a színek és minták terén. Az acetát keretek melegítéssel könnyen igazíthatók a fejalkathoz.',
    pros: ['Gazdag színválaszték', 'Egyedi minták', 'Hipoallergén', 'Rugalmas', 'Könnyen igazítható', 'Tartós anyag'],
  }
  if (mat.includes('fém') || mat.includes('acél') || mat.includes('steel') || mat.includes('metal')) return {
    icon: '✨', iconBg: '#f8fafc', iconBorder: '#e2e8f0', title: 'Fémkeret',
    desc: 'A fémkeretek (rozsdamentes acél, alpakka vagy aranyozott ötvözet) elegáns, vékony profilt tesznek lehetővé, amelyet nehéz elérni más anyagokkal. Rendkívül tartósak, és a legtöbb orr- és fülpárna könnyen cserélhető rajtuk.',
    pros: ['Vékony, elegáns profil', 'Tartós', 'Könnyen javítható', 'Klasszikus megjelenés', 'Sokszínű befejezés'],
  }
  if (mat.includes('tr90') || mat.includes('nylon') || mat.includes('grilamid')) return {
    icon: '🔄', iconBg: '#f0fdf4', iconBorder: '#bbf7d0', title: 'TR90 / Rugalmas műanyag keret',
    desc: 'A TR90 (más névend: Grilamid) egy ultrakönnyű, rendkívül rugalmas termoplasztikus anyag, amelyet főként sport- és gyermekszemüveg-keretekhez használnak. Akár 180 fokig is elhajlítható anélkül, hogy eltörne — ez teszi ideálissá az aktív életmódhoz és gyermekek számára.',
    pros: ['Ultrakönnyű', 'Törésbiztos', 'Rendkívül rugalmas', 'Hypoallergén', 'Gyerekeknek ideális', 'Sporthoz ajánlott'],
  }
  if (mat.includes('fa') || mat.includes('wood') || mat.includes('bamb')) return {
    icon: '🌿', iconBg: '#f0fdf4', iconBorder: '#bbf7d0', title: 'Fa / Bambusz keret',
    desc: 'A fa és bambusz keretek egyedi, természetes megjelenésükkel tűnnek ki. Minden darab más, az évgyűrűk mintája garantáltan egyszeri. Fenntartható, környezetbarát anyag, amely kellemes súlyt és organikus esztétikát kölcsönöz a szemüvegnek.',
    pros: ['100% természetes anyag', 'Minden darab egyedi', 'Fenntartható', 'Organikus esztétika', 'Könnyű', 'Allergiamentes'],
  }
  return null
})

// ── Lencse info ──────────────────────────────────────────────────────
const lensInfo = computed(() => {
  if (!product.value?.lens_type) return null
  const lt = product.value.lens_type.toLowerCase()

  if (lt.includes('progressz') || lt.includes('multifok')) return {
    title: 'Progresszív lencse',
    desc: 'A progresszív lencse (más névend: multifokális) egyetlen lencsében ötvözi a közel-, középtáv- és távolsági korrekciót. Nincs látható elválasztó vonal, így természetesebb megjelenést biztosít, mint a bifokális lencse. Idősebb, presbyopiában szenvedő viselők számára ajánlott.',
    features: [
      { label: 'Korrekciós zónák', value: 'Közel, közép, távoli — egyetlen lencsében' },
      { label: 'Megjelenés', value: 'Látható vonal nélküli, természetes' },
      { label: 'Kinek ajánlott', value: '40 év felett, presbyopia esetén' },
      { label: 'Megszokási idő', value: 'Kb. 1-2 hét az ideális viseléshez' },
    ],
  }
  if (lt.includes('polariz')) return {
    title: 'Polarizált lencse',
    desc: 'A polarizált lencsék speciális szűrőrétegük segítségével blokkolják a vízszintes fényhullámokat, amelyek a tükröző felületekről (víz, hó, aszfalt) visszaverődnek. Eredmény: élesebb, kontrasztosabb kép, kevesebb szikárlás és fáradtság.',
    features: [
      { label: 'Visszaverődés elleni védelem', value: '99%-os szikárlás-redukció' },
      { label: 'UV védelem', value: 'UV400 — teljes UVA/UVB blokkolás' },
      { label: 'Kinek ajánlott', value: 'Horgászok, síelők, sofőrök, strandolók' },
      { label: 'Kontrast', value: 'Javított színkontraszt és mélységérzékelés' },
    ],
  }
  if (lt.includes('fotokrom') || lt.includes('transitions') || lt.includes('adaptiv')) return {
    title: 'Fotokromatikus (Transitions) lencse',
    desc: 'A fotokromatikus lencsék UV-fény hatására automatikusan sötétednek, beltéren áttetsző maradnak. Egyetlen szemüveggel megoldható a normál és napszemüveg — nem kell cserélgetni.',
    features: [
      { label: 'Sötétedési idő', value: 'Kb. 30 másodperc napfényen' },
      { label: 'Visszavilágosodás', value: 'Beltéren kb. 2-4 perc' },
      { label: 'UV védelem', value: 'Sötét állapotban UV400 védelem' },
      { label: 'Kinek ajánlott', value: 'Aki sokat jár ki-be, vagy két szemüveget hordana' },
    ],
  }
  if (lt.includes('kékfény') || lt.includes('blue') || lt.includes('anti-blue') || lt.includes('bluecut')) return {
    title: 'Kék fény szűrős lencse',
    desc: 'A digitális képernyők (telefon, monitor, tablet) által kibocsátott kék fény (400-450 nm) tartós terhelést jelent a szemre. A kékfény-szűrős lencse részben blokkolja ezt a tartományt, csökkentve a digitális szemfáradtságot, javítva az alvásminőséget.',
    features: [
      { label: 'Szűrt fénytartomány', value: '400–450 nm (HEV blue light)' },
      { label: 'Kinek ajánlott', value: 'Képernyő előtt dolgozóknak, gamerereknek' },
      { label: 'Mellékhatás', value: 'Minimális sárgás árnyalat — alig észrevehető' },
      { label: 'Párosítható', value: 'Bármely dioptriás lencsével' },
    ],
  }
  if (lt.includes('egyfókusz') || lt.includes('single') || lt.includes('monofok')) return {
    title: 'Egyfókuszú lencse',
    desc: 'Az egyfókuszú lencse egyetlen, jól meghatározott látótávolságra korrigál — ez lehet közel (olvasáshoz) vagy távol (rövidlátáshoz). Ez a legelterjedtebb lencsefajta, könnyen megszokható, és megfizethető árban elérhető.',
    features: [
      { label: 'Korrekciós zóna', value: 'Egyetlen távolság (közel vagy távol)' },
      { label: 'Megszokás', value: 'Azonnal, szinte nincs adaptációs idő' },
      { label: 'Kinek ajánlott', value: 'Rövidlátóknak, távolbalátóknak, astigmiásoknak' },
      { label: 'Ár', value: 'Legkedvezőbb lencsetípus' },
    ],
  }
  return null
})

// ── Ápolási tippek ───────────────────────────────────────────────────
const careTips = computed(() => {
  const p = product.value
  if (!p) return []

  const tips = [
    { icon: '🧴', title: 'Lencse tisztítása', desc: 'Csak szemüveg-tisztítóval vagy folyó, langyos vízzel törölje át a lencséket. Papírzsebkendő és ruha karcoláshoz vezet.' },
    { icon: '🧺', title: 'Tárolás tokban', desc: 'Amikor nem viseli, mindig tegye a keménytokba. Ez megvédi a karcolástól, töréstől és porzástól.' },
    { icon: '🚿', title: 'Kerülje a forró vizet', desc: 'A nagyon forró víz és gőz torzíthatja az acetát keretet és a bevonatokat. Maximálisan 60 °C vízzel öblítse.' },
    { icon: '🌡️', title: 'Kerülje a hőt', desc: 'Ne hagyja a kocsi műszerfalán nyáron! 80 °C felett a keretanyag deformálódhat és az optikai bevonat megrepedhet.' },
  ]

  const mat = (p.frame_material ?? '').toLowerCase()
  if (mat.includes('fa') || mat.includes('wood') || mat.includes('bamb')) {
    tips.push({ icon: '💧', title: 'Fa keret olajozása', desc: 'Évente 1-2 alkalommal vigyen fel kevés fa-konzerváló olajat (pl. lencseolaj) a keret felszínére, hogy megőrizze ragyogását.' })
  }
  if (mat.includes('fém') || mat.includes('acél') || mat.includes('metal')) {
    tips.push({ icon: '🔩', title: 'Csavar ellenőrzés', desc: 'Negyedévente ellenőrizze a szárcsavarokat. Ha meglazulnak, egy kisoptikus csavarhúzóval húzza meg — a kiesett keret keretet karcolhat.' })
  }
  if (p.is_sunglasses) {
    tips.push({ icon: '☀️', title: 'Napszemüveg tárolása', desc: 'Napszemüveget is tartson tokban — a lencséken lévő tükröző bevonat (mirror coating) különösen érzékeny a karcolásra.' })
  }

  return tips
})

// ── Segédfüggvények ──────────────────────────────────────────────────
function ageLabel(age: string): string {
  const map: Record<string, string> = { adult: 'Felnőtt', child: 'Gyermek', senior: 'Idős' }
  return map[age] ?? age
}
</script>

<style scoped>
.prose-custom {
  font-size: 0.9rem;
  color: #475569;
  line-height: 1.75;
}
.prose-custom p + p { margin-top: 0.75em; }
</style>
