<template>
  <section id="contact" class="py-20 px-4 bg-gradient-to-b from-gray-900 to-black">
    <div class="container mx-auto max-w-4xl">
      <h2 class="section-title">Contact</h2>

      <div class="grid md:grid-cols-2 gap-8">
        <div class="card">
          <h3 class="text-2xl font-bold mb-6 text-gold-500">Formulaire de contact</h3>
          <form @submit.prevent="submitForm" class="space-y-4">
            <div>
              <label class="block text-sm font-medium mb-2">Nom *</label>
              <input v-model="form.name" type="text" required class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg focus:outline-none focus:border-gold-500">
            </div>
            <div>
              <label class="block text-sm font-medium mb-2">Email *</label>
              <input v-model="form.email" type="email" required class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg focus:outline-none focus:border-gold-500">
            </div>
            <div>
              <label class="block text-sm font-medium mb-2">Sujet *</label>
              <input v-model="form.subject" type="text" required class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg focus:outline-none focus:border-gold-500">
            </div>
            <div>
              <label class="block text-sm font-medium mb-2">Message *</label>
              <textarea v-model="form.message" required rows="4" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg focus:outline-none focus:border-gold-500"></textarea>
            </div>
            <button type="submit" class="btn-primary w-full">Envoyer un message</button>
          </form>
        </div>

        <div class="card">
          <h3 class="text-xl font-bold mb-4">Informations</h3>
          <div class="space-y-4">
            <div>
              <h4 class="font-semibold text-gold-500 mb-2">Lieu</h4>
              <p class="text-gray-300">Hilton Paris Charles de Gaulle Airport</p>
              <p class="text-gray-300">8 Rue de Rome</p>
              <p class="text-gray-300">93290 Tremblay-en-France, France</p>
            </div>
            <div>
              <h4 class="font-semibold text-gold-500 mb-2">Date</h4>
              <p class="text-gray-300">19 - 23 Novembre 2026</p>
            </div>
            <div>
              <h4 class="font-semibold text-gold-500 mb-2">Contact</h4>
              <p class="text-gray-300">pariskizombacongress@gmail.com</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
const form = ref({
  name: '',
  email: '',
  subject: '',
  message: ''
})

const submitForm = () => {
  alert('Merci pour votre message ! Nous vous répondrons dans les plus brefs délais.')
  form.value = { name: '', email: '', subject: '', message: '' }
}
</script>
