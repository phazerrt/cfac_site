<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowRight } from '@lucide/vue';
import WhatsAppIcon from '@/components/site/WhatsAppIcon.vue';
import { useSite } from '@/composables/useSite';

withDefaults(defineProps<{ image?: string }>(), {
    image: '/media/gallery/fairy-curtain-dinner.webp',
});

const { business, t, href, whatsappUrl } = useSite();
</script>

<template>
    <section class="bg-white px-3 py-3 sm:px-5 sm:py-5">
        <div
            v-reveal
            class="grain relative isolate overflow-hidden rounded-[2rem] bg-ink-950 px-6 py-20 text-white sm:px-12 sm:py-24 lg:rounded-[2.5rem] lg:px-20"
        >
            <img
                :src="image"
                alt=""
                aria-hidden="true"
                loading="lazy"
                class="absolute inset-0 -z-20 size-full object-cover opacity-45"
            />
            <div
                class="absolute inset-0 -z-10 bg-gradient-to-r from-ink-950 via-ink-950/85 to-ink-950/30"
            />
            <div
                class="absolute -bottom-40 -left-20 -z-10 size-[30rem] rounded-full bg-brand-500/30 blur-[120px]"
            />

            <div class="max-w-2xl">
                <p class="font-script text-4xl text-brand-400 sm:text-5xl">
                    {{ business.motto }}
                </p>
                <h2
                    class="mt-4 font-display-tight text-4xl text-balance sm:text-6xl"
                >
                    {{ t('cta.title') }}
                </h2>
                <p class="mt-6 max-w-xl text-lg leading-relaxed text-white/70">
                    {{ t('cta.lead') }}
                </p>

                <div class="mt-10 flex flex-col gap-3 sm:flex-row">
                    <a
                        :href="whatsappUrl()"
                        target="_blank"
                        rel="noopener"
                        class="inline-flex items-center justify-center gap-2.5 rounded-full bg-brand-500 px-7 py-4 font-semibold shadow-[0_12px_32px_-10px_rgb(250_102_52/0.8)] transition-all duration-300 hover:-translate-y-0.5 hover:bg-brand-600"
                    >
                        <WhatsAppIcon class="size-5" />
                        {{ t('cta.quote') }}
                    </a>
                    <Link
                        :href="href('contact')"
                        class="group inline-flex items-center justify-center gap-2.5 rounded-full bg-white/10 px-7 py-4 font-semibold ring-1 ring-white/20 backdrop-blur transition-colors duration-300 hover:bg-white/15"
                    >
                        {{ t('cta.plan') }}
                        <ArrowRight
                            class="size-4 transition-transform group-hover:translate-x-1"
                        />
                    </Link>
                </div>
            </div>
        </div>
    </section>
</template>
