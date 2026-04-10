<template>
  <div class="space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between">
      <p class="text-white/40 text-sm">{{ tickets.length }} billet{{ tickets.length > 1 ? 's' : '' }} configurés</p>
      <button @click="openCreate" class="px-4 py-2.5 bg-gold text-black font-black rounded-xl text-sm uppercase tracking-wider hover:bg-yellow-300 transition-colors">
        + Nouveau billet
      </button>
    </div>

    <!-- Grid -->
    <div v-if="loading" class="text-center py-16 text-white/30">Chargement...</div>
    <div v-else class="grid md:grid-cols-2 xl:grid-cols-3 gap-4">
      <div v-for="ticket in tickets" :key="ticket.id"
        class="bg-[#141414] border rounded-2xl overflow-hidden group transition-all duration-200"
        :class="ticket.is_active ? 'border-white/5 hover:border-white/10' : 'border-white/5 opacity-50'">

        <!-- Image ou placeholder -->
        <div class="h-40 relative overflow-hidden bg-gradient-to-br from-[#1a1200] to-[#0a0800]">
          <img v-if="ticket.image_url" :src="ticket.image_url" :alt="ticket.name"
            class="w-full h-full object-cover opacity-80 group-hover:opacity-100 group-hover:scale-105 transition-all duration-300" />
          <div v-else class="absolute inset-0 flex items-center justify-center text-4xl opacity-20">🎫</div>
          <!-- Badge catégorie -->
          <div class="absolute top-3 left-3">
            <span class="px-2 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-black/60 text-gold border border-gold/30">
              {{ ticket.category }}
            </span>
          </div>
          <!-- Badge statut -->
          <div class="absolute top-3 right-3 flex flex-col items-end gap-1">
            <span class="px-2 py-1 rounded-full text-[10px] font-black uppercase"
              :class="ticket.is_active ? 'bg-green-500/20 text-green-400' : 'bg-white/10 text-white/40'">
              {{ ticket.is_active ? 'Actif' : 'Inactif' }}
            </span>
            <span v-if="isEarlyBirdActive(ticket)" class="px-2 py-1 rounded-full text-[10px] font-black uppercase bg-gold/20 text-gold border border-gold/30">
              🐦 Early Bird
            </span>
          </div>
        </div>

        <div class="p-5">
          <div class="flex items-start justify-between gap-2 mb-1">
            <h3 class="font-black text-white leading-tight">{{ ticket.name }}</h3>
            <span class="text-gold font-black text-lg flex-shrink-0">{{ ticket.price?.toLocaleString() }}</span>
          </div>
          <div class="text-white/30 text-xs mb-3">{{ ticket.currency ?? 'FCFA' }}</div>

          <!-- Stock bar -->
          <div class="mb-4">
            <div class="flex justify-between text-xs text-white/40 mb-1">
              <span>{{ ticket.sold ?? 0 }} vendus</span>
              <span>{{ ticket.available_stock ?? (ticket.stock - ticket.sold) }} restants / {{ ticket.stock }}</span>
            </div>
            <div class="h-1.5 bg-white/5 rounded-full overflow-hidden">
              <div class="h-full rounded-full"
                :class="stockColor(ticket)"
                :style="{ width: `${ticket.stock > 0 ? Math.min(100, ((ticket.sold ?? 0) / ticket.stock) * 100) : 0}%` }" />
            </div>
          </div>

          <!-- Actions -->
          <div class="flex gap-2">
            <button @click="openEdit(ticket)" class="flex-1 py-2 rounded-xl text-xs font-bold border border-white/10 text-white/60 hover:text-white hover:border-white/30 transition-all">
              ✏️ Modifier
            </button>
            <button @click="toggle(ticket)" class="py-2 px-3 rounded-xl text-xs font-bold border transition-all"
              :class="ticket.is_active
                ? 'border-yellow-500/20 text-yellow-400 hover:bg-yellow-500/10'
                : 'border-green-500/20 text-green-400 hover:bg-green-500/10'">
              {{ ticket.is_active ? 'Désactiver' : 'Activer' }}
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <Teleport to="body">
      <div v-if="modal" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-[#141414] border border-white/10 rounded-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto" @click.stop>

          <div class="px-6 py-5 border-b border-white/5 flex items-center justify-between">
            <h2 class="font-black text-white">{{ modal === 'create' ? 'Nouveau billet' : 'Modifier le billet' }}</h2>
            <button @click="closeModal" class="text-white/30 hover:text-white transition-colors">✕</button>
          </div>

          <form @submit.prevent="submitTicket" class="px-6 py-6 space-y-4">

            <!-- Image -->
            <div>
              <label class="label-field">Image du billet</label>
              <div class="relative h-32 bg-black/40 border border-white/10 rounded-xl overflow-hidden cursor-pointer hover:border-gold/50 transition-colors"
                @click="imgInput?.click()">
                <img v-if="imagePreview" :src="imagePreview" class="w-full h-full object-cover" />
                <div v-else class="absolute inset-0 flex flex-col items-center justify-center text-white/20 text-sm gap-2">
                  <span class="text-2xl">🖼️</span>
                  <span>Cliquer pour ajouter une image</span>
                </div>
              </div>
              <input ref="imgInput" type="file" accept="image/*" class="hidden" @change="onImage" />
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div class="col-span-2">
                <label class="label-field">Nom *</label>
                <input v-model="form.name" required type="text" placeholder="Pass 5 jours" class="admin-input" />
              </div>
              <div class="col-span-2">
                <label class="label-field">Sous-titre</label>
                <input v-model="form.subtitle" type="text" placeholder="Accès complet festival" class="admin-input" />
              </div>
              <div>
                <label class="label-field">Catégorie *</label>
                <select v-model="form.category" required class="admin-input">
                  <option value="" disabled>Choisir une catégorie</option>
                  <option value="Event Pass">Event Pass</option>
                  <option value="Full Pass & Stay">Full Pass & Stay</option>
                  <option value="Shape Your Experience">Shape Your Experience</option>
                </select>
              </div>
              <div>
                <label class="label-field">Devise</label>
                <input v-model="form.currency" type="text" placeholder="FCFA" class="admin-input" />
              </div>
              <div>
                <label class="label-field">Prix (FCFA) *</label>
                <input v-model.number="form.price" required type="number" min="0" class="admin-input" />
              </div>
              <div>
                <label class="label-field">Stock *</label>
                <input v-model.number="form.stock" required type="number" min="0" class="admin-input" />
              </div>
              <div class="col-span-2">
                <label class="label-field">Description</label>
                <textarea v-model="form.description" rows="3" placeholder="Ce billet donne accès à..." class="admin-input resize-none" />
              </div>

              <!-- Early Bird -->
              <div class="col-span-2">
                <div class="border border-gold/20 rounded-xl p-4 space-y-3 bg-gold/5">
                  <p class="text-gold text-xs font-black uppercase tracking-wider">🐦 Early Bird (optionnel)</p>
                  <div class="grid grid-cols-2 gap-3">
                    <div class="col-span-2 sm:col-span-1">
                      <label class="label-field">Prix Early Bird (FCFA)</label>
                      <input v-model.number="form.early_bird_price" type="number" min="0" placeholder="Ex: 80000" class="admin-input" />
                    </div>
                    <div class="col-span-2 sm:col-span-1 flex items-end">
                      <p v-if="form.early_bird_price && form.price" class="text-white/40 text-xs">
                        Réduction : {{ Math.round((1 - (form.early_bird_price as number) / form.price) * 100) }}%
                        (-{{ (form.price - (form.early_bird_price as number)).toLocaleString() }} FCFA)
                      </p>
                    </div>
                    <div>
                      <label class="label-field">Début Early Bird</label>
                      <input v-model="form.early_bird_starts_at" type="datetime-local" class="admin-input" />
                    </div>
                    <div>
                      <label class="label-field">Fin Early Bird</label>
                      <input v-model="form.early_bird_ends_at" type="datetime-local" class="admin-input" />
                    </div>
                  </div>
                  <p class="text-white/30 text-[11px]">Laisser vide pour désactiver l'Early Bird sur ce billet.</p>
                </div>
              </div>
              <div class="col-span-2">
                <label class="label-field">Inclus (une ligne par item)</label>
                <textarea v-model="includesText" rows="3" placeholder="Ateliers de danse&#10;Soirées sociales&#10;Masterclasses" class="admin-input resize-none font-mono text-sm" />
              </div>
            </div>

            <div v-if="formError" class="text-red-400 text-sm bg-red-500/10 border border-red-500/20 rounded-xl px-4 py-3">
              {{ formError }}
            </div>

            <div class="flex gap-3 pt-2">
              <button type="button" @click="closeModal" class="flex-1 py-3 rounded-xl border border-white/10 text-white/50 hover:text-white text-sm font-bold transition-all">
                Annuler
              </button>
              <button type="submit" :disabled="saving"
                class="flex-1 py-3 rounded-xl font-black text-sm uppercase tracking-wider transition-all"
                :class="saving ? 'bg-gold/40 text-black/50 cursor-wait' : 'bg-gold text-black hover:bg-yellow-300'">
                {{ saving ? 'Enregistrement...' : (modal === 'create' ? 'Créer' : 'Enregistrer') }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </Teleport>

    <!-- Toast -->
    <Transition name="fade">
      <div v-if="toast" class="fixed bottom-6 right-6 bg-[#1a1a1a] border border-white/10 rounded-2xl px-5 py-3 text-sm font-bold shadow-2xl"
        :class="toast.type === 'success' ? 'text-green-400' : 'text-red-400'">
        {{ toast.msg }}
      </div>
    </Transition>

  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'admin', middleware: 'admin-auth' })

const { getTickets, createTicket, updateTicket, toggleTicket } = useAdminApi()

const tickets   = ref<any[]>([])
const loading   = ref(false)
const modal     = ref<null | 'create' | 'edit'>(null)
const saving    = ref(false)
const formError = ref<string | null>(null)
const editId    = ref<number | null>(null)
const toast     = ref<{ msg: string; type: 'success' | 'error' } | null>(null)

// Form state
const form = reactive({
  name: '', subtitle: '', category: '', currency: 'FCFA',
  price: 0, stock: 0, description: '', is_active: true,
  early_bird_price: '' as number | '',
  early_bird_starts_at: '',
  early_bird_ends_at: '',
})
const includesText = ref('')
const imageFile    = ref<File | null>(null)
const imagePreview = ref<string | null>(null)
const imgInput     = ref<HTMLInputElement | null>(null)

function isEarlyBirdActive(ticket: any): boolean {
  if (!ticket.early_bird_price || !ticket.early_bird_starts_at || !ticket.early_bird_ends_at) return false
  const now = Date.now()
  return now >= new Date(ticket.early_bird_starts_at).getTime() && now <= new Date(ticket.early_bird_ends_at).getTime()
}

async function load() {
  loading.value = true
  try { tickets.value = (await getTickets()).data ?? [] }
  finally { loading.value = false }
}

function resetForm() {
  Object.assign(form, {
    name: '', subtitle: '', category: '', currency: 'FCFA',
    price: 0, stock: 0, description: '', is_active: true,
    early_bird_price: '', early_bird_starts_at: '', early_bird_ends_at: '',
  })
  includesText.value = ''
  imageFile.value    = null
  imagePreview.value = null
  formError.value    = null
}

function openCreate() {
  resetForm()
  editId.value = null
  modal.value  = 'create'
}

function openEdit(ticket: any) {
  resetForm()
  editId.value = ticket.id
  Object.assign(form, {
    name:                 ticket.name ?? '',
    subtitle:             ticket.subtitle ?? '',
    category:             ticket.category ?? '',
    currency:             ticket.currency ?? 'FCFA',
    price:                ticket.price ?? 0,
    stock:                ticket.stock ?? 0,
    description:          ticket.description ?? '',
    is_active:            ticket.is_active ?? true,
    early_bird_price:     ticket.early_bird_price ?? '',
    early_bird_starts_at: ticket.early_bird_starts_at ? ticket.early_bird_starts_at.slice(0, 16) : '',
    early_bird_ends_at:   ticket.early_bird_ends_at   ? ticket.early_bird_ends_at.slice(0, 16)   : '',
  })
  includesText.value = (ticket.includes ?? []).join('\n')
  imagePreview.value = ticket.image_url ?? null
  modal.value = 'edit'
}

function closeModal() { modal.value = null }

function onImage(e: Event) {
  const file = (e.target as HTMLInputElement).files?.[0]
  if (!file) return
  imageFile.value    = file
  imagePreview.value = URL.createObjectURL(file)
}

async function submitTicket() {
  formError.value = null
  saving.value = true
  try {
    const fd = new FormData()
    Object.entries(form).forEach(([k, v]) => {
      // Les champs early bird peuvent être vides — on les envoie comme chaîne vide
      // pour permettre au backend de les effacer
      if (typeof v === 'boolean') fd.append(k, v ? '1' : '0')
      else if (v === '' || v === null || v === undefined) fd.append(k, '')
      else fd.append(k, String(v))
    })
    const includes = includesText.value.split('\n').map(s => s.trim()).filter(Boolean)
    includes.forEach((item, i) => fd.append(`includes[${i}]`, item))
    if (imageFile.value) fd.append('image', imageFile.value)

    if (modal.value === 'create') {
      await createTicket(fd)
      showToast('Billet créé avec succès')
    } else if (editId.value) {
      await updateTicket(editId.value, fd)
      showToast('Billet mis à jour')
    }

    closeModal()
    await load()
  } catch (e: any) {
    console.error('submitTicket error', e?.status, e?.data)
    const errs = e?.data?.errors
    formError.value = errs
      ? Object.values(errs).flat().join(' | ')
      : (e?.data?.message ?? e?.message ?? 'Une erreur est survenue')
  } finally {
    saving.value = false
  }
}

async function toggle(ticket: any) {
  await toggleTicket(ticket.id)
  await load()
}

function stockColor(t: any) {
  const pct = t.stock > 0 ? ((t.sold ?? 0) / t.stock) * 100 : 0
  if (pct >= 100) return 'bg-red-500'
  if (pct >= 75)  return 'bg-yellow-500'
  return 'bg-green-500'
}

function showToast(msg: string, type: 'success' | 'error' = 'success') {
  toast.value = { msg, type }
  setTimeout(() => { toast.value = null }, 3000)
}

onMounted(load)
</script>

<style scoped>
.label-field { @apply block text-white/40 text-xs uppercase tracking-wider mb-1.5; }
.admin-input { @apply w-full bg-black/50 border border-white/10 rounded-xl px-4 py-2.5 text-white placeholder-white/20 text-sm focus:outline-none focus:border-yellow-600/50 transition-colors; }
.bg-gold     { background-color: #C9A84C; }
.text-gold   { color: #C9A84C; }
.fade-enter-active, .fade-leave-active { transition: opacity 0.2s, transform 0.2s; }
.fade-enter-from, .fade-leave-to       { opacity: 0; transform: translateY(8px); }
</style>
