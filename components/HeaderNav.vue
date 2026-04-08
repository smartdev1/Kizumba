<template>
  <header class="fixed top-0 left-0 right-0 z-50 bg-black/80 backdrop-blur-md border-b border-gold-500/20">
    <div class="container mx-auto px-4">
      <nav class="flex items-center justify-between py-4">
        <NuxtLink to="/" class="text-2xl font-bold gradient-text">UKWC</NuxtLink>

        <div class="hidden md:flex items-center space-x-8">
          <NuxtLink to="/ukwc" class="hover:text-gold-500 transition-colors">UKWC 26</NuxtLink>
          <NuxtLink to="/battle-kiz-qualifier" class="hover:text-gold-500 transition-colors">The Battle KIZ Qualifier</NuxtLink>
          <NuxtLink to="/shop" class="hover:text-gold-500 transition-colors">Shop</NuxtLink>
          <NuxtLink to="/partners" class="hover:text-gold-500 transition-colors">Partners</NuxtLink>
          <NuxtLink to="/about" class="hover:text-gold-500 transition-colors">About Us</NuxtLink>
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
        <NuxtLink to="/ukwc" class="block py-2 hover:text-gold-500" @click="isMenuOpen = false">UKWC 26</NuxtLink>
        <NuxtLink to="/battle-kiz-qualifier" class="block py-2 hover:text-gold-500" @click="isMenuOpen = false">The Battle KIZ Qualifier</NuxtLink>
        <NuxtLink to="/shop" class="block py-2 hover:text-gold-500" @click="isMenuOpen = false">Shop</NuxtLink>
        <NuxtLink to="/partners" class="block py-2 hover:text-gold-500" @click="isMenuOpen = false">Partners</NuxtLink>
        <NuxtLink to="/about" class="block py-2 hover:text-gold-500" @click="isMenuOpen = false">About Us</NuxtLink>
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
