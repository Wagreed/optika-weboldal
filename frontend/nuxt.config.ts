// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2025-07-15',
  devtools: { enabled: true },

  modules: [
    '@unocss/nuxt',
    '@nuxt/eslint',
    '@nuxt/fonts',
    '@nuxt/icon',
    '@nuxt/image',
    '@nuxt/test-utils'
  ],

  fonts: {
    families: [
      { name: 'Outfit', weights: ['400', '500', '600', '700', '800', '900'] },
      { name: 'DM Sans', weights: ['300', '400', '500', '600', '700'] },
    ]
  },

  runtimeConfig: {
    public: {
      apiUrl: process.env.NUXT_PUBLIC_API_URL || 'http://localhost:8000/api',
      adminUrl: process.env.NUXT_PUBLIC_ADMIN_URL || 'http://localhost:8000/admin',
    },
  },
})