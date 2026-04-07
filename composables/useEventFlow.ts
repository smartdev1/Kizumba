export const useEventFlow = () => {
  const config = useRuntimeConfig()
  const apiBase = config.public.eventflowApiBase
  const apiToken = config.public.eventflowApiToken || ''

  const authHeaders = () => {
    if (!apiToken) {
      return {}
    }
    return {
      Authorization: `Bearer ${apiToken}`,
    }
  }

  const getEvents = async () => {
    return await $fetch(`${apiBase}/events`, {
      method: 'GET',
      headers: authHeaders(),
      params: { per_page: 50 }
    })
  }

  const getEvent = async (eventId: number) => {
    return await $fetch(`${apiBase}/events/${eventId}`, {
      method: 'GET',
      headers: authHeaders()
    })
  }

  const getTickets = async (query: Record<string, any> = {}) => {
    return await $fetch(`${apiBase}/tickets`, {
      method: 'GET',
      headers: authHeaders(),
      params: query
    })
  }

  const getTicketById = async (id: number) => {
    return await $fetch(`${apiBase}/tickets/${id}`, {
      method: 'GET',
      headers: authHeaders()
    })
  }

  return {
    getEvents,
    getEvent,
    getTickets,
    getTicketById
  }
}