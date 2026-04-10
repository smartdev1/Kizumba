<template>
  <div class="min-h-screen bg-[#0a0a0a] text-white" style="font-family: 'Nunito', sans-serif;">

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
      class="fixed inset-y-0 left-0 z-50 w-64 bg-[#111] border-r border-white/5 flex flex-col transition-transform duration-200 lg:translate-x-0">

      <!-- Logo -->
      <div class="px-6 py-5 border-b border-white/5 flex items-center justify-between">
        <div>
          <div class="text-gold font-black text-lg tracking-widest" style="font-family:'Bebas Neue',sans-serif;">UKWC</div>
          <div class="text-white/30 text-[10px] tracking-wider uppercase">Admin Dashboard</div>
        </div>
        <button class="lg:hidden text-white/40 hover:text-white" @click="sidebarOpen = false">✕</button>
      </div>

      <!-- Nav -->
      <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
        <NuxtLink v-for="item in nav" :key="item.to" :to="item.to"
          class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150"
          :class="$route.path.startsWith(item.to) && item.to !== '/admin'
            ? 'bg-gold/10 text-gold border border-gold/20'
            : $route.path === item.to
              ? 'bg-gold/10 text-gold border border-gold/20'
              : 'text-white/50 hover:text-white hover:bg-white/5'">
          <span class="text-base w-5 text-center">{{ item.icon }}</span>
          <span>{{ item.label }}</span>
          <span v-if="item.badge" class="ml-auto bg-red-500 text-white text-[10px] font-black px-1.5 py-0.5 rounded-full">
            {{ item.badge }}
          </span>
        </NuxtLink>
      </nav>

      <!-- Footer -->
      <div class="px-4 py-4 border-t border-white/5">
        <div class="flex items-center gap-3 mb-3">
          <div class="w-8 h-8 rounded-full bg-gold/20 flex items-center justify-center text-gold font-black text-sm">A</div>
          <div>
            <div class="text-white text-xs font-bold">Admin</div>
            <div class="text-white/30 text-[10px]">UKWC 2026</div>
          </div>
        </div>
        <button @click="handleLogout"
          class="w-full text-left px-3 py-2 rounded-lg text-white/40 hover:text-red-400 hover:bg-red-500/10 text-xs font-semibold transition-all flex items-center gap-2">
          <span>⏻</span> Déconnexion
        </button>
      </div>
    </aside>

    <!-- Mobile overlay -->
    <div v-if="sidebarOpen" class="fixed inset-0 bg-black/60 z-40 lg:hidden" @click="sidebarOpen = false" />

    <!-- Main -->
    <div class="lg:pl-64 min-h-screen flex flex-col">
      <!-- Topbar -->
      <header class="sticky top-0 z-30 bg-[#0a0a0a]/90 backdrop-blur border-b border-white/5 px-6 py-3 flex items-center gap-4">
        <button class="lg:hidden text-white/50 hover:text-white" @click="sidebarOpen = true">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
        </button>
        <div class="flex-1">
          <h1 class="text-white font-black text-base">{{ pageTitle }}</h1>
        </div>
        <a href="/" target="_blank" class="text-white/30 hover:text-white text-xs flex items-center gap-1 transition-colors">
          <span>↗</span> Voir le site
        </a>
      </header>

      <!-- Page content -->
      <main class="flex-1 p-6">
        <slot />
      </main>
    </div>

  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'

defineOptions({ name: 'AdminLayout' })

const route = useRoute()
const router = useRouter()
const { logout } = useAdminApi()

const sidebarOpen = ref(false)

const nav = [
  { to: '/admin',           icon: '⬛', label: 'Dashboard' },
  { to: '/admin/commandes', icon: '🎫', label: 'Commandes' },
  { to: '/admin/billets',   icon: '💳', label: 'Billets & Pass' },
  { to: '/admin/artistes',  icon: '🎭', label: 'Artistes & DJs' },
]

const titles: Record<string, string> = {
  '/admin':           'Dashboard',
  '/admin/commandes': 'Commandes',
  '/admin/billets':   'Billets & Pass',
  '/admin/artistes':  'Artistes & DJs',
}

const pageTitle = computed(() => {
  for (const [path, title] of Object.entries(titles)) {
    if (route.path.startsWith(path) && path !== '/admin') return title
  }
  return titles[route.path] ?? 'Admin'
})

async function handleLogout() {
  try { await logout() } catch {}
  navigateTo('/admin/login')
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Nunito:wght@400;600;700;800;900&display=swap');
.text-gold  { color: #C9A84C; }
.bg-gold    { background-color: #C9A84C; }
</style>
