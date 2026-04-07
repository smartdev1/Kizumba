/**
 * server/api/webhooks/flutterwave.post.ts
 *
 * Reçoit les webhooks Flutterwave, vérifie la signature,
 * double-vérifie auprès de l'API Flutterwave, puis notifie WordPress.
 */

export default defineEventHandler(async (event) => {
  const config = useRuntimeConfig()

  // ── 1. Vérification du hash secret Flutterwave ─────────────────────────────
  const signature = getHeader(event, 'verif-hash')

  if (!signature || signature !== config.flutterwaveWebhookHash) {
    throw createError({ statusCode: 401, message: 'Signature webhook invalide.' })
  }

  const payload = await readBody(event)

  // ── 2. On ne traite que les paiements complétés ────────────────────────────
  if (payload.event !== 'charge.completed') {
    return { received: true }
  }

  const {
    status,
    id: transaction_id,
    tx_ref,
    amount,
    currency,
    customer,
    payment_type,
  } = payload.data

  if (status !== 'successful') {
    return { received: true }
  }

  // ── 3. Double vérification auprès de l'API Flutterwave ─────────────────────
  let verification: any
  try {
    verification = await $fetch<any>(
      `https://api.flutterwave.com/v3/transactions/${transaction_id}/verify`,
      {
        headers: { Authorization: `Bearer ${config.flutterwaveSecretKey}` },
      }
    )
  } catch (err) {
    console.error('[FLW Webhook] Erreur vérification API:', err)
    throw createError({ statusCode: 502, message: 'Impossible de vérifier la transaction.' })
  }

  if (
    verification.status !== 'success' ||
    verification.data.status !== 'successful' ||
    verification.data.amount < amount          // protection sous-paiement
  ) {
    console.error('[FLW Webhook] Vérification échouée', verification)
    throw createError({ statusCode: 400, message: 'Vérification Flutterwave échouée.' })
  }

  // ── 4. Notifier WordPress (EventFlow payment-confirm) ──────────────────────
  const wpBase = config.wpApiUrl.replace('/wp-json', '')

  try {
    const wpResponse = await $fetch<any>(
      `${wpBase}/wp-json/eventflow/v1/payment-confirm`,
      {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-EventFlow-Secret': config.eventflowWebhookSecret,
        },
        body: {
          tx_ref,
          transaction_id: String(transaction_id),
          amount:         verification.data.amount,
          currency:       verification.data.currency,
          status:         'paid',
          customer:       verification.data.customer,
          payment_type:   verification.data.payment_type ?? payment_type,
          flw_data:       verification.data,
        },
      }
    )

    console.log('[FLW Webhook] WordPress notifié ✅', wpResponse)
  } catch (err: any) {
    // On log mais on retourne 200 à Flutterwave pour éviter les retries infinis.
    // WordPress recevra la notification lors du prochain retry manuel si besoin.
    console.error('[FLW Webhook] Erreur notification WordPress:', err?.data ?? err)
  }

  return { received: true }
})