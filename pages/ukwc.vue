<template>
    <div class="bg-black text-white overflow-x-hidden" style="font-family: 'Nunito', sans-serif;">

        <!-- ═══════════════════════════════════════════════
         HERO
    ══════════════════════════════════════════════════ -->
        <section class="relative min-h-screen flex items-end pb-20 overflow-hidden">
            <div class="absolute inset-0 z-0">
                <div class="ukwc-hero-bg absolute inset-0" />
                <!-- Diagonal gold line -->
                <svg class="absolute inset-0 w-full h-full opacity-10" viewBox="0 0 1440 900"
                    preserveAspectRatio="xMidYMid slice" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <line x1="-100" y1="900" x2="1200" y2="-50" stroke="#C9A84C" stroke-width="1" />
                    <line x1="100" y1="900" x2="1400" y2="-50" stroke="#C9A84C" stroke-width="0.5" />
                    <line x1="-300" y1="900" x2="1000" y2="-50" stroke="#C9A84C" stroke-width="0.3" />
                    <circle cx="720" cy="450" r="380" stroke="#C9A84C" stroke-width="0.5" />
                    <circle cx="720" cy="450" r="280" stroke="#C9A84C" stroke-width="0.3" />
                    <!-- African adinkra-inspired pattern top right -->
                    <g transform="translate(1100, 80)" opacity="0.5">
                        <circle cx="80" cy="80" r="70" stroke="#C9A84C" stroke-width="1.5" fill="none" />
                        <circle cx="80" cy="80" r="45" stroke="#C9A84C" stroke-width="1" fill="none" />
                        <line x1="80" y1="10" x2="80" y2="150" stroke="#C9A84C" stroke-width="1" />
                        <line x1="10" y1="80" x2="150" y2="80" stroke="#C9A84C" stroke-width="1" />
                        <line x1="30" y1="30" x2="130" y2="130" stroke="#C9A84C" stroke-width="0.7" />
                        <line x1="130" y1="30" x2="30" y2="130" stroke="#C9A84C" stroke-width="0.7" />
                    </g>
                </svg>
                <!-- Noise texture -->
                <div class="noise-overlay absolute inset-0" />
            </div>

            <div class="relative z-10 container mx-auto px-6 pt-32">
                <div class="max-w-4xl">
                    <p class="text-gold-400 text-xs tracking-[0.5em] uppercase mb-6 animate-fade-up"
                        style="animation-delay:0.1s">
                        Bénin, Afrique · 14 – 19 Juillet 2026
                    </p>
                    <h1 class="animate-fade-up" style="animation-delay:0.2s; font-family:'Bebas Neue',sans-serif;">
                        <span class="block text-[clamp(3.5rem,10vw,9rem)] leading-none tracking-tight">United
                            Kizdom</span>
                        <span
                            class="block text-[clamp(3rem,8vw,7.5rem)] leading-none tracking-tight gradient-text-gold">World
                            Congress</span>
                        <span
                            class="block text-[clamp(4rem,12vw,11rem)] leading-none tracking-tighter text-white/10">2026</span>
                    </h1>
                    <div class="flex flex-wrap gap-4 mt-8 animate-fade-up" style="animation-delay:0.4s">
                        <a href="#billetterie"
                            class="bg-gold-500 hover:bg-gold-400 text-black font-extrabold uppercase tracking-widest px-8 py-4 rounded-full transition-all duration-300 shadow-lg shadow-gold-500/30 hover:-translate-y-1 text-sm">
                            Réserver mes places
                        </a>
                        <a href="#programme"
                            class="border border-gold-500/40 hover:border-gold-500 text-white/70 hover:text-white font-bold uppercase tracking-widest px-8 py-4 rounded-full transition-all duration-300 text-sm">
                            Voir le programme
                        </a>
                    </div>
                </div>
            </div>

            <!-- Floating day badges -->
            <div class="absolute bottom-10 right-6 md:right-16 flex gap-3 z-10">
                <div v-for="n in 6" :key="n"
                    class="w-10 h-10 rounded-full border border-gold-500/30 flex items-center justify-center text-gold-400 text-xs font-bold">
                    J{{ n }}
                </div>
            </div>
        </section>

        <!-- ═══════════════════════════════════════════════
         NAV SECTIONS PILL
    ══════════════════════════════════════════════════ -->
        <div class="sticky top-16 z-40 py-3 bg-black/90 backdrop-blur-md border-b border-gold-500/10">
            <div class="container mx-auto px-6">
                <div class="flex gap-2 overflow-x-auto scrollbar-none pb-1">
                    <a v-for="nav in navSections" :key="nav.id" :href="'#' + nav.id"
                        class="whitespace-nowrap text-xs font-bold uppercase tracking-widest px-4 py-2 rounded-full border border-white/10 hover:border-gold-500/50 hover:text-gold-400 text-white/50 transition-all duration-200">
                        {{ nav.label }}
                    </a>
                </div>
            </div>
        </div>

        <!-- ═══════════════════════════════════════════════
         ARTISTES
    ══════════════════════════════════════════════════ -->
        <section id="artistes" class="py-28 relative">
            <div class="section-glow-left absolute inset-0 pointer-events-none" />
            <div class="container mx-auto px-6">

                <div class="flex items-end justify-between mb-16 gap-6 flex-wrap">
                    <div>
                        <div class="section-label mb-3">— 01</div>
                        <h2 class="section-title">Artistes <span class="gradient-text-gold">internationaux</span></h2>
                    </div>
                    <p class="text-white/40 max-w-xs text-sm leading-relaxed">
                        Plus de 20 figures majeures de la scène mondiale de la Kizomba et des danses afro-urbaines.
                    </p>
                </div>

                <!-- Artist grid -->
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                    <div v-for="(artist, i) in artists" :key="artist.name"
                        class="artist-card group relative overflow-hidden rounded-2xl bg-white/5 border border-white/8 hover:border-gold-500/40 transition-all duration-500 cursor-pointer aspect-[3/4]">
                        <!-- Placeholder visual with SVG dancer silhouette -->
                        <div class="absolute inset-0 flex items-center justify-center"
                            :style="{ background: artistGradients[i % artistGradients.length] }">
                            <svg viewBox="0 0 80 120" class="w-2/3 opacity-30 group-hover:opacity-50 transition-opacity"
                                fill="none">
                                <circle cx="40" cy="18" r="12" fill="#C9A84C" />
                                <path d="M40 30 C35 45 30 55 32 72 C34 82 38 88 40 98" stroke="#C9A84C" stroke-width="4"
                                    stroke-linecap="round" fill="none" />
                                <path d="M37 50 C26 46 18 42 10 36" stroke="#C9A84C" stroke-width="3"
                                    stroke-linecap="round" fill="none" />
                                <path d="M40 48 C50 46 60 44 70 40" stroke="#C9A84C" stroke-width="3"
                                    stroke-linecap="round" fill="none" />
                                <path d="M37 95 C32 106 28 112 24 118" stroke="#C9A84C" stroke-width="3.5"
                                    stroke-linecap="round" fill="none" />
                                <path d="M42 95 C46 106 50 112 54 118" stroke="#C9A84C" stroke-width="3.5"
                                    stroke-linecap="round" fill="none" />
                            </svg>
                        </div>
                        <!-- Image placeholder text -->
                        <div class="absolute top-3 right-3 text-[10px] text-white/20 font-mono">IMG</div>
                        <!-- Info overlay -->
                        <div
                            class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-black via-black/60 to-transparent translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                            <div class="font-black uppercase text-sm leading-tight">{{ artist.name }}</div>
                            <div class="text-gold-400 text-xs mt-1">{{ artist.specialty }}</div>
                            <div class="text-white/40 text-xs">{{ artist.country }}</div>
                        </div>
                    </div>
                </div>

                <p class="text-center text-white/30 text-sm mt-8 italic">
                    + artistes à annoncer · Photos à venir
                </p>
            </div>
        </section>

        <!-- ═══════════════════════════════════════════════
     PROGRAMME
══════════════════════════════════════════════════ -->
        <section id="programme" class="py-28 border-t border-gold-500/10 relative">
            <div class="container mx-auto px-6">

                <div class="mb-16">
                    <div class="section-label mb-3">— 02</div>
                    <h2 class="section-title">Programme <span class="gradient-text-gold">& Ateliers</span></h2>
                </div>

                <!-- Day tabs -->
                <div class="flex gap-2 mb-10 overflow-x-auto scrollbar-none pb-2">
                    <button v-for="day in dayKeys" :key="day" @click="activeDay = day"
                        class="whitespace-nowrap px-6 py-3 rounded-xl font-black uppercase text-sm tracking-wider transition-all duration-200"
                        :class="activeDay === day
                            ? 'bg-gold-500 text-black shadow-lg shadow-gold-500/30'
                            : 'bg-white/5 text-white/50 hover:text-white border border-white/10 hover:border-gold-500/30'">
                        {{ getDayLabel(day) }}
                    </button>
                </div>

                <!-- Day content -->
                <div v-if="activeDay === 'mardi'" key="mardi">
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div v-for="(slot, slotKey) in programData.mardi" :key="slotKey"
                            class="relative bg-white/4 border border-white/8 rounded-2xl p-6 hover:border-gold-500/30 transition-all duration-300 group overflow-hidden">
                            <ProgrammeSlot :slot="slot" :slotKey="slotKey" />
                        </div>
                    </div>
                </div>

                <div v-if="activeDay === 'mercredi'" key="mercredi">
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div v-for="(slot, slotKey) in programData.mercredi" :key="slotKey"
                            class="relative bg-white/4 border border-white/8 rounded-2xl p-6 hover:border-gold-500/30 transition-all duration-300 group overflow-hidden">
                            <ProgrammeSlot :slot="slot" :slotKey="slotKey" />
                        </div>
                    </div>
                </div>

                <div v-if="activeDay === 'jeudi'" key="jeudi">
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div v-for="(slot, slotKey) in programData.jeudi" :key="slotKey"
                            class="relative bg-white/4 border border-white/8 rounded-2xl p-6 hover:border-gold-500/30 transition-all duration-300 group overflow-hidden">
                            <ProgrammeSlot :slot="slot" :slotKey="slotKey" />
                        </div>
                    </div>
                </div>

                <div v-if="activeDay === 'vendredi'" key="vendredi">
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div v-for="(slot, slotKey) in programData.vendredi" :key="slotKey"
                            class="relative bg-white/4 border border-white/8 rounded-2xl p-6 hover:border-gold-500/30 transition-all duration-300 group overflow-hidden">
                            <ProgrammeSlot :slot="slot" :slotKey="slotKey" />
                        </div>
                    </div>
                </div>

                <div v-if="activeDay === 'samedi'" key="samedi">
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div v-for="(slot, slotKey) in programData.samedi" :key="slotKey"
                            class="relative bg-white/4 border border-white/8 rounded-2xl p-6 hover:border-gold-500/30 transition-all duration-300 group overflow-hidden">
                            <ProgrammeSlot :slot="slot" :slotKey="slotKey" />
                        </div>
                    </div>
                </div>

                <div v-if="activeDay === 'dimanche'" key="dimanche">
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div v-for="(slot, slotKey) in programData.dimanche" :key="slotKey"
                            class="relative bg-white/4 border border-white/8 rounded-2xl p-6 hover:border-gold-500/30 transition-all duration-300 group overflow-hidden">
                            <ProgrammeSlot :slot="slot" :slotKey="slotKey" />
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- ═══════════════════════════════════════════════
         TOURISME
    ══════════════════════════════════════════════════ -->
        <section id="tourisme"
            class="py-28 border-t border-gold-500/10 bg-gradient-to-b from-transparent via-gold-900/5 to-transparent">
            <div class="container mx-auto px-6">

                <div class="flex items-end justify-between mb-16 gap-6 flex-wrap">
                    <div>
                        <div class="section-label mb-3">— 03</div>
                        <h2 class="section-title">Le Bénin, <span class="gradient-text-gold">à découvrir</span></h2>
                    </div>
                    <p class="text-white/40 max-w-xs text-sm leading-relaxed">
                        Spectacles précédents, lieux emblématiques et expériences immersives au cœur de l'Afrique.
                    </p>
                </div>

                <!-- Masonry-style gallery grid -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 auto-rows-[180px]">
                    <div v-for="(photo, i) in tourismPhotos" :key="i" :class="photo.span"
                        class="relative rounded-2xl overflow-hidden group cursor-pointer border border-white/5 hover:border-gold-500/30 transition-all duration-300">
                        <!-- SVG placeholder -->
                        <div class="absolute inset-0 flex items-center justify-center"
                            :style="{ background: photo.bg }">
                            <div class="text-center p-4">
                                <div class="text-4xl mb-2">{{ photo.icon }}</div>
                                <div class="text-white/30 text-xs uppercase tracking-widest">{{ photo.label }}</div>
                                <div class="text-white/15 text-[10px] mt-1 font-mono">Photo à venir</div>
                            </div>
                        </div>
                        <!-- Hover overlay -->
                        <div
                            class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                            <span class="text-white font-bold text-sm">{{ photo.label }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ═══════════════════════════════════════════════
         SOIRÉES SOCIALES
    ══════════════════════════════════════════════════ -->
        <section id="soirees" class="py-28 border-t border-gold-500/10">
            <div class="container mx-auto px-6">

                <div class="mb-16">
                    <div class="section-label mb-3">— 04</div>
                    <h2 class="section-title">Soirées <span class="gradient-text-gold">Sociales</span></h2>
                    <p class="mt-4 text-white/40 max-w-2xl text-base">
                        Chaque nuit, une ambiance unique. DJs internationaux, pistes de danse sous les étoiles
                        béninoises,
                        fusion de cultures et rencontres inoubliables.
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div v-for="soiree in soirees" :key="soiree.night"
                        class="soiree-card group relative rounded-3xl overflow-hidden border border-white/8 hover:border-gold-500/40 transition-all duration-500 cursor-pointer">
                        <!-- Background visual -->
                        <div class="h-52 relative overflow-hidden" :style="{ background: soiree.bg }">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <svg viewBox="0 0 200 150" class="w-full h-full opacity-20" fill="none">
                                    <!-- Stars -->
                                    <circle v-for="s in 20" :key="s" :cx="(s * 47) % 190 + 5" :cy="(s * 31) % 90 + 5"
                                        :r="(s % 2) + 1" fill="#C9A84C" />
                                    <!-- Moon -->
                                    <path d="M160 30 C145 35 138 50 145 65 C130 60 122 45 130 30 C138 16 155 12 160 30Z"
                                        fill="#C9A84C" />
                                    <!-- Dance floor lights -->
                                    <rect x="20" y="100" width="160" height="40" rx="4" fill="#C9A84C" opacity="0.3" />
                                    <line x1="60" y1="100" x2="60" y2="140" stroke="#000" stroke-width="1"
                                        opacity="0.5" />
                                    <line x1="100" y1="100" x2="100" y2="140" stroke="#000" stroke-width="1"
                                        opacity="0.5" />
                                    <line x1="140" y1="100" x2="140" y2="140" stroke="#000" stroke-width="1"
                                        opacity="0.5" />
                                </svg>
                            </div>
                            <!-- Night label -->
                            <div
                                class="absolute top-4 left-4 bg-black/60 backdrop-blur-sm border border-gold-500/30 rounded-full px-3 py-1 text-gold-400 text-xs font-bold uppercase tracking-widest">
                                Nuit {{ soiree.night }}
                            </div>
                            <div class="absolute top-4 right-4 text-white/20 text-xs font-mono">Photo à venir</div>
                        </div>

                        <div class="p-6">
                            <div class="text-white/40 text-xs uppercase tracking-widest mb-2">{{ soiree.date }}</div>
                            <h3 class="font-black uppercase text-xl mb-3 group-hover:text-gold-400 transition-colors"
                                style="font-family:'Bebas Neue',sans-serif; letter-spacing:0.04em;">
                                {{ soiree.title }}
                            </h3>
                            <p class="text-white/50 text-sm leading-relaxed mb-4">{{ soiree.description }}</p>

                            <!-- DJ list -->
                            <div class="flex flex-wrap gap-2">
                                <span v-for="dj in soiree.djs" :key="dj"
                                    class="text-xs px-3 py-1 rounded-full bg-white/5 border border-white/10 text-white/60">
                                    🎧 {{ dj }}
                                </span>
                            </div>

                            <!-- Styles tags -->
                            <div class="flex flex-wrap gap-2 mt-3">
                                <span v-for="style in soiree.styles" :key="style"
                                    class="text-[10px] px-2 py-1 rounded bg-gold-500/10 border border-gold-500/20 text-gold-400 uppercase tracking-wide">
                                    {{ style }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ═══════════════════════════════════════════════
         THE BATTLE KIZ
    ══════════════════════════════════════════════════ -->
        <section id="battle-kiz" class="py-28 border-t border-gold-500/10 relative overflow-hidden">
            <!-- Bold background -->
            <div class="absolute inset-0">
                <div class="battle-bg absolute inset-0" />
                <div class="noise-overlay absolute inset-0 opacity-5" />
                <!-- Big text backdrop -->
                <div
                    class="absolute inset-0 flex items-center justify-center overflow-hidden pointer-events-none select-none">
                    <span
                        class="text-[20vw] font-black uppercase text-white/3 leading-none tracking-tighter whitespace-nowrap"
                        style="font-family:'Bebas Neue',sans-serif;">
                        BATTLE
                    </span>
                </div>
            </div>

            <div class="relative z-10 container mx-auto px-6">
                <div class="grid md:grid-cols-2 gap-16 items-center">

                    <!-- Left: Visual -->
                    <div class="relative">
                        <div
                            class="aspect-square max-w-md relative rounded-3xl overflow-hidden border border-gold-500/20">
                            <div class="absolute inset-0 battle-card-bg" />
                            <svg viewBox="0 0 400 400" class="absolute inset-0 w-full h-full" fill="none">
                                <!-- Arena circles -->
                                <circle cx="200" cy="200" r="180" stroke="#C9A84C" stroke-width="1" opacity="0.2" />
                                <circle cx="200" cy="200" r="120" stroke="#C9A84C" stroke-width="0.7" opacity="0.3" />
                                <circle cx="200" cy="200" r="60" stroke="#C9A84C" stroke-width="2" opacity="0.4"
                                    stroke-dasharray="8 4" />
                                <!-- VS divider -->
                                <line x1="200" y1="0" x2="200" y2="400" stroke="#C9A84C" stroke-width="0.5"
                                    opacity="0.2" />
                                <!-- Dancer 1 (left) -->
                                <circle cx="130" cy="155" r="18" fill="#C9A84C" opacity="0.9" />
                                <path d="M130 173 C124 190 118 208 120 228" stroke="#C9A84C" stroke-width="6"
                                    fill="none" stroke-linecap="round" />
                                <path d="M125 192 C112 185 100 178 90 172" stroke="#C9A84C" stroke-width="5" fill="none"
                                    stroke-linecap="round" />
                                <path d="M128 190 C138 185 148 182 158 185" stroke="#C9A84C" stroke-width="5"
                                    fill="none" stroke-linecap="round" />
                                <path d="M120 228 C114 244 108 258 105 272" stroke="#C9A84C" stroke-width="5"
                                    fill="none" stroke-linecap="round" />
                                <path d="M122 228 C126 244 130 260 132 276" stroke="#C9A84C" stroke-width="5"
                                    fill="none" stroke-linecap="round" />
                                <!-- Dancer 2 (right, mirrored) -->
                                <circle cx="270" cy="155" r="18" fill="#C9A84C" opacity="0.9" />
                                <path d="M270 173 C276 190 282 208 280 228" stroke="#C9A84C" stroke-width="6"
                                    fill="none" stroke-linecap="round" />
                                <path d="M275 192 C288 185 300 178 310 172" stroke="#C9A84C" stroke-width="5"
                                    fill="none" stroke-linecap="round" />
                                <path d="M272 190 C262 185 252 182 242 185" stroke="#C9A84C" stroke-width="5"
                                    fill="none" stroke-linecap="round" />
                                <path d="M280 228 C286 244 292 258 295 272" stroke="#C9A84C" stroke-width="5"
                                    fill="none" stroke-linecap="round" />
                                <path d="M278 228 C274 244 270 260 268 276" stroke="#C9A84C" stroke-width="5"
                                    fill="none" stroke-linecap="round" />
                                <!-- VS text -->
                                <text x="200" y="215" text-anchor="middle" fill="#C9A84C" font-size="36"
                                    font-weight="900" font-family="'Bebas Neue', sans-serif" opacity="0.9">VS</text>
                                <!-- Trophy -->
                                <text x="200" y="340" text-anchor="middle" font-size="36">🏆</text>
                            </svg>
                        </div>
                        <!-- Badge -->
                        <div
                            class="absolute -bottom-4 -right-4 bg-red-600 text-white font-black text-sm px-5 py-2 rounded-full -rotate-2 shadow-lg">
                            QUALIFIER 2026
                        </div>
                    </div>

                    <!-- Right: Content -->
                    <div>
                        <div class="section-label mb-4">— 05</div>
                        <h2 class="section-title mb-6">
                            The Battle<br />
                            <span class="gradient-text-gold">KIZ Qualifier</span>
                        </h2>
                        <p class="text-white/60 leading-relaxed mb-6">
                            La compétition de Kizomba la plus attendue de l'année. Des danseurs venus des quatre coins
                            du monde
                            s'affrontent devant un jury de renommée internationale pour décrocher leur qualification.
                        </p>
                        <ul class="space-y-3 mb-8">
                            <li v-for="feat in battleFeatures" :key="feat"
                                class="flex items-center gap-3 text-white/70 text-sm">
                                <span
                                    class="w-5 h-5 rounded-full bg-gold-500/20 border border-gold-500/40 flex items-center justify-center text-gold-400 text-xs flex-shrink-0">✓</span>
                                {{ feat }}
                            </li>
                        </ul>
                        <NuxtLink to="/battle-kiz-qualifier"
                            class="inline-flex items-center gap-3 bg-gold-500 hover:bg-gold-400 text-black font-extrabold uppercase tracking-widest px-8 py-4 rounded-full transition-all duration-300 shadow-lg shadow-gold-500/30 hover:-translate-y-1 text-sm group">
                            <span>Voir la compétition</span>
                            <span class="group-hover:translate-x-1 transition-transform">→</span>
                        </NuxtLink>
                    </div>
                </div>
            </div>
        </section>

        <!-- ═══════════════════════════════════════════════
         LIVRET D'ACCUEIL
    ══════════════════════════════════════════════════ -->
        <section id="livret" class="py-28 border-t border-gold-500/10">
            <div class="container mx-auto px-6">
                <div class="max-w-3xl mx-auto text-center">
                    <div class="section-label mb-4">— 06</div>
                    <h2 class="section-title mb-6">
                        Votre guide<br />
                        <span class="gradient-text-gold">d'accueil UKWC</span>
                    </h2>
                    <p class="text-white/50 mb-12 leading-relaxed">
                        Tout ce qu'il faut savoir avant d'arriver au Bénin : programme complet, informations pratiques,
                        lieux, transports, hébergements recommandés et conseils culturels.
                    </p>

                    <!-- Booklet visual -->
                    <div class="relative inline-block mb-10">
                        <div
                            class="livret-card relative w-72 mx-auto rounded-3xl overflow-hidden border border-gold-500/30 shadow-2xl shadow-gold-500/10">
                            <div class="h-96 relative"
                                style="background: linear-gradient(135deg, #0a0800 0%, #1a1200 50%, #0a0800 100%);">
                                <svg viewBox="0 0 280 380" class="absolute inset-0 w-full h-full" fill="none">
                                    <!-- Cover decoration -->
                                    <rect x="15" y="15" width="250" height="350" rx="8" stroke="#C9A84C"
                                        stroke-width="0.7" opacity="0.3" />
                                    <rect x="25" y="25" width="230" height="330" rx="6" stroke="#C9A84C"
                                        stroke-width="0.3" opacity="0.2" />
                                    <!-- Adinkra symbol center -->
                                    <g transform="translate(100, 100)">
                                        <circle cx="40" cy="40" r="35" stroke="#C9A84C" stroke-width="1.5" opacity="0.5"
                                            fill="none" />
                                        <circle cx="40" cy="40" r="22" stroke="#C9A84C" stroke-width="1" opacity="0.4"
                                            fill="none" />
                                        <circle cx="40" cy="40" r="8" fill="#C9A84C" opacity="0.3" />
                                        <line x1="40" y1="5" x2="40" y2="75" stroke="#C9A84C" stroke-width="0.8"
                                            opacity="0.3" />
                                        <line x1="5" y1="40" x2="75" y2="40" stroke="#C9A84C" stroke-width="0.8"
                                            opacity="0.3" />
                                    </g>
                                    <!-- Benin flag strip on left -->
                                    <rect x="15" y="15" width="14" height="350" rx="6" fill="#008751" opacity="0.8" />
                                    <rect x="15" y="130" width="14" height="120" fill="#FCD116" opacity="0.8" />
                                    <rect x="15" y="250" width="14" height="115" rx="0" fill="#E8112D" opacity="0.8" />
                                    <!-- Title text -->
                                    <text x="155" y="155" text-anchor="middle" fill="#C9A84C" font-size="22"
                                        font-weight="900" font-family="'Bebas Neue',sans-serif"
                                        letter-spacing="2">UKWC</text>
                                    <text x="155" y="176" text-anchor="middle" fill="#C9A84C" font-size="11"
                                        font-family="'Bebas Neue',sans-serif" letter-spacing="3"
                                        opacity="0.7">2026</text>
                                    <line x1="80" y1="185" x2="230" y2="185" stroke="#C9A84C" stroke-width="0.5"
                                        opacity="0.4" />
                                    <text x="155" y="205" text-anchor="middle" fill="white" font-size="9" opacity="0.4"
                                        letter-spacing="2">LIVRET D'ACCUEIL</text>
                                    <!-- Bottom info -->
                                    <text x="155" y="310" text-anchor="middle" fill="white" font-size="8" opacity="0.3"
                                        letter-spacing="1">14 – 19 Juillet 2026 · Bénin</text>
                                </svg>
                            </div>
                        </div>
                        <!-- Shine effect -->
                        <div
                            class="absolute inset-0 rounded-3xl bg-gradient-to-br from-white/5 to-transparent pointer-events-none" />
                    </div>

                    <!-- Download CTA -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        <a href="/livret-ukwc-2026.pdf" download
                            class="flex items-center gap-3 bg-gold-500 hover:bg-gold-400 text-black font-extrabold uppercase tracking-widest px-8 py-4 rounded-full transition-all duration-300 shadow-lg shadow-gold-500/30 hover:-translate-y-1 text-sm group">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            <span>Télécharger le livret PDF</span>
                        </a>
                        <p class="text-white/30 text-xs">Disponible en FR · EN · PT</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ═══════════════════════════════════════════════
         FOOTER CTA
    ══════════════════════════════════════════════════ -->
        <section class="py-24 border-t border-gold-500/10 text-center relative overflow-hidden">
            <div class="absolute inset-0 hero-bg-gradient opacity-30" />
            <div class="relative z-10 container mx-auto px-6">
                <p class="text-white/30 text-sm tracking-widest uppercase mb-4">Places limitées</p>
                <h2 class="text-5xl md:text-7xl font-black uppercase mb-8" style="font-family:'Bebas Neue',sans-serif;">
                    Réservez<br /><span class="gradient-text-gold">maintenant</span>
                </h2>
                <NuxtLink to="/checkout"
                    class="inline-block bg-gold-500 hover:bg-gold-400 text-black font-extrabold uppercase tracking-widest px-12 py-5 rounded-full transition-all duration-300 shadow-xl shadow-gold-500/30 hover:-translate-y-1 text-base">
                    Acheter mes billets
                </NuxtLink>
            </div>
        </section>

    </div>
</template>

<script setup>
import { ref } from 'vue'

// Import du composant ProgrammeSlot
// import ProgrammeSlot from './components/ProgrammeSlot.vue'

const navSections = [
    { id: 'artistes', label: '🎭 Artistes' },
    { id: 'programme', label: '📅 Programme' },
    { id: 'tourisme', label: '🌍 Tourisme' },
    { id: 'soirees', label: '🌙 Soirées Sociales' },
    { id: 'battle-kiz', label: '⚔️ The Battle KIZ' },
    { id: 'livret', label: '📖 Livret d\'accueil' },
]

const artists = [
    { name: 'Artist 1', specialty: 'Kizomba', country: '🇵🇹 Portugal' },
    { name: 'Artist 2', specialty: 'Urban Kiz', country: '🇫🇷 France' },
    { name: 'Artist 3', specialty: 'Semba', country: '🇦🇴 Angola' },
    { name: 'Artist 4', specialty: 'Afro Fusion', country: '🇧🇷 Brésil' },
    { name: 'Artist 5', specialty: 'Kizomba', country: '🇨🇻 Cap-Vert' },
    { name: 'Artist 6', specialty: 'Bachata', country: '🇩🇴 Rép. Dom.' },
    { name: 'Artist 7', specialty: 'Zouk', country: '🇧🇷 Brésil' },
    { name: 'Artist 8', specialty: 'Urban Kiz', country: '🇧🇪 Belgique' },
    { name: 'Artist 9', specialty: 'Salsa', country: '🇨🇺 Cuba' },
    { name: 'Artist 10', specialty: 'Kizomba', country: '🇧🇯 Bénin' },
]

const artistGradients = [
    'linear-gradient(135deg, #1a0e00 0%, #3d2200 100%)',
    'linear-gradient(135deg, #0a1500 0%, #1a3000 100%)',
    'linear-gradient(135deg, #12000a 0%, #2d001a 100%)',
    'linear-gradient(135deg, #001015 0%, #002030 100%)',
    'linear-gradient(135deg, #150a00 0%, #332200 100%)',
]

const programData = {
    "mardi": {
        "08:00-16:00": {
            "type": "tourisme",
            "activities": [
                "Rivière noire (Adjarra)",
                "Musée international du Vodun",
                "Ville de Porto-Novo"
            ]
        },
        "16:00-19:00": {
            "type": "break",
            "label": "Break Time"
        },
        "19:00-21:00": {
            "type": "workshops"
        },
        "21:00+": {
            "type": "social",
            "description": "Danse et interactions entre festivaliers"
        }
    },
    "mercredi": {
        "08:00-12:00": {
            "type": "tourisme",
            "activities": [
                "Découverte de la ville de Cotonou à bord du petit train",
                "Expérimentation de la pêche sur les plages de Togbin"
            ]
        },
        "12:00-14:00": {
            "type": "break",
            "label": "Break Time"
        },
        "14:00-16:00": {
            "type": "workshops_social"
        },
        "19:00-21:00": {
            "type": "break",
            "label": "Break Time"
        },
        "21:00+": {
            "type": "welcome_party",
            "activities": [
                "Cocktail d'ouverture du congrès",
                "Performances de troupes béninoises",
                "Mots de bienvenue des partenaires et organisateurs",
                "Présentation du programme de développement Bénin 2060",
                "Soirée dansante"
            ]
        }
    },
    "jeudi": {
        "08:00-19:00": {
            "type": "tourisme",
            "activities": [
                "Ouidah - Porte du non-retour",
                "Bateau de départ de la Route des Esclaves",
                "Temple des pythons",
                "Gogotinkpon (déjeuner et activités)"
            ]
        },
        "19:00-21:00": {
            "type": "break",
            "label": "Break Time"
        },
        "21:00+": {
            "type": "competition",
            "title": "The Battle Kiz",
            "description": "Qualification africaine des meilleurs danseurs du continent",
            "note": "Le Bénin accueille l'Afrique",
            "party": "Soirée dansante à partir de 23:00"
        }
    },
    "vendredi": {
        "08:00-14:00": {
            "type": "break",
            "label": "Break Time"
        },
        "14:00-19:00": {
            "type": "workshops"
        },
        "19:00-21:00": {
            "type": "break",
            "label": "Break Time"
        },
        "21:00+": {
            "type": "party",
            "title": "Tropical Kizdom",
            "description": "Soirée dansante",
            "dj_start": "22:30"
        }
    },
    "samedi": {
        "08:00-14:00": {
            "type": "break",
            "label": "Break Time"
        },
        "14:00-19:00": {
            "type": "workshops_masterclasses"
        },
        "19:00-21:00": {
            "type": "break",
            "label": "Break Time"
        },
        "21:00+": {
            "type": "gala",
            "title": "Kizdom Excellence",
            "activities": [
                "Gala",
                "Performances de troupes béninoises",
                "Performances d'artistes internationaux",
                "Soirée dansante"
            ]
        }
    },
    "dimanche": {
        "08:00-12:00": {
            "type": "break",
            "label": "Break Time"
        },
        "12:00-19:00": {
            "type": "brunch",
            "title": "Brunch & Pool Party"
        },
        "19:00+": {
            "type": "party",
            "title": "After Party"
        }
    }
}

const activeDay = ref('mardi')
const dayKeys = ['mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche']

const getDayLabel = (day) => {
    const labels = {
        'mardi': 'Mardi 14 Juil',
        'mercredi': 'Mercredi 15 Juil',
        'jeudi': 'Jeudi 16 Juil',
        'vendredi': 'Vendredi 17 Juil',
        'samedi': 'Samedi 18 Juil',
        'dimanche': 'Dimanche 19 Juil'
    }
    return labels[day] || day
}

const tourismPhotos = [
    { icon: '🎭', label: 'Spectacle UKWC 2024', bg: 'linear-gradient(135deg,#1a0e00,#3d2200)', span: 'col-span-2 row-span-2' },
    { icon: '🛡️', label: 'Palais Royal d\'Abomey', bg: 'linear-gradient(135deg,#001015,#002030)', span: 'col-span-1 row-span-1' },
    { icon: '⚓', label: 'Porte du Non-Retour · Ouidah', bg: 'linear-gradient(135deg,#120005,#2d0015)', span: 'col-span-1 row-span-1' },
    { icon: '🏖️', label: 'Plage de Grand-Popo', bg: 'linear-gradient(135deg,#001a0a,#003020)', span: 'col-span-1 row-span-1' },
    { icon: '💃', label: 'Show Kizomba UKWC 2023', bg: 'linear-gradient(135deg,#1a1000,#332500)', span: 'col-span-1 row-span-1' },
    { icon: '🌊', label: 'Lac Nokoué', bg: 'linear-gradient(135deg,#001530,#003060)', span: 'col-span-1 row-span-1' },
    { icon: '🎉', label: 'Soirée Sociale UKWC', bg: 'linear-gradient(135deg,#150010,#300030)', span: 'col-span-1 row-span-1' },
]

const soirees = [
    {
        night: 1, date: 'Mardi 14 Juillet',
        title: 'Opening Night',
        description: 'Lancement officiel sous les étoiles. Kizomba et Semba pour inaugurer une semaine d\'exception.',
        bg: 'linear-gradient(135deg, #1a0e00, #0a0500)',
        djs: ['DJ Intro', 'TBA'],
        styles: ['Kizomba', 'Semba'],
    },
    {
        night: 2, date: 'Mercredi 15 Juillet',
        title: 'Afro Urban Night',
        description: 'Urban Kiz, Afro Fusion et vibes contemporaines. La nuit des créateurs.',
        bg: 'linear-gradient(135deg, #000f1a, #000508)',
        djs: ['DJ Urban', 'TBA'],
        styles: ['Urban Kiz', 'Afro Fusion', 'Dancehall'],
    },
    {
        night: 3, date: 'Jeudi 16 Juillet',
        title: 'Battle Eve Party',
        description: 'La veille des batailles. Énergie maximale pour chauffer les compétiteurs.',
        bg: 'linear-gradient(135deg, #1a0005, #0a0003)',
        djs: ['DJ Battle', 'DJ Hype'],
        styles: ['Kizomba', 'Urban Kiz', 'Semba'],
    },
    {
        night: 4, date: 'Vendredi 17 Juillet',
        title: 'Latina Fusion Night',
        description: 'Salsa, Bachata, Zouk et Merengue. Un voyage caribéen au cœur du Bénin.',
        bg: 'linear-gradient(135deg, #001500, #000a00)',
        djs: ['DJ Latino', 'TBA'],
        styles: ['Salsa', 'Bachata', 'Zouk', 'Merengue'],
    },
    {
        night: 5, date: 'Samedi 18 Juillet',
        title: 'Grand Finale Night',
        description: 'Après la finale du Battle KIZ, la plus grande fête de la semaine.',
        bg: 'linear-gradient(135deg, #1a1200, #0a0800)',
        djs: ['Tous les DJs'],
        styles: ['Kizomba', 'Semba', 'Urban Kiz', 'All styles'],
    },
    {
        night: 6, date: 'Dimanche 19 Juillet',
        title: 'Closing Ceremony',
        description: 'La dernière danse. Un au revoir mémorable entre amis du monde entier.',
        bg: 'linear-gradient(135deg, #0a0010, #05000a)',
        djs: ['DJ Close', 'TBA'],
        styles: ['Kizomba', 'Semba'],
    },
]

const battleFeatures = [
    'Compétition internationale officielle',
    'Jury composé d\'artistes de renommée mondiale',
    'Catégories : Kizomba, Urban Kiz, Semba',
    'Qualifications pour le circuit mondial',
    'Prix et récompenses exclusives',
    'Open à tous les niveaux avancés',
]

// Note: Les fonctions getSlotTypeLabel et slotTypeClass sont maintenant dans le composant ProgrammeSlot
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Nunito:wght@400;600;700;800;900&display=swap');

.section-title {
    font-family: 'Bebas Neue', sans-serif;
    font-size: clamp(2.5rem, 5vw, 4.5rem);
    line-height: 1;
    text-transform: uppercase;
    letter-spacing: 0.02em;
}

.section-label {
    color: #C9A84C;
    font-size: 0.7rem;
    letter-spacing: 0.4em;
    text-transform: uppercase;
    font-weight: 800;
}

.gradient-text-gold {
    background: linear-gradient(135deg, #C9A84C 0%, #F5D78A 40%, #C9A84C 70%, #8B6914 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.ukwc-hero-bg {
    background:
        radial-gradient(ellipse 70% 60% at 20% 60%, rgba(201, 168, 76, 0.13) 0%, transparent 70%),
        radial-gradient(ellipse 50% 40% at 80% 30%, rgba(139, 105, 20, 0.08) 0%, transparent 70%),
        #000;
}

.hero-bg-gradient {
    background: radial-gradient(ellipse 80% 60% at 50% 50%, rgba(201, 168, 76, 0.15) 0%, transparent 70%);
}

.battle-bg {
    background:
        radial-gradient(ellipse 60% 60% at 50% 50%, rgba(201, 168, 76, 0.08) 0%, transparent 70%),
        #000;
}

.battle-card-bg {
    background: linear-gradient(135deg, #0d0800 0%, #1a1200 50%, #0d0800 100%);
}

.section-glow-left {
    background: radial-gradient(ellipse 40% 60% at 0% 50%, rgba(201, 168, 76, 0.05) 0%, transparent 70%);
}

.noise-overlay {
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='1'/%3E%3C/svg%3E");
    opacity: 0.03;
}

@keyframes fade-up {
    from {
        opacity: 0;
        transform: translateY(24px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-up {
    animation: fade-up 0.7s ease forwards;
    opacity: 0;
}

.scrollbar-none::-webkit-scrollbar {
    display: none;
}

.scrollbar-none {
    -ms-overflow-style: none;
    scrollbar-width: none;
}

/* Gold utilities */
.text-gold-400 {
    color: #F5D78A;
}

.bg-gold-400 {
    background-color: #F5D78A;
}

.bg-gold-500 {
    background-color: #C9A84C;
}

.hover\:bg-gold-400:hover {
    background-color: #F5D78A;
}

.border-gold-500 {
    border-color: #C9A84C;
}

.shadow-gold-500\/30 {
    box-shadow: 0 10px 40px rgba(201, 168, 76, 0.3);
}
</style>