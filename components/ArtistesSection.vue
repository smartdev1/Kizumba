<template>
  <section id="professeurs" class="py-20 px-4 bg-black">
    <div class="container mx-auto">
      <h2 class="section-title">Professeurs</h2>
      <p class="text-center text-gray-300 max-w-3xl mx-auto mb-12">
        Des artistes de renommée internationale, réunis à Cotonou pour vous faire vibrer !
      </p>

      <!-- Chargement -->
      <div v-if="pending" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <div v-for="n in 8" :key="n" class="card text-center">
          <div class="aspect-square mb-4 rounded-lg bg-white/5 animate-pulse" />
          <div class="h-4 bg-white/5 rounded animate-pulse mx-auto w-2/3" />
        </div>
      </div>

      <div v-else class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <div v-for="prof in professeurs" :key="prof.name" class="card text-center group">
          <div class="aspect-square mb-4 overflow-hidden rounded-lg">
            <img
              v-if="prof.image"
              :src="prof.image"
              :alt="prof.name"
              loading="lazy"
              class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
            />
            <div v-else class="w-full h-full bg-white/5 flex items-center justify-center text-4xl">🎭</div>
          </div>
          <h3 class="font-semibold text-gold-500">{{ prof.name }}</h3>
          <p v-if="prof.specialty" class="text-white/40 text-xs mt-1">{{ prof.specialty }}</p>
        </div>
      </div>
    </div>

    <div id="dj" class="container mx-auto mt-20">
      <h2 class="section-title">DJ'S</h2>
      <p class="text-center text-gray-300 max-w-3xl mx-auto mb-12">
        Les meilleurs DJ's Kizomba du monde réunis à Cotonou !
      </p>

      <!-- Chargement -->
      <div v-if="pending" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
        <div v-for="n in 4" :key="n" class="card text-center">
          <div class="aspect-square mb-4 rounded-lg bg-white/5 animate-pulse" />
          <div class="h-4 bg-white/5 rounded animate-pulse mx-auto w-2/3" />
        </div>
      </div>

      <div v-else class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
        <div v-for="dj in djs" :key="dj.name" class="card text-center group">
          <div class="aspect-square mb-4 overflow-hidden rounded-lg">
            <img
              v-if="dj.image"
              :src="dj.image"
              :alt="dj.name"
              loading="lazy"
              class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
            />
            <div v-else class="w-full h-full bg-white/5 flex items-center justify-center text-4xl">🎧</div>
          </div>
          <h3 class="font-semibold text-gold-500">{{ dj.name }}</h3>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
// Images statiques en fallback si l'API ne retourne rien
import imgAurea       from '~/assets/images/aurea-tresor.png'
import imgOmowise     from '~/assets/images/omowise-teni.png'
import imgQuinn       from '~/assets/images/quinn-wang.png'
import imgLedoux      from '~/assets/images/ledoux-kingsman.png'
import imgYasuke      from '~/assets/images/yasuke-kalinka.png'
import imgSaid        from '~/assets/images/said-d-street.png'
import imgSean        from '~/assets/images/sean.png'
import imgFofoJah     from '~/assets/images/dj-fofo-jah.png'
import imgGobedson    from '~/assets/images/dj-gobedson.png'
import imgMilkshake   from '~/assets/images/dj-milkshake.png'
import imgThemoz      from '~/assets/images/dj-themoz.png'

const staticProfesseurs = [
  { name: 'Aurea & Tresor',   image: imgAurea,   specialty: '' },
  { name: 'Omowise & Teni',   image: imgOmowise, specialty: '' },
  { name: 'Quinn Wang',       image: imgQuinn,   specialty: '' },
  { name: 'Ledoux Kingsman',  image: imgLedoux,  specialty: '' },
  { name: 'Yasuke & Kalinka', image: imgYasuke,  specialty: '' },
  { name: 'Said D Street',    image: imgSaid,    specialty: '' },
  { name: 'Sean',             image: imgSean,    specialty: '' },
]

const staticDjs = [
  { name: 'DJ Fofo Jah',  image: imgFofoJah  },
  { name: 'DJ Gobedson',  image: imgGobedson },
  { name: 'DJ Milkshake', image: imgMilkshake },
  { name: 'DJ Themoz',    image: imgThemoz   },
]

const { getArtists } = useApi()
const { data: artistsData, pending } = await useAsyncData('home-artists', () => getArtists())

const professeurs = computed(() => {
  const api = (artistsData.value ?? []).filter((a) => a.category !== 'dj')
  if (api.length > 0) {
    return api.map((a) => ({ name: a.name, image: a.image_url ?? '', specialty: a.specialty ?? '' }))
  }
  return staticProfesseurs
})

const djs = computed(() => {
  const api = (artistsData.value ?? []).filter((a) => a.category === 'dj')
  if (api.length > 0) {
    return api.map((a) => ({ name: a.name, image: a.image_url ?? '' }))
  }
  return staticDjs
})
</script>
