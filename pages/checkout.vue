<template>
  <div class="min-h-screen bg-black text-white overflow-x-hidden" style="font-family: 'Nunito', sans-serif;">

    <!-- ═══════════════════════════════════════════════
         CHECKOUT HERO
    ══════════════════════════════════════════════════ -->
    <section class="relative min-h-[40vh] flex items-center overflow-hidden">
      <div class="absolute inset-0 z-0">
        <div class="checkout-hero-bg absolute inset-0" />
        <svg class="absolute inset-0 w-full h-full opacity-10" viewBox="0 0 1440 900" preserveAspectRatio="xMidYMid slice" fill="none">
          <line x1="-100" y1="900" x2="1200" y2="-50" stroke="#C9A84C" stroke-width="1"/>
          <line x1="100" y1="900" x2="1400" y2="-50" stroke="#C9A84C" stroke-width="0.5"/>
          <circle cx="720" cy="450" r="380" stroke="#C9A84C" stroke-width="0.5"/>
        </svg>
        <div class="noise-overlay absolute inset-0" />
      </div>
      <div class="relative z-10 container mx-auto px-6 pt-32 pb-16 text-center">
        <p class="text-gold-400 text-xs tracking-[0.5em] uppercase mb-4 animate-fade-up">PAIEMENT SÉCURISÉ</p>
        <h1 class="animate-fade-up" style="animation-delay:0.1s; font-family:'Bebas Neue',sans-serif;">
          <span class="block text-[clamp(2.5rem,6vw,5rem)] leading-none tracking-tight">Finalisez votre</span>
          <span class="block text-[clamp(3rem,8vw,6rem)] leading-none gradient-text-gold">commande</span>
        </h1>
      </div>
    </section>

    <div class="container mx-auto max-w-6xl px-6 py-12">

      <!-- Loading State -->
      <div v-if="loading" class="text-center py-20">
        <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-gold-500 mx-auto"></div>
        <p class="text-white/60 mt-6">Traitement de votre commande...</p>
      </div>

      <!-- Error State -->
      <div v-else-if="error" class="bg-red-600/20 border border-red-500/50 text-red-400 p-6 rounded-2xl mb-8 backdrop-blur-sm">
        <h3 class="text-xl font-bold mb-2">Erreur</h3>
        <p>{{ error }}</p>
        <button @click="clearError" class="mt-4 px-6 py-2 bg-red-600 text-white rounded-full hover:bg-red-700 transition-all">
          Fermer
        </button>
      </div>

      <!-- Success State -->
      <div v-else-if="orderSuccess" class="bg-green-600/20 border border-green-500/50 text-green-400 p-6 rounded-2xl mb-8 backdrop-blur-sm text-center">
        <div class="text-6xl mb-4">🎉</div>
        <h3 class="text-2xl font-bold mb-2">Commande confirmée !</h3>
        <p>Numéro de commande : <span class="font-mono text-gold-400">#{{ orderId }}</span></p>
        <p class="mt-2 text-white/70">Vous recevrez un email de confirmation avec vos tickets.</p>
        <div class="mt-6 space-x-4">
          <button @click="goHome" class="px-6 py-3 bg-gold-500 text-black font-bold rounded-full hover:bg-gold-400 transition-all">
            Retour à l'accueil
          </button>
          <button @click="viewOrder" class="px-6 py-3 border border-gold-500 text-gold-400 font-bold rounded-full hover:bg-gold-500/10 transition-all">
            Voir ma commande
          </button>
        </div>
      </div>

      <div v-else class="space-y-10">

        <!-- Event Selection Section -->
        <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden backdrop-blur-sm">
          <div class="border-b border-white/10 px-6 py-4">
            <h2 class="text-xl font-bold text-gold-400 uppercase tracking-wider" style="font-family:'Bebas Neue',sans-serif;">📅 Détails de l'événement</h2>
          </div>

          <div v-if="!selectedEventForCheckout && eventStore.eventLoading" class="text-center py-12">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-gold-500 mx-auto"></div>
            <p class="text-white/50 mt-4">Chargement de l'événement...</p>
          </div>

          <div v-else-if="!selectedEventForCheckout" class="text-center py-12">
            <p class="text-white/50 mb-6">Événement non trouvé ou invalide</p>
            <NuxtLink to="/" class="inline-block px-6 py-3 bg-gold-500 text-black font-bold rounded-full hover:bg-gold-400 transition-all">
              Retour aux événements
            </NuxtLink>
          </div>

          <div v-else class="p-6">
            <!-- Event Details -->
            <div class="bg-black/40 rounded-xl p-5 border border-white/5">
              <div class="flex flex-wrap justify-between items-start gap-4 mb-4">
                <div>
                  <h3 class="text-2xl font-bold text-white mb-2" style="font-family:'Bebas Neue',sans-serif;">{{ selectedEventForCheckout.title }}</h3>
                  <p class="text-gold-400 font-semibold">
                    Prix: {{ formatPrice(selectedEventForCheckout.price || 0) }} FCFA par ticket
                  </p>
                </div>
                <div class="text-right bg-black/40 px-4 py-2 rounded-lg">
                  <p class="text-white/50 text-xs uppercase tracking-wider">Places restantes</p>
                  <p class="text-2xl font-bold text-green-400">
                    {{ selectedEventForCheckout.capacity === 0
                      ? '∞'
                      : (selectedEventForCheckout.capacity - (selectedEventForCheckout.sold_count || 0)) }}
                  </p>
                </div>
              </div>

              <div class="grid md:grid-cols-2 gap-4 text-white/60 text-sm">
                <div class="space-y-2">
                  <p class="flex items-center gap-2">📅 Début: {{ formatDate(selectedEventForCheckout.start_at) }}</p>
                  <p class="flex items-center gap-2">📅 Fin: {{ formatDate(selectedEventForCheckout.end_at) }}</p>
                </div>
                <div class="space-y-2">
                  <p class="flex items-center gap-2">📍 Lieu: {{ selectedEventForCheckout.location || 'À définir' }}</p>
                  <p class="flex items-center gap-2">🎟️ Vendu: {{ selectedEventForCheckout.sold_count || 0 }}/{{
                    selectedEventForCheckout.capacity === 0 ? '∞' : selectedEventForCheckout.capacity
                  }}</p>
                </div>
              </div>

              <div v-if="selectedEventForCheckout.description" class="mt-4 p-4 bg-black/30 rounded-lg">
                <h4 class="font-semibold text-gold-400 text-sm uppercase tracking-wider mb-2">Description</h4>
                <p class="text-white/50 text-sm">{{ selectedEventForCheckout.description }}</p>
              </div>
            </div>

            <!-- Tickets Selection -->
            <div class="mt-6 pt-6 border-t border-white/10">
              <h4 class="font-bold text-white mb-4 uppercase tracking-wider text-sm">Sélection des tickets</h4>

              <!-- Ticket Type Selection -->
              <div v-if="selectedEventForCheckout.ticket_types && selectedEventForCheckout.ticket_types.length > 0" class="mb-6">
                <label class="block text-white/70 text-sm mb-3">Type de ticket *</label>
                <div class="grid gap-3">
                  <div v-for="ticketType in selectedEventForCheckout.ticket_types" :key="ticketType.slug"
                    @click="selectTicketType(ticketType)" :class="[
                      'p-4 rounded-xl border cursor-pointer transition-all duration-300',
                      selectedTicketType?.slug === ticketType.slug
                        ? 'border-gold-500 bg-gold-500/10'
                        : 'border-white/10 bg-white/5 hover:border-gold-500/50'
                    ]">
                    <div class="flex flex-wrap justify-between items-center gap-3">
                      <div>
                        <h4 class="font-semibold text-white">{{ ticketType.name }}</h4>
                        <p v-if="ticketType.description" class="text-sm text-white/40">{{ ticketType.description }}</p>
                      </div>
                      <div class="text-right">
                        <p class="text-gold-400 font-bold">{{ formatPrice(ticketType.price) }} FCFA</p>
                        <span v-if="ticketType.max_quantity > 0" class="text-xs text-white/30">
                          Max: {{ ticketType.max_quantity }}
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Quantity Selection -->
              <div v-if="selectedTicketType || (!selectedEventForCheckout.ticket_types || selectedEventForCheckout.ticket_types.length === 0)">
                <label class="block text-white/70 text-sm mb-3">Nombre de tickets *</label>
                <div class="flex flex-wrap items-center gap-4">
                  <div class="flex items-center gap-3 bg-white/5 rounded-lg p-1">
                    <button @click="decrementTickets" :disabled="ticketQuantity <= 1"
                      class="w-10 h-10 rounded-lg bg-white/10 text-white font-bold hover:bg-gold-500 hover:text-black transition-all disabled:opacity-50 disabled:cursor-not-allowed">−</button>
                    <input v-model.number="ticketQuantity" type="number" min="1" max="10"
                      class="w-16 text-center bg-transparent text-white text-lg font-bold focus:outline-none" />
                    <button @click="incrementTickets" :disabled="ticketQuantity >= 10"
                      class="w-10 h-10 rounded-lg bg-white/10 text-white font-bold hover:bg-gold-500 hover:text-black transition-all disabled:opacity-50 disabled:cursor-not-allowed">+</button>
                  </div>
                  <span class="text-white/40 text-sm">Max: 10 tickets</span>
                </div>

                <div class="mt-4 bg-gold-500/10 border border-gold-500/20 rounded-xl p-4">
                  <div class="flex justify-between items-center">
                    <span class="text-white">
                      Sous-total ({{ ticketQuantity }} ticket{{ ticketQuantity > 1 ? 's' : '' }}
                      {{ selectedTicketType ? ` - ${selectedTicketType.name}` : '' }})
                    </span>
                    <span class="text-gold-400 font-bold text-xl">
                      {{ formatPrice(getSelectedPrice() * ticketQuantity) }} FCFA
                    </span>
                  </div>
                </div>

                <button @click="addEventTicketsToCart" :disabled="ticketQuantity < 1 || !canAddToCart()"
                  class="w-full mt-4 px-6 py-3 bg-green-600/80 text-white font-bold rounded-xl hover:bg-green-600 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                  + Ajouter {{ ticketQuantity }} {{ ticketQuantity === 1 ? 'ticket' : 'tickets' }} au panier
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Main Grid : Cart + Form -->
        <div class="grid lg:grid-cols-2 gap-8">

          <!-- Colonne gauche : Récapitulatif + Paiement -->
          <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden backdrop-blur-sm">
            <div class="border-b border-white/10 px-6 py-4">
              <h2 class="text-xl font-bold text-gold-400 uppercase tracking-wider" style="font-family:'Bebas Neue',sans-serif;">🛒 Récapitulatif</h2>
            </div>

            <div class="p-6">
              <div v-if="cartStore.items.length === 0" class="text-center py-8">
                <div class="text-5xl mb-4">🛒</div>
                <p class="text-white/50 mb-6">Votre panier est vide</p>
                <NuxtLink to="/" class="inline-block px-6 py-3 bg-gold-500 text-black font-bold rounded-full hover:bg-gold-400 transition-all">
                  Retour aux événements
                </NuxtLink>
              </div>

              <div v-else>
                <div class="space-y-4 max-h-80 overflow-y-auto custom-scrollbar">
                  <div v-for="item in cartStore.items" :key="item.id"
                    class="flex justify-between items-center border-b border-white/10 pb-4">
                    <div>
                      <h3 class="font-semibold text-white">{{ item.name }}</h3>
                      <p class="text-sm text-white/40">Quantité : {{ item.quantity }}</p>
                    </div>
                    <div class="text-right">
                      <p class="font-bold text-gold-400">{{ formatPrice(item.price * item.quantity) }} FCFA</p>
                      <button @click="removeItem(item.id)" class="text-red-400 text-sm hover:text-red-300 transition-colors">
                        Retirer
                      </button>
                    </div>
                  </div>
                </div>

                <div class="mt-6 pt-4 border-t border-white/10">
                  <div class="flex justify-between text-xl font-bold">
                    <span class="text-white">Total :</span>
                    <span class="text-gold-400">{{ formatPrice(cartStore.total) }} FCFA</span>
                  </div>
                </div>
              </div>

              <!-- Section coupon -->
              <div v-if="cartStore.items.length > 0" class="mt-6 pt-4 border-t border-white/10">
                <h4 class="text-white/70 text-sm uppercase tracking-wider mb-3">🎁 Code promo</h4>

                <div v-if="couponApplied" class="bg-green-600/20 border border-green-500/30 rounded-xl p-3">
                  <div class="flex justify-between items-center">
                    <div>
                      <p class="text-green-400 font-bold text-sm flex items-center gap-2">✓ Code {{ couponApplied.code }} appliqué</p>
                      <p class="text-green-300/70 text-xs">
                        {{ couponApplied.type === 'percent'
                          ? `Réduction de ${couponApplied.value}%`
                          : `Réduction de ${formatPrice(couponApplied.value)} FCFA` }}
                      </p>
                    </div>
                    <button @click="removeCoupon" class="text-white/40 hover:text-red-400 transition-colors text-sm">
                      Retirer
                    </button>
                  </div>
                </div>

                <div v-else class="flex gap-3">
                  <input v-model="couponCode" type="text" placeholder="Ex : UKWC2026" @keyup.enter="applyCoupon"
                    :disabled="couponLoading"
                    class="flex-1 px-4 py-2.5 bg-white/5 text-white rounded-xl border border-white/10 focus:border-gold-500 focus:outline-none text-sm uppercase placeholder:normal-case placeholder:text-white/30" />
                  <button @click="applyCoupon" :disabled="couponLoading || !couponCode.trim()"
                    class="px-5 py-2.5 bg-gold-500 text-black font-bold rounded-xl hover:bg-gold-400 transition-all disabled:opacity-50 disabled:cursor-not-allowed whitespace-nowrap">
                    <span v-if="couponLoading" class="inline-block w-4 h-4 border-2 border-black border-t-transparent rounded-full animate-spin"></span>
                    <span v-else>Appliquer</span>
                  </button>
                </div>
                <p v-if="couponError" class="text-red-400 text-xs mt-2">{{ couponError }}</p>

                <!-- Récapitulatif avec réduction -->
                <div v-if="couponApplied" class="mt-4 space-y-2 p-4 bg-white/5 rounded-xl">
                  <div class="flex justify-between text-sm">
                    <span class="text-white/50">Sous-total</span>
                    <span class="text-white">{{ formatPrice(cartStore.total) }} FCFA</span>
                  </div>
                  <div class="flex justify-between text-sm text-green-400">
                    <span>Réduction ({{ couponApplied.code }})</span>
                    <span>- {{ formatPrice(discountAmount) }} FCFA</span>
                  </div>
                  <div class="flex justify-between text-lg font-bold border-t border-white/10 pt-3 mt-2">
                    <span class="text-white">Total à payer</span>
                    <span class="text-gold-400">{{ formatPrice(totalAfterDiscount) }} FCFA</span>
                  </div>
                </div>
              </div>

              <!-- Section paiement -->
              <div v-if="cartStore.items.length > 0" class="mt-6 pt-4 border-t border-white/10">
                <h3 class="text-white/70 text-sm uppercase tracking-wider mb-4">💳 Méthode de paiement *</h3>

                <div class="grid gap-2">
                  <div v-for="method in paymentMethods" :key="method.id" @click="selectedPaymentMethod = method.id"
                    :class="[
                      'flex items-center gap-4 p-3 rounded-xl border cursor-pointer transition-all duration-300',
                      selectedPaymentMethod === method.id
                        ? 'border-gold-500 bg-gold-500/10'
                        : 'border-white/10 bg-white/5 hover:border-gold-500/30'
                    ]">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-sm font-bold"
                      :style="{ background: method.iconBg, color: method.iconColor }">{{ method.icon }}</div>
                    <div class="flex-1">
                      <div class="font-semibold text-white text-sm">{{ method.label }}</div>
                      <div class="text-xs text-white/40">{{ method.subtitle }}</div>
                    </div>
                    <div :class="[
                      'w-5 h-5 rounded-full border-2 flex items-center justify-center',
                      selectedPaymentMethod === method.id ? 'border-gold-500' : 'border-white/30'
                    ]">
                      <div v-if="selectedPaymentMethod === method.id" class="w-2.5 h-2.5 rounded-full bg-gold-500" />
                    </div>
                  </div>
                </div>

                <p class="text-xs text-white/30 flex items-center gap-1 mt-4">
                  🔒 Paiement sécurisé via Flutterwave
                </p>
              </div>
            </div>
          </div>

          <!-- Colonne droite : Informations personnelles -->
          <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden backdrop-blur-sm">
            <div class="border-b border-white/10 px-6 py-4">
              <h2 class="text-xl font-bold text-gold-400 uppercase tracking-wider" style="font-family:'Bebas Neue',sans-serif;">👤 Vos informations</h2>
            </div>

            <div class="p-6">
              <form @submit.prevent="submitOrder" class="space-y-5">
                <div class="grid md:grid-cols-2 gap-4">
                  <div>
                    <label class="block text-white/60 text-sm mb-2">Prénom *</label>
                    <input v-model="customerInfo.firstName" type="text" required
                      class="w-full px-4 py-3 bg-white/5 text-white rounded-xl border border-white/10 focus:border-gold-500 focus:outline-none transition-all" />
                  </div>
                  <div>
                    <label class="block text-white/60 text-sm mb-2">Nom *</label>
                    <input v-model="customerInfo.lastName" type="text" required
                      class="w-full px-4 py-3 bg-white/5 text-white rounded-xl border border-white/10 focus:border-gold-500 focus:outline-none transition-all" />
                  </div>
                </div>

                <div>
                  <label class="block text-white/60 text-sm mb-2">Email *</label>
                  <input v-model="customerInfo.email" type="email" required
                    class="w-full px-4 py-3 bg-white/5 text-white rounded-xl border border-white/10 focus:border-gold-500 focus:outline-none transition-all" />
                </div>

                <div>
                  <label class="block text-white/60 text-sm mb-2">Téléphone</label>
                  <input v-model="customerInfo.phone" type="tel"
                    class="w-full px-4 py-3 bg-white/5 text-white rounded-xl border border-white/10 focus:border-gold-500 focus:outline-none transition-all" />
                </div>

                <div>
                  <label class="block text-white/60 text-sm mb-2">Adresse</label>
                  <textarea v-model="customerInfo.address" rows="3"
                    class="w-full px-4 py-3 bg-white/5 text-white rounded-xl border border-white/10 focus:border-gold-500 focus:outline-none transition-all resize-none" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                  <div>
                    <label class="block text-white/60 text-sm mb-2">Code postal</label>
                    <input v-model="customerInfo.postcode" type="text"
                      class="w-full px-4 py-3 bg-white/5 text-white rounded-xl border border-white/10 focus:border-gold-500 focus:outline-none transition-all" />
                  </div>
                  <div>
                    <label class="block text-white/60 text-sm mb-2">Ville</label>
                    <input v-model="customerInfo.city" type="text"
                      class="w-full px-4 py-3 bg-white/5 text-white rounded-xl border border-white/10 focus:border-gold-500 focus:outline-none transition-all" />
                  </div>
                </div>

                <label class="flex items-center gap-3 cursor-pointer">
                  <input v-model="acceptTerms" type="checkbox" required class="w-4 h-4 accent-gold-500" />
                  <span class="text-white/70 text-sm">
                    J'accepte les <a href="#" class="text-gold-400 hover:underline">conditions générales de vente</a> *
                  </span>
                </label>

                <button type="submit" :disabled="!canSubmit"
                  class="w-full py-4 bg-gold-500 text-black font-bold rounded-xl hover:bg-gold-400 transition-all disabled:opacity-50 disabled:cursor-not-allowed text-lg uppercase tracking-wider">
                  {{ submitLabel }}
                </button>
              </form>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute } from '#app'
import { useCartStore } from '~/stores/cart'
import { useEventStore } from '~/stores/event'

const { openPaymentModal } = useFlutterwave()

const cartStore = useCartStore()
const eventStore = useEventStore()
const route = useRoute()

// ── État local ────────────────────────────────────────────────────────────────
const loading = ref(false)
const error = ref(null)
const orderSuccess = ref(false)
const orderId = ref(null)
const acceptTerms = ref(false)
const selectedEventForCheckout = ref(null)
const ticketQuantity = ref(1)
const selectedTicketType = ref(null)
const selectedPaymentMethod = ref('card')

const customerInfo = ref({
  firstName: '',
  lastName: '',
  email: '',
  phone: '',
  address: '',
  postcode: '',
  city: '',
})

// ── Coupon ────────────────────────────────────────────────────────────────────
const couponCode = ref('')
const couponLoading = ref(false)
const couponError = ref(null)
const couponApplied = ref(null)

const applyCoupon = async () => {
  if (!couponCode.value.trim()) return

  couponLoading.value = true
  couponError.value = null
  couponApplied.value = null

  try {
    const config = useRuntimeConfig()
    const wpBase = config.public.wpApiUrl.replace('/wp-json', '')

    const res = await $fetch(`${wpBase}/wp-json/eventflow/v1/coupons/validate`, {
      method: 'POST',
      body: {
        code: couponCode.value.trim().toUpperCase(),
        event_id: selectedEventForCheckout.value?.id ?? null,
        price: cartStore.total,
      },
    })

    if (res.success) {
      couponApplied.value = res.data
    }
  } catch (err) {
    couponError.value = err?.data?.message ?? err?.message ?? 'Code promo invalide.'
  } finally {
    couponLoading.value = false
  }
}

const removeCoupon = () => {
  couponApplied.value = null
  couponCode.value = ''
  couponError.value = null
}

const totalAfterDiscount = computed(() => {
  if (!couponApplied.value) return cartStore.total
  if (couponApplied.value.type === 'percent') {
    return cartStore.total - (cartStore.total * couponApplied.value.value / 100)
  }
  return Math.max(0, cartStore.total - couponApplied.value.value)
})

const discountAmount = computed(() => {
  if (!couponApplied.value) return 0
  return cartStore.total - totalAfterDiscount.value
})

// ── Méthodes de paiement ────────────────────────────────────────────────────
const paymentMethods = [
  { id: 'card', label: 'Carte bancaire', subtitle: 'Visa, Mastercard, Carte locale', icon: '💳', iconBg: '#1e3a5f', iconColor: '#93c5fd' },
  { id: 'mtn', label: 'MTN Mobile Money', subtitle: "Côte d'Ivoire, Ghana, Cameroun...", icon: 'MTN', iconBg: '#92400e', iconColor: '#fcd34d' },
  { id: 'wave', label: 'Wave', subtitle: "Sénégal, Côte d'Ivoire, Mali...", icon: '〜', iconBg: '#064e3b', iconColor: '#6ee7b7' },
  { id: 'orange', label: 'Orange Money', subtitle: "Toute l'Afrique de l'Ouest", icon: '●', iconBg: '#7c2d12', iconColor: '#fb923c' },
  { id: 'moov', label: 'Moov Money', subtitle: "Côte d'Ivoire, Bénin, Togo...", icon: 'MV', iconBg: '#1e3a5f', iconColor: '#93c5fd' },
]

// ── Computed ──────────────────────────────────────────────────────────────────
const canSubmit = computed(() =>
  cartStore.items.length > 0 &&
  customerInfo.value.firstName &&
  customerInfo.value.lastName &&
  customerInfo.value.email &&
  acceptTerms.value
)

const submitLabel = computed(() => {
  const method = paymentMethods.find(m => m.id === selectedPaymentMethod.value)
  if (!method) return 'Confirmer la commande'
  return selectedPaymentMethod.value === 'card'
    ? 'Payer par carte'
    : `Payer via ${method.label}`
})

// ── Helpers ───────────────────────────────────────────────────────────────────
const formatPrice = (price) => new Intl.NumberFormat('fr-FR').format(parseFloat(price))

const formatDate = (isoString) => {
  if (!isoString) return 'Date à définir'
  return new Intl.DateTimeFormat('fr-FR', {
    day: '2-digit', month: 'long', year: 'numeric',
    hour: '2-digit', minute: '2-digit',
  }).format(new Date(isoString))
}

// ── Actions événement ─────────────────────────────────────────────────────────
const loadEventById = async (eventId) => {
  try {
    const event = await eventStore.fetchEvent(eventId)
    if (event) {
      selectedEventForCheckout.value = event
      if (event.ticket_types?.length > 0) {
        selectedTicketType.value = event.ticket_types[0]
      }
    } else {
      error.value = 'Événement non trouvé'
    }
  } catch (err) {
    console.error('Erreur chargement événement:', err)
    error.value = 'Impossible de charger l\'événement'
  }
}

const selectTicketType = (ticketType) => {
  selectedTicketType.value = ticketType
  ticketQuantity.value = 1
}

const decrementTickets = () => { if (ticketQuantity.value > 1) ticketQuantity.value-- }
const incrementTickets = () => { if (ticketQuantity.value < 10) ticketQuantity.value++ }

const getSelectedPrice = () =>
  selectedTicketType.value
    ? selectedTicketType.value.price
    : (selectedEventForCheckout.value?.price || 0)

const canAddToCart = () => {
  if (!selectedEventForCheckout.value) return false
  if (!selectedEventForCheckout.value.available) return false
  if (selectedTicketType.value?.max_quantity > 0) {
    return ticketQuantity.value <= selectedTicketType.value.max_quantity
  }
  return true
}

const addEventTicketsToCart = () => {
  if (!selectedEventForCheckout.value) return
  const evt = selectedEventForCheckout.value
  const ticketType = selectedTicketType.value

  cartStore.addItem({
    id: evt.id,
    name: `${evt.title} — ${ticketType ? ticketType.name : 'Ticket'}`,
    price: getSelectedPrice(),
    quantity: ticketQuantity.value,
    eventId: evt.id,
    ticketType: ticketType ? ticketType.slug : 'standard',
  })

  ticketQuantity.value = 1
}

// ── Actions panier ────────────────────────────────────────────────────────────
const removeItem = (itemId) => cartStore.removeItem(itemId)
const clearError = () => { error.value = null }

// ── Soumission ────────────────────────────────────────────────────────────────
const submitOrder = async () => {
  if (!canSubmit.value) return

  loading.value = true
  error.value = null

  try {
    const tx_ref = `PKC-${Date.now()}-${Math.random().toString(36).slice(2, 6).toUpperCase()}`

    const result = await $fetch('/api/create-payment', {
      method: 'POST',
      body: {
        tx_ref,
        total: totalAfterDiscount.value,
        coupon: couponApplied.value,
        customer: customerInfo.value,
        cartItems: cartStore.items.map(item => ({
          id: item.eventId ?? item.id,
          name: item.name,
          price: item.price,
          quantity: item.quantity,
          ticketType: item.ticketType ?? 'standard',
          eventId: item.eventId,
        })),
      },
    })

    window.location.href = result.payment_url
  } catch (err) {
    error.value = err?.message ?? "Impossible d'initier le paiement."
    loading.value = false
  }
}

// ── Navigation ────────────────────────────────────────────────────────────────
const goHome = () => navigateTo('/')
const viewOrder = () => navigateTo(`/order/${orderId.value}`)

// ── Initialisation ────────────────────────────────────────────────────────────
onMounted(async () => {
  eventStore.cleanExpiredCache()
  const eventId = route.query.event_id
  if (eventId) {
    await loadEventById(eventId)
  } else {
    error.value = "Aucun événement spécifié dans l'URL"
  }
})
</script>

<style scoped>
.checkout-hero-bg {
  background: radial-gradient(ellipse 70% 60% at 20% 60%, rgba(201,168,76,0.13) 0%, transparent 70%),
              radial-gradient(ellipse 50% 40% at 80% 30%, rgba(139,105,20,0.08) 0%, transparent 70%),
              #000;
}

.noise-overlay {
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='1'/%3E%3C/svg%3E");
  opacity: 0.03;
  pointer-events: none;
}

.gradient-text-gold {
  background: linear-gradient(135deg, #C9A84C 0%, #F5D78A 40%, #C9A84C 70%, #8B6914 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

@keyframes fade-up {
  from { opacity: 0; transform: translateY(24px); }
  to { opacity: 1; transform: translateY(0); }
}

.animate-fade-up {
  animation: fade-up 0.7s ease forwards;
  opacity: 0;
}

.custom-scrollbar::-webkit-scrollbar {
  width: 4px;
}

.custom-scrollbar::-webkit-scrollbar-track {
  background: rgba(255,255,255,0.05);
  border-radius: 4px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
  background: rgba(201,168,76,0.5);
  border-radius: 4px;
}

input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
  opacity: 0.5;
}
</style>