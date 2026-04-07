<template>
  <header class="fixed top-0 left-0 right-0 z-50 bg-black/80 backdrop-blur-md border-b border-gold-500/20">
    <div class="container mx-auto px-4">
      <nav class="flex items-center justify-between py-4">
        <div class="text-2xl font-bold gradient-text">UKWC</div>

        <div class="hidden md:flex items-center space-x-8">
          <a href="#billetterie" class="hover:text-gold-500 transition-colors">Billetterie</a>
          <a href="#professeurs" class="hover:text-gold-500 transition-colors">Professeurs</a>
          <a href="#dj" class="hover:text-gold-500 transition-colors">DJs</a>
          <a href="#contact" class="hover:text-gold-500 transition-colors">Contact</a>
        </div>

        <div class="hidden md:block">
          <CountdownTimer />
        </div>

        <button class="md:hidden text-gold-500" @click="toggleMenu">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </nav>

      <div v-if="isMenuOpen" class="md:hidden py-4 border-t border-gold-500/20">
        <a href="#billetterie" class="block py-2 hover:text-gold-500">Billetterie</a>
        <a href="#professeurs" class="block py-2 hover:text-gold-500">Professeurs</a>
        <a href="#dj" class="block py-2 hover:text-gold-500">DJs</a>
        <a href="#contact" class="block py-2 hover:text-gold-500">Contact</a>
      </div>
    </div>
  </header>
</template>

<script setup>
const isMenuOpen = ref(false)

const toggleMenu = () => {
  isMenuOpen.value = !isMenuOpen.value
}
</script>
