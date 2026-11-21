<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowUp, Mail, MapPin, Phone } from '@lucide/vue';
import SocialIcon from '@/components/site/SocialIcon.vue';
import WhatsAppIcon from '@/components/site/WhatsAppIcon.vue';
import { useSite } from '@/composables/useSite';
import type { SocialKey } from '@/types/site';

const { site, business, t, whatsappUrl, telUrl, mailUrl } = useSite();

const year = new Date().getFullYear();
const socials: SocialKey[] = ['instagram', 'facebook', 'tiktok'];

function toTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}
</script>

<template>
    <footer
        class="grain relative isolate overflow-hidden bg-ink-950 text-white"
    >
        <div
            class="absolute -bottom-48 left-1/2 -z-10 h-[28rem] w-[60rem] -translate-x-1/2 rounded-full bg-brand-500/10 blur-[140px]"
        />

        <div class="mx-auto max-w-7xl px-5 pt-20 pb-10 sm:px-8 lg:pt-24">
            <div class="grid gap-14 lg:grid-cols-12">
                <div class="lg:col-span-5">
                    <img
                        src="/images/brand/logo-full.png"
                        :alt="business.name"
                        width="875"
                        height="439"
                        loading="lazy"
                        class="h-auto w-56"
                    />
                    <p class="mt-6 max-w-sm leading-relaxed text-white/60">
                        {{ t('footer.about') }}
                    </p>
                    <p class="mt-6 font-script text-4xl text-brand-400">
                        {{ business.motto }}
                    </p>
                </div>

                <nav class="lg:col-span-3" :aria-label="t('footer.explore')">
                    <h2
                        class="text-xs font-semibold tracking-[0.24em] text-white/40 uppercase"
                    >
                        {{ t('footer.explore') }}
                    </h2>
                    <ul class="mt-6 space-y-3">
                        <li v-for="item in site.nav" :key="item.key">
                            <Link
                                :href="item.href"
                                class="text-white/75 transition-colors hover:text-brand-400"
                            >
                                {{ t(`nav.${item.key}`) }}
                            </Link>
                        </li>
                    </ul>
                </nav>

                <div class="lg:col-span-4">
                    <h2
                        class="text-xs font-semibold tracking-[0.24em] text-white/40 uppercase"
                    >
                        {{ t('footer.contact') }}
                    </h2>
                    <ul class="mt-6 space-y-4 text-white/75">
                        <li>
                            <a
                                :href="whatsappUrl()"
                                target="_blank"
                                rel="noopener"
                                class="inline-flex items-center gap-3 transition-colors hover:text-brand-400"
                            >
                                <WhatsAppIcon class="size-4 text-brand-400" />
                                {{ business.whatsappDisplay }}
                            </a>
                        </li>
                        <li>
                            <a
                                :href="telUrl"
                                class="inline-flex items-center gap-3 transition-colors hover:text-brand-400"
                            >
                                <Phone class="size-4 text-brand-400" />
                                {{ business.phoneDisplay }}
                            </a>
                        </li>
                        <li>
                            <a
                                :href="mailUrl"
                                class="inline-flex items-center gap-3 break-all transition-colors hover:text-brand-400"
                            >
                                <Mail class="size-4 shrink-0 text-brand-400" />
                                {{ business.email }}
                            </a>
                        </li>
                        <li class="inline-flex items-center gap-3">
                            <MapPin class="size-4 text-brand-400" />
                            {{ business.area }}
                        </li>
                    </ul>
                    <div class="mt-8 flex gap-3">
                        <a
                            v-for="key in socials"
                            :key="key"
                            :href="business.social[key].url"
                            target="_blank"
                            rel="noopener"
                            :aria-label="t(`social.${key}`)"
                            class="grid size-11 place-items-center rounded-full bg-white/5 ring-1 ring-white/10 transition-all hover:-translate-y-0.5 hover:bg-brand-500 hover:ring-brand-500"
                        >
                            <SocialIcon :name="key" class="size-[18px]" />
                        </a>
                    </div>
                </div>
            </div>

            <div
                class="mt-16 flex flex-col-reverse items-start justify-between gap-6 border-t border-white/10 pt-8 text-sm text-white/45 sm:flex-row sm:items-center"
            >
                <p>
                    © {{ year }} {{ business.name }} ·
                    {{ business.tagline }}
                </p>
                <button
                    type="button"
                    class="inline-flex items-center gap-2 transition-colors hover:text-white"
                    @click="toTop"
                >
                    {{ t('footer.top') }}
                    <ArrowUp class="size-4" />
                </button>
            </div>
        </div>
    </footer>
</template>
