<script setup lang="ts">
import SiteFooter from '@/components/site/SiteFooter.vue';
import SiteHeader from '@/components/site/SiteHeader.vue';
import WhatsAppFloat from '@/components/site/WhatsAppFloat.vue';
</script>

<template>
    <div
        class="site-root min-h-svh bg-white font-sans text-ink-900 antialiased"
    >
        <SiteHeader />
        <main id="main">
            <slot />
        </main>
        <SiteFooter />
        <WhatsAppFloat />
    </div>
</template>
