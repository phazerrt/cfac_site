<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Menu, Phone, X } from '@lucide/vue';
import { computed, onBeforeUnmount, onMounted, ref, watch } from 'vue';
import WhatsAppIcon from '@/components/site/WhatsAppIcon.vue';
import { useSite } from '@/composables/useSite';
import type { Locale } from '@/types/site';

const { site, business, locale, t, href, whatsappUrl, telUrl } = useSite();

const scrolled = ref(false);
const menuOpen = ref(false);

// Transparent over the dark hero at the top of every page, frosted white once
// the visitor scrolls. The open mobile menu is always dark.
const solid = computed(() => scrolled.value && !menuOpen.value);

function onScroll() {
    scrolled.value = window.scrollY > 24;
}

onMounted(() => {
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
});

onBeforeUnmount(() => {
    window.removeEventListener('scroll', onScroll);
    document.documentElement.style.overflow = '';
});

watch(menuOpen, (open) => {
    document.documentElement.style.overflow = open ? 'hidden' : '';
});

// Close the mobile menu whenever we land on another page.
watch(
    () => site.value.key,
    () => (menuOpen.value = false),
);

const locales = computed(() => Object.keys(site.value.alternates) as Locale[]);
</script>

<template>
    <header
        :class="[
            'fixed inset-x-0 top-0 z-50 transition-[background-color,box-shadow,backdrop-filter] duration-500',
            solid
                ? 'bg-white/80 shadow-[0_1px_0_rgb(13_11_10/0.06),0_8px_30px_-12px_rgb(13_11_10/0.18)] backdrop-blur-xl backdrop-saturate-150'
                : 'bg-transparent',
        ]"
    >
        <div
            :class="[
                'mx-auto flex max-w-7xl items-center justify-between gap-6 px-5 transition-[height] duration-500 sm:px-8',
                solid ? 'h-16' : 'h-20',
            ]"
        >
            <Link
                :href="href('home')"
                class="relative block shrink-0 transition-[width] duration-500"
                :class="
                    solid ? 'w-[120px] sm:w-[132px]' : 'w-[132px] sm:w-[156px]'
                "
                :aria-label="business.name"
            >
                <img
                    src="/images/brand/logo-wordmark.png"
                    :alt="business.name"
                    width="646"
                    height="216"
                    :class="[
                        'h-auto w-full transition-opacity duration-500',
                        solid ? 'opacity-0' : 'opacity-100',
                    ]"
                />
                <img
                    src="/images/brand/logo-wordmark-dark.png"
                    alt=""
                    aria-hidden="true"
                    width="646"
                    height="216"
                    :class="[
                        'absolute inset-0 h-auto w-full transition-opacity duration-500',
                        solid ? 'opacity-100' : 'opacity-0',
                    ]"
                />
            </Link>

            <nav
                class="hidden items-center gap-1 lg:flex"
                :aria-label="t('nav.main')"
            >
                <Link
                    v-for="item in site.nav"
                    :key="item.key"
                    :href="item.href"
                    :aria-current="site.key === item.key ? 'page' : undefined"
                    :class="[
                        'relative rounded-full px-3.5 py-2 text-[0.9rem] font-medium whitespace-nowrap transition-colors duration-300 xl:px-4',
                        solid
                            ? site.key === item.key
                                ? 'text-ink-950'
                                : 'text-ink-600 hover:text-ink-950'
                            : site.key === item.key
                              ? 'text-white'
                              : 'text-white/70 hover:text-white',
                    ]"
                >
                    {{ t(`nav.${item.key}`) }}
                    <span
                        v-if="site.key === item.key"
                        class="absolute inset-x-4 -bottom-0.5 h-0.5 rounded-full bg-brand-500"
                    />
                </Link>
            </nav>

            <div class="flex items-center gap-2 sm:gap-3">
                <div
                    :class="[
                        'flex items-center rounded-full p-1 text-xs font-semibold transition-colors duration-500',
                        solid
                            ? 'bg-ink-100'
                            : 'bg-white/10 ring-1 ring-white/15 backdrop-blur',
                    ]"
                    role="group"
                    :aria-label="t('lang.switch')"
                >
                    <!-- Plain links (full page load) so <html lang> follows the language. -->
                    <a
                        v-for="code in locales"
                        :key="code"
                        :href="site.alternates[code].href"
                        :hreflang="site.alternates[code].hreflang"
                        :lang="code"
                        :title="site.alternates[code].name"
                        :aria-current="code === locale ? 'true' : undefined"
                        :class="[
                            'rounded-full px-2.5 py-1 transition-colors duration-300',
                            code === locale
                                ? solid
                                    ? 'bg-white text-ink-950 shadow-sm'
                                    : 'bg-white text-ink-950'
                                : solid
                                  ? 'text-ink-500 hover:text-ink-950'
                                  : 'text-white/70 hover:text-white',
                        ]"
                    >
                        {{ site.alternates[code].label }}
                    </a>
                </div>

                <a
                    :href="whatsappUrl()"
                    target="_blank"
                    rel="noopener"
                    class="group hidden items-center gap-2 rounded-full bg-brand-500 py-2.5 pr-5 pl-4 text-sm font-semibold text-white shadow-[0_8px_24px_-8px_rgb(250_102_52/0.7)] transition-all duration-300 hover:-translate-y-px hover:bg-brand-600 sm:inline-flex"
                >
                    <WhatsAppIcon class="size-4" />
                    {{ t('cta.whatsapp') }}
                </a>

                <button
                    type="button"
                    :class="[
                        'grid size-10 place-items-center rounded-full transition-colors duration-300 lg:hidden',
                        solid
                            ? 'text-ink-950 hover:bg-ink-100'
                            : 'text-white hover:bg-white/10',
                    ]"
                    :aria-expanded="menuOpen"
                    aria-controls="mobile-menu"
                    :aria-label="menuOpen ? t('menu.close') : t('menu.open')"
                    @click="menuOpen = !menuOpen"
                >
                    <X v-if="menuOpen" class="size-6" />
                    <Menu v-else class="size-6" />
                </button>
            </div>
        </div>

        <Transition
            enter-active-class="transition duration-500 ease-out-expo"
            enter-from-class="opacity-0"
            leave-active-class="transition duration-300"
            leave-to-class="opacity-0"
        >
            <div
                v-if="menuOpen"
                id="mobile-menu"
                class="fixed inset-0 top-20 -z-10 flex flex-col justify-between overflow-y-auto bg-ink-950 px-5 pt-6 pb-10 text-white sm:px-8 lg:hidden"
            >
                <nav class="flex flex-col" :aria-label="t('nav.main')">
                    <Link
                        v-for="(item, i) in site.nav"
                        :key="item.key"
                        :href="item.href"
                        class="animate-rise border-b border-white/10 py-4 font-display text-4xl font-semibold tracking-tight sm:text-5xl"
                        :class="
                            site.key === item.key
                                ? 'text-brand-400'
                                : 'text-white'
                        "
                        :style="{ animationDelay: `${80 + i * 60}ms` }"
                    >
                        {{ t(`nav.${item.key}`) }}
                    </Link>
                </nav>

                <div
                    class="mt-10 grid animate-rise gap-3 [animation-delay:400ms]"
                >
                    <a
                        :href="whatsappUrl()"
                        target="_blank"
                        rel="noopener"
                        class="flex items-center justify-center gap-2 rounded-full bg-brand-500 py-4 text-base font-semibold"
                    >
                        <WhatsAppIcon class="size-5" />
                        {{ t('cta.whatsapp') }}
                    </a>
                    <a
                        :href="telUrl"
                        class="flex items-center justify-center gap-2 rounded-full bg-white/10 py-4 text-base font-semibold ring-1 ring-white/15"
                    >
                        <Phone class="size-5" />
                        {{ business.phoneDisplay }}
                    </a>
                    <p class="mt-4 text-center text-sm text-white/50">
                        {{ business.motto }}
                    </p>
                </div>
            </div>
        </Transition>
    </header>
</template>
