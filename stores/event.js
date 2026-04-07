import { defineStore } from 'pinia'

// ─── Store ───────────────────────────────────────────────────────────────────
export const useEventStore = defineStore('event', {
  state: () => ({
    // Données EventFlow (API WordPress)
    events: [],
    selectedEvent: null,
    eventTickets: [],
    eventLoading: false,
    eventError: null,

    // Cache management
    eventCache: new Map(), // Map<id, {data: event, timestamp: Date}>
    cacheExpiry: 5 * 60 * 1000, // 5 minutes en millisecondes
    eventsLastFetch: null, // Timestamp de la dernière récupération de la liste complète

    // Info statique de secours (affiché si l'API ne répond pas)
    eventInfo: {
      name: 'Paris Kizomba Congress',
      location: 'Hilton Paris Charles de Gaulle Airport',
      address: '8 Rue de Rome, 93290 Tremblay-en-France, France',
      startDate: '2026-11-19',
      endDate: '2026-11-23',
      eventDate: new Date('2026-11-19T20:00:00').getTime()
    },

    countdown: { days: 0, hours: 0, minutes: 0, seconds: 0 },
    _countdownTimer: null
  }),

  getters: {
    // Événements disponibles uniquement
    availableEvents: (state) => state.events.filter((e) => e.available),

    // Récupère un événement par son ID depuis le cache avec vérification d'expiration
    eventById: (state) => (id) => {
      const cached = state.eventCache.get(id)
      if (cached && (Date.now() - cached.timestamp) < state.cacheExpiry) {
        return cached.data
      }
      // Si expiré ou non trouvé, supprimer du cache
      if (cached) state.eventCache.delete(id)
      return null
    },

    // Détermine la source de données affichée (API ou statique)
    displayEvent: (state) => state.selectedEvent ?? state.eventInfo
  },

  actions: {
    // ── Événements ────────────────────────────────────────────────────────

    async fetchEvents(params = {}) {
      // Vérifier si on a des événements récents en cache
      const now = Date.now()
      if (this.eventsLastFetch && (now - this.eventsLastFetch) < this.cacheExpiry && this.events.length > 0) {
        // Utiliser le cache si disponible et récent
        return this.events
      }

      this.eventLoading = true
      this.eventError = null

      try {
        const apiBase = useRuntimeConfig().public.wpApiUrl + '/eventflow/v1'
        const url = new URL(`${apiBase}/events`)

        // Paramètres optionnels : page, per_page, upcoming, category
        Object.entries(params).forEach(([k, v]) => {
          if (v !== undefined && v !== null) url.searchParams.set(k, v)
        })

        const response = await fetch(url.toString(), {
          headers: { 'Content-Type': 'application/json' }
        })

        if (!response.ok) {
          throw new Error(`HTTP ${response.status} — ${response.statusText}`)
        }

        const data = await response.json()
        // Le contrôleur REST retourne {success: true, data: [...]}
        this.events = Array.isArray(data.data) ? data.data : []

        // Mettre à jour le timestamp de dernière récupération
        this.eventsLastFetch = now

        // Mettre en cache tous les événements chargés
        this.events.forEach(event => {
          this.eventCache.set(event.id, {
            data: event,
            timestamp: now
          })
        })

        return this.events
      } catch (err) {
        this.eventError = err.message || 'Erreur lors du chargement des événements'
        console.error('[EventFlow] fetchEvents:', err)
        return []
      } finally {
        this.eventLoading = false
      }
    },

    async fetchEvent(eventId) {
      // Vérifier d'abord le cache
      const cached = this.eventById(eventId)
      if (cached) {
        this.selectedEvent = cached
        return cached
      }

      this.eventLoading = true
      this.eventError = null

      try {
        const apiBase = useRuntimeConfig().public.wpApiUrl + '/eventflow/v1'
        const response = await fetch(`${apiBase}/events/${eventId}`, {
          headers: { 'Content-Type': 'application/json' }
        })

        if (!response.ok) {
          throw new Error(`HTTP ${response.status} — ${response.statusText}`)
        }

        const data = await response.json()
        const event = data.data // Extract the event from the API response wrapper
        this.selectedEvent = event

        // Ajouter au cache avec timestamp
        this.eventCache.set(event.id, {
          data: event,
          timestamp: Date.now()
        })

        // Met à jour aussi la liste events si l'événement y est déjà
        const idx = this.events.findIndex((e) => e.id === event.id)
        if (idx !== -1) this.events[idx] = event

        return event
      } catch (err) {
        this.eventError = err.message || 'Erreur lors du chargement de l\'événement'
        console.error('[EventFlow] fetchEvent:', err)
        return null
      } finally {
        this.eventLoading = false
      }
    },

    // ── Tickets ───────────────────────────────────────────────────────────

    async fetchEventTickets(eventId) {
      this.eventLoading = true
      this.eventError = null

      try {
        // GET /wp-json/eventflow/v1/tickets?event_id=X
        // Note : endpoint authenticated → passer le token JWT si connecté
        const url = new URL(`${API_BASE}/tickets`)
        url.searchParams.set('event_id', eventId)

        const headers = { 'Content-Type': 'application/json' }
        const token = this._getJWT()
        if (token) headers['Authorization'] = `Bearer ${token}`

        const response = await fetch(url.toString(), { headers })

        if (!response.ok) {
          throw new Error(`HTTP ${response.status} — ${response.statusText}`)
        }

        const data = await response.json()
        this.eventTickets = Array.isArray(data.data) ? data.data : []
        return this.eventTickets
      } catch (err) {
        this.eventError = err.message || 'Erreur lors du chargement des tickets'
        console.error('[EventFlow] fetchEventTickets:', err)
        return []
      } finally {
        this.eventLoading = false
      }
    },

    async fetchMyTickets() {
      this.eventLoading = true
      this.eventError = null

      try {
        const token = this._getJWT()
        if (!token) throw new Error('Non authentifié — connectez-vous d\'abord.')

        const response = await fetch(`${API_BASE}/me/tickets`, {
          headers: {
            'Content-Type': 'application/json',
            Authorization: `Bearer ${token}`
          }
        })

        if (!response.ok) {
          throw new Error(`HTTP ${response.status} — ${response.statusText}`)
        }

        const data = await response.json()
        this.eventTickets = Array.isArray(data.data) ? data.data : []
        return this.eventTickets
      } catch (err) {
        this.eventError = err.message
        console.error('[EventFlow] fetchMyTickets:', err)
        return []
      } finally {
        this.eventLoading = false
      }
    },

    // ── Sélection / reset ─────────────────────────────────────────────────

    setSelectedEvent(event) {
      this.selectedEvent = event
    },

    clearEventTickets() {
      this.eventTickets = []
      this.selectedEvent = null
    },

    // ── Compte à rebours ──────────────────────────────────────────────────

    updateCountdown() {
      const distance = this.eventInfo.eventDate - Date.now()

      if (distance > 0) {
        this.countdown = {
          days:    Math.floor(distance / 86_400_000),
          hours:   Math.floor((distance % 86_400_000) / 3_600_000),
          minutes: Math.floor((distance % 3_600_000) / 60_000),
          seconds: Math.floor((distance % 60_000) / 1_000)
        }
      } else {
        this.countdown = { days: 0, hours: 0, minutes: 0, seconds: 0 }
      }
    },

    startCountdown() {
      if (this._countdownTimer) return // évite les doublons
      this.updateCountdown()
      this._countdownTimer = setInterval(() => this.updateCountdown(), 1_000)
    },

    stopCountdown() {
      if (this._countdownTimer) {
        clearInterval(this._countdownTimer)
        this._countdownTimer = null
      }
    },

    // ── Cache Management ──────────────────────────────────────────────────

    // Nettoie les entrées expirées du cache
    cleanExpiredCache() {
      const now = Date.now()
      for (const [id, cached] of this.eventCache.entries()) {
        if ((now - cached.timestamp) >= this.cacheExpiry) {
          this.eventCache.delete(id)
        }
      }
    },

    // Vide complètement le cache
    clearCache() {
      this.eventCache.clear()
      this.eventsLastFetch = null
    },

    // Force le rechargement de la liste complète des événements (ignore le cache)
    async forceReloadEvents(params = {}) {
      this.eventsLastFetch = null // Forcer le rechargement
      return await this.fetchEvents(params)
    },

    // ── Privé ─────────────────────────────────────────────────────────────

    _getJWT() {
      // Adaptez selon votre système d'auth (localStorage, cookie, autre store…)
      return localStorage.getItem('ef_token') ?? null
    }
  }
})