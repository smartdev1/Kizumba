/**
 * Composable centralisé pour toutes les requêtes vers l'API Laravel.
 * Remplace useWooCommerce, useEventFlow et les server/api/* existants.
 */
export const useApi = () => {
  const config = useRuntimeConfig()
  const baseUrl = config.public.apiBaseUrl

  // ─── Helpers ────────────────────────────────────────────────────────────────

  const get = <T = unknown>(path: string, query?: Record<string, string>) =>
    $fetch<T>(`${baseUrl}${path}`, { params: query })

  const post = <T = unknown>(path: string, body: object) =>
    $fetch<T>(`${baseUrl}${path}`, { method: 'POST', body: body as Record<string, unknown> })

  // ─── Artistes ───────────────────────────────────────────────────────────────

  const getArtists = () =>
    get<{ data: ApiArtist[] }>('/artists').then((r) => r.data)

  // ─── Tickets ────────────────────────────────────────────────────────────────

  /**
   * Retourne la liste des tickets actifs depuis l'API Laravel.
   */
  const getTickets = () =>
    get<{ data: ApiTicket[] }>('/tickets').then((r) => r.data)

  /**
   * Retourne le détail d'un ticket par son slug.
   */
  const getTicket = (slug: string) =>
    get<{ data: ApiTicket }>(`/tickets/${slug}`).then((r) => r.data)

  // ─── Paiement ───────────────────────────────────────────────────────────────

  /**
   * Initie un paiement PayDunya.
   * Retourne l'URL de paiement et le tx_ref.
   */
  const initiatePayment = (payload: PaymentPayload) =>
    post<{ payment_url: string; tx_ref: string; token: string }>(
      '/payments/initiate',
      payload,
    )

  /**
   * Vérifie le statut d'un paiement après retour PayDunya.
   */
  const getPaymentStatus = (txRef: string) =>
    get<PaymentStatus>(`/payments/${txRef}/status`)

  return {
    getArtists,
    getTickets,
    getTicket,
    initiatePayment,
    getPaymentStatus,
  }
}

// ─── Types ──────────────────────────────────────────────────────────────────

export interface ApiArtist {
  id: number
  name: string
  category: string
  specialty: string | null
  country: string | null
  country_flag: string | null
  image_url: string | null
  is_active: boolean
  display_order: number
}

export interface ApiTicket {
  id: number
  slug: string
  name: string
  description: string | null
  category: string
  price: number
  currency: string
  includes: string[]
  available_stock: number
  is_available: boolean
}

export interface CartItem {
  slug: string
  name: string
  quantity: number
  price: number
  currency: string
}

export interface PaymentPayload {
  customer: {
    name: string
    email: string
    phone?: string
  }
  items: Array<{
    slug: string
    quantity: number
  }>
}

export interface PaymentStatus {
  status: 'pending' | 'completed' | 'failed' | 'cancelled'
  amount: number
  currency: string
  customer_name: string
  customer_email: string
  issued_tickets: Array<{
    uid: string
    ticket_name: string
    status: string
  }>
}
