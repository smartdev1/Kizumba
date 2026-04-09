import { defineStore } from 'pinia'

// ─── Store ───────────────────────────────────────────────────────────────────
export const useEventStore = defineStore('event', {
  state: () => ({
    events: [],
    selectedEvent: null,
    eventTickets: [],
    eventLoading: false,
    eventError: null,

    // ⚠️ Map remplacé par objet plain pour compatibilité SSR/JSON
    eventCache: {},
    cacheExpiry: 5 * 60 * 1000,
    eventsLastFetch: null,

    // Info statique du festival
    eventInfo: {
      name: 'United Kizdom World Congress',
      location: 'Hilton Paris Charles de Gaulle Airport',
      address: '8 Rue de Rome, 93290 Tremblay-en-France, France',
      startDate: '2026-07-14',
      endDate: '2026-07-19',
      // Timestamp calculé une fois côté client pour éviter les problèmes SSR
      eventDate: 0, // initialisé côté client dans initEventDate()
    },

    countdown: { days: 0, hours: 0, minutes: 0, seconds: 0 },
    // Pas dans l'état Pinia — les timers ne sont pas sérialisables
  }),

  getters: {
    availableEvents: (state) => state.events.filter((e) => e.available),
    displayEvent: (state) => state.selectedEvent ?? state.eventInfo,
  },

  actions: {
    // ── Événements (stub — plus d'API WordPress) ──────────────────────────
    async fetchEvents() {
      // Le backend Laravel n'expose pas encore les événements via l'API.
      // Les tickets sont chargés directement dans shop.vue via useApi().
      this.eventLoading = false
      return []
    },

    async forceReloadEvents() {
      return this.fetchEvents()
    },

    setSelectedEvent(event) {
      this.selectedEvent = event
    },

    clearEventTickets() {
      this.eventTickets = []
      this.selectedEvent = null
    },

    cleanExpiredCache() {
      const now = Date.now()
      Object.entries(this.eventCache).forEach(([id, cached]) => {
        if ((now - cached.timestamp) >= this.cacheExpiry) {
          delete this.eventCache[id]
        }
      })
    },

    clearCache() {
      this.eventCache = {}
      this.eventsLastFetch = null
    },

    // ── Compte à rebours (client-only) ────────────────────────────────────

    initEventDate() {
      // ⚠️ Appelé uniquement depuis onMounted pour éviter les problèmes SSR
      this.eventInfo.eventDate = new Date('2026-07-14T00:00:00').getTime()
    },

    updateCountdown() {
      const distance = this.eventInfo.eventDate - Date.now()

      if (distance > 0) {
        this.countdown = {
          days:    Math.floor(distance / 86_400_000),
          hours:   Math.floor((distance % 86_400_000) / 3_600_000),
          minutes: Math.floor((distance % 3_600_000) / 60_000),
          seconds: Math.floor((distance % 60_000) / 1_000),
        }
      } else {
        this.countdown = { days: 0, hours: 0, minutes: 0, seconds: 0 }
      }
    },

    startCountdown() {
      // Stocker le timer dans une variable locale (non dans l'état Pinia)
      this.initEventDate()
      this.updateCountdown()
      if (!this._timer) {
        this._timer = setInterval(() => this.updateCountdown(), 1_000)
      }
    },

    stopCountdown() {
      if (this._timer) {
        clearInterval(this._timer)
        this._timer = null
      }
    },
  },
})