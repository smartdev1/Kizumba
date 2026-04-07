<template>
  <section id="billetterie" class="py-20 px-4 bg-gradient-to-b from-black to-gray-900">
    <div class="container mx-auto">
      <h2 class="section-title">Billetterie</h2>

      <!-- Loading State -->
      <div v-if="eventStore.eventLoading" class="text-center py-8">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-gold-500 mx-auto"></div>
        <p class="text-white mt-4">Chargement des événements...</p>
      </div>

      <!-- Error State -->
      <div v-else-if="eventStore.eventError" class="text-center py-8">
        <div class="bg-red-600 text-white p-4 rounded-lg max-w-md mx-auto">
          <p>{{ eventStore.eventError }}</p>
          <button @click="forceReloadEvents" class="mt-2 px-4 py-2 bg-white text-red-600 rounded">
            Réessayer
          </button>
        </div>
      </div>

      <!-- Events Grid -->
      <div v-else-if="eventStore.events.length > 0" class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
        <div v-for="event in eventStore.events" :key="event.id" class="card animate-slideInLeft">
          <div class="mb-4">
            <img :src="event.thumbnail || 'https://images.pexels.com/photos/1105666/pexels-photo-1105666.jpeg?auto=compress&cs=tinysrgb&w=600'"
                 :alt="event.title?.rendered || event.title"
                 class="w-full h-48 object-cover rounded-lg">
          </div>
          <h3 class="text-2xl font-bold mb-4 text-gold-500">{{ event.title?.rendered || event.title }}</h3>
          <div class="space-y-2 mb-6">
            <p class="flex items-center">
              <svg class="w-5 h-5 mr-2 text-gold-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
              </svg>
              📍 Lieu : {{ event.location || 'À définir' }}
            </p>
            <p class="flex items-center">
              <svg class="w-5 h-5 mr-2 text-gold-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
              </svg>
              📅 Date : {{ formatDate(event.start_at) }} - {{ formatDate(event.end_at) }}
            </p>
            <p class="flex items-center">
              <svg class="w-5 h-5 mr-2 text-gold-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
              </svg>
              🎟️ {{ event.sold_count || 0 }}/{{ event.capacity || '∞' }} places
            </p>
            <p class="flex items-center" v-if="event.base_price > 0">
              <svg class="w-5 h-5 mr-2 text-gold-500" fill="currentColor" viewBox="0 0 20 20">
                <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path>
              </svg>
              💰 À partir de {{ formatPrice(event.base_price) }}€
            </p>
            <div v-if="event.ticket_types && event.ticket_types.length > 0" class="mt-2">
              <p class="text-sm text-gray-400 mb-1">Types de tickets disponibles :</p>
              <div class="flex flex-wrap gap-1">
                <span v-for="type in event.ticket_types.slice(0, 3)" :key="type.slug"
                      class="text-xs bg-gold-500 text-black px-2 py-1 rounded">
                  {{ type.name }} - {{ formatPrice(type.price) }}€
                </span>
                <span v-if="event.ticket_types.length > 3" class="text-xs text-gray-400 px-2 py-1">
                  +{{ event.ticket_types.length - 3 }} autres
                </span>
              </div>
            </div>
          </div>
          <button @click="selectEvent(event)" class="btn-primary w-full text-center block">
            🎟️ Voir les tickets
          </button>
        </div>

        <!-- Default Info Card -->
        <div class="card animate-slideInRight">
          <h3 class="text-xl font-bold mb-4">Pourquoi participer ?</h3>
          <ul class="space-y-3">
            <li class="flex items-start">
              <span class="text-gold-500 mr-2">✓</span>
              <span>Des professeurs internationaux de renommée</span>
            </li>
            <li class="flex items-start">
              <span class="text-gold-500 mr-2">✓</span>
              <span>5 jours de workshops intensifs</span>
            </li>
            <li class="flex items-start">
              <span class="text-gold-500 mr-2">✓</span>
              <span>Soirées avec les meilleurs DJs</span>
            </li>
            <li class="flex items-start">
              <span class="text-gold-500 mr-2">✓</span>
              <span>Networking avec la communauté internationale</span>
            </li>
            <li class="flex items-start">
              <span class="text-gold-500 mr-2">✓</span>
              <span>Expérience unique à Paris</span>
            </li>
          </ul>
        </div>
      </div>

      <!-- No Events State -->
      <div v-else class="text-center py-8">
        <p class="text-gray-400 mb-4">Aucun événement disponible pour le moment</p>
        <button @click="forceReloadEvents" class="px-6 py-3 bg-gold-500 text-black rounded-lg hover:bg-gold-600">
          Actualiser
        </button>
      </div>
    </div>
  </section>
</template>

<script setup>
import { onMounted } from 'vue'
import { useEventStore } from '~/stores/event'

const eventStore = useEventStore()

const loadEvents = async () => {
  await eventStore.fetchEvents()
}

const forceReloadEvents = async () => {
  await eventStore.forceReloadEvents()
}

const selectEvent = async (event) => {
  // Rediriger vers la page checkout avec l'ID de l'événement dans l'URL
  await navigateTo(`/checkout?event_id=${event.id}`)
}

const formatDate = (dateString) => {
  if (!dateString) return 'Date à définir'
  try {
    const date = new Date(dateString)
    return date.toLocaleDateString('fr-FR', {
      day: 'numeric',
      month: 'long',
      year: 'numeric'
    })
  } catch (e) {
    return dateString
  }
}

const formatPrice = (price) => {
  return parseFloat(price).toFixed(2) + '€'
}

onMounted(() => {
  // Nettoyer le cache expiré au démarrage
  eventStore.cleanExpiredCache()
  loadEvents()
})
</script>
