<template>
    <div class="bg-black text-white overflow-x-hidden" style="font-family: 'Nunito', sans-serif;">

        <!-- SHOP HERO -->
        <section class="relative min-h-[50vh] flex items-center overflow-hidden">
            <div class="absolute inset-0 z-0">
                <div class="shop-hero-bg absolute inset-0" />
                <svg class="absolute inset-0 w-full h-full opacity-10" viewBox="0 0 1440 900"
                    preserveAspectRatio="xMidYMid slice" fill="none">
                    <line x1="-100" y1="900" x2="1200" y2="-50" stroke="#C9A84C" stroke-width="1" />
                    <line x1="100" y1="900" x2="1400" y2="-50" stroke="#C9A84C" stroke-width="0.5" />
                    <circle cx="720" cy="450" r="380" stroke="#C9A84C" stroke-width="0.5" />
                </svg>
                <div class="noise-overlay absolute inset-0" />
            </div>
            <div class="relative z-10 container mx-auto px-6 pt-32 pb-20 text-center">
                <p class="text-gold-400 text-xs tracking-[0.5em] uppercase mb-4">BILLETTERIE OFFICIELLE</p>
                <h1 style="font-family:'Bebas Neue',sans-serif;">
                    <span class="block text-[clamp(3rem,8vw,6rem)] leading-none tracking-tight">United Kizdom</span>
                    <span class="block text-[clamp(2.5rem,6vw,5rem)] leading-none gradient-text-gold">World Congress
                        2026</span>
                </h1>
                <p class="text-white/50 mt-6">Bénin, Afrique · 14 – 19 Juillet 2026</p>
            </div>
        </section>

        <!-- Loading State -->
        <div v-if="loading" class="text-center py-20">
            <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-gold-500 mx-auto"></div>
            <p class="text-white/60 mt-6">Chargement des offres...</p>
        </div>

        <div v-else>

            <!-- ═══════════════════════════════════════════════
           SECTION 1 : EVENT PASS (TOUS LES ÉVÉNEMENTS)
      ══════════════════════════════════════════════════ -->
            <section v-if="eventPassEvents.length > 0" class="py-20 border-t border-gold-500/10">
                <div class="container mx-auto px-6">
                    <div class="text-center mb-12">
                        <div class="section-label mb-3">— 01</div>
                        <h2 class="section-title">Event <span class="gradient-text-gold">Pass</span></h2>
                        <p class="text-white/40 mt-2">Choisissez le pass qui correspond à votre expérience</p>
                    </div>

                    <div class="relative">
                        <div class="overflow-hidden">
                            <div class="flex transition-transform duration-500 ease-out"
                                :style="eventPassEvents.length > 3 ? { transform: `translateX(-${eventPassCurrentIndex * 100}%)` } : { justifyContent: 'center' }">
                                <div v-for="event in eventPassEvents" :key="event.id"
                                    class="w-full sm:w-1/2 lg:w-1/3 flex-shrink-0 px-3">
                                    <div
                                        class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden hover:border-gold-500/40 transition-all duration-300 hover:-translate-y-1 h-full flex flex-col">
                                        <div
                                            class="h-48 overflow-hidden relative bg-gradient-to-br from-gold-900/30 to-black flex items-center justify-center">
                                            <span class="text-6xl text-gold-400 absolute">🎟️</span>
                                            <div
                                                class="absolute top-3 right-3 bg-black/60 px-2 py-1 rounded text-gold-400 text-xs">
                                                PASS</div>
                                        </div>
                                        <div class="p-5 flex-1 flex flex-col">
                                            <h3 class="font-black text-xl uppercase">{{ event.title }}</h3>
                                            <div class="mt-2">
                                                <span class="text-2xl font-bold text-gold-400">{{
                                                    formatEuro(event.price) }} €</span>
                                                <span class="text-white/40 text-sm ml-2">({{ formatPrice(event.price) }}
                                                    XOF)</span>
                                            </div>
                                            <div class="mt-4 space-y-2 flex-1">
                                                <div v-for="feature in getAllEventFeatures(event)" :key="feature"
                                                    class="flex items-start gap-2 text-white/60 text-sm">
                                                    <span
                                                        class="w-4 h-4 rounded-full bg-gold-500/20 flex items-center justify-center text-gold-400 text-xs mt-0.5 flex-shrink-0">✓</span>
                                                    <span>{{ feature }}</span>
                                                </div>
                                            </div>
                                            <NuxtLink :to="`/checkout?event_id=${event.id}`"
                                                class="mt-5 w-full py-3 rounded-xl bg-gold-500 hover:bg-gold-400 text-black font-extrabold uppercase tracking-wider text-sm transition-all duration-300 text-center block">
                                                Sélectionner
                                            </NuxtLink>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button v-if="eventPassEvents.length > 3" @click="prevEventPass"
                            class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 w-10 h-10 rounded-full bg-black/80 border border-gold-500/40 text-gold-400 hover:bg-gold-500 hover:text-black transition-all flex items-center justify-center z-10">◀</button>
                        <button v-if="eventPassEvents.length > 3" @click="nextEventPass"
                            class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 w-10 h-10 rounded-full bg-black/80 border border-gold-500/40 text-gold-400 hover:bg-gold-500 hover:text-black transition-all flex items-center justify-center z-10">▶</button>
                    </div>
                    <div v-if="eventPassEvents.length > 3" class="flex justify-center gap-2 mt-8">
                        <button v-for="(_, idx) in Math.ceil(eventPassEvents.length / 3)" :key="idx"
                            @click="eventPassCurrentIndex = idx" class="w-2 h-2 rounded-full transition-all"
                            :class="eventPassCurrentIndex === idx ? 'w-6 bg-gold-500' : 'bg-white/30'">
                        </button>
                    </div>
                </div>
            </section>

            <!-- ═══════════════════════════════════════════════
           SECTION 2 : FULL PASS & STAY
      ══════════════════════════════════════════════════ -->
            <section v-if="singleEvents.length > 0 || doubleEvents.length > 0"
                class="py-20 border-t border-gold-500/10 bg-gradient-to-b from-transparent via-gold-900/5 to-transparent">
                <div class="container mx-auto px-6">
                    <div class="text-center mb-12">
                        <div class="section-label mb-3">— 02</div>
                        <h2 class="section-title">Full Pass <span class="gradient-text-gold">& Hébergement</span></h2>
                        <p class="text-white/40 text-sm mt-2">⚠️ Réservation avant le 15 juin · 7 nuits</p>
                    </div>

                    <!-- Single Options -->
                    <div v-if="singleEvents.length > 0" class="mb-16">
                        <h3 class="text-2xl font-bold text-gold-400 mb-6 text-center uppercase tracking-wider"
                            style="font-family:'Bebas Neue',sans-serif;">👤 Single</h3>
                        <div class="relative">
                            <div class="overflow-hidden">
                                <div class="flex transition-transform duration-500 ease-out"
                                    :style="singleEvents.length > 3 ? { transform: `translateX(-${singleCurrentIndex * 33.333}%)` } : {}">
                                    <div v-for="event in singleEvents" :key="event.id"
                                        class="w-full sm:w-1/2 lg:w-1/3 flex-shrink-0 px-3">
                                        <div
                                            class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden hover:border-gold-500/40 transition-all duration-300 hover:-translate-y-1 h-full flex flex-col">
                                            <div
                                                class="h-48 overflow-hidden relative bg-gradient-to-br from-gold-900/30 to-black flex items-center justify-center">
                                                <span class="text-6xl text-gold-400 absolute">🏨</span>
                                                <div
                                                    class="absolute top-3 left-3 bg-black/60 px-2 py-1 rounded text-gold-400 text-xs uppercase">
                                                    Single</div>
                                            </div>
                                            <div class="p-5 flex-1 flex flex-col">
                                                <h3 class="font-black text-xl uppercase">{{ event.title }}</h3>
                                                <div class="mt-2">
                                                    <span class="text-2xl font-bold text-gold-400">{{
                                                        formatEuro(event.price) }} €</span>
                                                    <span class="text-white/40 text-sm ml-2">({{
                                                        formatPrice(event.price) }} XOF)</span>
                                                </div>
                                                <div class="text-white/30 text-xs">2 personnes max</div>
                                                <div class="mt-4 space-y-2 flex-1">
                                                    <div v-for="feature in getAllEventFeatures(event)" :key="feature"
                                                        class="flex items-start gap-2 text-white/60 text-sm">
                                                        <span
                                                            class="w-4 h-4 rounded-full bg-gold-500/20 flex items-center justify-center text-gold-400 text-xs mt-0.5 flex-shrink-0">✓</span>
                                                        <span>{{ feature }}</span>
                                                    </div>
                                                </div>
                                                <NuxtLink :to="`/checkout?event_id=${event.id}`"
                                                    class="mt-5 w-full py-3 rounded-xl bg-gold-500 hover:bg-gold-400 text-black font-extrabold uppercase tracking-wider text-sm transition-all duration-300 text-center block">
                                                    Choisir
                                                </NuxtLink>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button v-if="singleEvents.length > 3" @click="prevSingle"
                                class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 w-10 h-10 rounded-full bg-black/80 border border-gold-500/40 text-gold-400 hover:bg-gold-500 hover:text-black transition-all flex items-center justify-center z-10">◀</button>
                            <button v-if="singleEvents.length > 3" @click="nextSingle"
                                class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 w-10 h-10 rounded-full bg-black/80 border border-gold-500/40 text-gold-400 hover:bg-gold-500 hover:text-black transition-all flex items-center justify-center z-10">▶</button>
                        </div>
                        <div v-if="singleEvents.length > 3" class="flex justify-center gap-2 mt-8">
                            <button v-for="(_, idx) in Math.ceil(singleEvents.length / 3)" :key="idx"
                                @click="singleCurrentIndex = idx" class="w-2 h-2 rounded-full transition-all"
                                :class="singleCurrentIndex === idx ? 'w-6 bg-gold-500' : 'bg-white/30'">
                            </button>
                        </div>
                    </div>

                    <!-- Double Options -->
                    <div v-if="doubleEvents.length > 0">
                        <h3 class="text-2xl font-bold text-gold-400 mb-6 text-center uppercase tracking-wider"
                            style="font-family:'Bebas Neue',sans-serif;">👥 Double</h3>
                        <div class="relative">
                            <div class="overflow-hidden">
                                <div class="flex transition-transform duration-500 ease-out"
                                    :style="doubleEvents.length > 3 ? { transform: `translateX(-${doubleCurrentIndex * 33.333}%)` } : {}">
                                    <div v-for="event in doubleEvents" :key="event.id"
                                        class="w-full sm:w-1/2 lg:w-1/3 flex-shrink-0 px-3">
                                        <div
                                            class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden hover:border-gold-500/40 transition-all duration-300 hover:-translate-y-1 h-full flex flex-col">
                                            <div
                                                class="h-48 overflow-hidden relative bg-gradient-to-br from-gold-900/30 to-black flex items-center justify-center">
                                                <span class="text-6xl text-gold-400 absolute">🏨</span>
                                                <div
                                                    class="absolute top-3 left-3 bg-black/60 px-2 py-1 rounded text-gold-400 text-xs uppercase">
                                                    Double</div>
                                            </div>
                                            <div class="p-5 flex-1 flex flex-col">
                                                <h3 class="font-black text-xl uppercase">{{ event.title }}</h3>
                                                <div class="mt-2">
                                                    <span class="text-2xl font-bold text-gold-400">{{
                                                        formatEuro(event.price) }} €</span>
                                                    <span class="text-white/40 text-sm ml-2">({{
                                                        formatPrice(event.price) }} XOF)</span>
                                                </div>
                                                <div class="text-white/30 text-xs">4 personnes max</div>
                                                <div class="mt-4 space-y-2 flex-1">
                                                    <div v-for="feature in getAllEventFeatures(event)" :key="feature"
                                                        class="flex items-start gap-2 text-white/60 text-sm">
                                                        <span
                                                            class="w-4 h-4 rounded-full bg-gold-500/20 flex items-center justify-center text-gold-400 text-xs mt-0.5 flex-shrink-0">✓</span>
                                                        <span>{{ feature }}</span>
                                                    </div>
                                                </div>
                                                <NuxtLink :to="`/checkout?event_id=${event.id}`"
                                                    class="mt-5 w-full py-3 rounded-xl bg-gold-500 hover:bg-gold-400 text-black font-extrabold uppercase tracking-wider text-sm transition-all duration-300 text-center block">
                                                    Choisir
                                                </NuxtLink>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button v-if="doubleEvents.length > 3" @click="prevDouble"
                                class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 w-10 h-10 rounded-full bg-black/80 border border-gold-500/40 text-gold-400 hover:bg-gold-500 hover:text-black transition-all flex items-center justify-center z-10">◀</button>
                            <button v-if="doubleEvents.length > 3" @click="nextDouble"
                                class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 w-10 h-10 rounded-full bg-black/80 border border-gold-500/40 text-gold-400 hover:bg-gold-500 hover:text-black transition-all flex items-center justify-center z-10">▶</button>
                        </div>
                        <div v-if="doubleEvents.length > 3" class="flex justify-center gap-2 mt-8">
                            <button v-for="(_, idx) in Math.ceil(doubleEvents.length / 3)" :key="idx"
                                @click="doubleCurrentIndex = idx" class="w-2 h-2 rounded-full transition-all"
                                :class="doubleCurrentIndex === idx ? 'w-6 bg-gold-500' : 'bg-white/30'">
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ═══════════════════════════════════════════════
           SECTION 3 : SHAPE YOUR EXPERIENCE
      ══════════════════════════════════════════════════ -->
            <section v-if="shapeExperienceEvents.length > 0" class="py-20 border-t border-gold-500/10">
                <div class="container mx-auto px-6">
                    <div class="text-center mb-12">
                        <div class="section-label mb-3">— 03</div>
                        <h2 class="section-title">Shape Your <span class="gradient-text-gold">Experience</span></h2>
                    </div>

                    <div class="max-w-2xl mx-auto text-center mb-12">
                        <p class="text-white/60">
                            ✨ <span class="text-gold-400">Vous ne nous rejoignez que pour quelques jours ?</span><br />
                            Des options sont également prévues pour vous.<br />
                            <strong>N'hésitez pas à personnaliser votre expérience de séjour en fonction de votre
                                budget.</strong>
                        </p>
                    </div>

                    <div class="flex flex-col md:flex-row justify-center gap-8 max-w-4xl mx-auto">
                        <div v-for="event in shapeExperienceEvents" :key="event.id" class="flex-1">
                            <div
                                class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden hover:border-gold-500/40 transition-all duration-300 hover:-translate-y-1">
                                <div
                                    class="h-40 overflow-hidden relative bg-gradient-to-br from-gold-900/30 to-black flex items-center justify-center">
                                    <span class="text-5xl text-gold-400 absolute">🏝️</span>
                                </div>
                                <div class="p-5">
                                    <h3 class="font-black text-xl uppercase">{{ event.title }}</h3>
                                    <div class="mt-2">
                                        <span class="text-2xl font-bold text-gold-400">{{ formatEuro(event.price) }}
                                            €</span>
                                        <span class="text-white/40 text-sm">/ jour ({{ formatPrice(event.price) }}
                                            XOF)</span>
                                    </div>
                                    <div class="text-white/30 text-xs">2 personnes max</div>
                                    <div class="mt-4 space-y-2">
                                        <div v-for="feature in getAllEventFeatures(event)" :key="feature"
                                            class="flex items-start gap-2 text-white/60 text-sm">
                                            <span
                                                class="w-4 h-4 rounded-full bg-gold-500/20 flex items-center justify-center text-gold-400 text-xs mt-0.5 flex-shrink-0">✓</span>
                                            <span>{{ feature }}</span>
                                        </div>
                                    </div>
                                    <NuxtLink :to="`/checkout?event_id=${event.id}`"
                                        class="mt-5 w-full py-3 rounded-xl bg-gold-500 hover:bg-gold-400 text-black font-extrabold uppercase tracking-wider text-sm transition-all duration-300 text-center block">
                                        Personnaliser
                                    </NuxtLink>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="text-center text-white/30 text-sm mt-8">⚠️ Réservation avant le 15 juin · 2 personnes max
                    </p>
                </div>
            </section>

        </div>

        <!-- FOOTER -->
        <section class="py-20 border-t border-gold-500/10 text-center">
            <div class="container mx-auto px-6">
                <h2 class="text-4xl md:text-6xl font-black uppercase mb-8" style="font-family:'Bebas Neue',sans-serif;">
                    Réservez <span class="gradient-text-gold">maintenant</span>
                </h2>
                <NuxtLink to="/"
                    class="inline-block bg-gold-500 hover:bg-gold-400 text-black font-extrabold uppercase tracking-widest px-12 py-5 rounded-full transition-all shadow-xl shadow-gold-500/30 hover:-translate-y-1">
                    Retour à l'accueil
                </NuxtLink>
            </div>
        </section>

    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useEventStore } from '~/stores/event'

const eventStore = useEventStore()
const loading = ref(true)

// État pour les sliders
const eventPassCurrentIndex = ref(0)
const singleCurrentIndex = ref(0)
const doubleCurrentIndex = ref(0)

// Données des événements par catégorie
const eventPassEvents = ref([])
const singleEvents = ref([])
const doubleEvents = ref([])
const shapeExperienceEvents = ref([])

// Récupération des événements et filtrage par catégorie
const fetchAndOrganizeEvents = async () => {
    loading.value = true

    try {
        // Récupérer tous les événements
        await eventStore.fetchEvents({ per_page: 100 })
        const allEvents = eventStore.events

        // Event Pass : TOUS les 5 événements (Full Pass, Parties & Classes, Parties Only, Tourism, Classes Only)
        eventPassEvents.value = allEvents
            .filter(event => {
                const titles = ['Full Pass', 'Parties & Classes', 'Parties Only', 'Tourism', 'Classes Only']
                return titles.includes(event.title)
            })
            .sort((a, b) => b.price - a.price) // Tri décroissant (du plus cher au moins cher)

        // Single : Standard, Premium, Luxury (ceux sans le suffixe "-2")
        singleEvents.value = allEvents
            .filter(event => {
                const singleTitles = ['Standard', 'Premium', 'Luxury']
                return singleTitles.includes(event.title) && !event.slug.includes('-2')
            })
            .sort((a, b) => b.price - a.price)

        // Double : Standard, Premium, Luxury (avec suffixe "-2" dans le slug)
        doubleEvents.value = allEvents
            .filter(event => {
                const doubleSlugs = ['standard-2', 'premium-2', 'luxury-2']
                return doubleSlugs.includes(event.slug)
            })
            .sort((a, b) => b.price - a.price)

        // Shape Your Experience
        shapeExperienceEvents.value = allEvents
            .filter(event => {
                const shapeTitles = ['Standard Hotel', 'Premium Hotel']
                return shapeTitles.includes(event.title)
            })
            .sort((a, b) => b.price - a.price)

        // Log pour debug
        console.log('Event Pass trouvés:', eventPassEvents.value.length)
        console.log('Titres:', eventPassEvents.value.map(e => e.title))

    } catch (error) {
        console.error('Erreur lors du chargement des événements:', error)
    } finally {
        loading.value = false
    }
}

// Helpers
const formatPrice = (price) => {
    return new Intl.NumberFormat('fr-FR').format(parseFloat(price) || 0)
}

const formatEuro = (price) => {
    const euros = (parseFloat(price) / 655.957).toFixed(0)
    return new Intl.NumberFormat('fr-FR').format(euros)
}

// Récupérer TOUS les bullet points de la description
const getAllEventFeatures = (event) => {
    if (!event.description) return []

    try {
        const tempDiv = document.createElement('div')
        tempDiv.innerHTML = event.description

        const listItems = tempDiv.querySelectorAll('li')

        if (listItems.length > 0) {
            return Array.from(listItems).map(li => li.textContent?.trim()).filter(Boolean)
        }

        const text = tempDiv.textContent || tempDiv.innerText || ''
        const lines = text.split('\n')
            .filter(line => line.trim().startsWith('-') || line.trim().startsWith('•') || line.trim().startsWith('- '))

        if (lines.length > 0) {
            return lines.map(line => line.replace(/^[-•]\s*/, '').trim())
        }

        if (text.trim().length > 0) {
            return [text.trim()]
        }

        return []
    } catch (error) {
        console.error('Erreur parsing description:', error)
        return []
    }
}

// Navigation sliders
const prevEventPass = () => { if (eventPassCurrentIndex.value > 0) eventPassCurrentIndex.value-- }

const nextEventPass = () => {
    const totalSlides = Math.ceil(eventPassEvents.value.length / 3)
    const maxIndex = totalSlides - 1
    console.log('Current index:', eventPassCurrentIndex.value)
    console.log('Total slides:', totalSlides)
    console.log('Max index:', maxIndex)

    if (eventPassCurrentIndex.value < maxIndex) {
        eventPassCurrentIndex.value++
        console.log('New index:', eventPassCurrentIndex.value)
    } else {
        console.log('Already at last slide')
    }
}

const prevSingle = () => { if (singleCurrentIndex.value > 0) singleCurrentIndex.value-- }
const nextSingle = () => { if (singleCurrentIndex.value < Math.ceil(singleEvents.value.length / 3) - 1) singleCurrentIndex.value++ }

const prevDouble = () => { if (doubleCurrentIndex.value > 0) doubleCurrentIndex.value-- }
const nextDouble = () => { if (doubleCurrentIndex.value < Math.ceil(doubleEvents.value.length / 3) - 1) doubleCurrentIndex.value++ }

// Initialisation
onMounted(async () => {
    await fetchAndOrganizeEvents()
})
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
    background: radial-gradient(ellipse 70% 60% at 20% 60%, rgba(201, 168, 76, 0.13) 0%, transparent 70%),
        radial-gradient(ellipse 50% 40% at 80% 30%, rgba(139, 105, 20, 0.08) 0%, transparent 70%),
        #000;
}

.noise-overlay {
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='1'/%3E%3C/svg%3E");
    opacity: 0.03;
    pointer-events: none;
}

.text-gold-400 {
    color: #F5D78A;
}

.bg-gold-500 {
    background-color: #C9A84C;
}

.hover\:bg-gold-400:hover {
    background-color: #F5D78A;
}

.border-gold-500 {
    border-color: #C9A84C;
}

.shadow-gold-500\/30 {
    box-shadow: 0 10px 40px rgba(201, 168, 76, 0.3);
}
</style>