<template>
  <div>
    <!-- Hero -->
    <section class="relative overflow-hidden bg-blue-950 pt-20 pb-24 min-h-[420px] flex items-center">
      <img
        src="/img/about-bg.jpg"
        alt=""
        aria-hidden="true"
        class="absolute inset-0 w-full h-full object-cover opacity-40"
        @error="($event.target as HTMLImageElement).style.display = 'none'"
      >
      <div class="absolute inset-0 bg-gradient-to-br from-blue-950/75 via-blue-900/55 to-blue-800/45"></div>

      <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center w-full">
        <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 text-blue-100 text-xs font-semibold px-3 py-1.5 rounded-full mb-6 backdrop-blur-sm">
          <span class="w-1.5 h-1.5 bg-blue-300 rounded-full"></span>
          Ismerd meg csapatunkat
        </div>
        <h1 class="text-5xl md:text-6xl font-bold text-white mb-5 leading-tight">
          Több mint látásvizsgálat —<br>
          <span class="text-blue-300">gondoskodás.</span>
        </h1>
        <p class="text-blue-100/75 text-lg md:text-xl max-w-2xl mx-auto leading-relaxed">
          Évtizedes tapasztalattal, modern technológiával és személyes odafigyeléssel állunk ügyfeleink szolgálatában.
        </p>
      </div>
    </section>

    <!-- Számok -->
    <section class="bg-white border-b border-slate-100 py-12">
      <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
          <div v-for="stat in stats" :key="stat.label" class="group">
            <p class="text-4xl font-bold text-blue-700 mb-1 tabular-nums">{{ stat.value }}</p>
            <p class="text-sm text-slate-500 font-medium">{{ stat.label }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Történetünk -->
    <section class="py-20 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 gap-14 items-center">
          <div>
            <div class="inline-flex items-center gap-2 bg-blue-50 text-blue-700 text-xs font-semibold px-3 py-1.5 rounded-full mb-5 border border-blue-100">
              Történetünk
            </div>
            <h2 class="text-3xl md:text-4xl font-bold text-blue-950 mb-5 leading-snug">
              Helyi gyökerek,<br>modern szemlélet
            </h2>
            <div class="space-y-4 text-slate-500 text-sm leading-relaxed">
              <p>
                Optikánk több mint két évtizede nyújt professzionális látásjavítási megoldásokat. Ami kis családi vállalkozásként indult, mára a régió egyik megbízható optikai szaküzletévé vált.
              </p>
              <p>
                Hisszük, hogy a jó látás alapvetően befolyásolja az életminőséget — ezért nem csupán szemüveget adunk, hanem teljes körű szemészeti tanácsadást, személyre szabott megoldásokkal.
              </p>
              <p>
                Csapatunk folyamatosan képzi magát, hogy a legmodernebb diagnosztikai eszközökkel és technikákkal állhassunk pácienseink rendelkezésére.
              </p>
            </div>
          </div>

          <!-- Képes kártya -->
          <div class="relative">
            <div class="rounded-3xl overflow-hidden bg-slate-50 border border-slate-100 shadow-sm aspect-[4/3] flex items-center justify-center">
              <img
                v-if="!teamImageError"
                src="/img/about-team.jpg"
                alt="Csapatunk"
                class="w-full h-full object-cover"
                @error="teamImageError = true"
              >
              <svg v-else class="w-16 h-16 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
            </div>
            <!-- Lebegő badge -->
            <div class="absolute -bottom-4 -left-4 bg-white rounded-2xl shadow-lg border border-slate-100 px-5 py-3.5 flex items-center gap-3">
              <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                </svg>
              </div>
              <div>
                <p class="text-xs text-slate-400 font-medium">Minőségtanúsítvány</p>
                <p class="text-sm font-bold text-slate-800">ISO Certified</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Értékeink -->
    <section class="py-20 bg-slate-50 border-y border-slate-100">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
          <div class="inline-flex items-center gap-2 bg-white text-blue-700 text-xs font-semibold px-3 py-1.5 rounded-full mb-4 border border-blue-100 shadow-sm">
            Értékeink
          </div>
          <h2 class="text-3xl font-bold text-blue-950 mb-3">Miért különlegesek vagyunk?</h2>
          <p class="text-slate-500 max-w-lg mx-auto text-sm leading-relaxed">
            Nem csupán optikai terméket kínálunk — teljes körű, személyes látásgondozást.
          </p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
          <div
            v-for="value in values"
            :key="value.title"
            class="bg-white rounded-2xl border border-slate-100 p-7 shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300"
          >
            <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-5" :class="value.iconBg">
              <svg class="w-6 h-6" :class="value.iconColor" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" :d="value.icon" />
              </svg>
            </div>
            <h3 class="text-base font-bold text-blue-950 mb-2">{{ value.title }}</h3>
            <p class="text-slate-500 text-sm leading-relaxed">{{ value.desc }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Idővonal -->
    <section class="py-20 bg-white">
      <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
          <div class="inline-flex items-center gap-2 bg-blue-50 text-blue-700 text-xs font-semibold px-3 py-1.5 rounded-full mb-4 border border-blue-100">
            Mérföldkövek
          </div>
          <h2 class="text-3xl font-bold text-blue-950 mb-2">Utunk</h2>
          <p class="text-slate-500 text-sm">Hogyan jutottunk idáig</p>
        </div>

        <div class="relative">
          <!-- Vonal -->
          <div class="absolute left-6 top-2 bottom-2 w-px bg-slate-100"></div>

          <div class="space-y-8">
            <div v-for="(item, i) in timeline" :key="i" class="relative flex gap-6 items-start">
              <div class="w-12 h-12 rounded-xl bg-white border-2 flex items-center justify-center flex-shrink-0 z-10 shadow-sm"
                   :class="i === 0 ? 'border-blue-500' : 'border-slate-200'">
                <span class="text-xs font-bold" :class="i === 0 ? 'text-blue-600' : 'text-slate-400'">{{ item.year }}</span>
              </div>
              <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex-1 hover:border-blue-100 hover:shadow-md transition-all duration-200">
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
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4 leading-tight">
          Készen állsz a jobb látásra?
        </h2>
        <p class="text-blue-200/80 mb-8 leading-relaxed">
          Foglalj időpontot még ma — csapatunk örömmel fogad és segít megtalálni a számodra legjobb megoldást.
        </p>
        <div class="flex gap-3 justify-center flex-wrap">
          <NuxtLink
            to="/contact"
            class="bg-white text-blue-900 no-underline px-7 py-3.5 rounded-xl font-semibold hover:bg-blue-50 transition-colors shadow-sm inline-block"
          >
            Időpont foglalás
          </NuxtLink>
          <NuxtLink
            to="/szemuvegek"
            class="bg-white/10 text-white no-underline px-7 py-3.5 rounded-xl font-semibold hover:bg-white/20 border border-white/25 transition-colors inline-block backdrop-blur-sm"
          >
            Termékeink
          </NuxtLink>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup lang="ts">
useHead({ title: 'Rólunk - Optika' })

const teamImageError = ref(false)

const stats = [
  { value: '20+', label: 'Év tapasztalat' },
  { value: '3 000+', label: 'Elégedett páciens' },
  { value: '500+', label: 'Szemüveg típus' },
  { value: '4', label: 'Szakember' },
]

const values = [
  {
    title: 'Személyre szabott ellátás',
    desc: 'Minden páciens egyedi — a vizsgálattól a keret-kiválasztásig mindent az egyéni igényekhez igazítunk.',
    icon: 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
    iconBg: 'bg-blue-50',
    iconColor: 'text-blue-600',
  },
  {
    title: 'Modern diagnosztika',
    desc: 'Legkorszerűbb műszerekkel végezzük a szemvizsgálatokat, pontos és megbízható eredményekért.',
    icon: 'M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v10m0 0h10M9 13H5m0 0a2 2 0 01-2-2V9m2 4v4a2 2 0 002 2h2m0 0h4m-4 0v-4m4 4v-4m0 0h2a2 2 0 002-2v-4',
    iconBg: 'bg-violet-50',
    iconColor: 'text-violet-600',
  },
  {
    title: 'Prémium minőség',
    desc: 'Csak elismert márkák termékeit forgalmazzuk — keretektől a lencsékig minden minőségtanúsítvánnyal rendelkezik.',
    icon: 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z',
    iconBg: 'bg-amber-50',
    iconColor: 'text-amber-600',
  },
  {
    title: 'Gyors ügyintézés',
    desc: 'Online időpontfoglaló rendszerünkkel rugalmasan, várakozás nélkül tervezheted be a látogatásodat.',
    icon: 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
    iconBg: 'bg-green-50',
    iconColor: 'text-green-600',
  },
  {
    title: 'Folyamatos követés',
    desc: 'Pácienseinket nem csak az első vizit után gondozzuk — rendszeres ellenőrzéssel kísérjük figyelemmel látásuk változásait.',
    icon: 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
    iconBg: 'bg-blue-50',
    iconColor: 'text-blue-600',
  },
  {
    title: 'Helyi közösség',
    desc: 'Büszkék vagyunk arra, hogy helyi vállalkozásként a közösség megbízható partnerei lehetünk évtizedek óta.',
    icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
    iconBg: 'bg-orange-50',
    iconColor: 'text-orange-600',
  },
]

const timeline = [
  {
    year: '\'24',
    title: 'Online webshop és foglalási rendszer',
    desc: 'Elindítottuk a modern weboldalt online termékkatalógussal és időpontfoglaló rendszerrel.',
  },
  {
    year: '\'20',
    title: 'Digitális diagnosztikai fejlesztés',
    desc: 'Beruháztunk a legmodernebb számítógépes látásvizsgáló eszközökbe a még pontosabb diagnózisért.',
  },
  {
    year: '\'15',
    title: 'Bővítés és megújulás',
    desc: 'Nagyobb üzlethelyiségbe költöztünk, kibővítettük a kínálatot prémium keretekkel és kontaktlencse-részleggel.',
  },
  {
    year: '\'05',
    title: 'Az első szemvizsgáló kabinet',
    desc: 'Saját vizsgálóhelyiséggel bővültünk, ettől kezdve teljes körű szemészeti ellátást tudunk nyújtani.',
  },
  {
    year: '\'02',
    title: 'Alapítás',
    desc: 'Kis családi optikánk megnyitotta kapuit azzal a céllal, hogy elérhető áron, de kiváló minőségben szolgálja a helyi közösséget.',
  },
]
</script>
