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

        <div class="relative">
          <div class="overflow-hidden">
            <div class="flex transition-transform duration-500 ease-out"
                 :style="{ transform: `translateX(-${eventPassCurrentIndex * 33.333}%)` }">
              <div v-for="pass in eventPasses" :key="pass.name"
                   class="w-full sm:w-1/2 lg:w-1/3 flex-shrink-0 px-3">
                <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden hover:border-gold-500/40 transition-all duration-300 hover:-translate-y-1 h-full flex flex-col">
                  <div class="h-48 overflow-hidden relative bg-gradient-to-br from-gold-900/30 to-black flex items-center justify-center">
                    <img :src="`/images/Event-pass.jpeg`" :alt="pass.name" class="w-full h-full object-cover" @error="e => e.target.style.display = 'none'"/>
                    <span class="text-6xl text-gold-400 absolute" v-if="!pass.imageLoaded">🎟️</span>
                    <div class="absolute top-3 right-3 bg-black/60 px-2 py-1 rounded text-gold-400 text-xs">PASS</div>
                  </div>
                  <div class="p-5 flex-1 flex flex-col">
                    <h3 class="font-black text-xl uppercase">{{ pass.name }}</h3>
                    <div class="mt-2">
                      <span class="text-2xl font-bold text-gold-400">{{ pass.priceXOF.toLocaleString() }} XOF</span>
                      <span class="text-white/40 text-sm ml-2">({{ pass.priceEUR }} €)</span>
                    </div>
                    <div class="mt-4 space-y-2 flex-1">
                      <div v-for="feature in pass.features.slice(0,3)" :key="feature" class="flex items-center gap-2 text-white/60 text-sm">
                        <span class="w-4 h-4 rounded-full bg-gold-500/20 flex items-center justify-center text-gold-400 text-xs">✓</span>
                        {{ feature }}
                      </div>
                    </div>
                    <button class="mt-5 w-full py-3 rounded-xl bg-gold-500 hover:bg-gold-400 text-black font-extrabold uppercase tracking-wider text-sm transition-all duration-300">
                      Sélectionner
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

        <div class="relative">
          <div class="overflow-hidden">
            <div class="flex transition-transform duration-500 ease-out"
                 :style="{ transform: `translateX(-${fullPassStayCurrentIndex * 33.333}%)` }">
              <div v-for="option in fullPassStayOptions" :key="option.name"
                   class="w-full sm:w-1/2 lg:w-1/3 flex-shrink-0 px-3">
                <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden hover:border-gold-500/40 transition-all duration-300 hover:-translate-y-1 h-full flex flex-col">
                  <div class="h-48 overflow-hidden relative bg-gradient-to-br from-gold-900/30 to-black flex items-center justify-center">
                    <img :src="`/images/Full-Pass-&-Stay.jpeg`" class="w-full h-full object-cover" @error="e => e.target.style.display = 'none'"/>
                    <span class="text-6xl text-gold-400 absolute">🏨</span>
                    <div class="absolute top-3 left-3 bg-black/60 px-2 py-1 rounded text-gold-400 text-xs uppercase">{{ option.type }}</div>
                  </div>
                  <div class="p-5 flex-1 flex flex-col">
                    <h3 class="font-black text-xl uppercase">{{ option.name }}</h3>
                    <div class="mt-2">
                      <span class="text-2xl font-bold text-gold-400">{{ option.priceXOF.toLocaleString() }} XOF</span>
                      <span class="text-white/40 text-sm ml-2">({{ option.priceEUR }} €)</span>
                    </div>
                    <div class="text-white/30 text-xs">{{ option.maxPersons }} personnes max</div>
                    <div class="mt-4 space-y-2 flex-1">
                      <div v-for="feature in option.features.slice(0,3)" :key="feature" class="flex items-center gap-2 text-white/60 text-sm">
                        <span class="w-4 h-4 rounded-full bg-gold-500/20 flex items-center justify-center text-gold-400 text-xs">✓</span>
                        {{ feature }}
                      </div>
                    </div>
                    <button class="mt-5 w-full py-3 rounded-xl bg-gold-500 hover:bg-gold-400 text-black font-extrabold uppercase tracking-wider text-sm transition-all duration-300">
                      Choisir
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
          <button v-for="(_, idx) in Math.ceil(fullPassStayOptions.length / 3)" :key="idx"
                  @click="fullPassStayCurrentIndex = idx"
                  class="w-2 h-2 rounded-full transition-all"
                  :class="fullPassStayCurrentIndex === idx ? 'w-6 bg-gold-500' : 'bg-white/30'">
          </button>
        </div>
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

        <div class="flex flex-col md:flex-row justify-center gap-8 max-w-4xl mx-auto">
          <div v-for="option in shapeExperienceOptions" :key="option.name" class="flex-1">
            <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden hover:border-gold-500/40 transition-all duration-300 hover:-translate-y-1">
              <div class="h-40 overflow-hidden relative bg-gradient-to-br from-gold-900/30 to-black flex items-center justify-center">
                <img :src="`/images/Shape-your-experience.jpeg`" class="w-full h-full object-cover" @error="e => e.target.style.display = 'none'"/>
                <span class="text-5xl text-gold-400 absolute">🏝️</span>
              </div>
              <div class="p-5">
                <h3 class="font-black text-xl uppercase">{{ option.name }}</h3>
                <div class="mt-2">
                  <span class="text-2xl font-bold text-gold-400">{{ option.pricePerDayXOF.toLocaleString() }} XOF</span>
                  <span class="text-white/40 text-sm">/ jour ({{ option.pricePerDayEUR }} €)</span>
                </div>
                <div class="text-white/30 text-xs">{{ option.maxPersons }} personnes max</div>
                <div class="mt-4 space-y-2">
                  <div v-for="feature in option.features" :key="feature" class="flex items-center gap-2 text-white/60 text-sm">
                    <span class="w-4 h-4 rounded-full bg-gold-500/20 flex items-center justify-center text-gold-400 text-xs">✓</span>
                    {{ feature }}
                  </div>
                </div>
                <button class="mt-5 w-full py-3 rounded-xl bg-gold-500 hover:bg-gold-400 text-black font-extrabold uppercase tracking-wider text-sm transition-all duration-300">
                  Personnaliser
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
        <button class="bg-gold-500 hover:bg-gold-400 text-black font-extrabold uppercase tracking-widest px-12 py-5 rounded-full transition-all shadow-xl shadow-gold-500/30 hover:-translate-y-1">
          Acheter mes billets
        </button>
        <p class="text-white/20 text-xs mt-6">Powered by Matsuri Corp</p>
      </div>
    </section>

  </div>
</template>

<script setup>
import { ref } from 'vue'

// =====================================================
// EVENT PASS
// =====================================================
const eventPasses = ref([
  { name: 'Full Pass', priceXOF: 120000, priceEUR: 183, features: ['Toutes les soirées & socials', 'Tous les workshops & Masterclasses', 'Tourisme', 'T-shirt UKWC'] },
  { name: 'Parties & Classes', priceXOF: 70000, priceEUR: 106, features: ['Toutes les soirées & socials', 'Tous les workshops & Masterclasses'] },
  { name: 'Parties Only', priceXOF: 45000, priceEUR: 68, features: ['Toutes les soirées & socials'] },
  { name: 'Tourism', priceXOF: 55000, priceEUR: 84, features: ['Tourisme'] },
  { name: 'Classes Only', priceXOF: 30000, priceEUR: 46, features: ['Tous les workshops & Masterclasses'] }
])

const eventPassCurrentIndex = ref(0)
const prevEventPass = () => { if (eventPassCurrentIndex.value > 0) eventPassCurrentIndex.value-- }
const nextEventPass = () => { if (eventPassCurrentIndex.value < Math.ceil(eventPasses.value.length / 3) - 1) eventPassCurrentIndex.value++ }

// =====================================================
// FULL PASS & STAY
// =====================================================
const fullPassStayOptions = ref([
  { name: 'Single Standard', type: 'single', priceXOF: 355000, priceEUR: 541, features: ['1 Full pass', '1 appt chambre + salon standard', '1 petit dej / jour'], maxPersons: 2 },
  { name: 'Single Premium', type: 'single', priceXOF: 390000, priceEUR: 594, features: ['1 Full pass', '1 appt chambre + salon premium', '1 petit dej / jour', 'Pack d’accueil', '1 t-shirt'], maxPersons: 2 },
  { name: 'Single Luxury', type: 'single', priceXOF: 415000, priceEUR: 632, features: ['1 Full pass', '1 appt chambre + salon luxe', '1 petit dej / jour', 'Pack d’accueil', '1 t-shirt', 'Assistance'], maxPersons: 2 },
  { name: 'Double Standard', type: 'couple', priceXOF: 515000, priceEUR: 785, features: ['2 Full pass', '1 appt chambre + salon standard', '2 petit dej / jour'], maxPersons: 2 },
  { name: 'Double Premium', type: 'couple', priceXOF: 610000, priceEUR: 929, features: ['2 Full pass', 'Appartement 2 chambres + salon premium', '2 petit dej / jour', 'Pack d’accueil', '2 t-shirts'], maxPersons: 4 },
  { name: 'Double Luxury', type: 'couple', priceXOF: 655000, priceEUR: 998, features: ['2 Full pass', 'Appartement 2 chambres + salon luxe', '2 petit dej / jour', 'Pack d’accueil', '2 t-shirts', 'Assistance'], maxPersons: 4 }
])

const fullPassStayCurrentIndex = ref(0)
const prevFullPassStay = () => { if (fullPassStayCurrentIndex.value > 0) fullPassStayCurrentIndex.value-- }
const nextFullPassStay = () => { if (fullPassStayCurrentIndex.value < Math.ceil(fullPassStayOptions.value.length / 3) - 1) fullPassStayCurrentIndex.value++ }

// =====================================================
// SHAPE YOUR EXPERIENCE
// =====================================================
const shapeExperienceOptions = ref([
  { name: 'Standard', pricePerDayXOF: 30000, pricePerDayEUR: 46, features: ['1 chambre d’hôtel standard', '1 petit déjeuner / jour', 'Assistance standard'], maxPersons: 2 },
  { name: 'Premium', pricePerDayXOF: 35000, pricePerDayEUR: 53, features: ['1 chambre d’hôtel premium', '1 petit déjeuner / jour', 'Assistance standard'], maxPersons: 2 }
])
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
</style>