import { defineStore } from "pinia";

export const useCartStore = defineStore("cart", {
  state: () => ({
    items: [],
    total: 0,
    wpApi: {
      baseUrl: '',
      wcUrl: '',
      consumerKey: '',
      consumerSecret: '',
    },
    loading: false,
    error: null,
    synced: false,
  }),

  getters: {
    itemCount: (state) =>
      state.items.reduce((count, item) => count + item.quantity, 0),
    subtotal: (state) =>
      state.items.reduce((sum, item) => sum + item.price * item.quantity, 0),
  },

  actions: {
    addItem(ticket) {
      const existingItem = this.items.find((item) => item.id === ticket.id);

      if (existingItem) {
        existingItem.quantity += ticket.quantity;
      } else {
        this.items.push({ ...ticket });
      }

      this.calculateTotal();
    },

    removeItem(ticketId) {
      const index = this.items.findIndex((item) => item.id === ticketId);
      if (index > -1) {
        this.items.splice(index, 1);
      }
      this.calculateTotal();
    },

    updateQuantity(ticketId, quantity) {
      const item = this.items.find((item) => item.id === ticketId);
      if (item) {
        item.quantity = quantity;
        if (item.quantity <= 0) {
          this.removeItem(ticketId);
        }
      }
      this.calculateTotal();
    },

    calculateTotal() {
      this.total = this.subtotal;
    },

    clearCart() {
      this.items = [];
      this.total = 0;
    },

    // WordPress & WooCommerce API Methods using service
    async fetchWooCommerceProducts() {
      this.loading = true;
      this.error = null;
      try {
        const { $wooCommerce } = useNuxtApp();
        const products = await $wooCommerce.getProducts();
        return products;
      } catch (err) {
        this.error = err.message;
        console.error("WooCommerce API Error:", err);
        return [];
      } finally {
        this.loading = false;
      }
    },

    async createWooCommerceOrder(orderData = {}) {
      this.loading = true;
      this.error = null;
      try {
        const wpf = useRuntimeConfig().public.wpApiUrl.replace('/wp-json', '')
        const apiBase = `${wpf}/wp-json/eventflow/v1`
        // Use EventFlow API instead of WooCommerce
        const results = [];

        for (const item of this.items) {
          const ticketOrderData = {
            event_id: item.eventId,
            ticket_type: item.ticketType,
            quantity: item.quantity,
            customer_info: orderData.customer_info || orderData.billing,
          };

          // Use $fetch directly to call EventFlow API
          const response = await $fetch(`${apiBase}/tickets`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: ticketOrderData,
          });

          if (response.success) {
            results.push({
              item,
              result: response.data,
            });
          } else {
            throw new Error('Failed to create tickets for ' + item.name);
          }
        }

        return {
          success: true,
          orders: results,
        };
      } catch (err) {
        this.error = err.message;
        console.error("EventFlow Order Error:", err);
        return null;
      } finally {
        this.loading = false;
      }
    },

    async syncCartWithWooCommerce() {
      this.loading = true;
      this.error = null;
      try {
        // Add items to WooCommerce cart one by one
        const { $wooCommerce } = useNuxtApp();
        for (const item of this.items) {
          await $wooCommerce.addToCart({
            id: item.id.toString(),
            quantity: item.quantity,
          });
        }
        this.synced = true;
        return true;
      } catch (err) {
        this.error = err.message;
        console.error("WooCommerce Sync Error:", err);
        return false;
      } finally {
        this.loading = false;
      }
    },

    async loadCartFromWooCommerce() {
      this.loading = true;
      this.error = null;
      try {
        const { $wooCommerce } = useNuxtApp();
        const wcCart = await $wooCommerce.getCart();
        if (wcCart && wcCart.items) {
          this.items = wcCart.items.map((item) => ({
            id: item.id,
            name: item.name,
            price: parseFloat(item.price),
            quantity: item.quantity,
            image: item.images?.[0]?.src || "",
          }));
          this.calculateTotal();
        }
        return true;
      } catch (err) {
        this.error = err.message;
        console.error("Load Cart Error:", err);
        return false;
      } finally {
        this.loading = false;
      }
    },
  },

  persist: true,
});
