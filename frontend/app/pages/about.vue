<template>
  <div>
    <!-- HERO -->
    <section class="relative overflow-hidden bg-blue-950 flex items-center" style="min-height:60vh;padding-top:7rem;padding-bottom:5rem;">
      <div class="absolute inset-0" style="background:linear-gradient(135deg,rgba(15,23,42,.8) 0%,rgba(30,58,138,.55) 60%,rgba(37,99,235,.3) 100%);"></div>
      <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center w-full">
        <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 text-blue-100 text-xs font-semibold px-3 py-1.5 rounded-full mb-6 backdrop-blur-sm">
          <span class="w-1.5 h-1.5 bg-blue-300 rounded-full"></span>Ismerd meg csapatunkat
        </div>
        <h1 class="mb-5 leading-none text-white" style="font-family:'Outfit',sans-serif;font-size:clamp(2.5rem,6vw,5rem);font-weight:800;letter-spacing:-.02em;">
          Több mint látásvizsgálat —<br><span class="text-blue-300">gondoskodás.</span>
        </h1>
        <p class="max-w-2xl mx-auto leading-relaxed text-blue-100/80" style="font-size:1.125rem;">Évtizedes tapasztalattal, modern technológiával és személyes odafigyeléssel állunk ügyfeleink szolgálatában.</p>
      </div>
    </section>

    <!-- STATS -->
    <section class="bg-white border-b border-slate-100 py-12">
      <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
          <div v-for="stat in stats" :key="stat.label">
            <p class="font-extrabold text-blue-700 mb-1 tabular-nums" style="font-family:'Outfit',sans-serif;font-size:clamp(2rem,4vw,3rem);line-height:1;">{{ stat.value }}</p>
            <p class="text-sm text-slate-500">{{ stat.label }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- HISTORY -->
    <section class="py-20 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 gap-14 items-center">
          <div>
            <div class="section-label mb-5">Történetünk</div>
            <h2 class="mb-5 text-blue-950" style="font-family:'Outfit',sans-serif;font-size:clamp(1.8rem,3.5vw,2.8rem);font-weight:800;letter-spacing:-.02em;line-height:1.2;">Helyi gyökerek,<br>modern szemlélet</h2>
            <div class="space-y-4 text-sm leading-relaxed text-slate-500">
              <p>Optikánk több mint két évtizede nyújt professzionális látásjavítási megoldásokat. Ami kis családi vállalkozásként indult, mára a régió egyik megbízható optikai szaküzletévé vált.</p>
              <p>Hisszük, hogy a jó látás alapvetően befolyásolja az életminőséget — ezért nem csupán szemüveget adunk, hanem teljes körű szemészeti tanácsadást, személyre szabott megoldásokkal.</p>
              <p>Csapatunk folyamatosan képzi magát, hogy a legmodernebb diagnosztikai eszközökkel és technikákkal állhassunk pácienseink rendelkezésére.</p>
            </div>
          </div>
          <div class="relative">
            <div class="rounded-3xl overflow-hidden bg-slate-50 border border-slate-100 shadow-sm aspect-[4/3] flex items-center justify-center">
              <img v-if="!teamImageError" src="/img/about-team.jpg" alt="Csapatunk" class="w-full h-full object-cover" @error="teamImageError = true">
              <svg v-else class="w-16 h-16 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div class="absolute -bottom-4 -left-4 bg-white rounded-2xl shadow-lg border border-slate-100 px-5 py-3.5 flex items-center gap-3">
              <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0 border border-blue-100">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
              </div>
              <div><p class="text-xs text-slate-400 font-medium">Minőségtanúsítvány</p><p class="text-sm font-bold text-slate-800">ISO Certified</p></div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- VALUES -->
    <section class="py-20 bg-slate-50 border-y border-slate-100">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
          <div class="section-label mb-4">Értékeink</div>
          <h2 class="mb-3 text-blue-950" style="font-family:'Outfit',sans-serif;font-size:clamp(2rem,4vw,2.75rem);font-weight:800;letter-spacing:-.02em;">Miért különlegesek vagyunk?</h2>
          <p class="text-slate-500 max-w-lg mx-auto text-sm leading-relaxed">Nem csupán optikai terméket kínálunk — teljes körű, személyes látásgondozást.</p>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
          <div v-for="value in values" :key="value.title" class="glass-card p-7">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-5" :style="`background:${value.iconBg};border:1px solid ${value.iconBorder}`">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" :style="`color:${value.iconColor}`">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" :d="value.icon"/>
              </svg>
            </div>
            <h3 class="font-bold text-blue-950 mb-2">{{ value.title }}</h3>
            <p class="text-slate-500 text-sm leading-relaxed">{{ value.desc }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- TIMELINE -->
    <section class="py-20 bg-white">
      <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
          <div class="section-label mb-4">Mérföldkövek</div>
          <h2 class="mb-2 text-blue-950" style="font-family:'Outfit',sans-serif;font-size:clamp(2rem,4vw,2.75rem);font-weight:800;letter-spacing:-.02em;">Utunk</h2>
          <p class="text-slate-500 text-sm">Hogyan jutottunk idáig</p>
        </div>
        <div class="relative">
          <div class="absolute left-6 top-2 bottom-2 w-px bg-blue-100"></div>
          <div class="space-y-8">
            <div v-for="(item, i) in timeline" :key="i" class="relative flex gap-6 items-start">
              <div class="w-12 h-12 rounded-xl border-2 flex items-center justify-center flex-shrink-0 z-10 bg-white shadow-sm" :class="i===0?'border-blue-500':'border-slate-200'">
                <span class="text-xs font-bold" :class="i===0?'text-blue-600':'text-slate-400'">{{ item.year }}</span>
              </div>
              <div class="glass-card p-5 flex-1">
                <p class="text-sm font-bold text-blue-950 mb-1">{{ item.title }}</p>
                <p class="text-sm text-slate-500 leading-relaxed">{{ item.desc }}</p>
              </div>
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
useHead({ title: 'Rólunk - Optika' })
const teamImageError = ref(false)
const stats = [{ value: '20+', label: 'Év tapasztalat' }, { value: '3 000+', label: 'Elégedett páciens' }, { value: '500+', label: 'Szemüveg típus' }, { value: '4', label: 'Szakember' }]
const values = [
  { title: 'Személyre szabott ellátás', desc: 'Minden páciens egyedi — a vizsgálattól a keret-kiválasztásig mindent az egyéni igényekhez igazítunk.', icon: 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', iconBg: '#eff6ff', iconBorder: '#bfdbfe', iconColor: '#2563eb' },
  { title: 'Modern diagnosztika', desc: 'Legkorszerűbb műszerekkel végezzük a szemvizsgálatokat, pontos és megbízható eredményekért.', icon: 'M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v10m0 0h10M9 13H5m0 0a2 2 0 01-2-2V9m2 4v4a2 2 0 002 2h2m0 0h4m-4 0v-4m4 4v-4m0 0h2a2 2 0 002-2v-4', iconBg: '#f0f9ff', iconBorder: '#bae6fd', iconColor: '#0284c7' },
  { title: 'Prémium minőség', desc: 'Csak elismert márkák termékeit forgalmazzuk — keretektől a lencsékig minden minőségtanúsítvánnyal rendelkezik.', icon: 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z', iconBg: '#fefce8', iconBorder: '#fef08a', iconColor: '#ca8a04' },
  { title: 'Gyors ügyintézés', desc: 'Online időpontfoglaló rendszerünkkel rugalmasan, várakozás nélkül tervezheted be a látogatásodat.', icon: 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', iconBg: '#f0fdf4', iconBorder: '#bbf7d0', iconColor: '#16a34a' },
  { title: 'Folyamatos követés', desc: 'Pácienseinket rendszeres ellenőrzéssel kísérjük figyelemmel látásuk változásait.', icon: 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', iconBg: '#eff6ff', iconBorder: '#bfdbfe', iconColor: '#2563eb' },
  { title: 'Helyi közösség', desc: 'Büszkék vagyunk arra, hogy helyi vállalkozásként a közösség megbízható partnerei lehetünk évtizedek óta.', icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', iconBg: '#fff7ed', iconBorder: '#fed7aa', iconColor: '#ea580c' },
]
const timeline = [
  { year: "'24", title: 'Online webshop és foglalási rendszer', desc: 'Elindítottuk a modern weboldalt online termékkatalógussal és időpontfoglaló rendszerrel.' },
  { year: "'20", title: 'Digitális diagnosztikai fejlesztés', desc: 'Beruháztunk a legmodernebb számítógépes látásvizsgáló eszközökbe.' },
  { year: "'15", title: 'Bővítés és megújulás', desc: 'Nagyobb üzlethelyiségbe költöztünk, kibővítettük a kínálatot prémium keretekkel és kontaktlencse-részleggel.' },
  { year: "'05", title: 'Az első szemvizsgáló kabinet', desc: 'Saját vizsgálóhelyiséggel bővültünk, ettől kezdve teljes körű szemészeti ellátást tudunk nyújtani.' },
  { year: "'02", title: 'Alapítás', desc: 'Kis családi optikánk megnyitotta kapuit azzal a céllal, hogy elérhető áron, de kiváló minőségben szolgálja a helyi közösséget.' },
]
</script>
