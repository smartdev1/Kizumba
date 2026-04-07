<template>
  <section id="professeurs" class="py-20 px-4 bg-black">
    <div class="container mx-auto">
      <h2 class="section-title">Professeurs</h2>
      <p class="text-center text-gray-300 max-w-3xl mx-auto mb-12">
        Des artistes de renommée internationale, réunis à Paris pour vous faire vibrer !
      </p>

      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <div v-for="prof in professeurs" :key="prof.name" class="card text-center group">
          <div class="aspect-square mb-4 overflow-hidden rounded-lg">
            <img :src="prof.image" :alt="prof.name" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
          </div>
          <h3 class="font-semibold text-gold-500">{{ prof.name }}</h3>
        </div>
      </div>
    </div>

    <div id="dj" class="container mx-auto mt-20">
      <h2 class="section-title">DJ'S</h2>
      <p class="text-center text-gray-300 max-w-3xl mx-auto mb-12">
        Les meilleurs DJ's Kizomba du monde réunis à Paris !
      </p>

      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
        <div v-for="dj in djs" :key="dj.name" class="card text-center group">
          <div class="aspect-square mb-4 overflow-hidden rounded-lg">
            <img :src="dj.image" :alt="dj.name" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
          </div>
          <h3 class="font-semibold text-gold-500">{{ dj.name }}</h3>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
const professeurs = [
  { name: 'Adilson & Telma', image: 'https://images.pexels.com/photos/1679618/pexels-photo-1679618.jpeg?auto=compress&cs=tinysrgb&w=400' },
  { name: 'Jesus & Anni', image: 'https://images.pexels.com/photos/1679825/pexels-photo-1679825.jpeg?auto=compress&cs=tinysrgb&w=400' },
  { name: 'Fred Nelson', image: 'https://images.pexels.com/photos/1708936/pexels-photo-1708936.jpeg?auto=compress&cs=tinysrgb&w=400' },
  { name: 'Chamalo', image: 'https://images.pexels.com/photos/1752806/pexels-photo-1752806.jpeg?auto=compress&cs=tinysrgb&w=400' },
  { name: 'Gwany', image: 'https://images.pexels.com/photos/1114690/pexels-photo-1114690.jpeg?auto=compress&cs=tinysrgb&w=400' },
  { name: 'Asia Voronova', image: 'https://images.pexels.com/photos/1729931/pexels-photo-1729931.jpeg?auto=compress&cs=tinysrgb&w=400' },
  { name: 'Claudio', image: 'https://images.pexels.com/photos/1024311/pexels-photo-1024311.jpeg?auto=compress&cs=tinysrgb&w=400' },
  { name: 'Audi & Laura', image: 'https://images.pexels.com/photos/1191422/pexels-photo-1191422.jpeg?auto=compress&cs=tinysrgb&w=400' },
]

const djs = [
  { name: 'DJ Jazzy', image: 'https://images.pexels.com/photos/1763075/pexels-photo-1763075.jpeg?auto=compress&cs=tinysrgb&w=400' },
  { name: 'DJ Fred', image: 'https://images.pexels.com/photos/1190297/pexels-photo-1190297.jpeg?auto=compress&cs=tinysrgb&w=400' },
  { name: 'DJ Paraiso', image: 'https://images.pexels.com/photos/1699161/pexels-photo-1699161.jpeg?auto=compress&cs=tinysrgb&w=400' },
  { name: 'DJ Chanchan', image: 'https://images.pexels.com/photos/1481309/pexels-photo-1481309.jpeg?auto=compress&cs=tinysrgb&w=400' },
  { name: 'DJ Ichigo', image: 'https://images.pexels.com/photos/1644888/pexels-photo-1644888.jpeg?auto=compress&cs=tinysrgb&w=400' },
]
</script>
