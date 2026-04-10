<template>
  <footer class="bg-black border-t border-[#C9A032]/20 pt-16 pb-8 px-4">
    <div class="container mx-auto max-w-6xl">

      <!-- Grille principale -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">

        <!-- Identité -->
        <div class="md:col-span-2">
          <h3
            class="text-2xl font-black uppercase tracking-wider mb-2"
            style="font-family:'Bebas Neue',sans-serif; color:#C9A032;"
          >
            United Kizdom<br />World Congress
          </h3>
          <p class="text-[#C9A032]/60 text-xs tracking-[0.25em] uppercase mb-4">Cotonou · Bénin · 2026</p>
          <p class="text-gray-400 text-sm leading-relaxed max-w-sm">
            Le plus grand congrès de kizomba d'Afrique de l'Ouest.
            Workshops, soirées, artistes internationaux — une expérience unique au cœur du Bénin.
          </p>

          <!-- Réseaux sociaux -->
          <div class="flex gap-4 mt-6">
            <a
              href="https://www.instagram.com/united_kizdom?igsh=MW9hZXd4M3Ryd2pwag=="
              target="_blank"
              rel="noopener noreferrer"
              aria-label="Instagram"
              class="group w-10 h-10 rounded-full border border-[#C9A032]/30 flex items-center justify-center text-[#C9A032]/60 hover:border-[#C9A032] hover:text-[#C9A032] hover:bg-[#C9A032]/10 transition-all duration-300"
            >
              <!-- Instagram -->
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
              </svg>
            </a>
            <a
              href="https://www.facebook.com/profile.php?id=61574658126622"
              target="_blank"
              rel="noopener noreferrer"
              aria-label="Facebook"
              class="group w-10 h-10 rounded-full border border-[#C9A032]/30 flex items-center justify-center text-[#C9A032]/60 hover:border-[#C9A032] hover:text-[#C9A032] hover:bg-[#C9A032]/10 transition-all duration-300"
            >
              <!-- Facebook -->
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
              </svg>
            </a>
          </div>
        </div>

        <!-- Navigation -->
        <div>
          <h4 class="text-xs tracking-[0.25em] uppercase text-[#C9A032]/60 mb-5">Navigation</h4>
          <ul class="space-y-3">
            <li>
              <NuxtLink to="/#billetterie" class="text-gray-400 hover:text-[#C9A032] transition-colors text-sm">Billetterie</NuxtLink>
            </li>
            <li>
              <NuxtLink to="/#professeurs" class="text-gray-400 hover:text-[#C9A032] transition-colors text-sm">Artistes & Profs</NuxtLink>
            </li>
            <li>
              <NuxtLink to="/#dj" class="text-gray-400 hover:text-[#C9A032] transition-colors text-sm">DJs</NuxtLink>
            </li>
            <li>
              <NuxtLink to="/about" class="text-gray-400 hover:text-[#C9A032] transition-colors text-sm">À propos</NuxtLink>
            </li>
            <li>
              <NuxtLink to="/partners" class="text-gray-400 hover:text-[#C9A032] transition-colors text-sm">Partenaires</NuxtLink>
            </li>
          </ul>
        </div>

        <!-- Infos pratiques -->
        <div>
          <h4 class="text-xs tracking-[0.25em] uppercase text-[#C9A032]/60 mb-5">Infos pratiques</h4>
          <ul class="space-y-3">
            <li>
              <NuxtLink to="/shop" class="text-gray-400 hover:text-[#C9A032] transition-colors text-sm">Acheter un billet</NuxtLink>
            </li>
            <li>
              <NuxtLink to="/conditions-generales" class="text-gray-400 hover:text-[#C9A032] transition-colors text-sm">Conditions générales</NuxtLink>
            </li>
            <li>
              <NuxtLink to="/battle-kiz-qualifier" class="text-gray-400 hover:text-[#C9A032] transition-colors text-sm">Battle Kiz Qualifier</NuxtLink>
            </li>
          </ul>

          <!-- Lieu & date -->
          <div class="mt-6 pt-6 border-t border-[#C9A032]/10 space-y-2">
            <div class="flex items-start gap-2 text-sm text-gray-400">
              <svg class="w-4 h-4 mt-0.5 shrink-0 text-[#C9A032]/50" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
              </svg>
              Cotonou, Bénin
            </div>
            <div class="flex items-start gap-2 text-sm text-gray-400">
              <svg class="w-4 h-4 mt-0.5 shrink-0 text-[#C9A032]/50" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
              </svg>
              14 – 19 Juillet 2026
            </div>
          </div>
        </div>

      </div>

      <!-- Séparateur + copyright -->
      <div class="border-t border-[#C9A032]/10 pt-8 flex flex-col md:flex-row items-center justify-between gap-4 text-gray-500 text-xs">
        <p>&copy; {{ new Date().getFullYear() }} United Kizdom World Congress. Tous droits réservés.</p>
        <p class="tracking-widest uppercase text-[#C9A032]/30 text-[10px]">Cotonou · Bénin · UKWC 2026</p>
      </div>

    </div>
  </footer>
</template>
