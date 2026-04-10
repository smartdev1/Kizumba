<template>
  <div class="min-h-screen bg-black text-white overflow-x-hidden" style="font-family: 'Nunito', sans-serif;">

    <!-- HEADER COMPACT -->
    <div class="pt-20 pb-6 border-b border-white/5">
      <div class="container mx-auto max-w-5xl px-6">
        <p class="text-[#C9A84C] text-xs tracking-[0.4em] uppercase mb-2">PAIEMENT SÉCURISÉ — PayDunya</p>
        <h1 class="text-2xl md:text-3xl font-black uppercase" style="font-family:'Bebas Neue',sans-serif;">
          Finalisez votre <span class="gradient-text-gold">commande</span>
        </h1>

        <!-- Stepper -->
        <div class="flex items-center gap-0 mt-5">
          <div class="stepper-step stepper-done">
            <span class="stepper-circle">
              <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            </span>
            <span class="stepper-label">Billets</span>
          </div>
          <div class="stepper-line stepper-line-done"></div>
          <div class="stepper-step stepper-active">
            <span class="stepper-circle stepper-circle-active">2</span>
            <span class="stepper-label stepper-label-active">Infos & paiement</span>
          </div>
          <div class="stepper-line"></div>
          <div class="stepper-step stepper-pending">
            <span class="stepper-circle stepper-circle-pending">3</span>
            <span class="stepper-label">Confirmation</span>
          </div>
        </div>
      </div>
    </div>

    <div class="container mx-auto max-w-5xl px-6 py-12">

      <!-- Panier vide -->
      <div v-if="cartStore.isEmpty && !orderSuccess" class="text-center py-20">
        <p class="text-white/40 text-xl mb-8">Votre panier est vide.</p>
        <NuxtLink to="/shop" class="bg-gold-500 text-black font-bold px-8 py-4 rounded-full hover:bg-gold-400 transition-all">
          Voir les billets
        </NuxtLink>
      </div>

      <!-- Succès -->
      <div v-else-if="orderSuccess" class="py-12 max-w-2xl mx-auto">
        <div class="text-center bg-white/5 border border-green-500/20 rounded-3xl p-10 mb-6">
          <div class="text-6xl mb-5">🎉</div>
          <h2 class="text-3xl font-black uppercase mb-3" style="font-family:'Bebas Neue',sans-serif;">Paiement confirmé !</h2>
          <p class="text-white/70 mb-1">Vos billets ont été envoyés à <strong class="text-white">{{ form.email }}</strong></p>
          <p class="text-white/40 text-sm">Référence : <code class="text-[#C9A84C] font-mono">{{ successTxRef }}</code></p>
        </div>

        <!-- Prochaines étapes -->
        <div class="bg-white/5 border border-white/10 rounded-2xl p-6 mb-6 space-y-4">
          <h3 class="text-sm font-bold uppercase tracking-widest text-white/60 mb-4">Prochaines étapes</h3>
          <div class="flex items-start gap-4">
            <div class="w-8 h-8 rounded-full bg-green-500/20 flex items-center justify-center shrink-0 text-green-400">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8"/><rect x="2" y="6" width="20" height="14" rx="2" ry="2" stroke-linecap="round"/></svg>
            </div>
            <div>
              <p class="text-white font-semibold text-sm">Email reçu sous quelques minutes</p>
              <p class="text-white/50 text-xs mt-0.5">Vérifiez votre boîte de réception et vos spams si nécessaire.</p>
            </div>
          </div>
          <div class="flex items-start gap-4">
            <div class="w-8 h-8 rounded-full bg-[#C9A84C]/20 flex items-center justify-center shrink-0 text-[#C9A84C]">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 9h6M9 12h6M9 15h4" stroke-linecap="round"/></svg>
            </div>
            <div>
              <p class="text-white font-semibold text-sm">Votre billet contient un QR code</p>
              <p class="text-white/50 text-xs mt-0.5">Présentez-le à l'entrée du festival (version mobile ou imprimée).</p>
            </div>
          </div>
          <div class="flex items-start gap-4">
            <div class="w-8 h-8 rounded-full bg-blue-500/20 flex items-center justify-center shrink-0 text-blue-400">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
              <p class="text-white font-semibold text-sm">Email non reçu ?</p>
              <p class="text-white/50 text-xs mt-0.5">
                Contactez-nous :
                <a href="mailto:unitedkizdomworldcongress@gmail.com" class="text-[#C9A84C] hover:underline">unitedkizdomworldcongress@gmail.com</a>
              </p>
            </div>
          </div>
        </div>

        <NuxtLink to="/" class="w-full flex items-center justify-center gap-2 bg-[#C9A84C] hover:bg-[#F5D78A] text-black font-extrabold uppercase tracking-widest text-sm px-8 py-4 rounded-full transition-all duration-300 hover:-translate-y-0.5">
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
                   class="flex items-center justify-between py-3 border-b border-white/5 last:border-0 gap-3">
                <div class="flex-1 min-w-0">
                  <div class="flex items-center gap-2 flex-wrap">
                    <p class="font-bold text-sm">{{ item.name }}</p>
                    <span v-if="item.isEarlyBird" class="bg-gold-500 text-black text-[10px] font-black px-1.5 py-0.5 rounded uppercase tracking-wide">Early Bird</span>
                  </div>
                  <p class="text-white/50 text-xs mt-0.5">{{ item.price.toLocaleString() }} {{ item.currency }} / billet</p>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                  <!-- Contrôles quantité -->
                  <div class="flex items-center gap-1 bg-white/5 border border-white/10 rounded-xl overflow-hidden">
                    <button
                      @click="cartStore.updateQuantity(item.slug, item.quantity - 1)"
                      class="w-8 h-8 flex items-center justify-center text-white/50 hover:text-white hover:bg-white/10 transition-colors text-lg leading-none"
                      aria-label="Réduire la quantité"
                    >−</button>
                    <span class="w-6 text-center text-sm font-bold tabular-nums">{{ item.quantity }}</span>
                    <button
                      @click="cartStore.updateQuantity(item.slug, item.quantity + 1)"
                      class="w-8 h-8 flex items-center justify-center text-white/50 hover:text-white hover:bg-white/10 transition-colors text-lg leading-none"
                      aria-label="Augmenter la quantité"
                    >+</button>
                  </div>
                  <span class="text-gold-400 font-bold text-sm w-28 text-right">{{ (item.price * item.quantity).toLocaleString() }} {{ item.currency }}</span>
                  <button @click="cartStore.removeItem(item.slug)" class="text-red-400/50 hover:text-red-400 transition-colors text-sm p-1" aria-label="Supprimer">✕</button>
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
              :class="loading ? 'btn-pay-loading' : !cgpAccepted ? 'bg-white/10 text-white/40 cursor-not-allowed' : 'btn-pay'">
              <span v-if="loading" class="flex items-center justify-center gap-2">
                <span class="animate-spin inline-block w-4 h-4 border-2 border-black/40 border-t-black rounded-full"></span>
                Redirection vers PayDunya...
              </span>
              <span v-else>Payer avec PayDunya</span>
            </button>

            <!-- Message explicatif si bouton désactivé -->
            <p v-if="!cgpAccepted && !loading" class="text-yellow-400/80 text-xs text-center mt-2">
              Veuillez accepter les conditions générales pour continuer.
            </p>

            <p class="text-white/50 text-xs text-center mt-4">
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

useHead({
  title: 'Commande — UKWC 2026 · United Kizdom World Congress',
  meta: [
    { name: 'description', content: 'Finalisez votre commande de billets pour le UKWC 2026, festival kizomba à Cotonou, Bénin.' },
    { name: 'robots', content: 'noindex' }
  ]
})

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

  // L'email est récupéré depuis le sessionStorage (enregistré juste avant la redirection)
  const savedEmail = sessionStorage.getItem('checkout_email')
  if (!savedEmail) {
    globalError.value = 'Session expirée. Veuillez recommencer votre commande.'
    return
  }

  pendingStatus.value = true

  try {
    const status = await getPaymentStatus(txRef, savedEmail)

    if (status.status === 'completed') {
      successTxRef.value = txRef
      orderSuccess.value = true
      cartStore.clearCart()
      sessionStorage.removeItem('checkout_email')
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

// ─── Validation URL PayDunya avant redirection ───────
const PAYDUNYA_ALLOWED_HOSTS = ['app.paydunya.com', 'paydunya.com']

function safeRedirectToPayment(url) {
  try {
    const parsed = new URL(url)
    const isValid =
      (parsed.protocol === 'https:') &&
      PAYDUNYA_ALLOWED_HOSTS.some(
        (h) => parsed.hostname === h || parsed.hostname.endsWith(`.${h}`)
      )
    if (!isValid) {
      throw new Error(`Domaine de paiement invalide : ${parsed.hostname}`)
    }
    window.location.href = url
  } catch {
    globalError.value = 'URL de paiement invalide. Veuillez réessayer ou contacter le support.'
    loading.value = false
  }
}

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

    // Sauvegarder l'email pour vérifier le statut au retour (anti-IDOR)
    sessionStorage.setItem('checkout_email', form.email.trim())

    // Redirection sécurisée vers PayDunya (validation du domaine)
    safeRedirectToPayment(result.payment_url)
  } catch (err) {
    globalError.value = err?.data?.message
      ?? err?.message
      ?? 'Une erreur est survenue. Veuillez réessayer.'
    loading.value = false
  }
}
</script>

<style scoped>
/* Stepper */
.stepper-step {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.375rem;
}
.stepper-circle {
  width: 2rem;
  height: 2rem;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.8rem;
  font-weight: 800;
  background: rgba(201,168,76,0.2);
  color: #C9A84C;
  border: 1.5px solid #C9A84C;
}
.stepper-done .stepper-circle {
  background: #C9A84C;
  color: #000;
}
.stepper-circle-active {
  background: #C9A84C !important;
  color: #000 !important;
  box-shadow: 0 0 0 4px rgba(201,168,76,0.2);
}
.stepper-circle-pending {
  background: rgba(255,255,255,0.05) !important;
  color: rgba(255,255,255,0.3) !important;
  border-color: rgba(255,255,255,0.1) !important;
}
.stepper-label {
  font-size: 0.6rem;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  color: rgba(255,255,255,0.35);
  white-space: nowrap;
}
.stepper-label-active {
  color: #C9A84C !important;
  font-weight: 700;
}
.stepper-line {
  flex: 1;
  height: 1px;
  background: rgba(255,255,255,0.1);
  margin: 0 0.5rem;
  margin-bottom: 1.2rem;
}
.stepper-line-done {
  background: #C9A84C;
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
