<template>
  <div class="space-y-6 max-w-4xl">

    <!-- Back -->
    <NuxtLink to="/admin/commandes" class="inline-flex items-center gap-2 text-white/40 hover:text-white text-sm transition-colors">
      ← Retour aux commandes
    </NuxtLink>

    <div v-if="pending" class="text-center py-16 text-white/30">Chargement...</div>

    <template v-else-if="order">

      <!-- En-tête commande -->
      <div class="bg-[#141414] border border-white/5 rounded-2xl p-6 flex flex-wrap gap-6 items-start justify-between">
        <div>
          <div class="text-white/30 text-xs uppercase tracking-wider mb-1">Référence</div>
          <code class="text-gold font-mono text-lg font-black">{{ order.tx_ref }}</code>
          <div class="mt-3 flex items-center gap-3">
            <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider"
              :class="statusClass(order.status)">{{ statusLabel(order.status) }}</span>
            <span v-if="order.paid_at" class="text-white/30 text-xs">
              Payé le {{ formatDate(order.paid_at) }}
            </span>
          </div>
        </div>
        <div class="text-right">
          <div class="text-3xl font-black text-gold">{{ order.amount?.toLocaleString() }}</div>
          <div class="text-white/30 text-sm">{{ order.currency }}</div>
        </div>
      </div>

      <div class="grid md:grid-cols-2 gap-6">

        <!-- Infos client -->
        <div class="bg-[#141414] border border-white/5 rounded-2xl p-6">
          <h3 class="font-black text-sm uppercase tracking-wider text-white/50 mb-4">Client</h3>
          <div class="space-y-3">
            <div>
              <div class="text-white/30 text-xs mb-0.5">Nom</div>
              <div class="text-white font-bold">{{ order.customer_name }}</div>
            </div>
            <div>
              <div class="text-white/30 text-xs mb-0.5">Email</div>
              <div class="text-white">{{ order.customer_email }}</div>
            </div>
            <div v-if="order.customer_phone">
              <div class="text-white/30 text-xs mb-0.5">Téléphone</div>
              <div class="text-white">{{ order.customer_phone }}</div>
            </div>
          </div>
        </div>

        <!-- Articles commandés -->
        <div class="bg-[#141414] border border-white/5 rounded-2xl p-6">
          <h3 class="font-black text-sm uppercase tracking-wider text-white/50 mb-4">Articles</h3>
          <div class="space-y-2">
            <div v-for="(item, i) in cartItems" :key="i" class="flex justify-between text-sm">
              <span class="text-white/70">{{ item.name }} <span class="text-white/30">×{{ item.quantity }}</span></span>
              <span class="text-gold font-bold">{{ (item.unit_price * item.quantity).toLocaleString() }} FCFA</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Billets émis -->
      <div class="bg-[#141414] border border-white/5 rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-white/5 flex items-center justify-between">
          <h3 class="font-black text-sm uppercase tracking-wider text-white/70">
            Billets émis ({{ order.issued_tickets?.length ?? 0 }})
          </h3>
          <button v-if="order.status === 'completed'" @click="resend" :disabled="resending"
            class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-wider transition-all duration-200"
            :class="resending ? 'bg-gold/30 text-black/50 cursor-wait' : 'bg-gold text-black hover:bg-yellow-300'">
            {{ resending ? 'Envoi...' : '📧 Renvoyer les billets' }}
          </button>
        </div>
        <div v-if="!order.issued_tickets?.length" class="px-6 py-8 text-center text-white/30 text-sm">
          Aucun billet émis
        </div>
        <div v-else class="divide-y divide-white/5">
          <div v-for="ticket in order.issued_tickets" :key="ticket.uid"
            class="px-6 py-4 flex items-center gap-4">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center text-sm flex-shrink-0"
              :class="ticket.status === 'used' ? 'bg-white/5 text-white/30' : ticket.status === 'cancelled' ? 'bg-red-500/10 text-red-400' : 'bg-green-500/10 text-green-400'">
              {{ ticket.status === 'used' ? '✓✓' : ticket.status === 'cancelled' ? '✕' : '✓' }}
            </div>
            <div class="flex-1 min-w-0">
              <div class="text-white font-bold text-sm">{{ ticket.ticket_name }}</div>
              <code class="text-white/30 text-xs font-mono">{{ ticket.uid }}</code>
            </div>
            <div class="text-right flex-shrink-0">
              <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase"
                :class="ticketStatusClass(ticket.status)">{{ ticket.status }}</span>
              <div v-if="ticket.used_at" class="text-white/20 text-[10px] mt-1">
                Scanné {{ formatDate(ticket.used_at) }}
              </div>
              <div class="text-white/20 text-[10px] mt-1">
                Email {{ ticket.email_sent ? '✓ envoyé' : '✗ non envoyé' }}
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Toast -->
      <Transition name="fade">
        <div v-if="toast" class="fixed bottom-6 right-6 bg-[#1a1a1a] border border-white/10 rounded-2xl px-5 py-3 text-sm font-bold shadow-2xl"
          :class="toast.type === 'success' ? 'text-green-400' : 'text-red-400'">
          {{ toast.msg }}
        </div>
      </Transition>

    </template>

  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'admin', middleware: 'admin-auth' })

const route = useRoute()
const { getOrder, resendTickets } = useAdminApi()

const txRef = route.params.txRef as string
const { data, pending } = await useAsyncData(`order-${txRef}`, () => getOrder(txRef))

const order = computed(() => data.value?.data)
const cartItems = computed(() => {
  try {
    const raw = order.value?.cart_items
    return typeof raw === 'string' ? JSON.parse(raw) : (raw ?? [])
  } catch { return [] }
})

const resending = ref(false)
const toast = ref<{ msg: string; type: 'success' | 'error' } | null>(null)

function showToast(msg: string, type: 'success' | 'error' = 'success') {
  toast.value = { msg, type }
  setTimeout(() => { toast.value = null }, 3500)
}

async function resend() {
  resending.value = true
  try {
    const res = await resendTickets(txRef)
    showToast(res.message)
  } catch (e) {
    showToast(e?.data?.message ?? 'Erreur lors de l\'envoi', 'error')
  } finally {
    resending.value = false
  }
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

function ticketStatusClass(s: string) {
  return {
    active:    'bg-green-500/10 text-green-400',
    used:      'bg-white/5 text-white/30',
    cancelled: 'bg-red-500/10 text-red-400',
  }[s] ?? 'bg-white/5 text-white/30'
}

function formatDate(d: string) {
  if (!d) return '—'
  return new Date(d).toLocaleDateString('fr-FR', { day: '2-digit', month: 'short', hour: '2-digit', minute: '2-digit' })
}
</script>

<style scoped>
.fade-enter-active, .fade-leave-active { transition: opacity 0.2s, transform 0.2s; }
.fade-enter-from, .fade-leave-to       { opacity: 0; transform: translateY(8px); }
</style>
