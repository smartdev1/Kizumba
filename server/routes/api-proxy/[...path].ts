import { joinURL } from 'ufo'

export default defineEventHandler((event) => {
  const path = event.context.params?.path ?? ''
  const target = joinURL(
    process.env.NUXT_PUBLIC_API_BASE_URL || 'http://localhost:8000/api',
    path,
  )
  return proxyRequest(event, target)
})
