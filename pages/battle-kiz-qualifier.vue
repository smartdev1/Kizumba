<template>
    <div class="bg-black text-white" style="font-family: 'Nunito', sans-serif;">
        <HeroSection />

        <!-- ═══════════════════════════════════════════════
             INSCRIPTIONS BATTLE KIZ — COMING SOON
        ══════════════════════════════════════════════════ -->
        <section class="py-24 border-t border-gold-500/10">
            <div class="container mx-auto px-6 max-w-3xl text-center">

                <p class="section-label mb-4">Inscriptions</p>
                <h2 class="section-title mb-6">
                    Battle Kiz <span class="gradient-text-gold">Qualifier</span>
                </h2>

                <p class="text-white/60 mb-12 text-base leading-relaxed">
                    Préparez-vous à montrer votre talent sur scène.<br/>
                    Les inscriptions pour le <span class="text-gold-400 font-semibold">Battle Kiz Qualifier</span> ouvriront très bientôt.
                </p>

                <!-- Coming Soon block -->
                <div class="coming-soon-block">
                    <div class="coming-soon-icon">🥇</div>
                    <div class="coming-soon-title gradient-text-gold">Coming Soon</div>
                    <p class="coming-soon-sub">Les inscriptions pour le Battle Kiz seront bientôt disponibles.<br/>Restez connectés !</p>
                </div>

            </div>
        </section>
    </div>
</template>

<style scoped>
.section-title {
    font-family: 'Bebas Neue', sans-serif;
    font-size: clamp(2rem, 5vw, 4rem);
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
.text-gold-400 { color: #F5D78A; }

.coming-soon-block {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 5rem 1rem;
    border: 1px dashed rgba(201,168,76,0.25);
    border-radius: 1.5rem;
    background: radial-gradient(ellipse 60% 50% at 50% 50%, rgba(201,168,76,0.04) 0%, transparent 80%);
}
.coming-soon-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.4;
}
.coming-soon-title {
    font-family: 'Bebas Neue', sans-serif;
    font-size: clamp(2rem, 5vw, 3.5rem);
    letter-spacing: 0.15em;
    text-transform: uppercase;
    line-height: 1;
}
.coming-soon-sub {
    margin-top: 0.75rem;
    color: rgba(255,255,255,0.3);
    font-size: 0.85rem;
    text-align: center;
    line-height: 1.6;
}
</style>
