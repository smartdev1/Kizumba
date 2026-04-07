<template>
  <div class="min-h-screen">
    <NuxtLayout>
      <NuxtPage />
    </NuxtLayout>
  </div>
</template>

<script setup>
import { useEventStore } from '~/stores/event'

const eventStore = useEventStore()

// Start countdown on mount
onMounted(() => {
  eventStore.startCountdown()
})
</script>
