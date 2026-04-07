/**
 * server/api/webhooks/paydunya.post.ts
 *
 * Reçoit le webhook IPN de PayDunya et le relaie à WordPress
 * pour créer la commande WooCommerce + les tickets EventFlow.
 *
 * PayDunya envoie un POST avec le hash du paiement en query param :
 * POST /api/webhooks/paydunya?data=HASH_TOKEN
 */

export default defineEventHandler(async (event) => {
  const config = useRuntimeConfig()
  const query  = getQuery(event)
  const body   = await readBody(event).catch(() => ({}))

  // ── PayDunya envoie le token soit en query soit dans le body ──────────────
  const token = (query.data || body.data || '') as string

  if (!token) {
    throw createError({ statusCode: 400, message: 'Token IPN manquant.' })
  }

  // ── Vérification du paiement auprès de PayDunya ───────────────────────────
  const isTest  = config.paydunya_mode === 'test'
  const apiBase = isTest
    ? 'https://app.paydunya.com/sandbox-api/v1'
    : 'https://app.paydunya.com/api/v1'

  const headers = {
    'Content-Type':         'application/json',
    'PAYDUNYA-MASTER-KEY':  config.paydunya_master_key,
    'PAYDUNYA-PRIVATE-KEY': config.paydunya_private_key,
    'PAYDUNYA-TOKEN':       config.paydunya_token,
  }

  let invoiceData: any

  try {
    invoiceData = await $fetch<any>(`${apiBase}/checkout-invoice/confirm/${token}`, {
      headers,
    })
  } catch (err: any) {
    throw createError({
      statusCode: 502,
      message: 'Impossible de vérifier le paiement PayDunya.',
    })
  }

  // ── Paiement non complété — on ignore silencieusement ────────────────────
  if (invoiceData?.status !== 'completed') {
    return { received: true, processed: false, status: invoiceData?.status }
  }

  // ── Relai vers WordPress pour créer la commande + tickets ─────────────────
  const wpBase = config.wpApiUrl.replace('/wp-json', '')

  try {
    await $fetch(`${wpBase}/wp-json/eventflow/v1/payments/ipn`, {
      method: 'POST',
      headers: {
        'Content-Type':       'application/json',
        'X-EventFlow-Secret': config.eventflowWebhookSecret,
      },
      body: {
        token,
        invoice:     invoiceData,
        custom_data: invoiceData?.custom_data || {},
      },
    })
  } catch (err: any) {
    // On log mais on retourne 200 pour ne pas déclencher les retry PayDunya
    console.error('[EventFlow IPN] Erreur relai WordPress:', err?.message)
  }

  return { received: true, processed: true }
})