<template>
  <div class="bg-black text-white overflow-x-hidden">

    <!-- Hero -->
    <section class="relative min-h-[50vh] flex items-center justify-center overflow-hidden">
      <div class="absolute inset-0 z-0">
        <div class="partners-hero-bg absolute inset-0" />
        <svg class="absolute inset-0 w-full h-full opacity-10" viewBox="0 0 1440 900" preserveAspectRatio="xMidYMid slice" fill="none">
          <line x1="-100" y1="900" x2="1200" y2="-50" stroke="#C9A84C" stroke-width="1"/>
          <line x1="100" y1="900" x2="1400" y2="-50" stroke="#C9A84C" stroke-width="0.5"/>
          <circle cx="720" cy="450" r="380" stroke="#C9A84C" stroke-width="0.5"/>
        </svg>
      </div>
      <div class="relative z-10 container mx-auto px-6 pt-32 pb-20 text-center">
        <p class="text-gold-400 text-xs tracking-[0.5em] uppercase mb-4">UKWC 2026</p>
        <h1 style="font-family:'Bebas Neue',sans-serif;">
          <span class="block text-[clamp(3rem,8vw,6rem)] leading-none tracking-tight">Nos</span>
          <span class="block text-[clamp(2.5rem,6vw,5rem)] leading-none gradient-text-gold">Partenaires</span>
        </h1>
        <p class="text-white/50 mt-6 max-w-xl mx-auto">
          Ils soutiennent la diplomatie culturelle africaine et la promotion des danses afro dans le monde.
        </p>
      </div>
    </section>

    <!-- Partners grid -->
    <section class="py-20 border-t border-gold-500/10">
      <div class="container mx-auto px-6">
        <div class="text-center mb-16">
          <div class="section-label mb-4">Partenaires officiels</div>
          <h2 class="text-4xl font-black uppercase" style="font-family:'Bebas Neue',sans-serif;">
            Ils nous <span class="gradient-text-gold">font confiance</span>
          </h2>
        </div>

        <!-- Placeholder partner cards -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 max-w-5xl mx-auto">
          <div v-for="partner in partners" :key="partner.name"
            class="bg-white/5 border border-white/10 hover:border-gold-500/40 rounded-2xl p-8 flex flex-col items-center justify-center text-center transition-all duration-300 hover:-translate-y-1 group">
            <div class="text-5xl mb-4">{{ partner.emoji }}</div>
            <h3 class="font-bold text-white/80 group-hover:text-gold-400 transition-colors text-sm">{{ partner.name }}</h3>
            <p class="text-white/30 text-xs mt-1">{{ partner.category }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Become a partner CTA -->
    <section class="py-24 border-t border-gold-500/10 bg-gradient-to-b from-transparent via-gold-900/5 to-transparent">
      <div class="container mx-auto px-6 text-center">
        <div class="section-label mb-6">Rejoignez-nous</div>
        <h2 class="text-5xl md:text-6xl font-black uppercase mb-6" style="font-family:'Bebas Neue',sans-serif;">
          Devenez<br /><span class="gradient-text-gold">partenaire</span>
        </h2>
        <p class="text-white/50 max-w-2xl mx-auto mb-10 leading-relaxed">
          Le UKWC offre une visibilité internationale unique auprès d'une communauté passionnée de danses afro et
          afro-latines. Associez votre marque à l'excellence culturelle africaine.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <a href="mailto:unitedkizdomworldcongress@gmail.com"
            class="inline-block bg-gold-500 hover:bg-gold-400 text-black font-black uppercase tracking-widest px-10 py-4 rounded-full transition-all duration-300 shadow-lg shadow-gold-500/30 hover:-translate-y-1">
            Nous contacter
          </a>
          <NuxtLink to="/about"
            class="inline-block border border-gold-500/40 hover:border-gold-500 text-white/70 hover:text-white font-bold uppercase tracking-widest px-10 py-4 rounded-full transition-all duration-300">
            En savoir plus
          </NuxtLink>
        </div>
      </div>
    </section>

  </div>
</template>

<script setup>
useHead({
  title: 'Partenaires - United Kizdom World Congress 2026',
  meta: [
    { name: 'description', content: 'Découvrez les partenaires du United Kizdom World Congress 2026 au Bénin.' }
  ]
})

const partners = [
  { name: 'Ministère du Tourisme', category: 'Institutionnel', emoji: '🏛️' },
  { name: 'Office du Tourisme', category: 'Institutionnel', emoji: '🌍' },
  { name: 'Partenaire média', category: 'Médias', emoji: '📺' },
  { name: 'Sponsor principal', category: 'Sponsor', emoji: '⭐' },
  { name: 'Partenaire hôtelier', category: 'Hébergement', emoji: '🏨' },
  { name: 'Partenaire transport', category: 'Transport', emoji: '✈️' },
  { name: 'Partenaire cultural', category: 'Culture', emoji: '🎭' },
  { name: 'Partenaire digital', category: 'Digital', emoji: '💻' },
]
</script>

<style scoped>
.gradient-text-gold {
  background: linear-gradient(135deg, #C9A84C 0%, #F5D78A 40%, #C9A84C 70%, #8B6914 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.partners-hero-bg {
  background: radial-gradient(ellipse 80% 60% at 50% 40%, rgba(201, 168, 76, 0.10) 0%, transparent 70%), #000;
}

.section-label {
  color: #C9A84C;
  font-size: 0.7rem;
  letter-spacing: 0.4em;
  text-transform: uppercase;
  font-weight: 600;
}

.text-gold-400 { color: #F5D78A; }
.text-gold-500 { color: #C9A84C; }
.bg-gold-500 { background-color: #C9A84C; }
.bg-gold-400 { background-color: #F5D78A; }
.hover\:bg-gold-400:hover { background-color: #F5D78A; }
.border-gold-500 { border-color: #C9A84C; }
.border-gold-500\/40 { border-color: rgba(201, 168, 76, 0.4); }
.hover\:border-gold-500\/40:hover { border-color: rgba(201, 168, 76, 0.4); }
.hover\:border-gold-500:hover { border-color: #C9A84C; }
.shadow-gold-500\/30 { --tw-shadow-color: rgba(201, 168, 76, 0.3); }
</style>
