<template>
  <div class="space-y-6">

    <!-- Filtres -->
    <div class="flex flex-wrap gap-3">
      <input v-model="search" @input="debouncedFetch" type="text" placeholder="Rechercher par nom, email, référence..."
        class="flex-1 min-w-[240px] bg-[#141414] border border-white/10 rounded-xl px-4 py-2.5 text-white placeholder-white/20 text-sm focus:outline-none focus:border-gold/50 transition-colors" />
      <select v-model="statusFilter" @change="fetchOrders"
        class="bg-[#141414] border border-white/10 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-gold/50 transition-colors">
        <option value="">Tous les statuts</option>
        <option value="completed">Confirmé</option>
        <option value="pending">En attente</option>
        <option value="failed">Échoué</option>
        <option value="cancelled">Annulé</option>
      </select>
    </div>

    <!-- Table -->
    <div class="bg-[#141414] border border-white/5 rounded-2xl overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead>
            <tr class="border-b border-white/5 text-white/30 text-[11px] uppercase tracking-wider">
              <th class="px-6 py-3 text-left">Référence</th>
              <th class="px-6 py-3 text-left">Client</th>
              <th class="px-6 py-3 text-left hidden md:table-cell">Billets</th>
              <th class="px-6 py-3 text-right">Montant</th>
              <th class="px-6 py-3 text-center">Statut</th>
              <th class="px-6 py-3 text-left hidden lg:table-cell">Date</th>
              <th class="px-6 py-3"></th>
            </tr>
          </thead>
          <tbody class="divide-y divide-white/5">
            <tr v-if="loading">
              <td colspan="7" class="px-6 py-12 text-center text-white/30">Chargement...</td>
            </tr>
            <tr v-else-if="!orders.length">
              <td colspan="7" class="px-6 py-12 text-center text-white/30">Aucune commande trouvée</td>
            </tr>
            <tr v-for="order in orders" :key="order.tx_ref"
              class="hover:bg-white/2 transition-colors cursor-pointer"
              @click="router.push(`/admin/commandes/${order.tx_ref}`)">
              <td class="px-6 py-4">
                <code class="text-gold text-xs font-mono">{{ order.tx_ref?.slice(-12) }}</code>
              </td>
              <td class="px-6 py-4">
                <div class="font-bold text-white">{{ order.customer_name }}</div>
                <div class="text-white/30 text-xs">{{ order.customer_email }}</div>
              </td>
              <td class="px-6 py-4 hidden md:table-cell text-white/60">
                {{ order.issued_tickets?.length ?? 0 }} billet{{ (order.issued_tickets?.length ?? 0) > 1 ? 's' : '' }}
              </td>
              <td class="px-6 py-4 text-right font-black text-gold">
                {{ order.amount?.toLocaleString() }} <span class="text-white/30 font-normal text-xs">{{ order.currency }}</span>
              </td>
              <td class="px-6 py-4 text-center">
                <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider"
                  :class="statusClass(order.status)">
                  {{ statusLabel(order.status) }}
                </span>
              </td>
              <td class="px-6 py-4 text-white/30 text-xs hidden lg:table-cell">
                {{ formatDate(order.paid_at ?? order.created_at) }}
              </td>
              <td class="px-6 py-4 text-white/20 hover:text-gold">→</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div v-if="pagination" class="px-6 py-4 border-t border-white/5 flex items-center justify-between text-sm">
        <span class="text-white/30 text-xs">{{ pagination.total }} commande{{ pagination.total > 1 ? 's' : '' }}</span>
        <div class="flex gap-2">
          <button :disabled="pagination.current_page <= 1" @click="changePage(pagination.current_page - 1)"
            class="px-3 py-1.5 rounded-lg border border-white/10 text-white/40 hover:text-white hover:border-white/30 disabled:opacity-30 disabled:cursor-not-allowed transition-all text-xs">
            ← Préc
          </button>
          <span class="px-3 py-1.5 text-white/50 text-xs">{{ pagination.current_page }}/{{ pagination.last_page }}</span>
          <button :disabled="pagination.current_page >= pagination.last_page" @click="changePage(pagination.current_page + 1)"
            class="px-3 py-1.5 rounded-lg border border-white/10 text-white/40 hover:text-white hover:border-white/30 disabled:opacity-30 disabled:cursor-not-allowed transition-all text-xs">
            Suiv →
          </button>
        </div>
      </div>
    </div>

  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'admin', middleware: 'admin-auth' })

const router = useRouter()
const { getOrders } = useAdminApi()

const orders     = ref([])
const pagination = ref(null)
const loading    = ref(false)
const search     = ref('')
const statusFilter = ref('')
const page       = ref(1)

let debounceTimer: ReturnType<typeof setTimeout>

async function fetchOrders() {
  loading.value = true
  try {
    const params: Record<string, string> = { page: String(page.value) }
    if (search.value)       params.search = search.value
    if (statusFilter.value) params.status = statusFilter.value

    const res = await getOrders(params)
    orders.value     = res.data ?? []
    pagination.value = {
      total: res.total,
      current_page: res.current_page,
      last_page: res.last_page,
    }
  } finally {
    loading.value = false
  }
}

function debouncedFetch() {
  clearTimeout(debounceTimer)
  debounceTimer = setTimeout(fetchOrders, 400)
}

function changePage(p: number) {
  page.value = p
  fetchOrders()
}

function statusClass(s: string) {
  return {
    completed: 'bg-green-500/10 text-green-400 border border-green-500/20',
    pending:   'bg-yellow-500/10 text-yellow-400 border border-yellow-500/20',
    failed:    'bg-red-500/10 text-red-400 border border-red-500/20',
    cancelled: 'bg-white/5 text-white/30 border border-white/10',
  }[s] ?? 'bg-white/5 text-white/30'
}

function statusLabel(s: string) {
  return { completed: 'Confirmé', pending: 'En attente', failed: 'Échoué', cancelled: 'Annulé' }[s] ?? s
}

function formatDate(d: string) {
  if (!d) return '—'
  return new Date(d).toLocaleDateString('fr-FR', { day: '2-digit', month: 'short', year: 'numeric' })
}

onMounted(fetchOrders)
</script>
