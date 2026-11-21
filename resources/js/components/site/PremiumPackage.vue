<script setup lang="ts">
import { Check, Crown, Sparkles } from '@lucide/vue';
import WhatsAppIcon from '@/components/site/WhatsAppIcon.vue';
import { useSite } from '@/composables/useSite';
import type { Package } from '@/types/site';

defineProps<{ pkg: Package; flip?: boolean }>();

const { t, rm, packageWhatsappUrl } = useSite();
</script>

<template>
    <article
        v-reveal
        class="grain relative isolate overflow-hidden rounded-[2rem] bg-ink-950 text-white"
    >
        <div
            class="absolute -top-32 -right-32 -z-10 size-[28rem] rounded-full bg-gold/20 blur-[120px]"
        />
        <div class="grid lg:grid-cols-2">
            <div
                :class="[
                    'grid grid-cols-2 gap-2 p-2 sm:gap-3 sm:p-3',
                    flip ? 'lg:order-2' : '',
                ]"
            >
                <img
                    v-if="pkg.image"
                    :src="pkg.image"
                    :alt="pkg.name"
                    loading="lazy"
                    class="col-span-2 aspect-[16/10] w-full rounded-[1.5rem] object-cover"
                />
                <img
                    v-for="(src, i) in pkg.gallery.slice(0, 2)"
                    :key="src"
                    :src="src"
                    :alt="`${pkg.name} ${i + 2}`"
                    loading="lazy"
                    class="aspect-[4/3] w-full rounded-[1.25rem] object-cover"
                />
            </div>

            <div class="flex flex-col p-7 sm:p-10 lg:p-12">
                <p
                    class="inline-flex w-fit items-center gap-2 rounded-full bg-gradient-to-r from-gold to-amber-300 px-4 py-1.5 text-xs font-bold tracking-[0.2em] text-ink-950 uppercase"
                >
                    <Crown class="size-3.5" aria-hidden="true" />
                    {{ t('tier.premium') }}
                </p>
                <p
                    class="mt-6 text-xs font-semibold tracking-[0.2em] text-brand-400 uppercase"
                >
                    {{ t(`category.${pkg.category}`) }} · {{ pkg.size }}
                </p>
                <h3
                    class="mt-2 font-display-tight text-3xl text-balance sm:text-4xl"
                >
                    {{ pkg.name }}
                </h3>

                <ul
                    class="mt-7 grid gap-x-6 gap-y-3 text-white/80 sm:grid-cols-2"
                >
                    <li
                        v-for="feature in pkg.features"
                        :key="feature"
                        class="flex gap-3 text-[0.95rem]"
                    >
                        <Check
                            class="mt-0.5 size-4 shrink-0 text-gold"
                            aria-hidden="true"
                        />
                        <span>{{ feature }}</span>
                    </li>
                </ul>

                <p
                    v-if="pkg.note"
                    class="mt-7 flex gap-2.5 rounded-2xl bg-white/5 px-4 py-3 text-sm text-white/75 ring-1 ring-white/10"
                >
                    <Sparkles
                        class="mt-0.5 size-4 shrink-0 text-gold"
                        aria-hidden="true"
                    />
                    {{ pkg.note }}
                </p>

                <div
                    class="mt-auto flex flex-wrap items-end justify-between gap-6 pt-10"
                >
                    <div>
                        <p class="text-xs text-white/50">
                            {{ t('package.price_label') }}
                        </p>
                        <p class="font-display text-5xl font-bold">
                            <span class="text-2xl font-semibold text-white/50"
                                >RM</span
                            >{{ rm(pkg.price ?? 0) }}
                        </p>
                    </div>
                    <a
                        :href="packageWhatsappUrl(pkg)"
                        target="_blank"
                        rel="noopener"
                        class="inline-flex items-center gap-2.5 rounded-full bg-brand-500 px-6 py-3.5 font-semibold shadow-[0_12px_32px_-10px_rgb(250_102_52/0.8)] transition-all duration-300 hover:-translate-y-0.5 hover:bg-brand-600"
                    >
                        <WhatsAppIcon class="size-5" />
                        {{ t('package.enquire_this') }}
                    </a>
                </div>
            </div>
        </div>
    </article>
</template>
