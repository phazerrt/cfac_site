<script setup lang="ts">
import { onBeforeUnmount, onMounted, ref } from 'vue';
import WhatsAppIcon from '@/components/site/WhatsAppIcon.vue';
import { useSite } from '@/composables/useSite';

const { t, whatsappUrl } = useSite();

// Appears once the visitor has scrolled past the first screen.
const visible = ref(false);

function onScroll() {
    visible.value = window.scrollY > window.innerHeight * 0.6;
}

onMounted(() => {
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
});

onBeforeUnmount(() => window.removeEventListener('scroll', onScroll));
</script>

<template>
    <a
        :href="whatsappUrl()"
        target="_blank"
        rel="noopener"
        :aria-label="t('whatsapp.float')"
        :class="[
            'group fixed right-4 bottom-4 z-40 flex items-center rounded-full bg-whatsapp p-4 text-white shadow-[0_12px_32px_-8px_rgb(37_211_102/0.7)] transition-all duration-500 ease-out-expo hover:pr-6 sm:right-6 sm:bottom-6',
            visible
                ? 'translate-y-0 opacity-100'
                : 'pointer-events-none translate-y-6 opacity-0',
        ]"
    >
        <span
            class="absolute inset-0 -z-10 animate-ping rounded-full bg-whatsapp/40 [animation-duration:2.4s]"
        />
        <WhatsAppIcon class="size-6" />
        <span
            class="hidden max-w-0 overflow-hidden text-sm font-semibold whitespace-nowrap transition-all duration-500 group-hover:ml-3 group-hover:max-w-48 sm:inline"
        >
            {{ t('whatsapp.float') }}
        </span>
    </a>
</template>
