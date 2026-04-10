<template>
  <div class="min-h-screen bg-black">
    <!-- Skip to content (accessibilité clavier) -->
    <a href="#main-content" class="skip-link">Aller au contenu principal</a>

    <HeaderNav />
    <main id="main-content">
      <slot />
    </main>
    <FooterSection />
  </div>
</template>

<style scoped>
.skip-link {
  position: absolute;
  top: -100%;
  left: 1rem;
  z-index: 9999;
  background: #C9A84C;
  color: #000;
  font-weight: 700;
  font-size: 0.875rem;
  padding: 0.5rem 1rem;
  border-radius: 0 0 0.5rem 0.5rem;
  text-decoration: none;
  transition: top 0.2s;
}
.skip-link:focus {
  top: 0;
}
</style>
