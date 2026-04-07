import { $fetch } from 'ofetch'

class WooCommerceService {
  constructor() {
    this.baseUrl = null
    this.wcUrl = null
    this.consumerKey = null
    this.consumerSecret = null
    this.authToken = null
  }

  // Initialize config lazily on first use
  initConfig() {
    if (this.baseUrl) return // Already initialized
    
    const config = useRuntimeConfig().public
    this.baseUrl = config.wpApiUrl.replace('/wp-json', '')
    this.wcUrl = `${this.baseUrl}/wp-json/wc/v3`
    this.consumerKey = config.wcConsumerKey
    this.consumerSecret = config.wcConsumerSecret
    this.authToken = config.wpToken || ''
  }

  // Authentication headers for WooCommerce API
  getAuthHeaders() {
    return {
      'Authorization': `Basic ${btoa(`${this.consumerKey}:${this.consumerSecret}`)}`,
      'Content-Type': 'application/json'
    }
  }

  // WordPress authentication headers
  getWordPressHeaders() {
    return {
      'Authorization': `Bearer ${this.authToken}`,
      'Content-Type': 'application/json'
    }
  }

  // Generic fetch wrapper with error handling
  async apiRequest(endpoint, options = {}) {
    this.initConfig()
    try {
      const url = endpoint.startsWith('http') ? endpoint : `${this.wcUrl}${endpoint}`
      const response = await $fetch(url, {
        ...options,
        headers: {
          ...this.getAuthHeaders(),
          ...options.headers
        }
      })
      return response
    } catch (error) {
      console.error('WooCommerce API Error:', error)
      throw error
    }
  }

  // WordPress API request
  async wpRequest(endpoint, options = {}) {
    this.initConfig()
    try {
      const url = endpoint.startsWith('http') ? endpoint : `${this.baseUrl}${endpoint}`
      const response = await $fetch(url, {
        ...options,
        headers: {
          ...this.getWordPressHeaders(),
          ...options.headers
        }
      })
      return response
    } catch (error) {
      console.error('WordPress API Error:', error)
      throw error
    }
  }

  // PRODUCTS API METHODS
  async getProducts(params = {}) {
    return this.apiRequest('/products', { params })
  }

  async getProduct(productId) {
    return this.apiRequest(`/products/${productId}`)
  }

  async createProduct(productData) {
    return this.apiRequest('/products', {
      method: 'POST',
      body: productData
    })
  }

  async updateProduct(productId, productData) {
    return this.apiRequest(`/products/${productId}`, {
      method: 'PUT',
      body: productData
    })
  }

  async deleteProduct(productId, force = false) {
    return this.apiRequest(`/products/${productId}`, {
      method: 'DELETE',
      params: { force }
    })
  }

  // Get products by category
  async getProductsByCategory(categoryId, params = {}) {
    return this.apiRequest('/products', {
      params: { category: categoryId, ...params }
    })
  }

  // ORDERS API METHODS
  async getOrders(params = {}) {
    return this.apiRequest('/orders', { params })
  }

  async getOrder(orderId) {
    return this.apiRequest(`/orders/${orderId}`)
  }

  async createOrder(orderData) {
    return this.apiRequest('/orders', {
      method: 'POST',
      body: orderData
    })
  }

  async updateOrder(orderId, orderData) {
    return this.apiRequest(`/orders/${orderId}`, {
      method: 'PUT',
      body: orderData
    })
  }

  async deleteOrder(orderId, force = false) {
    return this.apiRequest(`/orders/${orderId}`, {
      method: 'DELETE',
      params: { force }
    })
  }

  // CUSTOMERS API METHODS
  async getCustomers(params = {}) {
    return this.apiRequest('/customers', { params })
  }

  async getCustomer(customerId) {
    return this.apiRequest(`/customers/${customerId}`)
  }

  async createCustomer(customerData) {
    return this.apiRequest('/customers', {
      method: 'POST',
      body: customerData
    })
  }

  async updateCustomer(customerId, customerData) {
    return this.apiRequest(`/customers/${customerId}`, {
      method: 'PUT',
      body: customerData
    })
  }

  // CART API METHODS
  async getCart() {
    return this.apiRequest('/cart')
  }

  async addToCart(cartItem) {
    return this.apiRequest('/cart/add', {
      method: 'POST',
      body: cartItem
    })
  }

  async updateCartItem(cartItemKey, cartItem) {
    return this.apiRequest(`/cart/${cartItemKey}`, {
      method: 'PUT',
      body: cartItem
    })
  }

  async removeFromCart(cartItemKey) {
    return this.apiRequest(`/cart/${cartItemKey}`, {
      method: 'DELETE'
    })
  }

  async clearCart() {
    return this.apiRequest('/cart', {
      method: 'DELETE'
    })
  }

  // CATEGORIES API METHODS
  async getCategories(params = {}) {
    return this.apiRequest('/products/categories', { params })
  }

  async getCategory(categoryId) {
    return this.apiRequest(`/products/categories/${categoryId}`)
  }

  async createCategory(categoryData) {
    return this.apiRequest('/products/categories', {
      method: 'POST',
      body: categoryData
    })
  }

  // WORDPRESS POSTS API METHODS
  async getPosts(params = {}) {
    return this.wpRequest('/wp/v2/posts', { params })
  }

  async getPost(postId) {
    return this.wpRequest(`/wp/v2/posts/${postId}`)
  }

  async createPost(postData) {
    return this.wpRequest('/wp/v2/posts', {
      method: 'POST',
      body: postData
    })
  }

  async updatePost(postId, postData) {
    return this.wpRequest(`/wp/v2/posts/${postId}`, {
      method: 'PUT',
      body: postData
    })
  }

  // EVENT-SPECIFIC METHODS
  async getEventTickets() {
    return this.getProductsByCategory('tickets')
  }

  async createEventTicket(ticketData) {
    return this.createProduct({
      ...ticketData,
      categories: [{ id: 'tickets' }],
      type: 'simple'
    })
  }

  async createEventOrder(cartItems, customerInfo) {
    const orderData = {
      line_items: cartItems.map(item => ({
        product_id: item.id,
        quantity: item.quantity,
        price: item.price
      })),
      billing: customerInfo.billing,
      shipping: customerInfo.shipping,
      customer_note: customerInfo.note || ''
    }

    return this.createOrder(orderData)
  }
}

export const wooCommerceService = new WooCommerceService()