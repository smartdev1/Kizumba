import { joinURL } from 'ufo'

export default defineEventHandler((event) => {
  const config = useRuntimeConfig()
  const path = event.context.params?.path ?? ''
  const target = joinURL(config.apiBackendUrl, path)
  return proxyRequest(event, target)
})
