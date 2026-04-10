<template>
  <div class="bg-black text-white overflow-x-hidden" style="font-family: 'Nunito', sans-serif;">

    <!-- ═══════════════════════════════════════════════
         SHOP HERO
    ══════════════════════════════════════════════════ -->
    <section class="relative min-h-[50vh] flex items-center overflow-hidden">
      <div class="absolute inset-0 z-0">
        <div class="shop-hero-bg absolute inset-0" />
        <svg class="absolute inset-0 w-full h-full opacity-10" viewBox="0 0 1440 900" preserveAspectRatio="xMidYMid slice" fill="none">
          <line x1="-100" y1="900" x2="1200" y2="-50" stroke="#C9A84C" stroke-width="1"/>
          <line x1="100" y1="900" x2="1400" y2="-50" stroke="#C9A84C" stroke-width="0.5"/>
          <circle cx="720" cy="450" r="380" stroke="#C9A84C" stroke-width="0.5"/>
        </svg>
        <div class="noise-overlay absolute inset-0" />
      </div>
      <div class="relative z-10 container mx-auto px-6 pt-32 pb-20 text-center">
        <p class="text-gold-400 text-xs tracking-[0.5em] uppercase mb-4">BILLETTERIE OFFICIELLE</p>
        <h1 style="font-family:'Bebas Neue',sans-serif;">
          <span class="block text-[clamp(3rem,8vw,6rem)] leading-none tracking-tight">United Kizdom</span>
          <span class="block text-[clamp(2.5rem,6vw,5rem)] leading-none gradient-text-gold">World Congress 2026</span>
        </h1>
        <p class="text-white/50 mt-6">Bénin, Afrique · 14 – 19 Juillet 2026</p>
      </div>
    </section>

    <!-- ═══════════════════════════════════════════════
         SECTION 1 : EVENT PASS
    ══════════════════════════════════════════════════ -->
    <section class="py-20 border-t border-gold-500/10">
      <div class="container mx-auto px-6">
        <div class="text-center mb-12">
          <div class="section-label mb-3">— 01</div>
          <h2 class="section-title">Event <span class="gradient-text-gold">Pass</span></h2>
        </div>

        <!-- Chargement -->
        <div v-if="ticketsLoading" class="text-center py-20 text-white/40">Chargement des billets...</div>

        <!-- Coming Soon -->
        <div v-else-if="eventPasses.length === 0" class="coming-soon-block">
          <div class="coming-soon-icon">🎟️</div>
          <div class="coming-soon-title gradient-text-gold">Coming Soon</div>
          <p class="coming-soon-sub">Les billets Event Pass seront bientôt disponibles.</p>
        </div>

        <!-- Carousel -->
        <template v-else>
          <div class="relative">
            <div class="overflow-hidden">
              <div class="flex transition-transform duration-500 ease-out"
                   :style="{ transform: `translateX(-${eventPassCurrentIndex * 33.333}%)` }">
                <div v-for="pass in eventPasses" :key="pass.slug"
                     class="w-full sm:w-1/2 lg:w-1/3 flex-shrink-0 px-3">
                  <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden hover:border-gold-500/40 transition-all duration-300 hover:-translate-y-1 h-full flex flex-col"
                       :class="{ 'opacity-50': !pass.is_available }">
                    <div class="h-48 overflow-hidden relative bg-gradient-to-br from-gold-900/30 to-black flex items-center justify-center">
                      <img v-if="pass.image_url" :src="pass.image_url" :alt="pass.name" class="w-full h-full object-cover object-[17%]" />
                      <span v-else class="text-6xl text-gold-400 absolute">🎟️</span>
                      <div class="absolute top-3 right-3 bg-black/60 px-2 py-1 rounded text-gold-400 text-xs">PASS</div>
                      <div v-if="pass.is_early_bird" class="absolute top-3 left-3 bg-gold-500 text-black text-xs font-black px-2 py-1 rounded uppercase tracking-wide">
                        🐦 Early Bird
                      </div>
                      <div v-if="!pass.is_available" class="absolute inset-0 bg-black/60 flex items-center justify-center">
                        <span class="text-red-400 font-bold uppercase text-sm">Épuisé</span>
                      </div>
                    </div>
                    <div class="p-5 flex-1 flex flex-col">
                      <h3 class="font-black text-xl uppercase">{{ pass.name }}</h3>
                      <div class="mt-2 flex items-baseline gap-2 flex-wrap">
                        <span class="text-2xl font-bold text-gold-400">{{ (pass.effective_price ?? pass.price).toLocaleString() }} {{ pass.currency }}</span>
                        <span v-if="pass.is_early_bird" class="text-sm text-white/30 line-through">{{ pass.price.toLocaleString() }}</span>
                      </div>
                      <div class="text-white/30 text-xs mt-1">{{ pass.available_stock }} place(s) restante(s)</div>
                      <div class="mt-4 space-y-2 flex-1">
                        <div v-for="item in (pass.includes ?? []).slice(0,3)" :key="item" class="flex items-center gap-2 text-white/60 text-sm">
                          <span class="w-4 h-4 rounded-full bg-gold-500/20 flex items-center justify-center text-gold-400 text-xs">✓</span>
                          {{ item }}
                        </div>
                      </div>
                      <button
                        @click="selectTicket(pass)"
                        :disabled="!pass.is_available"
                        class="mt-5 w-full py-3 rounded-xl font-extrabold uppercase tracking-wider text-sm transition-all duration-300"
                        :class="addedSlug === pass.slug
                          ? 'bg-green-500 text-white'
                          : pass.is_available
                            ? 'bg-gold-500 hover:bg-gold-400 text-black'
                            : 'bg-white/10 text-white/30 cursor-not-allowed'">
                        {{ addedSlug === pass.slug ? '✓ Ajouté !' : pass.is_available ? 'Sélectionner' : 'Indisponible' }}
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <button @click="prevEventPass" class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 w-10 h-10 rounded-full bg-black/80 border border-gold-500/40 text-gold-400 hover:bg-gold-500 hover:text-black transition-all flex items-center justify-center z-10">◀</button>
            <button @click="nextEventPass" class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 w-10 h-10 rounded-full bg-black/80 border border-gold-500/40 text-gold-400 hover:bg-gold-500 hover:text-black transition-all flex items-center justify-center z-10">▶</button>
          </div>
          <div class="flex justify-center gap-2 mt-8">
            <button v-for="(_, idx) in Math.ceil(eventPasses.length / 3)" :key="idx"
                    @click="eventPassCurrentIndex = idx"
                    class="w-2 h-2 rounded-full transition-all"
                    :class="eventPassCurrentIndex === idx ? 'w-6 bg-gold-500' : 'bg-white/30'">
            </button>
          </div>
        </template>
      </div>
    </section>

    <!-- ═══════════════════════════════════════════════
         SECTION 2 : FULL PASS & STAY
    ══════════════════════════════════════════════════ -->
    <section class="py-20 border-t border-gold-500/10 bg-gradient-to-b from-transparent via-gold-900/5 to-transparent">
      <div class="container mx-auto px-6">
        <div class="text-center mb-12">
          <div class="section-label mb-3">— 02</div>
          <h2 class="section-title">Full Pass <span class="gradient-text-gold">& Stay</span></h2>
          <p class="text-white/40 text-sm mt-2">⚠️ Réservation avant le 15 juin</p>
        </div>

        <!-- Chargement -->
        <div v-if="ticketsLoading" class="text-center py-20 text-white/40">Chargement...</div>

        <!-- Coming Soon -->
        <div v-else-if="fullPassStayTickets.length === 0" class="coming-soon-block">
          <div class="coming-soon-icon">🏨</div>
          <div class="coming-soon-title gradient-text-gold">Coming Soon</div>
          <p class="coming-soon-sub">Les offres Full Pass & Stay seront bientôt disponibles.</p>
        </div>

        <!-- Carousel -->
        <template v-else>
          <div class="relative">
            <div class="overflow-hidden">
              <div class="flex transition-transform duration-500 ease-out"
                   :style="{ transform: `translateX(-${fullPassStayCurrentIndex * 33.333}%)` }">
                <div v-for="ticket in fullPassStayTickets" :key="ticket.slug"
                     class="w-full sm:w-1/2 lg:w-1/3 flex-shrink-0 px-3">
                  <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden hover:border-gold-500/40 transition-all duration-300 hover:-translate-y-1 h-full flex flex-col"
                       :class="{ 'opacity-50': !ticket.is_available }">
                    <div class="h-48 overflow-hidden relative bg-gradient-to-br from-gold-900/30 to-black flex items-center justify-center">
                      <img v-if="ticket.image_url" :src="ticket.image_url" :alt="ticket.name" class="w-full h-full object-cover object-left" />
                      <span v-else class="text-6xl text-gold-400 absolute">🏨</span>
                      <div class="absolute top-3 right-3 bg-black/60 px-2 py-1 rounded text-gold-400 text-xs">PASS</div>
                      <div v-if="ticket.is_early_bird" class="absolute top-3 left-3 bg-gold-500 text-black text-xs font-black px-2 py-1 rounded uppercase tracking-wide">
                        🐦 Early Bird
                      </div>
                      <div v-if="!ticket.is_available" class="absolute inset-0 bg-black/60 flex items-center justify-center">
                        <span class="text-red-400 font-bold uppercase text-sm">Épuisé</span>
                      </div>
                    </div>
                    <div class="p-5 flex-1 flex flex-col">
                      <h3 class="font-black text-xl uppercase">{{ ticket.name }}</h3>
                      <div class="mt-2 flex items-baseline gap-2 flex-wrap">
                        <span class="text-2xl font-bold text-gold-400">{{ (ticket.effective_price ?? ticket.price).toLocaleString() }} {{ ticket.currency }}</span>
                        <span v-if="ticket.is_early_bird" class="text-sm text-white/30 line-through">{{ ticket.price.toLocaleString() }}</span>
                      </div>
                      <div class="text-white/30 text-xs mt-1">{{ ticket.available_stock }} place(s) restante(s)</div>
                      <div class="mt-4 space-y-2 flex-1">
                        <div v-for="item in (ticket.includes ?? []).slice(0,3)" :key="item" class="flex items-center gap-2 text-white/60 text-sm">
                          <span class="w-4 h-4 rounded-full bg-gold-500/20 flex items-center justify-center text-gold-400 text-xs">✓</span>
                          {{ item }}
                        </div>
                      </div>
                      <button
                        @click="selectTicket(ticket)"
                        :disabled="!ticket.is_available"
                        class="mt-5 w-full py-3 rounded-xl font-extrabold uppercase tracking-wider text-sm transition-all duration-300 disabled:opacity-40 disabled:cursor-not-allowed"
                        :class="addedSlug === ticket.slug ? 'bg-green-500 text-white' : 'bg-gold-500 hover:bg-gold-400 text-black'">
                        {{ addedSlug === ticket.slug ? '✓ Ajouté !' : 'Choisir' }}
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <button @click="prevFullPassStay" class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 w-10 h-10 rounded-full bg-black/80 border border-gold-500/40 text-gold-400 hover:bg-gold-500 hover:text-black transition-all flex items-center justify-center z-10">◀</button>
            <button @click="nextFullPassStay" class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 w-10 h-10 rounded-full bg-black/80 border border-gold-500/40 text-gold-400 hover:bg-gold-500 hover:text-black transition-all flex items-center justify-center z-10">▶</button>
          </div>
          <div class="flex justify-center gap-2 mt-8">
            <button v-for="(_, idx) in Math.ceil(fullPassStayTickets.length / 3)" :key="idx"
                    @click="fullPassStayCurrentIndex = idx"
                    class="w-2 h-2 rounded-full transition-all"
                    :class="fullPassStayCurrentIndex === idx ? 'w-6 bg-gold-500' : 'bg-white/30'">
            </button>
          </div>
        </template>
      </div>
    </section>

    <!-- ═══════════════════════════════════════════════
         SECTION 3 : SHAPE YOUR EXPERIENCE
    ══════════════════════════════════════════════════ -->
    <section class="py-20 border-t border-gold-500/10">
      <div class="container mx-auto px-6">
        <div class="text-center mb-12">
          <div class="section-label mb-3">— 03</div>
          <h2 class="section-title">Shape Your <span class="gradient-text-gold">Experience</span></h2>
        </div>

        <div class="max-w-2xl mx-auto text-center mb-12">
          <p class="text-white/60">
            ✨ <span class="text-gold-400">Vous ne nous rejoignez que pour quelques jours ?</span><br/>
            Des options sont également prévues pour vous.<br/>
            <strong>N'hésitez pas à personnaliser votre expérience de séjour en fonction de votre budget.</strong>
          </p>
        </div>

        <!-- Chargement -->
        <div v-if="ticketsLoading" class="text-center py-16 text-white/40">Chargement...</div>

        <!-- Coming Soon -->
        <div v-else-if="shapeExperienceTickets.length === 0" class="coming-soon-block">
          <div class="coming-soon-icon">🏝️</div>
          <div class="coming-soon-title gradient-text-gold">Coming Soon</div>
          <p class="coming-soon-sub">Les options Shape Your Experience seront bientôt disponibles.</p>
        </div>

        <!-- Grille de tickets -->
        <div v-else class="flex flex-col md:flex-row justify-center gap-8 max-w-4xl mx-auto">
          <div v-for="ticket in shapeExperienceTickets" :key="ticket.slug" class="flex-1">
            <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden hover:border-gold-500/40 transition-all duration-300 hover:-translate-y-1"
                 :class="{ 'opacity-50': !ticket.is_available }">
              <div class="h-40 overflow-hidden relative bg-gradient-to-br from-gold-900/30 to-black flex items-center justify-center">
                <img v-if="ticket.image_url" :src="ticket.image_url" :alt="ticket.name" class="w-full h-full object-cover object-left" />
                <span v-else class="text-5xl text-gold-400 absolute">🏝️</span>
                <div v-if="ticket.is_early_bird" class="absolute top-3 left-3 bg-gold-500 text-black text-xs font-black px-2 py-1 rounded uppercase tracking-wide">
                  🐦 Early Bird
                </div>
                <div v-if="!ticket.is_available" class="absolute inset-0 bg-black/60 flex items-center justify-center">
                  <span class="text-red-400 font-bold uppercase text-sm">Épuisé</span>
                </div>
              </div>
              <div class="p-5">
                <h3 class="font-black text-xl uppercase">{{ ticket.name }}</h3>
                <div class="mt-2 flex items-baseline gap-2 flex-wrap">
                  <span class="text-2xl font-bold text-gold-400">{{ (ticket.effective_price ?? ticket.price).toLocaleString() }} {{ ticket.currency }}</span>
                  <span v-if="ticket.is_early_bird" class="text-sm text-white/30 line-through">{{ ticket.price.toLocaleString() }}</span>
                </div>
                <div class="text-white/30 text-xs mt-1">{{ ticket.available_stock }} place(s) restante(s)</div>
                <div class="mt-4 space-y-2">
                  <div v-for="item in (ticket.includes ?? [])" :key="item" class="flex items-center gap-2 text-white/60 text-sm">
                    <span class="w-4 h-4 rounded-full bg-gold-500/20 flex items-center justify-center text-gold-400 text-xs">✓</span>
                    {{ item }}
                  </div>
                </div>
                <button
                  @click="selectTicket(ticket)"
                  :disabled="!ticket.is_available"
                  class="mt-5 w-full py-3 rounded-xl font-extrabold uppercase tracking-wider text-sm transition-all duration-300 disabled:opacity-40 disabled:cursor-not-allowed"
                  :class="addedSlug === ticket.slug ? 'bg-green-500 text-white' : 'bg-gold-500 hover:bg-gold-400 text-black'">
                  {{ addedSlug === ticket.slug ? '✓ Ajouté !' : 'Sélectionner' }}
                </button>
              </div>
            </div>
          </div>
        </div>
        <p class="text-center text-white/30 text-sm mt-8">⚠️ Réservation avant le 15 juin · 2 personnes max</p>
      </div>
    </section>

    <!-- FOOTER -->
    <section class="py-20 border-t border-gold-500/10 text-center">
      <div class="container mx-auto px-6">
        <h2 class="text-4xl md:text-6xl font-black uppercase mb-8" style="font-family:'Bebas Neue',sans-serif;">
          Réservez <span class="gradient-text-gold">maintenant</span>
        </h2>
        <button
          @click="goToCheckout"
          :disabled="cartStore.isEmpty"
          class="bg-gold-500 hover:bg-gold-400 text-black font-extrabold uppercase tracking-widest px-12 py-5 rounded-full transition-all shadow-xl shadow-gold-500/30 hover:-translate-y-1 disabled:opacity-40 disabled:cursor-not-allowed">
          {{ cartStore.isEmpty ? 'Sélectionnez un billet' : `Commander (${cartStore.itemCount} billet${cartStore.itemCount > 1 ? 's' : ''})` }}
        </button>
        <p class="text-white/20 text-xs mt-6">Powered by Matsuri Corp</p>
      </div>
    </section>

  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useCartStore } from '~/stores/cart'

const { getTickets } = useApi()
const cartStore = useCartStore()
const router = useRouter()

const { data: ticketsData, pending: ticketsLoading } = useAsyncData(
  'shop-tickets',
  () => getTickets(),
)

const SECTION_CATEGORIES = {
  fullPassStay:      'Full Pass & Stay',
  shapeExperience:   'Shape Your Experience',
}

const eventPasses = computed(() =>
  (ticketsData.value ?? []).filter((t) =>
    t.category !== SECTION_CATEGORIES.fullPassStay &&
    t.category !== SECTION_CATEGORIES.shapeExperience
  )
)

const fullPassStayTickets = computed(() =>
  (ticketsData.value ?? []).filter((t) => t.category === SECTION_CATEGORIES.fullPassStay)
)

const shapeExperienceTickets = computed(() =>
  (ticketsData.value ?? []).filter((t) => t.category === SECTION_CATEGORIES.shapeExperience)
)

const eventPassCurrentIndex = ref(0)
const prevEventPass = () => { if (eventPassCurrentIndex.value > 0) eventPassCurrentIndex.value-- }
const nextEventPass = () => {
  if (eventPassCurrentIndex.value < Math.ceil(eventPasses.value.length / 3) - 1)
    eventPassCurrentIndex.value++
}

const fullPassStayCurrentIndex = ref(0)
const prevFullPassStay = () => { if (fullPassStayCurrentIndex.value > 0) fullPassStayCurrentIndex.value-- }
const nextFullPassStay = () => {
  if (fullPassStayCurrentIndex.value < Math.ceil(fullPassStayTickets.value.length / 3) - 1)
    fullPassStayCurrentIndex.value++
}

const addedSlug = ref(null)

function selectTicket(ticket) {
  if (!ticket.is_available) return
  cartStore.addItem(ticket, 1)
  addedSlug.value = ticket.slug
  setTimeout(() => { addedSlug.value = null }, 1500)
}


function goToCheckout() {
  router.push('/checkout')
}
</script>

<style scoped>
.section-title {
  font-family: 'Bebas Neue', sans-serif;
  font-size: clamp(2rem, 5vw, 4rem);
  line-height: 1;
  text-transform: uppercase;
  letter-spacing: 0.02em;
}
.section-label {
  color: #C9A84C;
  font-size: 0.7rem;
  letter-spacing: 0.4em;
  text-transform: uppercase;
  font-weight: 800;
}
.gradient-text-gold {
  background: linear-gradient(135deg, #C9A84C 0%, #F5D78A 40%, #C9A84C 70%, #8B6914 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}
.shop-hero-bg {
  background: radial-gradient(ellipse 70% 60% at 20% 60%, rgba(201,168,76,0.13) 0%, transparent 70%),
              radial-gradient(ellipse 50% 40% at 80% 30%, rgba(139,105,20,0.08) 0%, transparent 70%),
              #000;
}
.noise-overlay {
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='1'/%3E%3C/svg%3E");
  opacity: 0.03;
  pointer-events: none;
}
.text-gold-400 { color: #F5D78A; }
.bg-gold-500 { background-color: #C9A84C; }
.hover\:bg-gold-400:hover { background-color: #F5D78A; }
.border-gold-500 { border-color: #C9A84C; }
.shadow-gold-500\/30 { box-shadow: 0 10px 40px rgba(201,168,76,0.3); }

.coming-soon-block {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 5rem 1rem;
  border: 1px dashed rgba(201,168,76,0.25);
  border-radius: 1.5rem;
  background: radial-gradient(ellipse 60% 50% at 50% 50%, rgba(201,168,76,0.04) 0%, transparent 80%);
}
.coming-soon-icon {
  font-size: 3rem;
  margin-bottom: 1rem;
  opacity: 0.4;
}
.coming-soon-title {
  font-family: 'Bebas Neue', sans-serif;
  font-size: clamp(2rem, 5vw, 3.5rem);
  letter-spacing: 0.15em;
  text-transform: uppercase;
  line-height: 1;
}
.coming-soon-sub {
  margin-top: 0.75rem;
  color: rgba(255,255,255,0.3);
  font-size: 0.85rem;
  text-align: center;
}
</style>