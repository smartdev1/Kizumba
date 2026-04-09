import { defineStore } from "pinia";

/**
 * Store panier — appels uniquement vers l'API Laravel.
 * WooCommerce / EventFlow / WordPress ont été supprimés.
 */
export const useCartStore = defineStore("cart", {
  state: () => ({
    /** @type {import('~/composables/useApi').CartItem[]} */
    items: [],
    total: 0,
    loading: false,
    error: null,
  }),

  getters: {
    itemCount: (state) =>
      state.items.reduce((count, item) => count + item.quantity, 0),

    subtotal: (state) =>
      state.items.reduce((sum, item) => sum + item.price * item.quantity, 0),

    isEmpty: (state) => state.items.length === 0,
  },

  actions: {
    /**
     * Ajoute un ticket au panier (ou incrémente la quantité).
     * @param {import('~/composables/useApi').ApiTicket} ticket
     * @param {number} quantity
     */
    addItem(ticket, quantity = 1) {
      const existing = this.items.find((i) => i.slug === ticket.slug);

      if (existing) {
        existing.quantity += quantity;
      } else {
        this.items.push({
          slug:     ticket.slug,
          name:     ticket.name,
          price:    ticket.price,
          currency: ticket.currency,
          quantity,
        });
      }

      this.calculateTotal();
    },

    removeItem(slug) {
      const index = this.items.findIndex((i) => i.slug === slug);
      if (index > -1) this.items.splice(index, 1);
      this.calculateTotal();
    },

    updateQuantity(slug, quantity) {
      const item = this.items.find((i) => i.slug === slug);
      if (!item) return;

      if (quantity <= 0) {
        this.removeItem(slug);
      } else {
        item.quantity = quantity;
        this.calculateTotal();
      }
    },

    calculateTotal() {
      this.total = this.subtotal;
    },

    clearCart() {
      this.items = [];
      this.total = 0;
      this.error = null;
    },

    clearError() {
      this.error = null;
    },
  },

  persist: true,
});
