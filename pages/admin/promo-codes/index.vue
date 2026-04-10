<template>
  <div class="space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between">
      <p class="text-white/40 text-sm">{{ codes.length }} code{{ codes.length > 1 ? 's' : '' }} configuré{{ codes.length > 1 ? 's' : '' }}</p>
      <button @click="openCreate" class="px-4 py-2.5 bg-gold text-black font-black rounded-xl text-sm uppercase tracking-wider hover:bg-yellow-300 transition-colors">
        + Nouveau code
      </button>
    </div>

    <!-- Table -->
    <div v-if="loading" class="text-center py-16 text-white/30">Chargement...</div>
    <div v-else-if="codes.length === 0" class="text-center py-16 text-white/20">
      <p class="text-4xl mb-3">🏷️</p>
      <p>Aucun code promo configuré.</p>
    </div>
    <div v-else class="bg-[#141414] border border-white/5 rounded-2xl overflow-hidden">
      <table class="w-full text-sm">
        <thead>
          <tr class="border-b border-white/5 text-white/30 text-xs uppercase tracking-wider">
            <th class="text-left px-5 py-3">Code</th>
            <th class="text-left px-5 py-3">Réduction</th>
            <th class="text-left px-5 py-3">Utilisations</th>
            <th class="text-left px-5 py-3">Validité</th>
            <th class="text-left px-5 py-3">Statut</th>
            <th class="px-5 py-3"></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="code in codes" :key="code.id"
            class="border-b border-white/5 last:border-0 hover:bg-white/2 transition-colors"
            :class="{ 'opacity-40': !code.is_active }">
            <td class="px-5 py-4">
              <div class="font-mono font-black text-white tracking-widest">{{ code.code }}</div>
              <div v-if="code.description" class="text-white/30 text-xs mt-0.5">{{ code.description }}</div>
              <div v-if="code.applicable_slugs?.length" class="text-white/20 text-[10px] mt-0.5">
                Limité à : {{ code.applicable_slugs.join(', ') }}
              </div>
            </td>
            <td class="px-5 py-4">
              <span v-if="code.type === 'percentage'" class="text-gold font-black text-base">-{{ code.value }}%</span>
              <span v-else class="text-gold font-black text-base">-{{ code.value.toLocaleString() }} FCFA</span>
            </td>
            <td class="px-5 py-4 text-white/60">
              {{ code.uses_count }}
              <span v-if="code.max_uses" class="text-white/30"> / {{ code.max_uses }}</span>
              <span v-else class="text-white/20"> / ∞</span>
            </td>
            <td class="px-5 py-4 text-white/40 text-xs">
              <div v-if="code.starts_at">Dès {{ formatDate(code.starts_at) }}</div>
              <div v-if="code.expires_at">Jusqu'au {{ formatDate(code.expires_at) }}</div>
              <div v-if="!code.starts_at && !code.expires_at" class="text-white/20">Illimité</div>
            </td>
            <td class="px-5 py-4">
              <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase"
                :class="code.is_active ? 'bg-green-500/20 text-green-400' : 'bg-white/10 text-white/40'">
                {{ code.is_active ? 'Actif' : 'Inactif' }}
              </span>
            </td>
            <td class="px-5 py-4">
              <div class="flex items-center gap-2 justify-end">
                <button @click="openEdit(code)" class="p-2 rounded-lg text-white/40 hover:text-white hover:bg-white/5 transition-all" title="Modifier">✏️</button>
                <button @click="toggle(code)" class="p-2 rounded-lg transition-all"
                  :class="code.is_active ? 'text-yellow-400/60 hover:text-yellow-400 hover:bg-yellow-500/10' : 'text-green-400/60 hover:text-green-400 hover:bg-green-500/10'"
                  :title="code.is_active ? 'Désactiver' : 'Activer'">
                  {{ code.is_active ? '⏸' : '▶' }}
                </button>
                <button @click="confirmDelete(code)" class="p-2 rounded-lg text-red-400/40 hover:text-red-400 hover:bg-red-500/10 transition-all" title="Supprimer">🗑</button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Modal création / édition -->
    <Teleport to="body">
      <div v-if="modal" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-[#141414] border border-white/10 rounded-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto" @click.stop>

          <div class="px-6 py-5 border-b border-white/5 flex items-center justify-between">
            <h2 class="font-black text-white">{{ modal === 'create' ? 'Nouveau code promo' : 'Modifier le code' }}</h2>
            <button @click="closeModal" class="text-white/30 hover:text-white transition-colors">✕</button>
          </div>

          <form @submit.prevent="submit" class="px-6 py-6 space-y-4">

            <!-- Code -->
            <div>
              <label class="label-field">Code *</label>
              <input v-model="form.code" required type="text" placeholder="UKWC2026"
                class="admin-input uppercase font-mono tracking-widest"
                :disabled="modal === 'edit'" />
              <p class="text-white/25 text-[11px] mt-1">Le code sera automatiquement mis en majuscules.</p>
            </div>

            <!-- Description -->
            <div>
              <label class="label-field">Description (interne)</label>
              <input v-model="form.description" type="text" placeholder="Code presse / partenaires..." class="admin-input" />
            </div>

            <!-- Type + Valeur -->
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="label-field">Type *</label>
                <select v-model="form.type" required class="admin-input">
                  <option value="percentage">Pourcentage (%)</option>
                  <option value="fixed">Montant fixe (FCFA)</option>
                </select>
              </div>
              <div>
                <label class="label-field">Valeur *</label>
                <div class="relative">
                  <input v-model.number="form.value" required type="number" min="1"
                    :max="form.type === 'percentage' ? 100 : undefined"
                    :placeholder="form.type === 'percentage' ? 'Ex: 20' : 'Ex: 10000'"
                    class="admin-input pr-12" />
                  <span class="absolute right-3 top-1/2 -translate-y-1/2 text-white/30 text-sm font-bold">
                    {{ form.type === 'percentage' ? '%' : 'CFA' }}
                  </span>
                </div>
              </div>
            </div>

            <!-- Utilisations max -->
            <div>
              <label class="label-field">Nombre max d'utilisations</label>
              <input v-model.number="form.max_uses" type="number" min="1" placeholder="Laisser vide = illimité" class="admin-input" />
            </div>

            <!-- Dates -->
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="label-field">Valide à partir du</label>
                <input v-model="form.starts_at" type="datetime-local" class="admin-input" />
              </div>
              <div>
                <label class="label-field">Expire le</label>
                <input v-model="form.expires_at" type="datetime-local" class="admin-input" />
              </div>
            </div>

            <!-- Tickets applicables -->
            <div>
              <label class="label-field">Tickets applicables (slugs, un par ligne)</label>
              <textarea v-model="slugsText" rows="3"
                placeholder="Laisser vide = applicable à tous&#10;full-pass-standard&#10;parties-only"
                class="admin-input resize-none font-mono text-xs" />
              <p class="text-white/25 text-[11px] mt-1">Ne s'applique jamais aux billets en Early Bird, peu importe ce champ.</p>
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

const { getPromoCodes, createPromoCode, updatePromoCode, deletePromoCode, togglePromoCode } = useAdminApi()

const codes     = ref<any[]>([])
const loading   = ref(false)
const modal     = ref<null | 'create' | 'edit'>(null)
const saving    = ref(false)
const formError = ref<string | null>(null)
const editId    = ref<number | null>(null)
const toast     = ref<{ msg: string; type: 'success' | 'error' } | null>(null)
const slugsText = ref('')

const form = reactive({
  code:        '',
  description: '',
  type:        'percentage' as 'percentage' | 'fixed',
  value:       0,
  max_uses:    null as number | null,
  starts_at:   '',
  expires_at:  '',
})

async function load() {
  loading.value = true
  try { codes.value = (await getPromoCodes()).data ?? [] }
  finally { loading.value = false }
}

function resetForm() {
  Object.assign(form, { code: '', description: '', type: 'percentage', value: 0, max_uses: null, starts_at: '', expires_at: '' })
  slugsText.value = ''
  formError.value = null
}

function openCreate() {
  resetForm()
  editId.value = null
  modal.value  = 'create'
}

function openEdit(code: any) {
  resetForm()
  editId.value = code.id
  Object.assign(form, {
    code:        code.code ?? '',
    description: code.description ?? '',
    type:        code.type ?? 'percentage',
    value:       code.value ?? 0,
    max_uses:    code.max_uses ?? null,
    starts_at:   code.starts_at ? code.starts_at.slice(0, 16) : '',
    expires_at:  code.expires_at ? code.expires_at.slice(0, 16) : '',
  })
  slugsText.value = (code.applicable_slugs ?? []).join('\n')
  modal.value = 'edit'
}

function closeModal() { modal.value = null }

async function submit() {
  formError.value = null
  saving.value = true

  try {
    const applicable_slugs = slugsText.value
      .split('\n').map(s => s.trim()).filter(Boolean)

    const payload: any = {
      ...form,
      code:              form.code.toUpperCase().trim(),
      applicable_slugs:  applicable_slugs.length ? applicable_slugs : null,
      max_uses:          form.max_uses || null,
      starts_at:         form.starts_at || null,
      expires_at:        form.expires_at || null,
    }

    if (modal.value === 'create') {
      await createPromoCode(payload)
      showToast('Code promo créé avec succès')
    } else if (editId.value) {
      await updatePromoCode(editId.value, payload)
      showToast('Code promo mis à jour')
    }

    closeModal()
    await load()
  } catch (e: any) {
    const errs = e?.data?.errors
    formError.value = errs
      ? Object.values(errs).flat().join(' | ')
      : (e?.data?.message ?? e?.message ?? 'Une erreur est survenue')
  } finally {
    saving.value = false
  }
}

async function toggle(code: any) {
  await togglePromoCode(code.id)
  await load()
}

async function confirmDelete(code: any) {
  if (!confirm(`Supprimer le code « ${code.code} » ?`)) return
  try {
    await deletePromoCode(code.id)
    showToast('Code supprimé')
    await load()
  } catch (e: any) {
    showToast(e?.data?.message ?? 'Erreur lors de la suppression', 'error')
  }
}

function formatDate(iso: string) {
  return new Date(iso).toLocaleDateString('fr-FR', { day: '2-digit', month: '2-digit', year: 'numeric' })
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
