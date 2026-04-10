<template>
  <div class="flex items-center space-x-4 text-sm">
    <div class="text-center">
      <div class="text-2xl font-bold text-gold-500">{{ eventStore.countdown.days }}</div>
      <div class="text-xs text-gray-400">Jours</div>
    </div>
    <div class="text-center">
      <div class="text-2xl font-bold text-gold-500">{{ eventStore.countdown.hours }}</div>
      <div class="text-xs text-gray-400">Heures</div>
    </div>
    <div class="text-center">
      <div class="text-2xl font-bold text-gold-500">{{ eventStore.countdown.minutes }}</div>
      <div class="text-xs text-gray-400">Minutes</div>
    </div>
  </div>
</template>

<script setup>
import { useEventStore } from '~/stores/event'

const eventStore = useEventStore()

onMounted(() => eventStore.startCountdown())
onUnmounted(() => eventStore.stopCountdown())
</script>
