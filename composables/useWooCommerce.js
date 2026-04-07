import { wooCommerceService } from '~/services/woocommerce'

export const useWooCommerce = () => {
  // Products
  const getProducts = async (params = {}) => {
    try {
      return await wooCommerceService.getProducts(params)
    } catch (error) {
      console.error('Failed to fetch products:', error)
      throw error
    }
  }

  const getProduct = async (productId) => {
    try {
      return await wooCommerceService.getProduct(productId)
    } catch (error) {
      console.error('Failed to fetch product:', error)
      throw error
    }
  }

  const createProduct = async (productData) => {
    try {
      return await wooCommerceService.createProduct(productData)
    } catch (error) {
      console.error('Failed to create product:', error)
      throw error
    }
  }

  // Orders
  const getOrders = async (params = {}) => {
    try {
      return await wooCommerceService.getOrders(params)
    } catch (error) {
      console.error('Failed to fetch orders:', error)
      throw error
    }
  }

  const createOrder = async (orderData) => {
    try {
      return await wooCommerceService.createOrder(orderData)
    } catch (error) {
      console.error('Failed to create order:', error)
      throw error
    }
  }

  // Cart operations
  const getCart = async () => {
    try {
      return await wooCommerceService.getCart()
    } catch (error) {
      console.error('Failed to fetch cart:', error)
      throw error
    }
  }

  const addToCart = async (cartItem) => {
    try {
      return await wooCommerceService.addToCart(cartItem)
    } catch (error) {
      console.error('Failed to add to cart:', error)
      throw error
    }
  }

  const updateCartItem = async (cartItemKey, cartItem) => {
    try {
      return await wooCommerceService.updateCartItem(cartItemKey, cartItem)
    } catch (error) {
      console.error('Failed to update cart item:', error)
      throw error
    }
  }

  const removeFromCart = async (cartItemKey) => {
    try {
      return await wooCommerceService.removeFromCart(cartItemKey)
    } catch (error) {
      console.error('Failed to remove from cart:', error)
      throw error
    }
  }

  const clearCart = async () => {
    try {
      return await wooCommerceService.clearCart()
    } catch (error) {
      console.error('Failed to clear cart:', error)
      throw error
    }
  }

  // Event-specific methods
  const getEventTickets = async () => {
    try {
      return await wooCommerceService.getEventTickets()
    } catch (error) {
      console.error('Failed to fetch event tickets:', error)
      throw error
    }
  }

  const createEventOrder = async (cartItems, customerInfo) => {
    try {
      return await wooCommerceService.createEventOrder(cartItems, customerInfo)
    } catch (error) {
      console.error('Failed to create event order:', error)
      throw error
    }
  }

  // WordPress integration
  const getPosts = async (params = {}) => {
    try {
      return await wooCommerceService.getPosts(params)
    } catch (error) {
      console.error('Failed to fetch posts:', error)
      throw error
    }
  }

  const createPost = async (postData) => {
    try {
      return await wooCommerceService.createPost(postData)
    } catch (error) {
      console.error('Failed to create post:', error)
      throw error
    }
  }

  // Utility methods
  const testConnection = async () => {
    return await wooCommerceService.testConnection()
  }

  const getSystemStatus = async () => {
    try {
      return await wooCommerceService.getSystemStatus()
    } catch (error) {
      console.error('Failed to get system status:', error)
      throw error
    }
  }

  return {
    // Products
    getProducts,
    getProduct,
    createProduct,

    // Orders
    getOrders,
    createOrder,

    // Cart
    getCart,
    addToCart,
    updateCartItem,
    removeFromCart,
    clearCart,

    // Events
    getEventTickets,
    createEventOrder,

    // WordPress
    getPosts,
    createPost,

    // Utils
    testConnection,
    getSystemStatus
  }
}