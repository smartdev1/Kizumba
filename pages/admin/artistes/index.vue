<template>
  <div class="space-y-6">

    <!-- Header + Onglets catégorie -->
    <div class="flex flex-wrap items-center justify-between gap-4">
      <div class="flex gap-2">
        <button v-for="cat in categories" :key="cat.key"
          @click="activeCategory = cat.key"
          class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-wider transition-all duration-150"
          :class="activeCategory === cat.key
            ? 'bg-gold text-black'
            : 'bg-white/5 text-white/50 border border-white/10 hover:border-white/30 hover:text-white'">
          {{ cat.label }} <span class="ml-1 opacity-60">{{ cat.count }}</span>
        </button>
      </div>
      <button @click="openCreate" class="px-4 py-2.5 bg-gold text-black font-black rounded-xl text-sm uppercase tracking-wider hover:bg-yellow-300 transition-colors">
        + Ajouter
      </button>
    </div>

    <!-- Grid -->
    <div v-if="loading" class="text-center py-16 text-white/30">Chargement...</div>
    <div v-else-if="!filteredArtists.length" class="text-center py-16 text-white/30">
      Aucun {{ activeCategory === 'dj' ? 'DJ' : 'professeur' }} enregistré
    </div>
    <div v-else class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
      <div v-for="artist in filteredArtists" :key="artist.id"
        class="bg-[#141414] border rounded-2xl overflow-hidden group transition-all duration-200"
        :class="artist.is_active ? 'border-white/5 hover:border-white/10' : 'border-white/5 opacity-50'">

        <!-- Image -->
        <div class="aspect-[3/4] relative overflow-hidden bg-gradient-to-br from-[#1a0e00] to-[#0a0500]">
          <img v-if="artist.image_url" :src="artist.image_url" :alt="artist.name"
            class="w-full h-full object-cover object-left-top opacity-90 group-hover:opacity-100 group-hover:scale-105 transition-all duration-300" />
          <div v-else class="absolute inset-0 flex items-center justify-center">
            <div class="text-5xl opacity-10">{{ artist.category === 'dj' ? '🎧' : '🎭' }}</div>
          </div>
          <div class="absolute top-3 left-3">
            <span class="px-2 py-1 rounded-full text-[10px] font-black uppercase bg-black/60 text-gold border border-gold/30">
              {{ artist.category === 'dj' ? 'DJ' : 'Prof' }}
            </span>
          </div>
          <div v-if="!artist.is_active" class="absolute inset-0 bg-black/50 flex items-center justify-center">
            <span class="text-white/50 text-xs font-bold">Masqué</span>
          </div>
        </div>

        <div class="p-4">
          <div class="font-black text-white text-sm leading-tight mb-0.5">{{ artist.name }}</div>
          <div class="text-gold text-xs mb-1">{{ artist.specialty }}</div>
          <div class="text-white/30 text-xs">{{ artist.country_flag }} {{ artist.country }}</div>

          <div class="flex gap-2 mt-4">
            <button @click="openEdit(artist)" class="flex-1 py-2 rounded-xl text-xs font-bold border border-white/10 text-white/60 hover:text-white hover:border-white/30 transition-all">
              ✏️ Modifier
            </button>
            <button @click="toggle(artist)" class="py-2 px-3 rounded-xl text-xs font-bold border transition-all"
              :class="artist.is_active
                ? 'border-yellow-500/20 text-yellow-400 hover:bg-yellow-500/10'
                : 'border-green-500/20 text-green-400 hover:bg-green-500/10'">
              {{ artist.is_active ? '👁️' : '👁️‍🗨️' }}
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
            <h2 class="font-black text-white">{{ modal === 'create' ? 'Nouvel artiste' : 'Modifier' }}</h2>
            <button @click="closeModal" class="text-white/30 hover:text-white transition-colors">✕</button>
          </div>

          <form @submit.prevent="submitArtist" class="px-6 py-6 space-y-4">

            <!-- Image -->
            <div>
              <label class="label-field">Photo</label>
              <div class="relative h-48 bg-black/40 border border-white/10 rounded-xl overflow-hidden cursor-pointer hover:border-gold/50 transition-colors"
                @click="imgInput?.click()">
                <img v-if="imagePreview" :src="imagePreview" class="w-full h-full object-cover object-left-top" />
                <div v-else class="absolute inset-0 flex flex-col items-center justify-center text-white/20 text-sm gap-2">
                  <span class="text-3xl">📷</span>
                  <span>Cliquer pour ajouter une photo</span>
                </div>
              </div>
              <input ref="imgInput" type="file" accept="image/*" class="hidden" @change="onImage" />
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div class="col-span-2">
                <label class="label-field">Nom *</label>
                <input v-model="form.name" required type="text" placeholder="DJ Fofo Jah" class="admin-input" />
              </div>
              <div>
                <label class="label-field">Catégorie *</label>
                <select v-model="form.category" required class="admin-input">
                  <option value="professeur">Professeur</option>
                  <option value="dj">DJ</option>
                </select>
              </div>
              <div>
                <label class="label-field">Spécialité</label>
                <input v-model="form.specialty" type="text" placeholder="Kizomba / DJ Set" class="admin-input" />
              </div>
              <div>
                <label class="label-field">Pays</label>
                <input v-model="form.country" type="text" placeholder="France" class="admin-input" />
              </div>
              <div>
                <label class="label-field">Drapeau (emoji)</label>
                <input v-model="form.country_flag" type="text" placeholder="🇫🇷" class="admin-input text-xl" />
              </div>
              <div class="col-span-2">
                <label class="label-field">Instagram</label>
                <input v-model="form.instagram" type="text" placeholder="@djfofojah" class="admin-input" />
              </div>
              <div class="col-span-2">
                <label class="label-field">Bio</label>
                <textarea v-model="form.bio" rows="3" placeholder="Quelques mots sur cet artiste..." class="admin-input resize-none" />
              </div>
              <div>
                <label class="label-field">Ordre d'affichage</label>
                <input v-model.number="form.display_order" type="number" min="0" class="admin-input" />
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
                {{ saving ? 'Enregistrement...' : (modal === 'create' ? 'Ajouter' : 'Enregistrer') }}
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

const { getArtists, createArtist, updateArtist, toggleArtist } = useAdminApi()

const artists       = ref<any[]>([])
const loading       = ref(false)
const activeCategory = ref('professeur')
const modal         = ref<null | 'create' | 'edit'>(null)
const saving        = ref(false)
const formError     = ref<string | null>(null)
const editId        = ref<number | null>(null)
const toast         = ref<{ msg: string; type: 'success' | 'error' } | null>(null)
const imageFile     = ref<File | null>(null)
const imagePreview  = ref<string | null>(null)
const imgInput      = ref<HTMLInputElement>()

const form = reactive({
  name: '', category: 'professeur', specialty: '',
  country: '', country_flag: '', bio: '', instagram: '',
  is_active: true, display_order: 0,
})

const categories = computed(() => [
  { key: 'professeur', label: '🎭 Professeurs', count: artists.value.filter(a => a.category === 'professeur').length },
  { key: 'dj',        label: '🎧 DJs',         count: artists.value.filter(a => a.category === 'dj').length },
])

const filteredArtists = computed(() =>
  artists.value.filter(a => a.category === activeCategory.value)
)

async function load() {
  loading.value = true
  try { artists.value = (await getArtists()).data ?? [] }
  finally { loading.value = false }
}

function resetForm() {
  Object.assign(form, { name: '', category: activeCategory.value, specialty: '', country: '', country_flag: '', bio: '', instagram: '', is_active: true, display_order: 0 })
  imageFile.value    = null
  imagePreview.value = null
  formError.value    = null
}

function openCreate() {
  resetForm()
  editId.value = null
  modal.value  = 'create'
}

function openEdit(artist: any) {
  resetForm()
  editId.value = artist.id
  Object.assign(form, {
    name:          artist.name ?? '',
    category:      artist.category ?? 'professeur',
    specialty:     artist.specialty ?? '',
    country:       artist.country ?? '',
    country_flag:  artist.country_flag ?? '',
    bio:           artist.bio ?? '',
    instagram:     artist.instagram ?? '',
    is_active:     artist.is_active ?? true,
    display_order: artist.display_order ?? 0,
  })
  imagePreview.value = artist.image_url ?? null
  modal.value = 'edit'
}

function closeModal() { modal.value = null }

function onImage(e: Event) {
  const file = (e.target as HTMLInputElement).files?.[0]
  if (!file) return
  imageFile.value    = file
  imagePreview.value = URL.createObjectURL(file)
}

async function submitArtist() {
  formError.value = null
  saving.value = true
  try {
    const fd = new FormData()
    Object.entries(form).forEach(([k, v]) => fd.append(k, typeof v === 'boolean' ? (v ? '1' : '0') : String(v)))
    if (imageFile.value) fd.append('image', imageFile.value)

    if (modal.value === 'create') {
      await createArtist(fd)
      showToast('Artiste ajouté avec succès')
    } else if (editId.value) {
      await updateArtist(editId.value, fd)
      showToast('Artiste mis à jour')
    }

    closeModal()
    await load()
  } catch (e: any) {
    formError.value = e?.data?.message ?? 'Une erreur est survenue'
  } finally {
    saving.value = false
  }
}

async function toggle(artist: any) {
  await toggleArtist(artist.id)
  await load()
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
