import { defineStore } from "pinia";

/**
 * Store panier — appels uniquement vers l'API Laravel.
 * Gère aussi le code promo et les réductions associées.
 */
export const useCartStore = defineStore("cart", {
  state: () => ({
    /** @type {import('~/composables/useApi').CartItem[]} */
    items: [],
    total: 0,
    loading: false,
    error: null,

    // Code promo appliqué
    promoCode: null,        // string | null
    promoData: null,        // réponse complète du serveur après validation
    promoLoading: false,
    promoError: null,
  }),

  getters: {
    itemCount: (state) =>
      state.items.reduce((count, item) => count + item.quantity, 0),

    subtotal: (state) =>
      state.items.reduce((sum, item) => sum + item.price * item.quantity, 0),

    isEmpty: (state) => state.items.length === 0,

    /** Montant total de la réduction (0 si pas de promo) */
    discountAmount: (state) => state.promoData?.total_discount ?? 0,

    /** Total après réduction */
    totalAfterDiscount: (state) => {
      const sub = state.items.reduce((sum, item) => sum + item.price * item.quantity, 0);
      return sub - (state.promoData?.total_discount ?? 0);
    },

    /** Vrai si un code promo valide est appliqué */
    hasPromo: (state) => !!state.promoData?.valid,
  },

  actions: {
    /**
     * Ajoute un ticket au panier (ou incrémente la quantité).
     * Réinitialise le code promo car le panier a changé.
     * @param {import('~/composables/useApi').ApiTicket} ticket
     * @param {number} quantity
     */
    addItem(ticket, quantity = 1) {
      const existing = this.items.find((i) => i.slug === ticket.slug);

      if (existing) {
        existing.quantity += quantity;
      } else {
        this.items.push({
          slug:          ticket.slug,
          name:          ticket.name,
          price:         ticket.effective_price ?? ticket.price,
          originalPrice: ticket.price,
          currency:      ticket.currency,
          isEarlyBird:   ticket.is_early_bird ?? false,
          quantity,
        });
      }

      this.calculateTotal();
      // On vide le promo validé car le panier a changé
      this._clearPromoData();
    },

    removeItem(slug) {
      const index = this.items.findIndex((i) => i.slug === slug);
      if (index > -1) this.items.splice(index, 1);
      this.calculateTotal();
      this._clearPromoData();
    },

    updateQuantity(slug, quantity) {
      const item = this.items.find((i) => i.slug === slug);
      if (!item) return;

      if (quantity <= 0) {
        this.removeItem(slug);
      } else {
        item.quantity = quantity;
        this.calculateTotal();
        this._clearPromoData();
      }
    },

    calculateTotal() {
      this.total = this.subtotal;
    },

    clearCart() {
      this.items = [];
      this.total = 0;
      this.error = null;
      this._clearPromoData();
    },

    clearError() {
      this.error = null;
    },

    // ── Promo code ────────────────────────────────────────────────────────────

    /**
     * Valide un code promo auprès du serveur et stocke le résultat.
     */
    async validatePromo(code) {
      if (!code?.trim()) return;

      this.promoLoading = true;
      this.promoError   = null;

      const payload = {
        code,
        items: this.items.map((i) => ({ slug: i.slug, quantity: i.quantity })),
      };

      try {
        const config = useRuntimeConfig();
        const res = await $fetch(`${config.public.apiBaseUrl}/promo-codes/validate`, {
          method: 'POST',
          body:   payload,
        });

        this.promoCode = code.toUpperCase().trim();
        this.promoData = res;
        this.promoError = null;
      } catch (err) {
        this.promoData  = null;
        this.promoCode  = null;
        this.promoError = err?.data?.message ?? 'Code promo invalide.';
      } finally {
        this.promoLoading = false;
      }
    },

    removePromo() {
      this._clearPromoData();
    },

    _clearPromoData() {
      this.promoCode  = null;
      this.promoData  = null;
      this.promoError = null;
    },
  },

  persist: true,
});
