export default defineEventHandler(async (event) => {
  const config = useRuntimeConfig()
  const apiBase = config.public.eventflowApiBase
  const apiToken = config.public.eventflowApiToken || ''

  try {
    const headers = {}
    if (apiToken) {
      headers.Authorization = `Bearer ${apiToken}`
    }

    const response = await fetch(`${apiBase}/events?per_page=50`, {
      method: 'GET',
      headers
    })

    const data = await response.json()
    return data
  } catch (error) {
    throw createError({
      statusCode: 500,
      statusMessage: 'Failed to fetch events'
    })
  }
})