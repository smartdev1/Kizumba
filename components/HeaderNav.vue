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

        <!-- Panier + Décompte (desktop) -->
        <div class="hidden md:flex items-center gap-4">
          <NuxtLink to="/checkout" class="relative flex items-center gap-2 border border-gold-500/40 hover:border-gold-500 text-white/70 hover:text-white px-3 py-1.5 rounded-full transition-all duration-200 text-sm font-semibold">
            <svg class="w-4 h-4 text-gold-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <span v-if="cartStore.itemCount > 0">
              Commander {{ cartStore.itemCount }} ticket{{ cartStore.itemCount > 1 ? 's' : '' }}
            </span>
            <span v-else>Commander</span>
          </NuxtLink>
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
        <NuxtLink to="/checkout" class="flex items-center gap-2 py-2 text-gold-500 font-semibold" @click="isMenuOpen = false">
          <span v-if="cartStore.itemCount > 0">
            🛒 Commander {{ cartStore.itemCount }} ticket{{ cartStore.itemCount > 1 ? 's' : '' }}
          </span>
          <span v-else>🛒 Commander</span>
        </NuxtLink>
      </div>
    </div>
  </header>
</template>

<script setup>
import { useCartStore } from '~/stores/cart'

const isMenuOpen = ref(false)
const cartStore = useCartStore()

const toggleMenu = () => {
  isMenuOpen.value = !isMenuOpen.value
}
</script>
