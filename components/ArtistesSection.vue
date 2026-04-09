<template>
  <section id="professeurs" class="py-20 px-4 bg-black">
    <div class="container mx-auto">
      <h2 class="section-title">Professeurs</h2>
      <p class="text-center text-gray-300 max-w-3xl mx-auto mb-12">
        Des artistes de renommée internationale, réunis à Cotonou pour vous faire vibrer !
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
        Les meilleurs DJ's Kizomba du monde réunis à Cotonou !
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
import imgAurea       from '~/assets/images/AUREA & TRESOR .png'
import imgOmowise     from '~/assets/images/OMOWISE & TENI.png'
import imgQuinn       from '~/assets/images/QUINN WANG.png'
import imgLedoux      from '~/assets/images/LEDOUX KINGSMAN.png'
import imgYasuke      from '~/assets/images/YASUKE & KALINKA.png'
import imgGazl        from '~/assets/images/GAZL & COLIBRI.png'
import imgSaid        from '~/assets/images/SAID D STREET.png'
import imgSean        from '~/assets/images/SEAN.png'
import imgFofoJah     from '~/assets/images/DJ FOFO JAH.png'
import imgGobedson    from '~/assets/images/DJ GOBEDSON.png'
import imgMilkshake   from '~/assets/images/DJ MILKSHAKE.png'
import imgThemoz      from '~/assets/images/DJ THEMOZ.png'

const professeurs = [
  { name: 'Aurea & Tresor',    image: imgAurea    },
  { name: 'Omowise & Teni',    image: imgOmowise  },
  { name: 'Quinn Wang',        image: imgQuinn    },
  { name: 'Ledoux Kingsman',   image: imgLedoux   },
  { name: 'Yasuke & Kalinka',  image: imgYasuke   },
  { name: 'Gazl & Colibri',    image: imgGazl     },
  { name: 'Said D Street',     image: imgSaid     },
  { name: 'Sean',              image: imgSean     },
]

const djs = [
  { name: 'DJ Fofo Jah',   image: imgFofoJah   },
  { name: 'DJ Gobedson',   image: imgGobedson  },
  { name: 'DJ Milkshake',  image: imgMilkshake },
  { name: 'DJ Themoz',     image: imgThemoz    },
]
</script>
