<script setup lang="ts">
import { Check, Info } from '@lucide/vue';
import WhatsAppIcon from '@/components/site/WhatsAppIcon.vue';
import { useSite } from '@/composables/useSite';
import type { Package } from '@/types/site';

defineProps<{ pkg: Package; delay?: number }>();

const { t, rm, packageWhatsappUrl } = useSite();
</script>

<template>
    <article
        v-reveal="delay"
        class="group flex flex-col overflow-hidden rounded-3xl bg-white ring-1 ring-ink-950/8 transition-shadow duration-500 hover:shadow-[0_30px_60px_-30px_rgb(13_11_10/0.35)]"
    >
        <div class="relative aspect-[4/3] overflow-hidden bg-ink-100">
            <img
                v-if="pkg.image"
                :src="pkg.image"
                :alt="pkg.name"
                loading="lazy"
                class="size-full object-cover transition-transform duration-700 ease-out-expo group-hover:scale-105"
            />
            <div
                class="absolute inset-x-0 top-0 flex items-start justify-between p-4"
            >
                <span
                    v-if="pkg.code"
                    class="grid size-11 place-items-center rounded-xl bg-brand-500 font-display text-xl font-bold text-white shadow-lg"
                    :aria-label="t('package.code', { code: pkg.code })"
                >
                    {{ pkg.code }}
                </span>
                <span
                    v-if="pkg.finish"
                    class="rounded-full bg-ink-950/70 px-3 py-1 text-xs font-semibold tracking-wide text-white backdrop-blur"
                >
                    {{ t(`finish.${pkg.finish}`) }}
                </span>
            </div>
        </div>

        <div class="flex flex-1 flex-col p-6 sm:p-7">
            <p
                class="text-xs font-semibold tracking-[0.2em] text-brand-600 uppercase"
            >
                {{ t(`category.${pkg.category}`) }}
                <template v-if="pkg.size"> · {{ pkg.size }}</template>
            </p>
            <h3
                class="mt-2 font-display text-xl leading-snug font-semibold text-ink-950"
            >
                {{ pkg.name }}
            </h3>

            <ul class="mt-5 space-y-2.5 text-[0.95rem] text-ink-700">
                <li
                    v-for="feature in pkg.features"
                    :key="feature"
                    class="flex gap-3"
                >
                    <Check
                        class="mt-0.5 size-4 shrink-0 text-brand-500"
                        aria-hidden="true"
                    />
                    <span>{{ feature }}</span>
                </li>
            </ul>

            <p
                v-if="pkg.note"
                class="mt-5 flex gap-2.5 rounded-2xl bg-cream px-4 py-3 text-sm text-ink-700"
            >
                <Info
                    class="mt-0.5 size-4 shrink-0 text-brand-600"
                    aria-hidden="true"
                />
                {{ pkg.note }}
            </p>

            <div class="min-h-6 flex-1" />
            <div
                class="flex items-end justify-between gap-4 border-t border-ink-950/8 pt-6"
            >
                <div>
                    <template v-if="pkg.price">
                        <p class="text-xs text-ink-500">
                            {{ t('package.price_label') }}
                        </p>
                        <p class="font-display text-3xl font-bold text-ink-950">
                            <span class="text-lg font-semibold text-ink-500"
                                >RM</span
                            >{{ rm(pkg.price) }}
                        </p>
                    </template>
                    <p
                        v-else
                        class="font-display text-lg font-semibold text-ink-950"
                    >
                        {{ t('package.quote') }}
                    </p>
                </div>
                <a
                    :href="packageWhatsappUrl(pkg)"
                    target="_blank"
                    rel="noopener"
                    class="inline-flex shrink-0 items-center gap-2 rounded-full bg-ink-950 px-5 py-3 text-sm font-semibold text-white transition-colors duration-300 hover:bg-brand-500"
                >
                    <WhatsAppIcon class="size-4" />
                    {{ t('package.enquire') }}
                </a>
            </div>
        </div>
    </article>
</template>
