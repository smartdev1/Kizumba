/**
 * server/api/create-payment.post.ts
 *
 * Crée une invoice PayDunya et retourne le payment_url.
 * Appelé depuis le composant checkout (submitOrder).
 */

export default defineEventHandler(async (event) => {
  const config = useRuntimeConfig()
  const body = await readBody(event)

  const { tx_ref, total, coupon, customer, cartItems } = body

  if (!tx_ref || !total || !customer || !cartItems?.length) {
    throw createError({
      statusCode: 400,
      message: 'tx_ref, total, customer et cartItems sont requis.',
    })
  }

  const isTest = config.paydunya_mode === 'test'

  const apiBase = isTest
    ? 'https://app.paydunya.com/sandbox-api/v1'
    : 'https://app.paydunya.com/api/v1'

  const headers = {
    'Content-Type':             'application/json',
    'PAYDUNYA-MASTER-KEY':      config.paydunya_master_key,
    'PAYDUNYA-PRIVATE-KEY':     config.paydunya_private_key,
    'PAYDUNYA-TOKEN':           config.paydunya_token,
  }

  // ── Construction des items de la facture ──────────────────────────────────
  const invoiceItems: Record<string, { unit_price: string; total_price: string; quantity: number }> = {}

  for (const item of cartItems) {
    invoiceItems[item.name] = {
      unit_price:  String(item.price),
      total_price: String(item.price * item.quantity),
      quantity:    item.quantity,
    }
  }

  // ── Description coupon ────────────────────────────────────────────────────
  let description = `Commande EventFlow — ${cartItems.map((i: any) => i.name).join(', ')}`
  if (coupon) {
    const reduction = coupon.type === 'percent'
      ? `${coupon.value}%`
      : `${coupon.value} FCFA`
    description += ` | Coupon ${coupon.code} (-${reduction})`
  }

  // ── Payload PayDunya ──────────────────────────────────────────────────────
  const payload = {
    invoice: {
      items:        invoiceItems,
      taxes:        {},
      total_amount: total,
      description,
    },
    store: {
      name:     'EventFlow Billetterie',
      tagline:  'Vos tickets en quelques clics',
      // logo_url: 'https://votre-site.com/logo.png', // optionnel
    },
    actions: {
      cancel_url: `${config.public.wpApiUrl.replace('/wp-json', '')}/checkout?event_id=${cartItems[0]?.eventId}&cancelled=1`,
      return_url: `${config.public.wpApiUrl.replace('/wp-json', '')}/checkout/success?tx_ref=${tx_ref}`,
      callback_url: `${config.public.wpApiUrl.replace('/wp-json', '')}/wp-json/eventflow/v1/payments/paydunya/ipn`,

    },
    custom_data: {
      tx_ref,
      customer_email:    customer.email,
      customer_phone:    customer.phone || '',
      customer_name:     `${customer.firstName} ${customer.lastName}`,
      coupon_code:       coupon?.code || null,
      cart_items:        JSON.stringify(cartItems),
    },
  }

  // ── Appel PayDunya ────────────────────────────────────────────────────────
  try {
    const res = await $fetch<any>(`${apiBase}/checkout-invoice/create`, {
      method:  'POST',
      headers,
      body:    payload,
    })

    if (res.response_code !== '00') {
      throw createError({
        statusCode: 502,
        message: res.response_text || 'Erreur PayDunya lors de la création de la facture.',
      })
    }

    return {
      success:     true,
      payment_url: res.response_text, // PayDunya retourne l'URL ici
      token:       res.token,
      tx_ref,
    }
  } catch (err: any) {
    throw createError({
      statusCode: err.statusCode || 502,
      message:    err.message || 'Impossible de contacter PayDunya.',
    })
  }
})