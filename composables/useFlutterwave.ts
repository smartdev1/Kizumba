/**
 * composables/useFlutterwave.ts
 *
 * Composable Nuxt 3 pour l'intégration Flutterwave Inline JS.
 * Gère : chargement du script, stockage pending-order, ouverture modal,
 * vérification serveur et création commande WooCommerce.
 */

export interface FlwCustomer {
  email:        string
  name:         string
  first_name?:  string
  last_name?:   string
  phone_number?: string
}

export interface FlwCartItem {
  id:          number | string   // event_id
  name:        string
  price:       number
  quantity:    number
  ticketType?: string
  eventId?:    number
}

export interface FlwPaymentOptions {
  amount:      number
  currency?:   string
  customer:    FlwCustomer
  cartItems:   FlwCartItem[]
  title?:      string
  description?: string
  onSuccess:   (orderId: number, tickets: any[]) => void
  onClose?:    () => void
}

export const useFlutterwave = () => {
  const config     = useRuntimeConfig()
  const cartStore  = useCartStore()

  // ── Chargement du script Flutterwave (une seule fois) ─────────────────────
  const loadScript = (): Promise<void> => {
    return new Promise((resolve) => {
      if (document.getElementById('flw-script')) return resolve()
      const script    = document.createElement('script')
      script.id       = 'flw-script'
      script.src      = 'https://checkout.flutterwave.com/v3.js'
      script.onload   = () => resolve()
      script.onerror  = () => console.error('[FLW] Impossible de charger le script Flutterwave')
      document.head.appendChild(script)
    })
  }

  // ── Génération d'un tx_ref unique ─────────────────────────────────────────
  const generateTxRef = (): string =>
    `EVT-${Date.now()}-${Math.random().toString(36).slice(2, 8).toUpperCase()}`

  // ── Ouverture du modal de paiement ────────────────────────────────────────
  const openPaymentModal = async (options: FlwPaymentOptions): Promise<void> => {
    const {
      amount,
      currency    = 'XOF',
      customer,
      cartItems,
      title       = 'Billetterie',
      description = 'Paiement de vos tickets',
      onSuccess,
      onClose     = () => {},
    } = options

    await loadScript()

    const tx_ref = generateTxRef()

    // ── 1. Stocker la commande en attente côté WordPress ──────────────────
    try {
      await $fetch('/api/store-pending-order', {
        method: 'POST',
        body: {
          tx_ref,
          customer,
          items: cartItems,
        },
      })
    } catch (err) {
      console.error('[FLW] Erreur store-pending-order:', err)
      // On continue quand même — le webhook utilisera le fallback meta
    }

    // ── 2. Ouvrir le modal Flutterwave ────────────────────────────────────
    // @ts-ignore — FlutterwaveCheckout est injecté par le script tiers
    FlutterwaveCheckout({
      public_key: config.public.flutterwavePublicKey,
      tx_ref,
      amount,
      currency,

      // En XOF, Flutterwave affiche automatiquement :
      // Carte + MTN Mobile Money + Orange Money + Wave + Moov
      payment_options: 'card, mobilemoneyfranc',

      customer: {
        email:        customer.email,
        name:         customer.name || `${customer.first_name ?? ''} ${customer.last_name ?? ''}`.trim(),
        phone_number: customer.phone_number ?? '',
      },

      customizations: {
        title,
        description,
        logo: '/logo.png',
      },

      meta: {
        items: cartItems.map(i => ({
          id:          i.eventId ?? i.id,
          name:        i.name,
          price:       i.price,
          quantity:    i.quantity,
          ticketType:  i.ticketType ?? 'standard',
        })),
      },

      // ── 3. Callback succès (modal encore ouvert) ──────────────────────
      callback: async (data: any) => {
        if (data.status !== 'successful' && data.status !== 'completed') return

        try {
          // Vérification serveur obligatoire
          const verification = await $fetch<{ verified: boolean; data: any }>(
            '/api/verify-payment',
            {
              method: 'POST',
              body: { transaction_id: data.transaction_id },
            }
          )

          if (!verification.verified) {
            console.error('[FLW] Vérification paiement échouée')
            return
          }

          // Créer la commande WooCommerce + tickets EventFlow via WordPress
          const result = await $fetch<any>(
            `${config.public.wpApiUrl.replace('/wp-json', '')}/wp-json/eventflow/v1/payment-confirm`,
            {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: {
                tx_ref,
                transaction_id: String(data.transaction_id),
                amount:         verification.data.amount,
                currency:       verification.data.currency,
                status:         'paid',
                customer:       {
                  ...verification.data.customer,
                  first_name:   customer.first_name,
                  last_name:    customer.last_name,
                },
                payment_type:   verification.data.payment_type,
                flw_data:       verification.data,
              },
            }
          )

          cartStore.clearCart()
          onSuccess(result.order_id, result.tickets ?? [])

        } catch (err) {
          console.error('[FLW] Erreur confirmation paiement:', err)
        }
      },

      // ── 4. Fermeture du modal ─────────────────────────────────────────
      onclose: onClose,
    })
  }

  return { openPaymentModal }
}