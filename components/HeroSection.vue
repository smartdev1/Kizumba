<template>
  <section class="hero-section relative overflow-hidden">

    <!-- Background fixe -->
    <div
      class="absolute inset-0 bg-cover bg-center z-0"
      :style="{ backgroundImage: `url(${bgImage})` }"
    ></div>
    <div class="absolute inset-0 bg-black/45 z-0"></div>

    <!--
      LAYOUT :
      - Mobile  : flex colonne — zone image (flex-1) + zone CTA (hauteur fixe en bas)
      - Desktop : flex ligne   — image à gauche ancrée au bas + CTA à droite centré
    -->
    <div class="absolute inset-0 z-10 flex flex-col md:flex-row">

      <!-- ── Zone image ─────────────────────────────────── -->
      <div class="relative flex-1 min-h-0 md:h-full">
        <div
          v-for="(slide, index) in slides"
          :key="slide.name"
          :class="[
            'absolute inset-0',
            getSlideClass(index)
          ]"
        >
          <!-- Mobile : cover aligné à gauche, remplit toute la zone -->
          <img
            :src="slide.image"
            :alt="slide.name"
            class="
              w-full h-full
              object-cover object-left
              md:object-contain md:object-bottom
              md:w-auto md:h-full
              drop-shadow-2xl
            "
          />
        </div>
      </div>

      <!-- ── Zone CTA ───────────────────────────────────── -->
      <div class="
        flex-shrink-0
        flex flex-col items-center justify-center gap-2
        px-5 pb-10 pt-3
        h-[26svh]
        md:h-auto md:w-[300px] md:items-end md:justify-center
        md:pr-[5%] md:pb-0 md:pt-0 md:gap-3
      ">
        <!-- Label artiste -->
        <p class="text-[9px] md:text-[11px] tracking-[0.2em] uppercase text-[#C9A032]/60 text-center md:text-right">
          {{ slides[current].name }}
        </p>

        <!-- Boutons côte à côte sur mobile, empilés sur desktop -->
        <div class="flex flex-row gap-2 w-full justify-center md:flex-col md:items-end md:w-auto">
          <a
            href="#billetterie"
            class="btn-primary text-center text-xs px-3 py-2 flex-1 max-w-[160px]
                   md:text-base md:px-5 md:py-3 md:flex-none md:w-[220px] md:max-w-none"
          >
            Réserver maintenant
          </a>
          <a
            href="#professeurs"
            class="btn-secondary text-center text-xs px-3 py-2 flex-1 max-w-[160px]
                   md:text-base md:px-5 md:py-3 md:flex-none md:w-[220px] md:max-w-none"
          >
            Découvrir les artistes
          </a>
        </div>
      </div>

    </div>

    <!-- Boutons nav — desktop uniquement -->
    <button class="nav-btn left-4 hidden md:flex" aria-label="Précédent" @click="prev">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
           stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
        <polyline points="15 18 9 12 15 6"/>
      </svg>
    </button>
    <button class="nav-btn right-4 hidden md:flex" aria-label="Suivant" @click="next">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
           stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
        <polyline points="9 18 15 12 9 6"/>
      </svg>
    </button>

    <!-- Barre du bas : dots + counter -->
    <div class="absolute bottom-3 left-0 right-0 z-20 flex items-center justify-between px-5 md:px-[5%]">
      <div class="flex gap-2">
        <button
          v-for="(slide, index) in slides"
          :key="index"
          :class="['dot', { active: index === current }]"
          :aria-label="`Aller à ${slide.name}`"
          @click="goTo(index)"
        />
      </div>
      <span class="text-[11px] tracking-[0.15em] text-[#C9A032]/60 tabular-nums">
        {{ String(current + 1).padStart(2, '0') }} / {{ String(slides.length).padStart(2, '0') }}
      </span>
    </div>

    <!-- Zones tap mobile gauche/droite (sur la zone image uniquement) -->
    <div class="absolute top-0 left-0 w-1/2 z-20 md:hidden" style="height: 74svh;" @click="prev" />
    <div class="absolute top-0 right-0 w-1/2 z-20 md:hidden" style="height: 74svh;" @click="next" />

  </section>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'

import bgImage     from '~/assets/images/BACKGROUND.png'
import imgAurea    from '~/assets/images/AUREA & TRESOR .png'
import imgFofoJah  from '~/assets/images/DJ FOFO JAH.png'
import imgGobedson from '~/assets/images/DJ GOBEDSON.png'

interface Slide {
  name: string
  image: string
}

const slides: Slide[] = [
  { name: 'Aurea & Tresor', image: imgAurea    },
  { name: 'DJ Fofo Jah',    image: imgFofoJah  },
  { name: 'DJ Gobedson',    image: imgGobedson },
]

const current    = ref(0)
const leaving    = ref<number | null>(null)
const animating  = ref(false)
const firstShown = ref(true)

let timer: ReturnType<typeof setInterval> | null = null

function getSlideClass(index: number): string[] {
  if (index === current.value) {
    return [index === 0 && firstShown.value ? 'slide-visible' : 'slide-fadein']
  }
  if (index === leaving.value) return ['slide-fadeout']
  return ['slide-hidden']
}

function goTo(n: number) {
  if (animating.value || n === current.value) return
  animating.value  = true
  firstShown.value = false
  leaving.value    = current.value
  current.value    = ((n % slides.length) + slides.length) % slides.length
  setTimeout(() => { leaving.value = null; animating.value = false }, 800)
}

function next() { goTo(current.value + 1); resetTimer() }
function prev() { goTo(current.value - 1); resetTimer() }

function resetTimer() {
  if (timer) clearInterval(timer)
  timer = setInterval(() => goTo(current.value + 1), 4500)
}

function onKey(e: KeyboardEvent) {
  if (e.key === 'ArrowLeft')  prev()
  if (e.key === 'ArrowRight') next()
}

onMounted(() => {
  resetTimer()
  window.addEventListener('keydown', onKey)
})

onUnmounted(() => {
  if (timer) clearInterval(timer)
  window.removeEventListener('keydown', onKey)
})
</script>

<style scoped>
.hero-section {
  height: 100svh;
  min-height: 600px;
}

/* Fade */
.slide-visible  { opacity: 1; pointer-events: auto; }
.slide-hidden   { opacity: 0; pointer-events: none; }
.slide-fadein   { animation: fadeIn 0.8s ease forwards; pointer-events: auto; }
.slide-fadeout  { animation: fadeOut 0.8s ease forwards; pointer-events: none; }

@keyframes fadeIn  { from { opacity: 0; } to { opacity: 1; } }
@keyframes fadeOut { from { opacity: 1; } to { opacity: 0; } }

/* Nav buttons */
.nav-btn {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  z-index: 20;
  background: rgba(0, 0, 0, 0.3);
  border: 1px solid rgba(201, 160, 50, 0.4);
  color: #C9A032;
  width: 48px; height: 48px;
  border-radius: 50%;
  cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  transition: background 0.2s, border-color 0.2s;
}
.nav-btn:hover {
  background: rgba(201, 160, 50, 0.2);
  border-color: #C9A032;
}

/* Dots */
.dot {
  width: 8px; height: 8px;
  border-radius: 9999px;
  background: rgba(201, 160, 50, 0.35);
  border: 1px solid rgba(201, 160, 50, 0.5);
  cursor: pointer;
  transition: all 0.3s;
  padding: 0;
}
.dot.active {
  background: #C9A032;
  width: 28px;
  border-radius: 4px;
}
</style>