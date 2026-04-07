# Nuxt 3 Minimal Starter

Look at the [Nuxt 3 documentation](https://nuxt.com/docs/getting-started/introduction) to learn more.

## Setup

Make sure to install the dependencies:

```bash
# yarn
yarn install

# npm
npm install

# pnpm
pnpm install
```

## Development Server

Start the development server on http://localhost:3000

```bash
npm run dev
```

## Production

Build the application for production:

```bash
npm run build
```

Locally preview production build:

```bash
npm run preview
```

Check out the [deployment documentation](https://nuxt.com/docs/getting-started/deployment) for more information.

## WooCommerce Integration

This project includes a comprehensive WooCommerce service for syncing data between Nuxt.js and WordPress WooCommerce.

### Setup

1. Copy `.env.example` to `.env` and configure your WordPress/WooCommerce credentials:

```bash
cp .env.example .env
```

2. Fill in your WordPress and WooCommerce API details in `.env`

### Usage

#### Using the Composable

```javascript
const { getProducts, createOrder, getEventTickets } = useWooCommerce()

// Fetch all products
const products = await getProducts()

// Get event tickets
const tickets = await getEventTickets()

// Create an order
const order = await createOrder({
  line_items: [
    { product_id: 123, quantity: 2 }
  ],
  billing: { /* billing info */ }
})
```

#### Using the Service Directly

```javascript
const { $wooCommerce } = useNuxtApp()

// Test connection
const status = await $wooCommerce.testConnection()

// Get system status
const systemInfo = await $wooCommerce.getSystemStatus()
```

#### In Stores

The cart and event stores are already integrated with WooCommerce:

```javascript
const cartStore = useCartStore()

// Sync cart with WooCommerce
await cartStore.syncCartWithWooCommerce()

// Load cart from WooCommerce
await cartStore.loadCartFromWooCommerce()

const eventStore = useEventStore()

// Fetch event tickets
await eventStore.fetchEventTickets()

// Publish event update
await eventStore.publishEventUpdate('New event information!')
```

### API Methods Available

- **Products**: `getProducts()`, `getProduct()`, `createProduct()`, `updateProduct()`, `deleteProduct()`
- **Orders**: `getOrders()`, `getOrder()`, `createOrder()`, `updateOrder()`, `deleteOrder()`
- **Cart**: `getCart()`, `addToCart()`, `updateCartItem()`, `removeFromCart()`, `clearCart()`
- **Customers**: `getCustomers()`, `getCustomer()`, `createCustomer()`, `updateCustomer()`
- **Categories**: `getCategories()`, `getCategory()`, `createCategory()`
- **WordPress**: `getPosts()`, `getPost()`, `createPost()`, `updatePost()`
- **Events**: `getEventTickets()`, `createEventOrder()`

### Environment Variables

- `NUXT_PUBLIC_WP_API_URL`: Your WordPress site URL with `/wp-json` endpoint
- `NUXT_PUBLIC_WC_CONSUMER_KEY`: WooCommerce API consumer key
- `NUXT_PUBLIC_WC_CONSUMER_SECRET`: WooCommerce API consumer secret
- `NUXT_PUBLIC_WP_TOKEN`: WordPress authentication token for posting updates
