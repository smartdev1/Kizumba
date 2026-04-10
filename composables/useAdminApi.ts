// Composable centralisé pour les appels API admin
export function useAdminApi() {
  const token = useCookie('admin_token')
  const config = useRuntimeConfig()

  const base = config.public.apiBaseUrl

  function headers(): Record<string, string> {
    return {
      Authorization: `Bearer ${token.value ?? ''}`,
      Accept: 'application/json',
    }
  }

  async function api<T>(path: string, options: RequestInit = {}): Promise<T> {
    const res = await $fetch<T>(`${base}${path}`, {
      ...options,
      headers: {
        ...headers(),
        ...(options.headers ?? {}),
      },
    } as any)
    return res
  }

  // ── Auth ──────────────────────────────────────────────
  async function login(email: string, password: string) {
    const data = await $fetch<{ token: string; user: any }>(`${base}/admin/login`, {
      method: 'POST',
      body: { email, password },
    })
    token.value = data.token
    return data
  }

  async function logout() {
    await api('/admin/logout', { method: 'POST' })
    token.value = null
  }

  // ── Dashboard ─────────────────────────────────────────
  const getDashboard = () => api<any>('/admin/dashboard')

  // ── Tickets ───────────────────────────────────────────
  const getTickets = () => api<any>('/admin/tickets')

  async function createTicket(formData: FormData) {
    return $fetch<any>(`${base}/admin/tickets`, {
      method: 'POST',
      body: formData,
      headers: headers(),
    })
  }

  async function updateTicket(id: number, formData: FormData) {
    // Laravel ne supporte pas PUT multipart — on passe par POST + _method
    formData.append('_method', 'PUT')
    return $fetch<any>(`${base}/admin/tickets/${id}`, {
      method: 'POST',
      body: formData,
      headers: {
        ...headers(),
        'X-HTTP-Method-Override': 'PUT',
      },
    })
  }

  const deleteTicket = (id: number) => api<any>(`/admin/tickets/${id}`, { method: 'DELETE' })
  const toggleTicket = (id: number) => api<any>(`/admin/tickets/${id}/toggle`, { method: 'PATCH' })

  // ── Artistes ──────────────────────────────────────────
  const getArtists = () => api<any>('/admin/artists')

  async function createArtist(formData: FormData) {
    return $fetch<any>(`${base}/admin/artists`, {
      method: 'POST',
      body: formData,
      headers: headers(),
    })
  }

  async function updateArtist(id: number, formData: FormData) {
    formData.append('_method', 'PUT')
    return $fetch<any>(`${base}/admin/artists/${id}`, {
      method: 'POST',
      body: formData,
      headers: {
        ...headers(),
        'X-HTTP-Method-Override': 'PUT',
      },
    })
  }

  const deleteArtist = (id: number) => api<any>(`/admin/artists/${id}`, { method: 'DELETE' })
  const toggleArtist = (id: number) => api<any>(`/admin/artists/${id}/toggle`, { method: 'PATCH' })

  // ── Commandes ─────────────────────────────────────────
  const getOrders = (params?: Record<string, string>) => {
    const qs = params ? '?' + new URLSearchParams(params).toString() : ''
    return api<any>(`/admin/orders${qs}`)
  }

  const getOrder = (txRef: string) => api<any>(`/admin/orders/${txRef}`)
  const resendTickets = (txRef: string) => api<any>(`/admin/orders/${txRef}/resend`, { method: 'POST' })
  const validateTicket = (uid: string) => api<any>(`/admin/validate/${uid}`)

  return {
    login, logout,
    getDashboard,
    getTickets, createTicket, updateTicket, deleteTicket, toggleTicket,
    getArtists, createArtist, updateArtist, deleteArtist, toggleArtist,
    getOrders, getOrder, resendTickets, validateTicket,
  }
}
