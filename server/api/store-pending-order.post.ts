/**
 * server/api/store-pending-order.post.ts
 *
 * Relaie les données de commande en attente vers WordPress
 * avant l'ouverture du modal Flutterwave.
 */

export default defineEventHandler(async (event) => {
  const config = useRuntimeConfig()
  const body   = await readBody(event)

  const { tx_ref, customer, items } = body

  if (!tx_ref || !customer || !items) {
    throw createError({ statusCode: 400, message: 'tx_ref, customer et items sont requis.' })
  }

  const wpBase = config.wpApiUrl.replace('/wp-json', '')

  await $fetch(`${wpBase}/wp-json/eventflow/v1/pending-order`, {
    method: 'POST',
    headers: {
      'Content-Type':      'application/json',
      'X-EventFlow-Secret': config.eventflowWebhookSecret,
    },
    body: { tx_ref, customer, items },
  })

  return { ok: true }
})