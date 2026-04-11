<template>
  <header class="fixed top-0 left-0 right-0 z-50 bg-black/80 backdrop-blur-md border-b border-gold-500/20">
    <div class="container mx-auto px-4">
      <nav class="flex items-center justify-between py-4">
        <NuxtLink to="/" class="text-2xl font-bold gradient-text">UKWC</NuxtLink>

        <div class="hidden md:flex items-center space-x-8">
          <NuxtLink to="/ukwc" class="nav-link" :class="{ 'nav-link-active': route.path === '/ukwc' }">UKWC 26</NuxtLink>
          <NuxtLink to="/battle-kiz-qualifier" class="nav-link" :class="{ 'nav-link-active': route.path === '/battle-kiz-qualifier' }">Battle KIZ</NuxtLink>
          <NuxtLink to="/shop" class="nav-link" :class="{ 'nav-link-active': route.path === '/shop' }">Shop</NuxtLink>
          <NuxtLink to="/partners" class="nav-link" :class="{ 'nav-link-active': route.path === '/partners' }">Partners</NuxtLink>
          <NuxtLink to="/about" class="nav-link" :class="{ 'nav-link-active': route.path === '/about' }">About Us</NuxtLink>
        </div>

        <!-- Panier + Décompte (desktop) -->
        <div class="hidden md:flex items-center gap-4">
          <NuxtLink
            to="/checkout"
            class="relative flex items-center gap-2 border border-gold-500/40 hover:border-gold-500 text-white/70 hover:text-white px-3 py-1.5 rounded-full transition-all duration-200 text-sm font-semibold"
            :class="{ 'border-gold-500 text-white': cartStore.itemCount > 0 }"
          >
            <svg class="w-4 h-4 text-gold-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <span v-if="cartStore.itemCount > 0">
              Commander {{ cartStore.itemCount }} ticket{{ cartStore.itemCount > 1 ? 's' : '' }}
            </span>
            <span v-else>Commander</span>
            <!-- Badge panier -->
            <span v-if="cartStore.itemCount > 0"
              class="absolute -top-1.5 -right-1.5 w-4 h-4 bg-gold-500 text-black text-[9px] font-black rounded-full flex items-center justify-center">
              {{ cartStore.itemCount }}
            </span>
          </NuxtLink>
          <CountdownTimer />
        </div>

        <button class="md:hidden text-gold-500 p-2.5 -mr-1" @click="toggleMenu" :aria-label="isMenuOpen ? 'Fermer le menu' : 'Ouvrir le menu'">
          <svg v-if="!isMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
          <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </nav>

      <div v-if="isMenuOpen" class="md:hidden py-4 border-t border-gold-500/20">
        <NuxtLink to="/ukwc" class="mobile-nav-link" :class="{ 'mobile-nav-link-active': route.path === '/ukwc' }" @click="isMenuOpen = false">UKWC 26</NuxtLink>
        <NuxtLink to="/battle-kiz-qualifier" class="mobile-nav-link" :class="{ 'mobile-nav-link-active': route.path === '/battle-kiz-qualifier' }" @click="isMenuOpen = false">Battle KIZ Qualifier</NuxtLink>
        <NuxtLink to="/shop" class="mobile-nav-link" :class="{ 'mobile-nav-link-active': route.path === '/shop' }" @click="isMenuOpen = false">Shop</NuxtLink>
        <NuxtLink to="/partners" class="mobile-nav-link" :class="{ 'mobile-nav-link-active': route.path === '/partners' }" @click="isMenuOpen = false">Partners</NuxtLink>
        <NuxtLink to="/about" class="mobile-nav-link" :class="{ 'mobile-nav-link-active': route.path === '/about' }" @click="isMenuOpen = false">About Us</NuxtLink>
        <NuxtLink to="/checkout" class="flex items-center gap-2 py-4 text-gold-500 font-semibold text-base border-t border-gold-500/10 mt-2 pt-4" @click="isMenuOpen = false">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
          </svg>
          <span v-if="cartStore.itemCount > 0">
            Commander ({{ cartStore.itemCount }} billet{{ cartStore.itemCount > 1 ? 's' : '' }})
          </span>
          <span v-else>Commander</span>
        </NuxtLink>
      </div>
    </div>
  </header>
</template>

<script setup>
import { useCartStore } from '~/stores/cart'

const isMenuOpen = ref(false)
const cartStore = useCartStore()
const route = useRoute()

const toggleMenu = () => {
  isMenuOpen.value = !isMenuOpen.value
}
</script>

<style scoped>
.nav-link {
  color: rgba(255,255,255,0.7);
  font-size: 0.875rem;
  transition: color 0.2s;
  position: relative;
  padding-bottom: 2px;
}
.nav-link:hover {
  color: #C9A84C;
}
.nav-link-active {
  color: #C9A84C !important;
}
.nav-link-active::after {
  content: '';
  position: absolute;
  bottom: -4px;
  left: 0;
  right: 0;
  height: 2px;
  background: #C9A84C;
  border-radius: 1px;
}
.mobile-nav-link {
  display: block;
  padding: 0.875rem 0;
  font-size: 0.9375rem;
  color: rgba(255,255,255,0.7);
  transition: color 0.2s;
}
.mobile-nav-link:hover {
  color: #C9A84C;
}
.mobile-nav-link-active {
  color: #C9A84C !important;
  font-weight: 600;
}
</style>
