<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import {
    ArrowRight,
    ArrowUpRight,
    Check,
    Crown,
    Lightbulb,
    MonitorPlay,
    Speaker,
} from '@lucide/vue';
import CtaBand from '@/components/site/CtaBand.vue';
import GalleryGrid from '@/components/site/GalleryGrid.vue';
import SectionHeading from '@/components/site/SectionHeading.vue';
import SiteIcon from '@/components/site/SiteIcon.vue';
import SiteSeo from '@/components/site/SiteSeo.vue';
import WhatsAppIcon from '@/components/site/WhatsAppIcon.vue';
import { useSite } from '@/composables/useSite';
import type { GalleryItem, Package, Service } from '@/types/site';

const props = defineProps<{
    events: Service[];
    featured: Package[];
    fromPrices: { arabian: number; block: number };
    tentCount: number;
    gallery: GalleryItem[];
}>();

const { business, t, href, whatsappUrl, rm } = useSite();

const facts = [
    { value: String(props.tentCount), label: t('facts.packages') },
    {
        value: `RM${rm(props.fromPrices.arabian)}`,
        label: t('facts.from'),
    },
    { value: "20' × 40'", label: t('facts.sizes') },
    { value: 'LED · PA', label: t('facts.av') },
];

const tents = [
    {
        key: 'arabian',
        image: '/media/hero/arabian-deco.webp',
        size: "20' × 20'",
        from: props.fromPrices.arabian,
        anchor: '#arabian',
    },
    {
        key: 'block',
        image: '/media/hero/block-clear-fairy.webp',
        size: "20' × 40'",
        from: props.fromPrices.block,
        anchor: '#block',
    },
];

const av = [
    { icon: MonitorPlay, key: 'led' },
    { icon: Speaker, key: 'sound' },
    { icon: Lightbulb, key: 'lighting' },
];

const steps = [1, 2, 3, 4];
</script>

<template>
    <SiteSeo
        :title="t('home.seo.title')"
        :description="t('home.seo.description')"
    />

    <!-- Hero -->
    <section
        class="grain relative isolate overflow-hidden bg-ink-950 text-white"
    >
        <img
            src="/media/hero/marquee-beach.webp"
            alt=""
            aria-hidden="true"
            class="absolute inset-0 -z-30 size-full animate-fade object-cover opacity-20 blur-sm"
            fetchpriority="high"
        />
        <div
            class="absolute inset-0 -z-20 bg-gradient-to-b from-ink-950/70 via-ink-950/85 to-ink-950"
        />
        <div
            class="absolute top-1/4 -right-40 -z-10 size-[40rem] rounded-full bg-brand-500/20 blur-[150px]"
        />
        <div
            class="absolute -bottom-40 -left-40 -z-10 size-[30rem] rounded-full bg-gold/10 blur-[130px]"
        />

        <div
            class="mx-auto grid max-w-7xl items-center gap-14 px-5 pt-32 pb-16 sm:px-8 lg:min-h-svh lg:grid-cols-12 lg:gap-10 lg:pt-36 lg:pb-24"
        >
            <div class="lg:col-span-6">
                <p
                    class="inline-flex animate-rise items-center gap-3 text-xs font-semibold tracking-[0.24em] text-brand-400 uppercase"
                >
                    <span class="h-px w-8 bg-brand-400/60" />
                    {{ business.tagline }}
                </p>
                <p
                    class="mt-8 animate-rise font-script text-5xl text-brand-400 [animation-delay:80ms] sm:text-6xl"
                >
                    {{ business.motto }}
                </p>
                <h1
                    class="mt-4 animate-rise font-display-tight text-[2.7rem] text-balance [animation-delay:160ms] sm:text-6xl xl:text-7xl"
                >
                    {{ t('hero.title') }}
                </h1>
                <p
                    class="mt-7 max-w-xl animate-rise text-lg leading-relaxed text-pretty text-white/70 [animation-delay:240ms]"
                >
                    {{ t('hero.lead', { area: business.area }) }}
                </p>

                <div
                    class="mt-10 flex animate-rise flex-col gap-3 [animation-delay:320ms] sm:flex-row"
                >
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
                        :href="href('tents')"
                        class="group inline-flex items-center justify-center gap-2.5 rounded-full bg-white/10 px-7 py-4 font-semibold ring-1 ring-white/20 backdrop-blur transition-colors duration-300 hover:bg-white/15"
                    >
                        {{ t('cta.packages') }}
                        <ArrowRight
                            class="size-4 transition-transform group-hover:translate-x-1"
                        />
                    </Link>
                </div>
            </div>

            <!-- Photo collage -->
            <div
                class="relative mx-auto w-full max-w-xl animate-rise [animation-delay:200ms] lg:col-span-6 lg:max-w-none"
            >
                <div class="frame-corners">
                    <img
                        src="/media/hero/marquee-beach.webp"
                        :alt="t('hero.image_main')"
                        width="1243"
                        height="558"
                        class="aspect-[4/3] w-full rounded-[1.75rem] object-cover shadow-2xl sm:aspect-[5/4]"
                    />
                </div>
                <img
                    src="/media/hero/stage-concert.webp"
                    :alt="t('hero.image_stage')"
                    width="1023"
                    height="696"
                    class="absolute -bottom-8 -left-4 hidden w-[44%] rotate-[-3deg] rounded-2xl object-cover shadow-2xl ring-4 ring-ink-950 sm:block lg:-left-10"
                />
                <img
                    src="/media/pkg/arabian-clear-premium.webp"
                    :alt="t('hero.image_tent')"
                    width="942"
                    height="430"
                    class="absolute -top-8 -right-3 hidden w-[42%] rotate-[3deg] rounded-2xl object-cover shadow-2xl ring-4 ring-ink-950 sm:block lg:-right-6"
                />
                <div
                    class="absolute right-4 -bottom-6 rounded-2xl bg-brand-500 px-5 py-4 shadow-[0_20px_40px_-12px_rgb(250_102_52/0.7)] sm:right-8"
                >
                    <p
                        class="text-[0.7rem] font-semibold tracking-[0.2em] text-white/80 uppercase"
                    >
                        {{ t('hero.badge') }}
                    </p>
                    <p class="font-display text-3xl font-bold">
                        RM{{ rm(fromPrices.arabian) }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Facts -->
        <div class="border-t border-white/10">
            <dl
                class="mx-auto grid max-w-7xl grid-cols-2 gap-px px-5 sm:px-8 lg:grid-cols-4"
            >
                <div
                    v-for="(fact, i) in facts"
                    :key="fact.label"
                    v-reveal="i * 80"
                    class="flex flex-col py-8 lg:py-10"
                >
                    <dt class="order-2 mt-1 text-sm text-white/55">
                        {{ fact.label }}
                    </dt>
                    <dd
                        class="order-1 font-display text-3xl font-bold text-white sm:text-4xl"
                    >
                        {{ fact.value }}
                    </dd>
                </div>
            </dl>
        </div>
    </section>

    <!-- Events we do -->
    <section class="bg-cream py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-5 sm:px-8">
            <div
                class="flex flex-col justify-between gap-8 lg:flex-row lg:items-end"
            >
                <SectionHeading
                    :eyebrow="t('events.eyebrow')"
                    :title="t('events.title')"
                    :lead="t('events.lead')"
                />
                <Link
                    v-reveal
                    :href="href('contact')"
                    class="group inline-flex shrink-0 items-center gap-2 font-semibold text-brand-600"
                >
                    {{ t('cta.plan') }}
                    <ArrowRight
                        class="size-4 transition-transform group-hover:translate-x-1"
                    />
                </Link>
            </div>

            <div
                class="no-scrollbar -mx-5 mt-14 flex snap-x snap-mandatory gap-4 overflow-x-auto px-5 pb-4 sm:-mx-8 sm:px-8 lg:mx-0 lg:grid lg:grid-cols-5 lg:overflow-visible lg:px-0"
            >
                <article
                    v-for="(event, i) in events"
                    :key="event.slug"
                    v-reveal="i * 70"
                    class="group relative isolate flex aspect-[3/4] w-[75vw] max-w-xs shrink-0 snap-start flex-col justify-end overflow-hidden rounded-3xl bg-ink-900 p-6 text-white sm:w-72 lg:w-auto lg:max-w-none"
                >
                    <img
                        v-if="event.image"
                        :src="event.image"
                        alt=""
                        loading="lazy"
                        class="absolute inset-0 -z-20 size-full object-cover transition-transform duration-700 ease-out-expo group-hover:scale-105"
                    />
                    <div
                        class="absolute inset-0 -z-10 bg-gradient-to-t from-ink-950 via-ink-950/60 to-ink-950/5"
                    />
                    <span
                        class="mb-auto grid size-11 place-items-center rounded-full bg-white/15 ring-1 ring-white/20 backdrop-blur"
                    >
                        <SiteIcon :name="event.icon" class="size-5" />
                    </span>
                    <h3
                        class="font-display text-xl leading-tight font-semibold"
                    >
                        {{ event.title }}
                    </h3>
                    <p class="mt-2 text-sm leading-relaxed text-white/70">
                        {{ event.summary }}
                    </p>
                </article>
            </div>
        </div>
    </section>

    <!-- Tents -->
    <section class="bg-white py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-5 sm:px-8">
            <SectionHeading
                :eyebrow="t('tents.eyebrow')"
                :title="t('tents.title')"
                :lead="t('tents.lead')"
            />

            <div class="mt-14 grid gap-6 lg:grid-cols-2">
                <Link
                    v-for="(tent, i) in tents"
                    :key="tent.key"
                    v-reveal="i * 100"
                    :href="href('tents') + tent.anchor"
                    class="group relative isolate flex min-h-[30rem] flex-col justify-end overflow-hidden rounded-[2rem] bg-ink-950 p-8 text-white sm:p-10"
                >
                    <img
                        :src="tent.image"
                        alt=""
                        loading="lazy"
                        class="absolute inset-0 -z-20 size-full object-cover transition-transform duration-700 ease-out-expo group-hover:scale-105"
                    />
                    <div
                        class="absolute inset-0 -z-10 bg-gradient-to-t from-ink-950 via-ink-950/55 to-transparent"
                    />
                    <span
                        class="absolute top-8 right-8 grid size-12 place-items-center rounded-full bg-white/15 ring-1 ring-white/25 backdrop-blur transition-colors duration-300 group-hover:bg-brand-500"
                    >
                        <ArrowUpRight class="size-5" />
                    </span>
                    <p
                        class="text-xs font-semibold tracking-[0.24em] text-brand-400 uppercase"
                    >
                        {{ tent.size }}
                    </p>
                    <h3 class="mt-3 font-display-tight text-4xl sm:text-5xl">
                        {{ t(`category.${tent.key}`) }}
                    </h3>
                    <ul class="mt-5 space-y-2 text-white/80">
                        <li
                            v-for="n in 3"
                            :key="n"
                            class="flex items-center gap-3"
                        >
                            <Check class="size-4 text-brand-400" />
                            {{ t(`tents.${tent.key}.${n}`) }}
                        </li>
                    </ul>
                    <p class="mt-7 text-white/60">
                        {{ t('package.from') }}
                        <span class="font-display text-3xl font-bold text-white"
                            >RM{{ rm(tent.from) }}</span
                        >
                    </p>
                </Link>
            </div>
        </div>
    </section>

    <!-- Signature (premium) packages -->
    <section
        class="grain relative isolate overflow-hidden bg-ink-950 py-24 text-white sm:py-32"
    >
        <div
            class="absolute -top-40 left-1/3 -z-10 size-[36rem] rounded-full bg-gold/10 blur-[140px]"
        />
        <div class="mx-auto max-w-7xl px-5 sm:px-8">
            <div
                class="flex flex-col justify-between gap-8 lg:flex-row lg:items-end"
            >
                <SectionHeading
                    :eyebrow="t('signature.eyebrow')"
                    :title="t('signature.title')"
                    :lead="t('signature.lead')"
                    dark
                />
                <Link
                    v-reveal
                    :href="href('tents')"
                    class="group inline-flex shrink-0 items-center gap-2 font-semibold text-brand-400"
                >
                    {{ t('cta.all_packages') }}
                    <ArrowRight
                        class="size-4 transition-transform group-hover:translate-x-1"
                    />
                </Link>
            </div>

            <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <Link
                    v-for="(pkg, i) in featured"
                    :key="pkg.slug"
                    v-reveal="i * 80"
                    :href="`${href('tents')}#${pkg.category}`"
                    class="group flex flex-col overflow-hidden rounded-3xl bg-white/5 ring-1 ring-white/10 transition-colors duration-300 hover:bg-white/10"
                >
                    <div class="relative aspect-[4/3] overflow-hidden">
                        <img
                            v-if="pkg.image"
                            :src="pkg.image"
                            :alt="pkg.name"
                            loading="lazy"
                            class="size-full object-cover transition-transform duration-700 ease-out-expo group-hover:scale-105"
                        />
                        <span
                            class="absolute top-4 left-4 inline-flex items-center gap-1.5 rounded-full bg-gradient-to-r from-gold to-amber-300 px-3 py-1 text-[0.7rem] font-bold tracking-[0.18em] text-ink-950 uppercase"
                        >
                            <Crown class="size-3" />
                            {{ t('tier.premium') }}
                        </span>
                    </div>
                    <div class="flex flex-1 flex-col p-6">
                        <p class="text-xs text-white/50">
                            {{ t(`category.${pkg.category}`) }} ·
                            {{ pkg.size }}
                        </p>
                        <h3
                            class="mt-2 font-display text-lg leading-snug font-semibold"
                        >
                            {{ pkg.name }}
                        </h3>
                        <p class="mt-auto pt-6 font-display text-3xl font-bold">
                            <span class="text-base font-semibold text-white/50"
                                >RM</span
                            >{{ rm(pkg.price ?? 0) }}
                        </p>
                    </div>
                </Link>
            </div>
        </div>
    </section>

    <!-- LED, sound & lighting -->
    <section class="bg-white py-24 sm:py-32">
        <div
            class="mx-auto grid max-w-7xl items-center gap-14 px-5 sm:px-8 lg:grid-cols-2 lg:gap-20"
        >
            <div>
                <SectionHeading
                    :eyebrow="t('av.eyebrow')"
                    :title="t('av.title')"
                    :lead="t('av.lead')"
                />
                <ul class="mt-10 space-y-4">
                    <li
                        v-for="(item, i) in av"
                        :key="item.key"
                        v-reveal="i * 80"
                        class="flex gap-5 rounded-2xl bg-cream p-5"
                    >
                        <span
                            class="grid size-12 shrink-0 place-items-center rounded-xl bg-brand-500 text-white"
                        >
                            <component :is="item.icon" class="size-5" />
                        </span>
                        <div>
                            <h3 class="font-display text-lg font-semibold">
                                {{ t(`av.${item.key}.title`) }}
                            </h3>
                            <p class="mt-1 text-[0.95rem] text-ink-600">
                                {{ t(`av.${item.key}.text`) }}
                            </p>
                        </div>
                    </li>
                </ul>
                <Link
                    v-reveal
                    :href="href('equipment')"
                    class="group mt-10 inline-flex items-center gap-2.5 rounded-full bg-ink-950 px-7 py-4 font-semibold text-white transition-colors duration-300 hover:bg-brand-500"
                >
                    {{ t('cta.equipment') }}
                    <ArrowRight
                        class="size-4 transition-transform group-hover:translate-x-1"
                    />
                </Link>
            </div>

            <div v-reveal="120" class="grid grid-cols-2 gap-4">
                <img
                    src="/media/av/led-wall.webp"
                    :alt="t('av.image_led')"
                    loading="lazy"
                    class="col-span-2 aspect-[2/1] w-full rounded-3xl object-cover"
                />
                <img
                    src="/media/av/beams.webp"
                    :alt="t('av.image_beams')"
                    loading="lazy"
                    class="aspect-square w-full rounded-3xl object-cover"
                />
                <img
                    src="/media/av/p3-stage.webp"
                    :alt="t('av.image_stage')"
                    loading="lazy"
                    class="aspect-square w-full rounded-3xl object-cover"
                />
            </div>
        </div>
    </section>

    <!-- How it works -->
    <section class="bg-cream py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-5 sm:px-8">
            <SectionHeading
                :eyebrow="t('process.eyebrow')"
                :title="t('process.title')"
                align="center"
            />
            <ol class="mt-16 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <li
                    v-for="n in steps"
                    :key="n"
                    v-reveal="n * 80"
                    class="relative rounded-3xl bg-white p-7 ring-1 ring-ink-950/5"
                >
                    <span
                        class="font-display text-5xl font-bold text-brand-500/25"
                        aria-hidden="true"
                        >0{{ n }}</span
                    >
                    <h3 class="mt-4 font-display text-xl font-semibold">
                        {{ t(`process.${n}.title`) }}
                    </h3>
                    <p class="mt-2 leading-relaxed text-ink-600">
                        {{ t(`process.${n}.text`) }}
                    </p>
                </li>
            </ol>
        </div>
    </section>

    <!-- Gallery teaser -->
    <section class="bg-white py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-5 sm:px-8">
            <div
                class="mb-14 flex flex-col justify-between gap-8 lg:flex-row lg:items-end"
            >
                <SectionHeading
                    :eyebrow="t('gallery.eyebrow')"
                    :title="t('gallery.title')"
                />
                <Link
                    v-reveal
                    :href="href('gallery')"
                    class="group inline-flex shrink-0 items-center gap-2 font-semibold text-brand-600"
                >
                    {{ t('cta.gallery') }}
                    <ArrowRight
                        class="size-4 transition-transform group-hover:translate-x-1"
                    />
                </Link>
            </div>
            <GalleryGrid :items="gallery" columns="compact" />
        </div>
    </section>

    <CtaBand />
</template>
