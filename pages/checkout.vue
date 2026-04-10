<template>
  <div class="min-h-screen bg-black text-white overflow-x-hidden" style="font-family: 'Nunito', sans-serif;">

    <!-- HERO -->
    <section class="relative min-h-[40vh] flex items-center overflow-hidden">
      <div class="absolute inset-0 z-0">
        <div class="checkout-hero-bg absolute inset-0" />
        <svg class="absolute inset-0 w-full h-full opacity-10" viewBox="0 0 1440 900" preserveAspectRatio="xMidYMid slice" fill="none">
          <line x1="-100" y1="900" x2="1200" y2="-50" stroke="#C9A84C" stroke-width="1"/>
          <circle cx="720" cy="450" r="380" stroke="#C9A84C" stroke-width="0.5"/>
        </svg>
      </div>
      <div class="relative z-10 container mx-auto px-6 pt-32 pb-16 text-center">
        <p class="text-gold-400 text-xs tracking-[0.5em] uppercase mb-4">PAIEMENT SÉCURISÉ — PayDunya</p>
        <h1 style="font-family:'Bebas Neue',sans-serif;">
          <span class="block text-[clamp(2.5rem,6vw,5rem)] leading-none">Finalisez votre</span>
          <span class="block text-[clamp(3rem,8vw,6rem)] leading-none gradient-text-gold">commande</span>
        </h1>
      </div>
    </section>

    <div class="container mx-auto max-w-5xl px-6 py-12">

      <!-- Panier vide -->
      <div v-if="cartStore.isEmpty && !orderSuccess" class="text-center py-20">
        <p class="text-white/40 text-xl mb-8">Votre panier est vide.</p>
        <NuxtLink to="/shop" class="bg-gold-500 text-black font-bold px-8 py-4 rounded-full hover:bg-gold-400 transition-all">
          Voir les billets
        </NuxtLink>
      </div>

      <!-- Succès -->
      <div v-else-if="orderSuccess" class="text-center py-16 bg-white/5 border border-green-500/30 rounded-3xl">
        <div class="text-7xl mb-6">🎉</div>
        <h2 class="text-3xl font-black uppercase mb-4" style="font-family:'Bebas Neue',sans-serif;">Paiement confirmé !</h2>
        <p class="text-white/60 mb-2">Vos billets ont été envoyés à <strong class="text-white">{{ form.email }}</strong></p>
        <p class="text-white/40 text-sm mb-8">Référence : <code class="text-gold-400 font-mono">{{ successTxRef }}</code></p>
        <NuxtLink to="/" class="bg-gold-500 text-black font-bold px-8 py-4 rounded-full hover:bg-gold-400 transition-all">
          Retour à l'accueil
        </NuxtLink>
      </div>

      <!-- Paiement en attente (retour PayDunya) -->
      <div v-else-if="pendingStatus" class="text-center py-16 bg-white/5 border border-yellow-500/30 rounded-3xl">
        <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-gold-500 mx-auto mb-6"></div>
        <h2 class="text-2xl font-bold mb-2">Vérification du paiement...</h2>
        <p class="text-white/40 text-sm">Référence : <code class="font-mono text-gold-400">{{ route.query.tx_ref }}</code></p>
      </div>

      <!-- Formulaire -->
      <div v-else class="grid lg:grid-cols-[1fr_380px] gap-8">

        <!-- Colonne gauche : formulaire -->
        <div class="space-y-8">

          <!-- Récapitulatif panier -->
          <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
            <h2 class="text-lg font-bold uppercase tracking-wider text-gold-400 mb-4" style="font-family:'Bebas Neue',sans-serif;">
              🛒 Votre panier
            </h2>
            <div class="space-y-3">
              <div v-for="item in cartStore.items" :key="item.slug"
                   class="flex items-center justify-between py-3 border-b border-white/5 last:border-0">
                <div>
                  <div class="flex items-center gap-2">
                    <p class="font-bold">{{ item.name }}</p>
                    <span v-if="item.isEarlyBird" class="bg-gold-500 text-black text-[10px] font-black px-1.5 py-0.5 rounded uppercase tracking-wide">Early Bird</span>
                  </div>
                  <p class="text-white/40 text-sm">{{ item.price.toLocaleString() }} {{ item.currency }} × {{ item.quantity }}</p>
                </div>
                <div class="flex items-center gap-3">
                  <span class="text-gold-400 font-bold">{{ (item.price * item.quantity).toLocaleString() }} {{ item.currency }}</span>
                  <button @click="cartStore.removeItem(item.slug)" class="text-red-400/60 hover:text-red-400 transition-colors text-sm">✕</button>
                </div>
              </div>
            </div>
          </div>

          <!-- Code promo -->
          <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
            <h2 class="text-lg font-bold uppercase tracking-wider text-gold-400 mb-4" style="font-family:'Bebas Neue',sans-serif;">
              🏷️ Code promo
            </h2>

            <!-- Code déjà appliqué -->
            <div v-if="cartStore.hasPromo" class="flex items-center justify-between bg-green-500/10 border border-green-500/30 rounded-xl px-4 py-3">
              <div>
                <span class="text-green-400 font-bold font-mono">{{ cartStore.promoCode }}</span>
                <span class="text-white/50 text-sm ml-2">
                  — {{ cartStore.promoData.type === 'percentage' ? `-${cartStore.promoData.value}%` : `-${cartStore.promoData.value.toLocaleString()} FCFA` }}
                  <template v-if="cartStore.promoData.description"> · {{ cartStore.promoData.description }}</template>
                </span>
              </div>
              <button @click="cartStore.removePromo()" class="text-white/30 hover:text-red-400 transition-colors text-sm ml-4">✕</button>
            </div>

            <!-- Saisie du code -->
            <div v-else class="flex gap-2">
              <input
                v-model="promoInput"
                type="text"
                placeholder="Entrez votre code promo"
                @keyup.enter="applyPromo"
                class="flex-1 bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/20 focus:outline-none focus:border-gold-500/50 transition-colors uppercase font-mono tracking-widest"
              />
              <button
                @click="applyPromo"
                :disabled="cartStore.promoLoading || !promoInput.trim()"
                class="bg-gold-500 hover:bg-gold-400 text-black font-bold px-5 py-3 rounded-xl transition-all disabled:opacity-40 disabled:cursor-not-allowed whitespace-nowrap">
                <span v-if="cartStore.promoLoading" class="animate-spin inline-block w-4 h-4 border-2 border-black/40 border-t-black rounded-full"></span>
                <span v-else>Appliquer</span>
              </button>
            </div>

            <p v-if="cartStore.promoError" class="text-red-400 text-sm mt-2">{{ cartStore.promoError }}</p>
            <p v-if="cartStore.promoData?.early_bird_skipped?.length" class="text-yellow-400/70 text-xs mt-2">
              ⚠️ Non applicable aux billets Early Bird : {{ cartStore.promoData.early_bird_skipped.join(', ') }}
            </p>
          </div>

          <!-- Informations client -->
          <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
            <h2 class="text-lg font-bold uppercase tracking-wider text-gold-400 mb-6" style="font-family:'Bebas Neue',sans-serif;">
              👤 Vos informations
            </h2>
            <div class="grid md:grid-cols-2 gap-4">
              <div>
                <label class="block text-white/50 text-xs uppercase tracking-wider mb-2">Prénom & Nom *</label>
                <input
                  v-model="form.name"
                  type="text"
                  placeholder="Jean Dupont"
                  class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/20 focus:outline-none focus:border-gold-500/50 transition-colors"
                  :class="{ 'border-red-500/50': errors.name }"
                />
                <p v-if="errors.name" class="text-red-400 text-xs mt-1">{{ errors.name }}</p>
              </div>
              <div>
                <label class="block text-white/50 text-xs uppercase tracking-wider mb-2">Email *</label>
                <input
                  v-model="form.email"
                  type="email"
                  placeholder="jean@exemple.com"
                  class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/20 focus:outline-none focus:border-gold-500/50 transition-colors"
                  :class="{ 'border-red-500/50': errors.email }"
                />
                <p v-if="errors.email" class="text-red-400 text-xs mt-1">{{ errors.email }}</p>
              </div>
              <div>
                <label class="block text-white/50 text-xs uppercase tracking-wider mb-2">Téléphone</label>
                <input
                  v-model="form.phone"
                  type="tel"
                  placeholder="+33 6 00 00 00 00"
                  class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/20 focus:outline-none focus:border-gold-500/50 transition-colors"
                />
              </div>
            </div>
          </div>

          <!-- Erreur globale -->
          <div v-if="globalError" class="bg-red-600/20 border border-red-500/40 text-red-400 px-5 py-4 rounded-xl text-sm">
            {{ globalError }}
          </div>

        </div>

        <!-- Colonne droite : total + bouton payer -->
        <div class="space-y-6">
          <div class="bg-white/5 border border-white/10 rounded-2xl p-6 sticky top-24">
            <h2 class="text-lg font-bold uppercase tracking-wider text-gold-400 mb-6" style="font-family:'Bebas Neue',sans-serif;">
              Récapitulatif
            </h2>

            <div class="space-y-3 mb-4">
              <div v-for="item in cartStore.items" :key="item.slug" class="flex justify-between text-sm">
                <span class="text-white/60">
                  {{ item.name }} ×{{ item.quantity }}
                  <span v-if="item.isEarlyBird" class="text-gold-500 text-[10px] font-black ml-1 uppercase">Early Bird</span>
                </span>
                <span>{{ (item.price * item.quantity).toLocaleString() }} {{ item.currency }}</span>
              </div>
            </div>

            <!-- Ligne sous-total + réduction -->
            <template v-if="cartStore.hasPromo">
              <div class="border-t border-white/10 pt-3 space-y-2 mb-4">
                <div class="flex justify-between text-sm">
                  <span class="text-white/50">Sous-total</span>
                  <span>{{ cartStore.subtotal.toLocaleString() }} FCFA</span>
                </div>
                <div class="flex justify-between text-sm text-green-400">
                  <span>Code <span class="font-mono font-bold">{{ cartStore.promoCode }}</span></span>
                  <span>−{{ cartStore.discountAmount.toLocaleString() }} FCFA</span>
                </div>
              </div>
            </template>

            <div class="border-t border-white/10 pt-4 mb-6">
              <div class="flex justify-between items-center">
                <span class="text-white/60 uppercase text-xs tracking-wider">Total</span>
                <span class="text-2xl font-black text-gold-400">{{ cartStore.totalAfterDiscount.toLocaleString() }} FCFA</span>
              </div>
            </div>

            <!-- CGP -->
            <label class="flex items-start gap-3 cursor-pointer mb-5 group">
              <input
                v-model="cgpAccepted"
                type="checkbox"
                class="mt-0.5 w-4 h-4 flex-shrink-0 accent-yellow-500 cursor-pointer"
              />
              <span class="text-white/50 text-xs leading-relaxed group-hover:text-white/70 transition-colors">
                J'ai lu et j'accepte les
                <NuxtLink to="/conditions-generales" target="_blank" class="text-gold-400 underline hover:text-gold-300">
                  Conditions Générales de Participation
                </NuxtLink>
                au UKWC 2026.
              </span>
            </label>

            <button
              @click="submitPayment"
              :disabled="loading || cartStore.isEmpty || !cgpAccepted"
              class="w-full py-4 rounded-2xl font-extrabold uppercase tracking-widest text-sm transition-all duration-300"
              :class="loading ? 'btn-pay-loading' : !cgpAccepted ? 'bg-white/10 text-white/30 cursor-not-allowed' : 'btn-pay'">
              <span v-if="loading" class="flex items-center justify-center gap-2">
                <span class="animate-spin inline-block w-4 h-4 border-2 border-black/40 border-t-black rounded-full"></span>
                Redirection...
              </span>
              <span v-else>Payer avec PayDunya</span>
            </button>

            <p class="text-white/20 text-xs text-center mt-4">
              🔒 Paiement 100% sécurisé · Billet envoyé par email
            </p>
          </div>
        </div>

      </div>
    </div>

  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import { useCartStore } from '~/stores/cart'

const cartStore = useCartStore()
const route     = useRoute()
const { initiatePayment, getPaymentStatus } = useApi()

// ─── État ────────────────────────────────────────────
const loading       = ref(false)
const globalError   = ref(null)
const orderSuccess  = ref(false)
const successTxRef  = ref(null)
const pendingStatus = ref(false)
const promoInput    = ref('')
const cgpAccepted   = ref(false)

// ─── Code promo ──────────────────────────────────────
async function applyPromo() {
  if (!promoInput.value.trim()) return
  await cartStore.validatePromo(promoInput.value)
  if (cartStore.hasPromo) promoInput.value = ''
}

const form = reactive({
  name:  '',
  email: '',
  phone: '',
})

const errors = reactive({
  name:  null,
  email: null,
})

// ─── Validation simple ───────────────────────────────
function validate() {
  errors.name  = null
  errors.email = null

  if (!form.name.trim()) {
    errors.name = 'Le nom est requis'
    return false
  }
  if (!form.email.trim() || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email)) {
    errors.email = 'Email invalide'
    return false
  }
  return true
}

// ─── Vérification statut au retour PayDunya ──────────
onMounted(async () => {
  const txRef = route.query.tx_ref
  if (!txRef) return

  pendingStatus.value = true

  try {
    const status = await getPaymentStatus(txRef)

    if (status.status === 'completed') {
      successTxRef.value = txRef
      orderSuccess.value = true
      cartStore.clearCart()
    } else if (status.status === 'pending') {
      globalError.value = 'Paiement en cours de traitement. Vérifiez votre email dans quelques minutes.'
    } else {
      globalError.value = 'Le paiement a échoué ou a été annulé.'
    }
  } catch {
    globalError.value = 'Impossible de vérifier le statut du paiement.'
  } finally {
    pendingStatus.value = false
  }
})

// ─── Soumission paiement ─────────────────────────────
async function submitPayment() {
  globalError.value = null

  if (!validate()) return
  if (cartStore.isEmpty) return

  loading.value = true

  try {
    const result = await initiatePayment({
      customer: {
        name:  form.name.trim(),
        email: form.email.trim(),
        phone: form.phone.trim() || undefined,
      },
      items: cartStore.items.map((i) => ({
        slug:     i.slug,
        quantity: i.quantity,
      })),
      promo_code: cartStore.promoCode ?? undefined,
    })

    // Redirection vers PayDunya
    window.location.href = result.payment_url
  } catch (err) {
    globalError.value = err?.data?.message
      ?? err?.message
      ?? 'Une erreur est survenue. Veuillez réessayer.'
    loading.value = false
  }
}
</script>

<style scoped>
.checkout-hero-bg {
  background: radial-gradient(ellipse 70% 60% at 20% 60%, rgba(201,168,76,0.10) 0%, transparent 70%), #000;
}
.gradient-text-gold {
  background: linear-gradient(135deg, #C9A84C 0%, #F5D78A 40%, #C9A84C 70%, #8B6914 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}
.text-gold-400  { color: #F5D78A; }
.bg-gold-500    { background-color: #C9A84C; }
.border-gold-500 { border-color: #C9A84C; }
.btn-pay {
  background-color: #C9A84C;
  color: #000;
  box-shadow: 0 10px 40px rgba(201,168,76,0.3);
}
.btn-pay:hover {
  background-color: #F5D78A;
  transform: translateY(-2px);
}
.btn-pay-loading {
  background-color: rgba(201,168,76,0.5);
  color: rgba(0,0,0,0.5);
  cursor: wait;
}
</style>
