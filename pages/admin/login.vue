<template>
  <div class="min-h-screen bg-[#0a0a0a] flex items-center justify-center px-4" style="font-family:'Nunito',sans-serif;">
    <div class="w-full max-w-sm">

      <!-- Logo -->
      <div class="text-center mb-10">
        <div class="text-4xl font-black tracking-widest text-gold mb-1" style="font-family:'Bebas Neue',sans-serif;">UKWC</div>
        <div class="text-white/30 text-xs tracking-[0.3em] uppercase">Administration</div>
      </div>

      <!-- Card -->
      <div class="bg-[#141414] border border-white/8 rounded-2xl p-8">
        <h1 class="text-white font-black text-xl mb-6">Connexion</h1>

        <form @submit.prevent="submit" class="space-y-4">
          <div>
            <label class="block text-white/40 text-xs uppercase tracking-wider mb-2">Email</label>
            <input v-model="form.email" type="email" placeholder="admin@ukwc.com" autocomplete="email"
              class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/20 focus:outline-none focus:border-gold/50 transition-colors text-sm"
              :class="{ 'border-red-500/50': error }" />
          </div>
          <div>
            <label class="block text-white/40 text-xs uppercase tracking-wider mb-2">Mot de passe</label>
            <input v-model="form.password" type="password" placeholder="••••••••" autocomplete="current-password"
              class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/20 focus:outline-none focus:border-gold/50 transition-colors text-sm"
              :class="{ 'border-red-500/50': error }" />
          </div>

          <div v-if="error" class="text-red-400 text-sm bg-red-500/10 border border-red-500/20 rounded-xl px-4 py-3">
            {{ error }}
          </div>

          <button type="submit" :disabled="loading"
            class="w-full py-3 rounded-xl font-extrabold uppercase tracking-widest text-sm transition-all duration-200"
            :class="loading ? 'bg-gold/50 text-black/50 cursor-wait' : 'bg-gold text-black hover:bg-gold-light'">
            <span v-if="loading" class="flex items-center justify-center gap-2">
              <span class="animate-spin inline-block w-4 h-4 border-2 border-black/30 border-t-black rounded-full"></span>
              Connexion...
            </span>
            <span v-else>Se connecter</span>
          </button>
        </form>
      </div>

    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: false })

const { login } = useAdminApi()

const form = reactive({ email: '', password: '' })
const loading = ref(false)
const error = ref<string | null>(null)

// Rediriger si déjà connecté (uniquement côté client pour éviter les problèmes d'hydration)
const token = useCookie('admin_token')
onMounted(() => {
  if (token.value) navigateTo('/admin')
})

async function submit() {
  error.value = null
  loading.value = true
  try {
    await login(form.email, form.password)
    await navigateTo('/admin')
  } catch (e: any) {
    error.value = e?.data?.message ?? 'Identifiants invalides'
  } finally {
    loading.value = false
  }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Nunito:wght@400;600;700;800;900&display=swap');
.text-gold   { color: #C9A84C; }
.bg-gold     { background-color: #C9A84C; }
.bg-gold-light { background-color: #F5D78A; }
</style>
