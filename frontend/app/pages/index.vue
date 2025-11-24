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
          <NuxtLink
            v-if="isLoggedIn"
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

<script setup>
const { isLoggedIn } = useAuth()

useHead({
  title: 'Főoldal - Optika'
})
</script>