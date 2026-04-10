import { joinURL } from 'ufo'

/**
 * Routes publiques autorisées à traverser le proxy.
 * Toute autre route est bloquée avec 403.
 */
const ALLOWED_PREFIXES = [
  'tickets',
  'artists',
  'payments',
  'promo-codes',
  'webhooks/paydunya',
  'admin',
]

export default defineEventHandler((event) => {
  const config = useRuntimeConfig()
  const path = event.context.params?.path ?? ''

  // Bloquer les tentatives de path traversal
  if (path.includes('..') || path.includes('//') || path.includes('\0')) {
    throw createError({ statusCode: 400, statusMessage: 'Invalid path' })
  }

  // Whitelist des préfixes autorisés
  const isAllowed = ALLOWED_PREFIXES.some(
    (prefix) => path === prefix || path.startsWith(`${prefix}/`) || path.startsWith(`${prefix}?`)
  )

  if (!isAllowed) {
    throw createError({ statusCode: 403, statusMessage: 'Forbidden' })
  }

  const target = joinURL(config.apiBackendUrl, path)
  return proxyRequest(event, target)
})
