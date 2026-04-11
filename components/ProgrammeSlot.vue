<!-- components/ProgrammeSlot.vue -->
<template>
  <div>
    <div class="absolute top-0 right-0 w-24 h-24 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 bg-gold-500/10" />

    <div class="flex items-start justify-between mb-4">
      <span class="text-gold-400 font-mono text-sm font-bold">{{ slotKey }}</span>
      <span class="text-[10px] uppercase tracking-widest px-2 py-1 rounded-full border" :class="slotTypeClass(slot.type)">
        {{ getSlotTypeLabel(slot.type) }}
      </span>
    </div>

    <!-- Tourisme -->
    <div v-if="slot.type === 'tourisme'">
      <h4 class="font-black uppercase text-base mb-2">Tourisme</h4>
      <div class="space-y-2">
        <div v-for="activity in slot.activities" :key="activity" class="flex items-start gap-2 text-white/60 text-sm">
          <span class="w-4 h-4 rounded-full bg-gold-500/20 flex items-center justify-center text-gold-400 text-xs mt-0.5 flex-shrink-0">✓</span>
          <span>{{ activity }}</span>
        </div>
      </div>
    </div>

    <!-- Welcome Party -->
    <div v-else-if="slot.type === 'welcome_party'">
      <h4 class="font-black uppercase text-base mb-2">Cocktail d'ouverture</h4>
      <div class="space-y-2">
        <div v-for="activity in slot.activities" :key="activity" class="flex items-start gap-2 text-white/60 text-sm">
          <span class="w-4 h-4 rounded-full bg-gold-500/20 flex items-center justify-center text-gold-400 text-xs mt-0.5 flex-shrink-0">✓</span>
          <span>{{ activity }}</span>
        </div>
      </div>
    </div>

    <!-- Competition / Battle -->
    <div v-else-if="slot.type === 'competition'">
      <h4 class="font-black uppercase text-base mb-2">{{ slot.title }}</h4>
      <p class="text-white/40 text-sm mb-2">{{ slot.description }}</p>
      <p v-if="slot.note" class="text-gold-400 text-xs italic mb-2">{{ slot.note }}</p>
      <p v-if="slot.party" class="text-white/30 text-xs">{{ slot.party }}</p>
    </div>

    <!-- Party / Gala -->
    <div v-else-if="slot.type === 'party' || slot.type === 'gala'">
      <h4 class="font-black uppercase text-base mb-2">{{ slot.title }}</h4>
      <p class="text-white/40 text-sm">{{ slot.description }}</p>
      <div v-if="slot.activities" class="mt-2 space-y-1">
        <div v-for="activity in slot.activities" :key="activity" class="text-white/50 text-xs">{{ activity }}</div>
      </div>
      <p v-if="slot.dj_start" class="text-white/30 text-xs mt-2">🎧 DJ à partir de {{ slot.dj_start }}</p>
    </div>

    <!-- Workshops -->
    <div v-else-if="slot.type === 'workshops' || slot.type === 'workshops_social' || slot.type === 'workshops_masterclasses'">
      <h4 class="font-black uppercase text-base mb-2">
        {{ slot.type === 'workshops_masterclasses' ? 'Workshops & Masterclasses' : 'Workshops' }}
      </h4>
      <p class="text-white/40 text-sm">Session de danse avec nos artistes internationaux</p>
      <p class="text-white/30 text-xs mt-2">📍 Salles A, B, C</p>
    </div>

    <!-- Break -->
    <div v-else-if="slot.type === 'break'">
      <h4 class="font-black uppercase text-base mb-2">⏸️ {{ slot.label || 'Pause' }}</h4>
      <p class="text-white/40 text-sm">Temps libre pour profiter du site, vous restaurer ou vous détendre</p>
    </div>

    <!-- Brunch -->
    <div v-else-if="slot.type === 'brunch'">
      <h4 class="font-black uppercase text-base mb-2">🍳 {{ slot.title }}</h4>
      <p class="text-white/40 text-sm">Dernier moment de convivialité entre festivaliers</p>
    </div>

    <!-- Social -->
    <div v-else-if="slot.type === 'social'">
      <h4 class="font-black uppercase text-base mb-2">🎧 Social Dancing</h4>
      <p class="text-white/40 text-sm">{{ slot.description }}</p>
    </div>

    <!-- Default -->
    <div v-else>
      <h4 class="font-black uppercase text-base mb-2">{{ slot.title || slot.type }}</h4>
      <p class="text-white/40 text-sm">{{ slot.description }}</p>
    </div>

    <p class="text-white/30 text-xs mt-3 font-mono">{{ slotKey }}</p>
  </div>
</template>

<script setup>
defineProps({
  slot: {
    type: Object,
    required: true
  },
  slotKey: {
    type: String,
    required: true
  }
})

const getSlotTypeLabel = (type) => {
  const labels = {
    'tourisme': '🌍 Tourisme',
    'break': '⏸️ Pause',
    'workshops': '💃 Workshops',
    'workshops_social': '💃 Workshops & Social',
    'workshops_masterclasses': '🎓 Masterclasses',
    'social': '🎧 Social',
    'welcome_party': '🥂 Welcome',
    'competition': '⚔️ Battle',
    'party': '🎉 Party',
    'gala': '✨ Gala',
    'brunch': '🍳 Brunch'
  }
  return labels[type] || type
}

const slotTypeClass = (type) => {
  const map = {
    'tourisme': 'border-green-500/30 text-green-400',
    'break': 'border-gray-500/30 text-gray-400',
    'workshops': 'border-blue-500/30 text-blue-400',
    'workshops_social': 'border-blue-500/30 text-blue-400',
    'workshops_masterclasses': 'border-purple-500/30 text-purple-400',
    'social': 'border-purple-500/30 text-purple-400',
    'welcome_party': 'border-gold-500/30 text-gold-400',
    'competition': 'border-red-500/30 text-red-400',
    'party': 'border-pink-500/30 text-pink-400',
    'gala': 'border-gold-500/40 text-gold-400',
    'brunch': 'border-orange-500/30 text-orange-400',
  }
  return map[type] || 'border-white/20 text-white/40'
}
</script>