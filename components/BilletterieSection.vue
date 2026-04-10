<template>
  <section id="billetterie" class="py-24 px-4 bg-gradient-to-b from-black to-gray-900">
    <div class="container mx-auto max-w-4xl text-center">

      <p class="text-[11px] tracking-[0.4em] uppercase text-[#C9A032]/60 mb-4">Billetterie officielle</p>
      <h2 class="text-4xl md:text-6xl font-black uppercase mb-6" style="font-family:'Bebas Neue',sans-serif;">
        United Kizdom World Congress<br />
        <span class="text-[#C9A032]">Congress 2026</span>
      </h2>
      <p class="text-gray-400 text-lg mb-4">
        19 – 23 Juillet 2026 · Cotonou, Bénin
      </p>

      <div class="flex flex-wrap justify-center gap-3 mb-12 text-sm text-white/70">
        <span class="border border-white/10 px-4 py-2 rounded-full">🎓 Workshops</span>
        <span class="border border-white/10 px-4 py-2 rounded-full">🎉 Soirées</span>
        <span class="border border-white/10 px-4 py-2 rounded-full">🎧 DJs internationaux</span>
        <span class="border border-white/10 px-4 py-2 rounded-full">🌍 Artistes du monde entier</span>
      </div>

      <NuxtLink
        to="/shop"
        class="inline-block bg-[#C9A032] hover:bg-[#e8b93a] text-black font-extrabold uppercase tracking-widest px-12 py-5 rounded-full transition-all duration-300 shadow-xl shadow-[#C9A032]/30 hover:-translate-y-1 text-base"
      >
        Voir les billets &amp; tarifs
      </NuxtLink>

    </div>
  </section>
</template>
