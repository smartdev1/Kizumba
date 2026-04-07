export default defineEventHandler(async (event) => {
  const config = useRuntimeConfig()
  const apiBase = config.public.eventflowApiBase
  const apiToken = config.public.eventflowApiToken || ''
  const query = getQuery(event)

  try {
    const headers = {}
    if (apiToken) {
      headers.Authorization = `Bearer ${apiToken}`
    }

    const params = new URLSearchParams()
    if (query.event_id) params.append('event_id', query.event_id)
    if (query.status) params.append('status', query.status)

    const url = `${apiBase}/tickets${params.toString() ? '?' + params.toString() : ''}`

    const response = await fetch(url, {
      method: 'GET',
      headers
    })

    const data = await response.json()
    return data
  } catch (error) {
    throw createError({
      statusCode: 500,
      statusMessage: 'Failed to fetch tickets'
    })
  }
})