<template>
  <div>
    <!-- HERO -->
    <section
      class="relative overflow-hidden bg-blue-950 flex items-center"
      style="min-height:52vh;padding-top:7rem;padding-bottom:5rem;"
    >
      <div
        class="absolute inset-0"
        style="background:linear-gradient(135deg,rgba(15,23,42,.85) 0%,rgba(30,58,138,.6) 60%,rgba(37,99,235,.3) 100%);"
      ></div>
      <div
        class="absolute right-0 top-1/2 -translate-y-1/2 pointer-events-none"
        style="width:420px;height:420px;opacity:.12;"
      >
        <svg viewBox="0 0 500 500" fill="none" class="w-full h-full">
          <circle cx="250" cy="250" r="230" stroke="white" stroke-width="1"/>
          <circle cx="250" cy="250" r="170" stroke="white" stroke-width="1.5"/>
          <circle cx="250" cy="250" r="110" stroke="white" stroke-width="1.5"/>
          <circle cx="250" cy="250" r="50" stroke="white" stroke-width="2"/>
        </svg>
      </div>
      <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center w-full">
        <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 text-blue-100 text-xs font-semibold px-3 py-1.5 rounded-full mb-6 backdrop-blur-sm">
          <span class="w-1.5 h-1.5 bg-blue-300 rounded-full"></span>Elérhetőség & Foglalás
        </div>
        <h1
          class="mb-5 leading-none text-white"
          style="font-family:'Outfit',sans-serif;font-size:clamp(2.5rem,6vw,4.5rem);font-weight:800;letter-spacing:-.02em;"
        >
          Vegye fel velünk a<br><span class="text-blue-300">kapcsolatot</span>
        </h1>
        <p class="max-w-xl mx-auto leading-relaxed text-blue-100/80" style="font-size:1.05rem;">
          Foglaljon időpontot online, vagy lépjen kapcsolatba velünk közvetlenül.
        </p>
      </div>
    </section>

    <!-- MAIN CONTENT -->
    <section class="py-20 bg-slate-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-5 gap-10">

          <!-- Contact info (left) -->
          <div class="lg:col-span-2 space-y-6">
            <div>
              <div class="section-label mb-5">Elérhetőségek</div>
              <h2
                class="mb-3 text-blue-950"
                style="font-family:'Outfit',sans-serif;font-size:1.75rem;font-weight:800;letter-spacing:-.02em;"
              >
                Hogyan találhat meg?
              </h2>
              <p class="text-slate-500 text-sm leading-relaxed">
                Személyesen, telefonon és emailen is elérhet minket. Nyitvatartási időn belül szívesen fogadjuk kérdéseit.
              </p>
            </div>

            <div class="space-y-4">
              <div v-for="info in contactInfo" :key="info.label" class="glass-card p-5 flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 bg-blue-50 border border-blue-100">
                  <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" :d="info.icon"/>
                  </svg>
                </div>
                <div>
                  <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-0.5">{{ info.label }}</p>
                  <p class="text-sm font-medium text-slate-800" v-html="info.value"></p>
                </div>
              </div>
            </div>

            <!-- Google Maps embed -->
            <div class="glass-card overflow-hidden rounded-2xl aspect-[4/3]">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2718.0!2d25.8053767!3d46.3640018!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x474b2a0e7a8a12d1%3A0x28863474f950aee1!2sBIOOPTICA!5e0!3m2!1shu!2sro!4v1714820000000!5m2!1shu!2sro"
                width="100%"
                height="100%"
                style="border:0;"
                allowfullscreen
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                title="BIOOPTICA térkép"
              ></iframe>
            </div>
          </div>

          <!-- Booking form (right) -->
          <div class="lg:col-span-3">

            <!-- Success state -->
            <div v-if="bookingSuccess" class="glass-card p-10 text-center">
              <div class="w-16 h-16 bg-green-50 border border-green-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
              </div>
              <h3 class="text-xl font-bold text-blue-950 mb-3" style="font-family:'Outfit',sans-serif;">Időpont kérés elküldve!</h3>
              <p class="text-slate-500 text-sm leading-relaxed mb-6 max-w-sm mx-auto">
                Kérése beérkezett. Hamarosan emailben értesítjük a foglalás megerősítéséről.
              </p>
              <button @click="bookingSuccess = false; resetForm()" class="btn-primary text-sm">
                Új foglalás
              </button>
            </div>

            <!-- Booking form -->
            <div v-else class="glass-card p-8">
              <div class="section-label mb-5">Időpont foglalás</div>
              <h3 class="text-xl font-bold text-blue-950 mb-6" style="font-family:'Outfit',sans-serif;">
                Foglaljon időpontot
              </h3>

              <!-- Step 1: Service type -->
              <div class="mb-7">
                <label class="block text-sm font-semibold text-slate-700 mb-3">1. Válasszon szolgáltatást</label>
                <div v-if="typesLoading" class="text-sm text-slate-400">Betöltés...</div>
                <div v-else class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                  <button
                    v-for="type in appointmentTypes"
                    :key="type.id"
                    type="button"
                    @click="form.appointment_type_id = type.id"
                    class="text-left p-4 rounded-xl border-2 transition-all"
                    :class="form.appointment_type_id === type.id
                      ? 'border-blue-500 bg-blue-50'
                      : 'border-slate-200 bg-white hover:border-blue-200'"
                  >
                    <div class="flex items-start gap-3">
                      <span
                        class="w-3 h-3 rounded-full flex-shrink-0 mt-1"
                        :style="`background:${type.color}`"
                      ></span>
                      <div>
                        <p class="text-sm font-semibold text-slate-800">{{ type.name }}</p>
                        <p v-if="type.description" class="text-xs text-slate-400 mt-0.5 leading-relaxed">{{ type.description }}</p>
                        <p v-if="type.price" class="text-xs font-semibold text-blue-600 mt-1">{{ type.price }} RON</p>
                      </div>
                    </div>
                  </button>
                </div>
                <p v-if="errors.appointment_type_id" class="mt-2 text-xs text-red-500">{{ errors.appointment_type_id }}</p>
              </div>

              <!-- Step 2: Calendar -->
              <div class="mb-7">
                <label class="block text-sm font-semibold text-slate-700 mb-3">2. Válasszon dátumot</label>
                <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
                  <!-- Calendar header -->
                  <div class="flex items-center justify-between px-5 py-3 border-b border-slate-100 bg-slate-50">
                    <button type="button" @click="prevMonth" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-slate-200 text-slate-600 transition">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <div class="flex items-center gap-2">
                      <span class="text-sm font-semibold text-slate-800">{{ calendarTitle }}</span>
                      <div v-if="availabilityLoading" class="w-3 h-3 border border-blue-400 border-t-transparent rounded-full animate-spin"></div>
                    </div>
                    <button type="button" @click="nextMonth" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-slate-200 text-slate-600 transition">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                  </div>
                  <!-- Day names -->
                  <div class="grid grid-cols-7 border-b border-slate-100">
                    <div v-for="d in ['H', 'K', 'Sz', 'Cs', 'P', 'Sz', 'V']" :key="d" class="py-2 text-center text-xs font-semibold text-slate-400">{{ d }}</div>
                  </div>
                  <!-- Days grid -->
                  <div class="grid grid-cols-7 p-2 gap-1">
                    <div v-for="(day, i) in calendarDays" :key="i">
                      <div v-if="!day" class="aspect-square"></div>
                      <button
                        v-else
                        type="button"
                        :disabled="day.isDisabled"
                        :title="day.blockedReason ?? undefined"
                        @click="!day.isDisabled && selectDate(day.dateStr)"
                        class="relative w-full aspect-square flex flex-col items-center justify-center text-sm rounded-lg transition-all font-medium"
                        :class="dayClass(day)"
                      >
                        <span :class="{ 'line-through': day.isBlocked || day.isFullyBooked }">{{ day.day }}</span>
                        <!-- Részlegesen foglalt jelző pont -->
                        <span
                          v-if="day.isPartiallyBooked && !day.isDisabled"
                          class="absolute bottom-1 left-1/2 -translate-x-1/2 w-1 h-1 rounded-full bg-orange-400"
                        ></span>
                      </button>
                    </div>
                  </div>
                  <!-- Jelmagyarázat -->
                  <div class="px-4 pb-3 flex flex-wrap gap-x-4 gap-y-1.5">
                    <div class="flex items-center gap-1.5">
                      <span class="w-3 h-3 rounded bg-slate-100 border border-slate-200 inline-block"></span>
                      <span class="text-xs text-slate-400">Hétvége / zárva</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                      <span class="w-3 h-3 rounded bg-red-100 border border-red-200 inline-block"></span>
                      <span class="text-xs text-slate-400">Ünnepnap / zárva</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                      <span class="w-3 h-3 rounded bg-slate-200 inline-block"></span>
                      <span class="text-xs text-slate-400">Teljesen foglalt</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                      <span class="w-2 h-2 rounded-full bg-orange-400 inline-block"></span>
                      <span class="text-xs text-slate-400">Részben foglalt</span>
                    </div>
                  </div>
                </div>
                <p v-if="errors.appointment_date" class="mt-2 text-xs text-red-500">{{ errors.appointment_date }}</p>
              </div>

              <!-- Step 3: Time slot -->
              <div class="mb-7">
                <label class="block text-sm font-semibold text-slate-700 mb-3">3. Válasszon időpontot</label>
                <p v-if="!form.appointment_date" class="text-sm text-slate-400 italic">Először válasszon dátumot a naptárból.</p>
                <div v-else class="grid grid-cols-4 sm:grid-cols-6 gap-2">
                  <button
                    v-for="slot in timeSlots"
                    :key="slot"
                    type="button"
                    :disabled="isSlotBooked(slot)"
                    @click="!isSlotBooked(slot) && (form.start_time = slot)"
                    class="py-2 px-2 text-sm rounded-xl border-2 font-medium transition-all relative"
                    :class="form.start_time === slot
                      ? 'border-blue-500 bg-blue-600 text-white'
                      : isSlotBooked(slot)
                        ? 'border-slate-100 bg-slate-50 text-slate-300 cursor-not-allowed line-through'
                        : 'border-slate-200 text-slate-600 hover:border-blue-300 hover:text-blue-700'"
                  >
                    {{ slot }}
                  </button>
                </div>
                <p v-if="errors.start_time" class="mt-2 text-xs text-red-500">{{ errors.start_time }}</p>
              </div>

              <!-- Step 4: Personal info -->
              <div class="mb-7">
                <label class="block text-sm font-semibold text-slate-700 mb-3">4. Személyes adatok</label>

                <!-- Logged in user info badge -->
                <div v-if="isLoggedIn" class="flex items-center gap-3 p-4 bg-blue-50 border border-blue-200 rounded-xl mb-3">
                  <div class="w-9 h-9 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                    <span class="text-sm font-bold text-white">{{ user?.name?.charAt(0).toUpperCase() }}</span>
                  </div>
                  <div>
                    <p class="text-sm font-semibold text-blue-900">{{ user?.name }}</p>
                    <p class="text-xs text-blue-600">{{ user?.email }}</p>
                  </div>
                  <div class="ml-auto">
                    <span class="text-xs bg-blue-600 text-white px-2 py-1 rounded-full font-medium">Bejelentkezve</span>
                  </div>
                </div>

                <!-- Guest fields -->
                <div v-if="!isLoggedIn" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1.5">Teljes neve *</label>
                    <input
                      v-model="form.guest_name"
                      type="text"
                      placeholder="Kovács János"
                      class="w-full px-4 py-2.5 text-sm border rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                      :class="errors.guest_name ? 'border-red-300' : 'border-slate-200'"
                    >
                    <p v-if="errors.guest_name" class="mt-1 text-xs text-red-500">{{ errors.guest_name }}</p>
                  </div>
                  <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1.5">Email cím *</label>
                    <input
                      v-model="form.guest_email"
                      type="email"
                      placeholder="pelda@email.com"
                      class="w-full px-4 py-2.5 text-sm border rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                      :class="errors.guest_email ? 'border-red-300' : 'border-slate-200'"
                    >
                    <p v-if="errors.guest_email" class="mt-1 text-xs text-red-500">{{ errors.guest_email }}</p>
                  </div>
                </div>
              </div>

              <!-- Step 5: Notes -->
              <div class="mb-8">
                <label class="block text-sm font-semibold text-slate-700 mb-2">5. Megjegyzés <span class="text-slate-400 font-normal">(opcionális)</span></label>
                <textarea
                  v-model="form.customer_notes"
                  rows="3"
                  placeholder="Pl. recepty száma, speciális kérés, korábbi vizsgálat..."
                  class="w-full px-4 py-3 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"
                ></textarea>
              </div>

              <!-- Submit -->
              <div v-if="submitError" class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl">
                <p class="text-sm text-red-700">{{ submitError }}</p>
              </div>

              <button
                type="button"
                :disabled="submitting"
                @click="submitBooking"
                class="w-full btn-primary justify-center py-3.5"
                style="font-size:.95rem;"
              >
                <span v-if="submitting">Küldés...</span>
                <span v-else>Időpont kérés elküldése</span>
              </button>

              <p class="mt-4 text-xs text-slate-400 text-center leading-relaxed">
                Az időpont kérés elküldése után emailben értesítjük a visszaigazolásról.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup lang="ts">
interface AppointmentType {
  id: number
  name: string
  description: string | null
  duration_minutes: number
  price: number | null
  color: string
}

interface BookingForm {
  appointment_type_id: number | null
  appointment_date: string
  start_time: string
  guest_name: string
  guest_email: string
  customer_notes: string
}

interface CalendarDay {
  day: number
  dateStr: string
  isPast: boolean
  isToday: boolean
  isWeekend: boolean
  isBlocked: boolean
  isFullyBooked: boolean
  isPartiallyBooked: boolean
  isDisabled: boolean
  blockedReason: string | null
}

interface AvailabilityData {
  blocked_dates: Record<string, string>
  booked_slots: Record<string, string[]>
  fully_booked_dates: string[]
}

const { user, isLoggedIn } = useAuth()
const { api } = useApi()

const appointmentTypes = ref<AppointmentType[]>([])
const typesLoading = ref(true)
const submitting = ref(false)
const bookingSuccess = ref(false)
const submitError = ref('')
const errors = ref<Record<string, string>>({})

// Elérhetőségi adatok
const availabilityLoading = ref(false)
const blockedDates = ref<Record<string, string>>({})
const bookedSlots = ref<Record<string, string[]>>({})
const fullyBookedDates = ref<string[]>([])

const today = new Date()
const calendarYear = ref(today.getFullYear())
const calendarMonth = ref(today.getMonth())

const form = ref<BookingForm>({
  appointment_type_id: null,
  appointment_date: '',
  start_time: '',
  guest_name: '',
  guest_email: '',
  customer_notes: '',
})

// Nap-specifikus időpontok (1=H, 2=K, 3=Sz, 4=Cs, 5=P; 6=Szo és 0=V zárva)
const SLOTS_BY_DOW: Record<number, string[]> = {
  1: ['10:00', '11:00', '12:00', '14:00', '15:00', '16:00', '17:00'],
  2: ['10:00', '11:00', '12:00', '14:00', '15:00', '16:00', '17:00'],
  3: ['10:00', '11:00', '12:00', '14:00', '15:00', '16:00', '17:00'],
  4: ['09:00', '10:00', '11:00', '12:00', '14:00', '15:00', '16:00'],
  5: ['09:00', '10:00', '11:00', '12:00', '14:00', '15:00'],
}

const timeSlots = computed<string[]>(() => {
  if (!form.value.appointment_date) return []
  const dow = new Date(form.value.appointment_date + 'T00:00:00').getDay()
  return SLOTS_BY_DOW[dow] ?? []
})

const monthNames = ['Január','Február','Március','Április','Május','Június','Július','Augusztus','Szeptember','Október','November','December']

const calendarTitle = computed(() => `${calendarYear.value}. ${monthNames[calendarMonth.value]}`)

async function fetchAvailability(year: number, month: number) {
  availabilityLoading.value = true
  try {
    const data = await api<AvailabilityData>(
      `/appointments/availability?year=${year}&month=${month + 1}`
    )
    blockedDates.value = data.blocked_dates
    bookedSlots.value = data.booked_slots
    fullyBookedDates.value = data.fully_booked_dates
  } catch {
    // Ha nem sikerül, üres adatokkal dolgozunk
  } finally {
    availabilityLoading.value = false
  }
}

// Ha a felhasználó hónapot vált, töltjük az új adatokat
watch([calendarYear, calendarMonth], ([y, m]) => fetchAvailability(y, m))

function isSlotBooked(slot: string): boolean {
  if (!form.value.appointment_date) return false
  return (bookedSlots.value[form.value.appointment_date] ?? []).includes(slot)
}

function dayClass(day: CalendarDay): Record<string, boolean> {
  const isSelected = form.value.appointment_date === day.dateStr
  return {
    'bg-blue-600 text-white shadow-sm': isSelected,
    'bg-red-50 text-red-300 cursor-not-allowed': !isSelected && day.isBlocked,
    'bg-slate-200 text-slate-400 cursor-not-allowed': !isSelected && day.isFullyBooked,
    'bg-blue-50 text-blue-700 ring-1 ring-blue-200': !isSelected && day.isToday && !day.isDisabled,
    'text-slate-300 cursor-not-allowed': !isSelected && (day.isPast || day.isWeekend) && !day.isBlocked && !day.isFullyBooked,
    'text-slate-700 hover:bg-blue-50 hover:text-blue-700': !isSelected && !day.isDisabled && !day.isToday,
  }
}

const calendarDays = computed(() => {
  const year = calendarYear.value
  const month = calendarMonth.value
  const firstDow = new Date(year, month, 1).getDay()
  const daysInMonth = new Date(year, month + 1, 0).getDate()
  const todayDate = new Date(today.getFullYear(), today.getMonth(), today.getDate())

  const offset = firstDow === 0 ? 6 : firstDow - 1
  const days: Array<CalendarDay | null> = Array.from({ length: offset }, () => null)

  for (let d = 1; d <= daysInMonth; d++) {
    const date = new Date(year, month, d)
    const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`

    const dow            = date.getDay()
    const isPast         = date < todayDate
    const isWeekend      = dow === 0 || dow === 6
    const isBlocked      = dateStr in blockedDates.value
    const isFullyBooked  = fullyBookedDates.value.includes(dateStr)
    const slots          = bookedSlots.value[dateStr] ?? []
    const isPartiallyBooked = slots.length > 0 && !isFullyBooked

    days.push({
      day: d,
      dateStr,
      isPast,
      isToday: date.getTime() === todayDate.getTime(),
      isWeekend,
      isBlocked,
      isFullyBooked,
      isPartiallyBooked,
      isDisabled: isPast || isWeekend || isBlocked || isFullyBooked,
      blockedReason: isBlocked ? (blockedDates.value[dateStr] ?? null) : null,
    })
  }

  return days
})

const contactInfo = [
  {
    label: 'Cím',
    value: 'Decemberi Forradalom utca 3 szám, Csíkszereda',
    icon: 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z',
  },
  {
    label: 'Telefonszám',
    value: '+40 755 088 373',
    icon: 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z',
  },
  {
    label: 'Email',
    value: 'office@biooptica.ro',
    icon: 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
  },
  {
    label: 'Nyitvatartás',
    value: 'Hétfő–Szerda: 10:00–18:00<br>Csütörtök: 09:00–17:00<br>Péntek: 09:00–16:00<br>Szombat–Vasárnap: Zárva',
    icon: 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
  },
]

function selectDate(dateStr: string) {
  form.value.appointment_date = dateStr
  // Ha a korábban választott időpont ezen a napon már foglalt, töröljük
  if (form.value.start_time && isSlotBooked(form.value.start_time)) {
    form.value.start_time = ''
  }
}

function prevMonth() {
  if (calendarMonth.value === 0) {
    calendarMonth.value = 11
    calendarYear.value--
  } else {
    calendarMonth.value--
  }
}

function nextMonth() {
  if (calendarMonth.value === 11) {
    calendarMonth.value = 0
    calendarYear.value++
  } else {
    calendarMonth.value++
  }
}

function resetForm() {
  form.value = {
    appointment_type_id: null,
    appointment_date: '',
    start_time: '',
    guest_name: '',
    guest_email: '',
    customer_notes: '',
  }
  errors.value = {}
  submitError.value = ''
}

function validate(): boolean {
  const e: Record<string, string> = {}

  if (!form.value.appointment_type_id) e.appointment_type_id = 'Kérjük, válasszon szolgáltatást.'
  if (!form.value.appointment_date) e.appointment_date = 'Kérjük, válasszon dátumot.'
  if (!form.value.start_time) e.start_time = 'Kérjük, válasszon időpontot.'

  if (!isLoggedIn.value) {
    if (!form.value.guest_name.trim()) e.guest_name = 'Kérjük, adja meg a nevét.'
    if (!form.value.guest_email.trim()) e.guest_email = 'Kérjük, adja meg az email címét.'
  }

  errors.value = e
  return Object.keys(e).length === 0
}

async function submitBooking() {
  submitError.value = ''
  if (!validate()) return

  submitting.value = true

  try {
    const payload: Record<string, unknown> = {
      appointment_type_id: form.value.appointment_type_id,
      appointment_date: form.value.appointment_date,
      start_time: form.value.start_time,
      customer_notes: form.value.customer_notes || null,
    }

    if (!isLoggedIn.value) {
      payload.guest_name = form.value.guest_name
      payload.guest_email = form.value.guest_email
    }

    await api('/appointments', { method: 'POST', body: payload })
    bookingSuccess.value = true
  } catch (err: unknown) {
    const apiErr = err as { data?: { message?: string; errors?: Record<string, string[]> } }
    if (apiErr.data?.errors) {
      const serverErrors: Record<string, string> = {}
      for (const [field, messages] of Object.entries(apiErr.data.errors)) {
        serverErrors[field] = messages[0] ?? ''
      }
      errors.value = serverErrors
    } else {
      submitError.value = apiErr.data?.message ?? 'Hiba történt az időpont kérés elküldése során. Kérjük, próbálja újra.'
    }
  } finally {
    submitting.value = false
  }
}

onMounted(async () => {
  // Szolgáltatások és az aktuális hónap elérhetőségének betöltése párhuzamosan
  await Promise.allSettled([
    api<{ types: AppointmentType[] }>('/appointment-types').then(data => {
      appointmentTypes.value = data.types
    }).finally(() => {
      typesLoading.value = false
    }),
    fetchAvailability(calendarYear.value, calendarMonth.value),
  ])
})
</script>
