<template>
  <div class="space-y-8">

    <!-- KPIs -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
      <div v-for="kpi in kpis" :key="kpi.label"
        class="bg-[#141414] border border-white/5 rounded-2xl p-5 hover:border-white/10 transition-colors">
        <div class="text-2xl mb-1">{{ kpi.icon }}</div>
        <div class="text-2xl font-black text-white mt-2">{{ kpi.value }}</div>
        <div class="text-white/40 text-xs mt-1 uppercase tracking-wider">{{ kpi.label }}</div>
        <div v-if="kpi.sub" :class="kpi.subColor ?? 'text-white/30'" class="text-xs mt-1 font-semibold">
          {{ kpi.sub }}
        </div>
      </div>
    </div>

    <div class="grid lg:grid-cols-[1fr_360px] gap-6">

      <!-- Ventes récentes -->
      <div class="bg-[#141414] border border-white/5 rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-white/5 flex items-center justify-between">
          <h2 class="font-black text-sm uppercase tracking-wider text-white/70">Dernières ventes</h2>
          <NuxtLink to="/admin/commandes" class="text-gold text-xs font-bold hover:underline">Tout voir →</NuxtLink>
        </div>
        <div v-if="pending" class="px-6 py-8 text-center text-white/30 text-sm">Chargement...</div>
        <div v-else-if="!recentPayments.length" class="px-6 py-8 text-center text-white/30 text-sm">Aucune vente</div>
        <div v-else class="divide-y divide-white/5">
          <div v-for="p in recentPayments" :key="p.tx_ref"
            class="px-6 py-4 flex items-center gap-4 hover:bg-white/2 transition-colors">
            <div class="w-8 h-8 rounded-full bg-green-500/10 flex items-center justify-center text-green-400 text-xs font-black flex-shrink-0">
              ✓
            </div>
            <div class="flex-1 min-w-0">
              <div class="text-white text-sm font-bold truncate">{{ p.customer_name }}</div>
              <div class="text-white/30 text-xs truncate">{{ p.customer_email }}</div>
            </div>
            <div class="text-right flex-shrink-0">
              <div class="text-gold font-black text-sm">{{ p.amount.toLocaleString() }} FCFA</div>
              <div class="text-white/30 text-[10px]">{{ p.tickets_count }} billet{{ p.tickets_count > 1 ? 's' : '' }}</div>
            </div>
            <NuxtLink :to="`/admin/commandes/${p.tx_ref}`"
              class="text-white/20 hover:text-gold transition-colors flex-shrink-0">→</NuxtLink>
          </div>
        </div>
      </div>

      <!-- Stock billets -->
      <div class="bg-[#141414] border border-white/5 rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-white/5 flex items-center justify-between">
          <h2 class="font-black text-sm uppercase tracking-wider text-white/70">Stock billets</h2>
          <NuxtLink to="/admin/billets" class="text-gold text-xs font-bold hover:underline">Gérer →</NuxtLink>
        </div>
        <div class="divide-y divide-white/5">
          <div v-for="t in ticketStats" :key="t.id" class="px-6 py-4">
            <div class="flex items-center justify-between mb-2">
              <span class="text-white text-sm font-bold truncate max-w-[160px]">{{ t.name }}</span>
              <span class="text-white/40 text-xs">{{ t.sold }}/{{ t.stock }}</span>
            </div>
            <!-- Barre de progression -->
            <div class="h-1.5 bg-white/5 rounded-full overflow-hidden">
              <div class="h-full rounded-full transition-all duration-500"
                :class="stockColor(t)"
                :style="{ width: `${Math.min(100, t.stock > 0 ? (t.sold / t.stock) * 100 : 0)}%` }" />
            </div>
            <div class="flex justify-between mt-1.5">
              <span class="text-white/30 text-[10px]">{{ t.price.toLocaleString() }} {{ t.currency ?? 'FCFA' }}</span>
              <span :class="t.available_stock === 0 ? 'text-red-400' : 'text-white/30'" class="text-[10px] font-bold">
                {{ t.available_stock === 0 ? 'ÉPUISÉ' : `${t.available_stock} restants` }}
              </span>
            </div>
          </div>
          <div v-if="!ticketStats.length" class="px-6 py-8 text-center text-white/30 text-sm">Aucun billet</div>
        </div>
      </div>

    </div>

  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'admin', middleware: 'admin-auth' })

const { getDashboard } = useAdminApi()

const { data, pending } = await useAsyncData('admin-dashboard', getDashboard)

const kpis = computed(() => {
  const k = data.value?.kpis ?? {}
  return [
    {
      icon: '💰', label: 'Revenus total',
      value: (k.total_revenue ?? 0).toLocaleString() + ' FCFA',
    },
    {
      icon: '🎫', label: 'Commandes',
      value: k.total_orders ?? 0,
    },
    {
      icon: '✅', label: 'Billets émis',
      value: k.total_tickets ?? 0,
    },
    {
      icon: '⏳', label: 'En attente',
      value: k.pending_payments ?? 0,
      sub: k.pending_payments > 0 ? 'Paiements non confirmés' : null,
      subColor: 'text-yellow-400',
    },
  ]
})

const ticketStats    = computed(() => data.value?.ticket_stats ?? [])
const recentPayments = computed(() => data.value?.recent_payments ?? [])

function stockColor(t) {
  const pct = t.stock > 0 ? (t.sold / t.stock) * 100 : 0
  if (pct >= 100) return 'bg-red-500'
  if (pct >= 75)  return 'bg-yellow-500'
  return 'bg-green-500'
}
</script>
