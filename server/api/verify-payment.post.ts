/**
 * server/api/verify-payment.post.ts
 *
 * Vérification côté serveur après le callback du modal Flutterwave.
 * Appelé depuis le composant checkout (onSuccess du modal).
 */

export default defineEventHandler(async (event) => {
  const config         = useRuntimeConfig()
  const { transaction_id } = await readBody(event)

  if (!transaction_id) {
    throw createError({ statusCode: 400, message: 'transaction_id requis.' })
  }

  const res = await $fetch<any>(
    `https://api.flutterwave.com/v3/transactions/${transaction_id}/verify`,
    {
      headers: { Authorization: `Bearer ${config.flutterwaveSecretKey}` },
    }
  )

  if (
    res.status === 'success' &&
    res.data.status === 'successful'
  ) {
    return { verified: true, data: res.data }
  }

  return { verified: false }
})