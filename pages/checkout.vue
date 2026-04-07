<template>
  <div class="min-h-screen bg-gradient-to-b from-black to-gray-900 py-20 px-4">
    <div class="container mx-auto max-w-4xl">
      <h1 class="text-4xl font-bold text-center mb-8 text-gold-500">Checkout</h1>

      <!-- Loading State -->
      <div v-if="loading" class="text-center py-12">
        <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-gold-500 mx-auto"></div>
        <p class="text-white mt-4">Traitement de votre commande...</p>
      </div>

      <!-- Error State -->
      <div v-else-if="error" class="bg-red-600 text-white p-6 rounded-lg mb-8">
        <h3 class="text-xl font-bold mb-2">Erreur</h3>
        <p>{{ error }}</p>
        <button @click="clearError" class="mt-4 px-4 py-2 bg-white text-red-600 rounded">
          Fermer
        </button>
      </div>

      <!-- Success State -->
      <div v-else-if="orderSuccess" class="bg-green-600 text-white p-6 rounded-lg mb-8">
        <h3 class="text-xl font-bold mb-2">Commande confirmée !</h3>
        <p>Numéro de commande : #{{ orderId }}</p>
        <p class="mt-2">Vous recevrez un email de confirmation avec vos tickets.</p>
        <div class="mt-4 space-x-4">
          <button @click="goHome" class="px-6 py-2 bg-white text-green-600 rounded">
            Retour à l'accueil
          </button>
          <button @click="viewOrder" class="px-6 py-2 border border-white text-white rounded">
            Voir ma commande
          </button>
        </div>
      </div>

      <div v-else class="space-y-8">

        <!-- Event Selection Section -->
        <div class="bg-gray-800 p-6 rounded-lg">
          <h2 class="text-2xl font-bold mb-6 text-gold-500">Détails de l'événement</h2>

          <div v-if="!selectedEventForCheckout && eventStore.eventLoading" class="text-center py-8">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-gold-500 mx-auto"></div>
            <p class="text-white mt-4">Chargement de l'événement...</p>
          </div>

          <div v-else-if="!selectedEventForCheckout" class="text-center py-8">
            <p class="text-gray-400 mb-4">Événement non trouvé ou invalide</p>
            <NuxtLink to="/" class="btn-primary">Retour aux événements</NuxtLink>
          </div>

          <div v-else class="space-y-6">
            <!-- Event Details -->
            <div class="p-6 bg-gray-700 rounded-lg">
              <div class="flex justify-between items-start mb-4">
                <div>
                  <h3 class="text-2xl font-bold text-white mb-2">{{ selectedEventForCheckout.title }}</h3>
                  <p class="text-gold-500 font-semibold mb-2">
                    Prix: {{ formatPrice(selectedEventForCheckout.price || 0) }} FCFA par ticket
                  </p>
                </div>
                <div class="text-right">
                  <p class="text-gray-400">Places restantes</p>
                  <p class="text-xl font-bold text-green-400">
                    {{ selectedEventForCheckout.capacity === 0
                      ? '∞'
                      : (selectedEventForCheckout.capacity - (selectedEventForCheckout.sold_count || 0)) }}
                  </p>
                </div>
              </div>

              <div class="grid md:grid-cols-2 gap-4 text-gray-300">
                <div>
                  <p class="flex items-center mb-2">
                    <svg class="w-5 h-5 mr-2 text-gold-500" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                    </svg>
                    📅 Début: {{ formatDate(selectedEventForCheckout.start_at) }}
                  </p>
                  <p class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gold-500" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                    </svg>
                    📅 Fin: {{ formatDate(selectedEventForCheckout.end_at) }}
                  </p>
                </div>
                <div>
                  <p class="flex items-center mb-2">
                    <svg class="w-5 h-5 mr-2 text-gold-500" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                    </svg>
                    📍 Lieu: {{ selectedEventForCheckout.location || 'À définir' }}
                  </p>
                  <p class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gold-500" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                    </svg>
                    🎟️ Vendu: {{ selectedEventForCheckout.sold_count || 0 }}/{{
                      selectedEventForCheckout.capacity === 0 ? '∞' : selectedEventForCheckout.capacity
                    }}
                  </p>
                </div>
              </div>

              <div v-if="selectedEventForCheckout.description" class="mt-4 p-4 bg-gray-600 rounded">
                <h4 class="font-semibold text-white mb-2">Description</h4>
                <p class="text-gray-300">{{ selectedEventForCheckout.description }}</p>
              </div>
            </div>

            <!-- Tickets Selection -->
            <div class="border-t border-gray-600 pt-6">
              <!-- Ticket Type Selection -->
              <div v-if="selectedEventForCheckout.ticket_types && selectedEventForCheckout.ticket_types.length > 0"
                class="mb-6">
                <label class="block text-white font-bold mb-3">Type de ticket *</label>
                <div class="space-y-3">
                  <div v-for="ticketType in selectedEventForCheckout.ticket_types" :key="ticketType.slug"
                    @click="selectTicketType(ticketType)" :class="[
                      'p-4 border rounded cursor-pointer transition-colors',
                      selectedTicketType?.slug === ticketType.slug
                        ? 'border-gold-500 bg-gray-700'
                        : 'border-gray-600 hover:bg-gray-700'
                    ]">
                    <div class="flex justify-between items-center">
                      <div>
                        <h4 class="font-semibold text-white">{{ ticketType.name }}</h4>
                        <p v-if="ticketType.description" class="text-sm text-gray-400">{{ ticketType.description }}</p>
                        <p class="text-gold-500 font-bold">{{ formatPrice(ticketType.price) }} FCFA</p>
                      </div>
                      <div class="text-right">
                        <span v-if="ticketType.max_quantity > 0" class="text-xs text-gray-400">
                          Max: {{ ticketType.max_quantity }}
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Quantity Selection -->
              <div
                v-if="selectedTicketType || (!selectedEventForCheckout.ticket_types || selectedEventForCheckout.ticket_types.length === 0)">
                <label class="block text-white font-bold mb-3">Nombre de tickets *</label>
                <div class="space-y-3">
                  <div class="flex items-center gap-4">
                    <button @click="decrementTickets" :disabled="ticketQuantity <= 1"
                      class="px-4 py-2 bg-gray-700 text-white rounded disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-600">−</button>
                    <input v-model.number="ticketQuantity" type="number" min="1" max="10"
                      class="w-20 p-2 bg-gray-700 text-white text-center rounded border border-gray-600 focus:border-gold-500 focus:outline-none" />
                    <button @click="incrementTickets" :disabled="ticketQuantity >= 10"
                      class="px-4 py-2 bg-gray-700 text-white rounded disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-600">+</button>
                    <span class="text-gray-400">Max: 10 tickets</span>
                  </div>

                  <div class="bg-gray-700 p-4 rounded">
                    <div class="flex justify-between items-center">
                      <span class="text-white">
                        Sous-total ({{ ticketQuantity }} ticket{{ ticketQuantity > 1 ? 's' : '' }}
                        {{ selectedTicketType ? ` - ${selectedTicketType.name}` : '' }})
                      </span>
                      <span class="text-gold-500 font-bold text-xl">
                        {{ formatPrice(getSelectedPrice() * ticketQuantity) }} FCFA
                      </span>
                    </div>
                  </div>

                  <button @click="addEventTicketsToCart" :disabled="ticketQuantity < 1 || !canAddToCart()"
                    class="w-full px-6 py-3 bg-green-600 text-white font-bold rounded hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed">
                    Ajouter {{ ticketQuantity }} {{ ticketQuantity === 1 ? 'ticket' : 'tickets' }} au panier
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Main Grid : Cart + Form -->
        <div class="grid md:grid-cols-2 gap-8">

          <!-- Colonne gauche : Récapitulatif + Paiement -->
          <div class="bg-gray-800 p-6 rounded-lg">
            <h2 class="text-2xl font-bold mb-6 text-gold-500">Récapitulatif</h2>

            <div v-if="cartStore.items.length === 0" class="text-center py-8">
              <p class="text-gray-400 mb-4">Votre panier est vide</p>
              <NuxtLink to="/" class="btn-primary">Retour aux événements</NuxtLink>
            </div>

            <div v-else>
              <div class="space-y-4 mb-6">
                <div v-for="item in cartStore.items" :key="item.id"
                  class="flex justify-between items-center border-b border-gray-600 pb-4">
                  <div>
                    <h3 class="font-semibold text-white">{{ item.name }}</h3>
                    <p class="text-sm text-gray-400">Quantité : {{ item.quantity }}</p>
                  </div>
                  <div class="text-right">
                    <p class="font-bold text-gold-500">{{ formatPrice(item.price * item.quantity) }} FCFA</p>
                    <button @click="removeItem(item.id)" class="text-red-400 text-sm hover:text-red-300">
                      Retirer
                    </button>
                  </div>
                </div>
              </div>
              <div class="border-t border-gray-600 pt-4">
                <div class="flex justify-between text-xl font-bold">
                  <span class="text-white">Total :</span>
                  <span class="text-gold-500">{{ formatPrice(cartStore.total) }} FCFA</span>
                </div>
              </div>
            </div>

            <!-- ── Section coupon ────────────────────────────────────────────────── -->
            <div v-if="cartStore.items.length > 0" class="border-t border-gray-600 mt-4 pt-4">

              <!-- Coupon déjà appliqué -->
              <div v-if="couponApplied" class="bg-green-900 border border-green-600 rounded-lg p-3 mb-3">
                <div class="flex justify-between items-center">
                  <div>
                    <p class="text-green-400 font-bold text-sm flex items-center gap-2">
                      <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                          d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                          clip-rule="evenodd" />
                      </svg>
                      Code {{ couponApplied.code }} appliqué
                    </p>
                    <p class="text-green-300 text-xs mt-1">
                      {{ couponApplied.type === 'percent'
                        ? `Réduction de ${couponApplied.value}%`
                        : `Réduction de ${formatPrice(couponApplied.value)} FCFA` }}
                    </p>
                  </div>
                  <button @click="removeCoupon" class="text-gray-400 hover:text-red-400 transition-colors text-xs">
                    Retirer
                  </button>
                </div>
              </div>

              <!-- Saisie du coupon -->
              <div v-else>
                <label class="block text-gray-400 text-sm mb-2">Code promo</label>
                <div class="flex gap-2">
                  <input v-model="couponCode" type="text" placeholder="Ex : PKC2026" @keyup.enter="applyCoupon"
                    :disabled="couponLoading"
                    class="flex-1 p-2.5 bg-gray-700 text-white rounded border border-gray-600 focus:border-gold-500 focus:outline-none text-sm uppercase placeholder:normal-case placeholder:text-gray-500" />
                  <button @click="applyCoupon" :disabled="couponLoading || !couponCode.trim()"
                    class="px-4 py-2.5 bg-gold-500 text-black font-bold rounded text-sm hover:bg-gold-600 disabled:opacity-50 disabled:cursor-not-allowed whitespace-nowrap">
                    <span v-if="couponLoading">
                      <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
                      </svg>
                    </span>
                    <span v-else>Appliquer</span>
                  </button>
                </div>
                <p v-if="couponError" class="text-red-400 text-xs mt-2">{{ couponError }}</p>
              </div>

              <!-- Récapitulatif des prix avec réduction -->
              <div v-if="couponApplied" class="mt-4 space-y-2">
                <div class="flex justify-between text-sm">
                  <span class="text-gray-400">Sous-total</span>
                  <span class="text-white">{{ formatPrice(cartStore.total) }} FCFA</span>
                </div>
                <div class="flex justify-between text-sm text-green-400">
                  <span>Réduction ({{ couponApplied.code }})</span>
                  <span>- {{ formatPrice(discountAmount) }} FCFA</span>
                </div>
                <div class="flex justify-between text-xl font-bold border-t border-gray-600 pt-2 mt-2">
                  <span class="text-white">Total à payer</span>
                  <span class="text-gold-500">{{ formatPrice(totalAfterDiscount) }} FCFA</span>
                </div>
              </div>

            </div>

            <!-- ── Section paiement (visible uniquement si panier non vide) ── -->
            <div v-if="cartStore.items.length > 0" class="border-t border-gray-600 mt-6 pt-6">
              <h3 class="text-lg font-bold text-white mb-4">Méthode de paiement *</h3>

              <!-- Note : Flutterwave gère nativement Carte + MTN + Orange + Wave + Moov.
                   Cette section est purement visuelle / indicative.
                   Le modal Flutterwave s'ouvrira avec toutes les options au clic sur "Payer". -->
              <div class="space-y-2 mb-4">
                <div v-for="method in paymentMethods" :key="method.id" @click="selectedPaymentMethod = method.id"
                  :class="[
                    'flex items-center gap-3 p-3 rounded-lg border cursor-pointer transition-all',
                    selectedPaymentMethod === method.id
                      ? 'border-gold-500 bg-gray-700'
                      : 'border-gray-600 hover:bg-gray-700'
                  ]">
                  <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0 text-xs font-bold"
                    :style="{ background: method.iconBg, color: method.iconColor }">{{ method.icon }}</div>
                  <div class="flex-1 min-w-0">
                    <div class="font-semibold text-white text-sm">{{ method.label }}</div>
                    <div class="text-xs text-gray-400 truncate">{{ method.subtitle }}</div>
                  </div>
                  <div :class="[
                    'w-4 h-4 rounded-full border-2 flex items-center justify-center flex-shrink-0',
                    selectedPaymentMethod === method.id ? 'border-yellow-500' : 'border-gray-500'
                  ]">
                    <div v-if="selectedPaymentMethod === method.id" class="w-2 h-2 rounded-full bg-yellow-500" />
                  </div>
                </div>
              </div>

              <!-- Info sécurité Flutterwave -->
              <p class="text-xs text-gray-400 flex items-center gap-1 mt-3">
                <svg class="w-3 h-3 text-green-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                    clip-rule="evenodd" />
                </svg>
                Paiement sécurisé via Flutterwave
              </p>
            </div>
          </div>

          <!-- Colonne droite : Informations personnelles -->
          <div class="bg-gray-800 p-6 rounded-lg">
            <h2 class="text-2xl font-bold mb-6 text-gold-500">Informations personnelles</h2>

            <form @submit.prevent="submitOrder" class="space-y-4">
              <div class="grid md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-white mb-2">Prénom *</label>
                  <input v-model="customerInfo.firstName" type="text" required
                    class="w-full p-3 bg-gray-700 text-white rounded border border-gray-600 focus:border-gold-500 focus:outline-none" />
                </div>
                <div>
                  <label class="block text-white mb-2">Nom *</label>
                  <input v-model="customerInfo.lastName" type="text" required
                    class="w-full p-3 bg-gray-700 text-white rounded border border-gray-600 focus:border-gold-500 focus:outline-none" />
                </div>
              </div>

              <div>
                <label class="block text-white mb-2">Email *</label>
                <input v-model="customerInfo.email" type="email" required
                  class="w-full p-3 bg-gray-700 text-white rounded border border-gray-600 focus:border-gold-500 focus:outline-none" />
              </div>

              <div>
                <label class="block text-white mb-2">Téléphone</label>
                <input v-model="customerInfo.phone" type="tel"
                  class="w-full p-3 bg-gray-700 text-white rounded border border-gray-600 focus:border-gold-500 focus:outline-none" />
              </div>

              <div>
                <label class="block text-white mb-2">Adresse</label>
                <textarea v-model="customerInfo.address" rows="3"
                  class="w-full p-3 bg-gray-700 text-white rounded border border-gray-600 focus:border-gold-500 focus:outline-none" />
              </div>

              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label class="block text-white mb-2">Code postal</label>
                  <input v-model="customerInfo.postcode" type="text"
                    class="w-full p-3 bg-gray-700 text-white rounded border border-gray-600 focus:border-gold-500 focus:outline-none" />
                </div>
                <div>
                  <label class="block text-white mb-2">Ville</label>
                  <input v-model="customerInfo.city" type="text"
                    class="w-full p-3 bg-gray-700 text-white rounded border border-gray-600 focus:border-gold-500 focus:outline-none" />
                </div>
              </div>

              <div class="flex items-center">
                <input v-model="acceptTerms" type="checkbox" id="terms" required class="mr-2" />
                <label for="terms" class="text-white text-sm">
                  J'accepte les <a href="#" class="text-gold-500 underline">conditions générales de vente</a> *
                </label>
              </div>

              <button type="submit" :disabled="!canSubmit"
                class="w-full btn-primary disabled:opacity-50 disabled:cursor-not-allowed">
                {{ submitLabel }}
              </button>
            </form>
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

// ✅ Import correct : composable LOCAL dans ~/composables/useFlutterwave.ts
// (PAS 'vue-flutterwave' qui est une lib Vue 2 incompatible)
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

// Total après réduction
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

// ── Méthodes de paiement (affichage indicatif — Flutterwave gère le reste) ────
const paymentMethods = [
  {
    id: 'card',
    label: 'Carte bancaire',
    subtitle: 'Visa, Mastercard, Carte locale',
    icon: '💳',
    iconBg: '#1e3a5f',
    iconColor: '#93c5fd',
  },
  {
    id: 'mtn',
    label: 'MTN Mobile Money',
    subtitle: "Côte d'Ivoire, Ghana, Cameroun...",
    icon: 'MTN',
    iconBg: '#92400e',
    iconColor: '#fcd34d',
  },
  {
    id: 'wave',
    label: 'Wave',
    subtitle: "Sénégal, Côte d'Ivoire, Mali...",
    icon: '〜',
    iconBg: '#064e3b',
    iconColor: '#6ee7b7',
  },
  {
    id: 'orange',
    label: 'Orange Money',
    subtitle: "Toute l'Afrique de l'Ouest",
    icon: '●',
    iconBg: '#7c2d12',
    iconColor: '#fb923c',
  },
  {
    id: 'moov',
    label: 'Moov Money',
    subtitle: "Côte d'Ivoire, Bénin, Togo...",
    icon: 'MV',
    iconBg: '#1e3a5f',
    iconColor: '#93c5fd',
  },
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

// ── Soumission — ouverture modal Paydunya ──────────────────────────────────
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
.btn-primary {
  @apply px-6 py-3 bg-gold-500 text-black font-bold rounded-lg hover:bg-gold-600 transition-colors;
}
</style>