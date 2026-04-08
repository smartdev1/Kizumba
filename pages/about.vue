<template>
  <div class="bg-black text-white overflow-x-hidden">

    <!-- Hero -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
      <!-- Animated background -->
      <div class="absolute inset-0 z-0">
        <div class="hero-bg-gradient absolute inset-0" />
        <div class="noise-overlay absolute inset-0 opacity-30" />
        <!-- Geometric decorative circles -->
        <div class="absolute top-1/4 left-1/4 w-96 h-96 rounded-full border border-gold-500/10 animate-spin-slow" />
        <div class="absolute top-1/3 left-1/3 w-64 h-64 rounded-full border border-gold-500/20 animate-spin-reverse" />
        <div class="absolute bottom-1/4 right-1/4 w-80 h-80 rounded-full border border-gold-500/10 animate-spin-slow" />
      </div>

      <!-- Generated SVG illustration - African dancers silhouette -->
      <div class="absolute right-0 top-0 h-full w-1/2 z-0 opacity-20">
        <svg viewBox="0 0 600 800" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-full w-full object-cover">
          <!-- Dancer 1 -->
          <ellipse cx="180" cy="120" rx="28" ry="28" fill="#C9A84C"/>
          <path d="M180 148 C160 180 140 220 150 270 C155 290 165 300 175 320 C160 360 145 400 140 440" stroke="#C9A84C" stroke-width="8" stroke-linecap="round" fill="none"/>
          <path d="M175 200 C145 215 120 230 100 250" stroke="#C9A84C" stroke-width="7" stroke-linecap="round" fill="none"/>
          <path d="M175 200 C200 210 220 225 240 240" stroke="#C9A84C" stroke-width="7" stroke-linecap="round" fill="none"/>
          <path d="M170 320 C150 360 135 390 130 430" stroke="#C9A84C" stroke-width="8" stroke-linecap="round" fill="none"/>
          <path d="M175 320 C185 360 190 390 185 435" stroke="#C9A84C" stroke-width="8" stroke-linecap="round" fill="none"/>
          <!-- Skirt shape -->
          <path d="M150 270 C130 310 120 340 118 380 C140 370 165 360 180 355 C195 360 215 370 240 375 C238 340 230 310 208 270 Z" fill="#C9A84C" opacity="0.3"/>

          <!-- Dancer 2 -->
          <ellipse cx="400" cy="200" rx="28" ry="28" fill="#C9A84C"/>
          <path d="M400 228 C390 260 385 295 390 340 C393 360 400 375 405 395 C395 435 385 475 380 515" stroke="#C9A84C" stroke-width="8" stroke-linecap="round" fill="none"/>
          <path d="M392 280 C365 265 340 255 318 248" stroke="#C9A84C" stroke-width="7" stroke-linecap="round" fill="none"/>
          <path d="M400 275 C425 260 450 250 475 248" stroke="#C9A84C" stroke-width="7" stroke-linecap="round" fill="none"/>
          <path d="M400 395 C390 435 382 475 380 515" stroke="#C9A84C" stroke-width="8" stroke-linecap="round" fill="none"/>
          <path d="M405 395 C415 430 425 465 428 510" stroke="#C9A84C" stroke-width="8" stroke-linecap="round" fill="none"/>
          <!-- Skirt -->
          <path d="M385 340 C368 375 358 405 355 445 C378 435 395 428 405 424 C418 430 435 440 458 448 C458 408 450 375 430 340 Z" fill="#C9A84C" opacity="0.3"/>

          <!-- Background decorative patterns -->
          <circle cx="300" cy="400" r="200" stroke="#C9A84C" stroke-width="0.5" opacity="0.2" fill="none"/>
          <circle cx="300" cy="400" r="280" stroke="#C9A84C" stroke-width="0.5" opacity="0.15" fill="none"/>

          <!-- African pattern strip -->
          <g opacity="0.15">
            <rect x="0" y="720" width="600" height="80" fill="#C9A84C"/>
            <path d="M0 720 L30 760 L60 720 L90 760 L120 720 L150 760 L180 720 L210 760 L240 720 L270 760 L300 720 L330 760 L360 720 L390 760 L420 720 L450 760 L480 720 L510 760 L540 720 L570 760 L600 720" stroke="black" stroke-width="4" fill="none"/>
          </g>
        </svg>
      </div>

      <div class="relative z-10 container mx-auto px-6 pt-32 pb-20">
        <div class="max-w-3xl">
          <div class="overline-text mb-6 animate-fade-up" style="animation-delay: 0.1s">
            <span class="text-gold-400 text-xs tracking-[0.4em] uppercase font-medium border border-gold-400/30 px-4 py-2">
              Bénin, Afrique · 14 – 19 Juillet 2026
            </span>
          </div>
          <h1 class="hero-title animate-fade-up" style="animation-delay: 0.2s">
            <span class="block text-6xl md:text-8xl font-black uppercase leading-none tracking-tighter">United</span>
            <span class="block text-6xl md:text-8xl font-black uppercase leading-none tracking-tighter gradient-text-gold">Kizdom</span>
            <span class="block text-6xl md:text-8xl font-black uppercase leading-none tracking-tighter">World</span>
            <span class="block text-5xl md:text-7xl font-black uppercase leading-none tracking-tighter text-white/40">Congress</span>
          </h1>
          <p class="mt-8 text-white/60 text-lg leading-relaxed max-w-xl animate-fade-up" style="animation-delay: 0.35s">
            Une plateforme internationale dédiée au rayonnement des danses afro, afro-latines, caribéennes
            et des expressions culturelles africaines.
          </p>
          <div class="mt-10 animate-fade-up" style="animation-delay: 0.45s">
            <div class="flex items-center gap-3">
              <div class="w-12 h-px bg-gold-400" />
              <span class="text-gold-400 text-sm tracking-widest uppercase">Découvrir l'événement</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Scroll indicator -->
      <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 opacity-50">
        <span class="text-xs tracking-widest uppercase text-white/50">Scroll</span>
        <div class="w-px h-12 bg-gradient-to-b from-gold-400 to-transparent animate-pulse" />
      </div>
    </section>

    <!-- Stats bar -->
    <section class="border-y border-gold-500/20 bg-black/60 backdrop-blur-sm">
      <div class="container mx-auto px-6 py-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
          <div v-for="stat in stats" :key="stat.label" class="text-center stat-item">
            <div class="text-4xl font-black gradient-text-gold mb-1">{{ stat.value }}</div>
            <div class="text-white/40 text-xs tracking-widest uppercase">{{ stat.label }}</div>
          </div>
        </div>
      </div>
    </section>

    <!-- About description -->
    <section class="py-28 relative">
      <div class="absolute inset-0 bg-gradient-to-b from-transparent via-gold-900/5 to-transparent pointer-events-none" />
      <div class="container mx-auto px-6">
        <div class="grid md:grid-cols-2 gap-16 items-center">

          <!-- Left: Text -->
          <div>
            <div class="section-label mb-6">À propos</div>
            <h2 class="text-4xl md:text-5xl font-black uppercase leading-tight mb-8">
              Une diplomatie<br />
              <span class="gradient-text-gold">culturelle</span><br />
              africaine
            </h2>
            <div class="space-y-5 text-white/60 leading-relaxed">
              <p>
                Le <strong class="text-white">United Kizdom World Congress</strong> est un événement international
                organisé au <strong class="text-gold-400">Bénin</strong>, valorisant les danses afro, afro-latines,
                caribéennes et les expressions culturelles africaines.
              </p>
              <p>
                Il constitue une plateforme stratégique de rencontre entre artistes locaux et internationaux,
                leaders culturels, créateurs de contenu et professionnels du secteur, tout en renforçant la
                diplomatie culturelle et la visibilité touristique du pays.
              </p>
              <p>
                Chaque édition rassemble plus de <strong class="text-white">250 participants</strong> et plus de
                <strong class="text-white">20 artistes internationaux</strong> référencés mondialement — enseignants,
                performers et ambassadeurs de leurs communautés artistiques.
              </p>
            </div>
          </div>

          <!-- Right: Visual card -->
          <div class="relative">
            <!-- Decorative card -->
            <div class="relative bg-gradient-to-br from-gold-900/20 to-transparent border border-gold-500/20 rounded-2xl p-8 overflow-hidden">
              <div class="absolute top-0 right-0 w-40 h-40 bg-gold-500/10 rounded-full blur-3xl" />

              <!-- African pattern SVG inside card -->
              <svg viewBox="0 0 400 300" class="w-full mb-6 rounded-xl" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="400" height="300" fill="#0a0a0a"/>
                <!-- Background gradient -->
                <defs>
                  <radialGradient id="bg-grad" cx="50%" cy="50%" r="60%">
                    <stop offset="0%" stop-color="#C9A84C" stop-opacity="0.15"/>
                    <stop offset="100%" stop-color="#000" stop-opacity="0"/>
                  </radialGradient>
                  <linearGradient id="benin-grad" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0%" stop-color="#008751"/>
                    <stop offset="33%" stop-color="#008751"/>
                    <stop offset="33%" stop-color="#FCD116"/>
                    <stop offset="66%" stop-color="#FCD116"/>
                    <stop offset="66%" stop-color="#E8112D"/>
                    <stop offset="100%" stop-color="#E8112D"/>
                  </linearGradient>
                </defs>
                <rect width="400" height="300" fill="url(#bg-grad)"/>

                <!-- Benin flag small -->
                <rect x="20" y="20" width="60" height="40" rx="3" fill="url(#benin-grad)" opacity="0.8"/>
                <rect x="20" y="20" width="20" height="40" rx="2" fill="#008751"/>

                <!-- Map of Africa silhouette (simplified) -->
                <path d="M200 40 C220 42 245 50 260 65 C275 80 278 100 275 120 C272 140 265 155 270 175 C275 195 280 205 275 225 C270 245 255 260 240 265 C225 270 210 262 200 255 C190 262 175 270 160 265 C145 260 130 245 125 225 C120 205 125 195 130 175 C135 155 128 140 125 120 C122 100 125 80 140 65 C155 50 180 42 200 40Z" fill="#C9A84C" opacity="0.15"/>
                <path d="M200 40 C220 42 245 50 260 65 C275 80 278 100 275 120 C272 140 265 155 270 175 C275 195 280 205 275 225 C270 245 255 260 240 265 C225 270 210 262 200 255 C190 262 175 270 160 265 C145 260 130 245 125 225 C120 205 125 195 130 175 C135 155 128 140 125 120 C122 100 125 80 140 65 C155 50 180 42 200 40Z" stroke="#C9A84C" stroke-width="1.5" fill="none" opacity="0.5"/>

                <!-- Kizomba couple silhouette -->
                <!-- Person 1 -->
                <circle cx="168" cy="138" r="14" fill="#C9A84C" opacity="0.9"/>
                <path d="M168 152 C162 165 158 182 160 198" stroke="#C9A84C" stroke-width="5" fill="none" opacity="0.9"/>
                <path d="M164 164 C152 160 143 156 136 150" stroke="#C9A84C" stroke-width="4" fill="none" opacity="0.9"/>
                <path d="M164 164 C172 162 180 162 186 164" stroke="#C9A84C" stroke-width="4" fill="none" opacity="0.9"/>
                <path d="M159 198 C155 210 152 222 150 234" stroke="#C9A84C" stroke-width="4" fill="none" opacity="0.9"/>
                <path d="M162 198 C165 212 168 224 168 238" stroke="#C9A84C" stroke-width="4" fill="none" opacity="0.9"/>
                <!-- Person 2 -->
                <circle cx="232" cy="138" r="14" fill="#C9A84C" opacity="0.9"/>
                <path d="M232 152 C238 165 242 182 240 198" stroke="#C9A84C" stroke-width="5" fill="none" opacity="0.9"/>
                <path d="M236 164 C248 160 257 156 264 150" stroke="#C9A84C" stroke-width="4" fill="none" opacity="0.9"/>
                <path d="M236 164 C228 162 220 162 214 164" stroke="#C9A84C" stroke-width="4" fill="none" opacity="0.9"/>
                <path d="M241 198 C245 210 248 222 250 234" stroke="#C9A84C" stroke-width="4" fill="none" opacity="0.9"/>
                <path d="M238 198 C235 212 232 224 232 238" stroke="#C9A84C" stroke-width="4" fill="none" opacity="0.9"/>

                <!-- UKWC text -->
                <text x="200" y="285" text-anchor="middle" fill="#C9A84C" font-size="13" font-weight="bold" letter-spacing="6" opacity="0.7">UKWC 2026</text>

                <!-- Decorative dots -->
                <circle cx="50" cy="260" r="3" fill="#C9A84C" opacity="0.4"/>
                <circle cx="60" cy="260" r="3" fill="#C9A84C" opacity="0.4"/>
                <circle cx="70" cy="260" r="3" fill="#C9A84C" opacity="0.4"/>
                <circle cx="330" cy="260" r="3" fill="#C9A84C" opacity="0.4"/>
                <circle cx="340" cy="260" r="3" fill="#C9A84C" opacity="0.4"/>
                <circle cx="350" cy="260" r="3" fill="#C9A84C" opacity="0.4"/>

                <!-- Border decoration -->
                <rect x="1" y="1" width="398" height="298" rx="11" stroke="#C9A84C" stroke-width="1" opacity="0.2" fill="none"/>
              </svg>

              <blockquote class="text-white/70 italic text-sm leading-relaxed border-l-2 border-gold-400 pl-4">
                "Le UKWC ambitionne de positionner le Bénin comme un hub majeur des danses afro et afro-latines en Afrique et à l'international."
              </blockquote>
            </div>

            <!-- Floating badge -->
            <div class="absolute -top-5 -right-5 bg-gold-500 text-black font-black text-sm px-4 py-2 rounded-full rotate-3 shadow-lg shadow-gold-500/30">
              Bénin 🇧🇯
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Dance styles -->
    <section class="py-24 border-t border-gold-500/10">
      <div class="container mx-auto px-6">
        <div class="text-center mb-16">
          <div class="section-label mb-4">Au Programme</div>
          <h2 class="text-4xl md:text-5xl font-black uppercase">
            Les danses à l'<span class="gradient-text-gold">honneur</span>
          </h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
          <div v-for="dance in danceStyles" :key="dance.name"
            class="dance-card group relative bg-white/5 hover:bg-gold-500/10 border border-white/10 hover:border-gold-500/40 rounded-2xl p-5 text-center cursor-default transition-all duration-300">
            <div class="text-3xl mb-3">{{ dance.emoji }}</div>
            <div class="text-white/80 group-hover:text-white font-medium text-sm transition-colors">{{ dance.name }}</div>
            <div class="absolute inset-0 rounded-2xl bg-gold-500/5 opacity-0 group-hover:opacity-100 transition-opacity" />
          </div>
        </div>
      </div>
    </section>

    <!-- Mission / pillars -->
    <section class="py-24 bg-gradient-to-b from-transparent via-gold-900/5 to-transparent">
      <div class="container mx-auto px-6">
        <div class="text-center mb-16">
          <div class="section-label mb-4">Notre mission</div>
          <h2 class="text-4xl font-black uppercase">
            Trois piliers,<br/><span class="gradient-text-gold">un impact durable</span>
          </h2>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
          <div v-for="pillar in pillars" :key="pillar.title"
            class="relative bg-white/3 border border-white/10 rounded-2xl p-8 hover:border-gold-500/30 transition-all duration-300 group overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"
              :class="pillar.glowColor" />
            <div class="text-5xl mb-5">{{ pillar.icon }}</div>
            <h3 class="text-xl font-black uppercase mb-3 group-hover:text-gold-400 transition-colors">{{ pillar.title }}</h3>
            <p class="text-white/50 text-sm leading-relaxed">{{ pillar.description }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section class="py-24 border-t border-gold-500/10">
      <div class="container mx-auto px-6 text-center">
        <h2 class="text-5xl md:text-7xl font-black uppercase mb-6">
          Rejoignez<br/>
          <span class="gradient-text-gold">l'aventure</span>
        </h2>
        <p class="text-white/50 mb-10 max-w-xl mx-auto">
          14 au 19 juillet 2026 · Bénin, Afrique
        </p>
        <NuxtLink to="/ukwc"
          class="inline-block bg-gold-500 hover:bg-gold-400 text-black font-black uppercase tracking-widest px-10 py-4 rounded-full transition-all duration-300 shadow-lg shadow-gold-500/30 hover:shadow-gold-400/50 hover:-translate-y-1">
          Voir l'événement UKWC 26
        </NuxtLink>
      </div>
    </section>

  </div>
</template>

<script setup>
import HeroSection from '~/components/HeroSection.vue'

const stats = [
  { value: '250+', label: 'Participants' },
  { value: '20+', label: 'Artistes internationaux' },
  { value: '6', label: 'Jours de festival' },
  { value: '1', label: 'Continent africain' },
]

const danceStyles = [
  { name: 'Kizomba', emoji: '💃' },
  { name: 'Semba', emoji: '🎶' },
  { name: 'Afro Fusion', emoji: '🌍' },
  { name: 'Urban Kiz', emoji: '🏙️' },
  { name: 'Salsa', emoji: '🔥' },
  { name: 'Bachata', emoji: '🌹' },
  { name: 'Rumba', emoji: '🥁' },
  { name: 'Zouk', emoji: '✨' },
  { name: 'Kompa', emoji: '🎵' },
  { name: 'Merengue', emoji: '🎺' },
  { name: 'Houngan', emoji: '🛡️' },
  { name: 'Afro Urban', emoji: '⚡' },
]

const pillars = [
  {
    icon: '🌍',
    title: 'Diplomatie Culturelle',
    description: 'Renforcer la diplomatie culturelle africaine en réunissant artistes locaux et internationaux autour d\'une vision commune.',
    glowColor: 'bg-gold-500/20',
  },
  {
    icon: '💫',
    title: 'Excellence Artistique',
    description: 'Réunir les figures majeures de la scène internationale pour un niveau d\'enseignement et de performance d\'exception.',
    glowColor: 'bg-amber-500/20',
  },
  {
    icon: '🇧🇯',
    title: 'Impact au Bénin',
    description: 'Générer un impact culturel, économique et digital durable, positionnant le Bénin comme hub mondial des danses afro.',
    glowColor: 'bg-green-500/20',
  },
]
</script>

<style scoped>
/* Fonts */
@import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Nunito:wght@400;600;800&display=swap');

* {
  font-family: 'Nunito', sans-serif;
}

h1, h2, h3 {
  font-family: 'Bebas Neue', sans-serif;
  letter-spacing: 0.02em;
}

/* Gradients */
.gradient-text-gold {
  background: linear-gradient(135deg, #C9A84C 0%, #F5D78A 40%, #C9A84C 70%, #8B6914 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.hero-bg-gradient {
  background: radial-gradient(ellipse 80% 60% at 30% 40%, rgba(201, 168, 76, 0.12) 0%, transparent 70%),
              radial-gradient(ellipse 60% 80% at 80% 70%, rgba(139, 105, 20, 0.08) 0%, transparent 70%),
              #000;
}

.noise-overlay {
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.4'/%3E%3C/svg%3E");
  opacity: 0.04;
}

.section-label {
  color: #C9A84C;
  font-size: 0.7rem;
  letter-spacing: 0.4em;
  text-transform: uppercase;
  font-weight: 600;
}

/* Animations */
@keyframes spin-slow {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}
@keyframes spin-reverse {
  from { transform: rotate(360deg); }
  to { transform: rotate(0deg); }
}
@keyframes fade-up {
  from { opacity: 0; transform: translateY(24px); }
  to { opacity: 1; transform: translateY(0); }
}

.animate-spin-slow {
  animation: spin-slow 30s linear infinite;
}
.animate-spin-reverse {
  animation: spin-reverse 20s linear infinite;
}
.animate-fade-up {
  animation: fade-up 0.7s ease forwards;
  opacity: 0;
}

/* Gold colors (extends Tailwind if not in config) */
.text-gold-400 { color: #F5D78A; }
.text-gold-500 { color: #C9A84C; }
.bg-gold-400 { background-color: #F5D78A; }
.bg-gold-500 { background-color: #C9A84C; }
.hover\:bg-gold-400:hover { background-color: #F5D78A; }
.border-gold-400 { border-color: #F5D78A; }
.border-gold-500 { border-color: #C9A84C; }
.bg-gold-900\/20 { background-color: rgba(120, 80, 10, 0.2); }
.shadow-gold-500\/30 { --tw-shadow-color: rgba(201, 168, 76, 0.3); }
.shadow-gold-400\/50 { --tw-shadow-color: rgba(245, 215, 138, 0.5); }
</style>