import { wooCommerceService } from '~/services/woocommerce'

export default defineNuxtPlugin(() => {
  return {
    provide: {
      wooCommerce: wooCommerceService
    }
  }
})