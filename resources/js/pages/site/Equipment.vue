<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import {
    ArrowRight,
    Armchair,
    Fan,
    Lightbulb,
    MonitorPlay,
    Speaker,
    Theater,
} from '@lucide/vue';
import CtaBand from '@/components/site/CtaBand.vue';
import PackageCard from '@/components/site/PackageCard.vue';
import PageHero from '@/components/site/PageHero.vue';
import SectionHeading from '@/components/site/SectionHeading.vue';
import SiteIcon from '@/components/site/SiteIcon.vue';
import SiteSeo from '@/components/site/SiteSeo.vue';
import WhatsAppIcon from '@/components/site/WhatsAppIcon.vue';
import { useSite } from '@/composables/useSite';
import type { Package, Service } from '@/types/site';

defineProps<{
    packages: Package[];
    extras: Service[];
}>();

const { t, href, whatsappUrl } = useSite();

const kit = [
    { key: 'led', icon: MonitorPlay, image: '/media/av/led-wall.webp' },
    { key: 'sound', icon: Speaker, image: '/media/av/mixer.webp' },
    { key: 'lighting', icon: Lightbulb, image: '/media/av/beams.webp' },
    {
        key: 'stage',
        icon: Theater,
        image: '/media/pkg/block-white-stage-3.webp',
    },
];

const rentals = [
    { key: 'furniture', icon: Armchair },
    { key: 'cooling', icon: Fan },
];
</script>

<template>
    <SiteSeo
        :title="t('equipment_page.seo.title')"
        :description="t('equipment_page.seo.description')"
    />

    <PageHero
        :eyebrow="t('equipment_page.hero.eyebrow')"
        :title="t('equipment_page.hero.title')"
        :lead="t('equipment_page.hero.lead')"
        image="/media/hero/stage-concert.webp"
    />

    <!-- Kit overview -->
    <section class="bg-white py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-5 sm:px-8">
            <SectionHeading
                :eyebrow="t('equipment_page.kit.eyebrow')"
                :title="t('equipment_page.kit.title')"
                :lead="t('equipment_page.kit.lead')"
            />
            <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <article
                    v-for="(item, i) in kit"
                    :key="item.key"
                    v-reveal="i * 80"
                    class="group overflow-hidden rounded-3xl bg-cream"
                >
                    <div class="aspect-[4/3] overflow-hidden">
                        <img
                            :src="item.image"
                            alt=""
                            loading="lazy"
                            class="size-full object-cover transition-transform duration-700 ease-out-expo group-hover:scale-105"
                        />
                    </div>
                    <div class="p-6">
                        <span
                            class="grid size-11 place-items-center rounded-xl bg-brand-500 text-white"
                        >
                            <component :is="item.icon" class="size-5" />
                        </span>
                        <h3 class="mt-5 font-display text-xl font-semibold">
                            {{ t(`av.${item.key}.title`) }}
                        </h3>
                        <p
                            class="mt-2 text-[0.95rem] leading-relaxed text-ink-600"
                        >
                            {{ t(`av.${item.key}.text`) }}
                        </p>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- AV packages -->
    <section class="bg-cream py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-5 sm:px-8">
            <div
                class="flex flex-col justify-between gap-8 lg:flex-row lg:items-end"
            >
                <SectionHeading
                    :eyebrow="t('equipment_page.packages.eyebrow')"
                    :title="t('equipment_page.packages.title')"
                    :lead="t('equipment_page.packages.lead')"
                />
                <a
                    v-reveal
                    :href="whatsappUrl(t('equipment_page.whatsapp_message'))"
                    target="_blank"
                    rel="noopener"
                    class="inline-flex shrink-0 items-center gap-2.5 rounded-full bg-brand-500 px-6 py-3.5 font-semibold text-white transition-colors hover:bg-brand-600"
                >
                    <WhatsAppIcon class="size-5" />
                    {{ t('cta.quote') }}
                </a>
            </div>
            <div class="mt-14 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                <PackageCard
                    v-for="(pkg, i) in packages"
                    :key="pkg.slug"
                    :pkg="pkg"
                    :delay="i * 80"
                />
            </div>
        </div>
    </section>

    <!-- Other services -->
    <section
        class="grain relative isolate overflow-hidden bg-ink-950 py-24 text-white sm:py-32"
    >
        <div
            class="absolute -top-40 -left-24 -z-10 size-[34rem] rounded-full bg-brand-500/15 blur-[140px]"
        />
        <div class="mx-auto max-w-7xl px-5 sm:px-8">
            <SectionHeading
                :eyebrow="t('extras.eyebrow')"
                :title="t('extras.title')"
                :lead="t('extras.lead')"
                dark
            />
            <div class="mt-14 grid gap-6 lg:grid-cols-3">
                <article
                    v-for="(extra, i) in extras"
                    :key="extra.slug"
                    v-reveal="i * 80"
                    class="flex flex-col overflow-hidden rounded-3xl bg-white/5 ring-1 ring-white/10"
                >
                    <div class="grid grid-cols-3 gap-1.5 p-1.5">
                        <img
                            v-if="extra.image"
                            :src="extra.image"
                            :alt="extra.title"
                            loading="lazy"
                            class="col-span-2 aspect-[4/3] size-full rounded-[1.25rem] object-cover"
                        />
                        <img
                            v-for="src in extra.gallery.slice(0, 1)"
                            :key="src"
                            :src="src"
                            alt=""
                            loading="lazy"
                            class="size-full rounded-[1.25rem] object-cover"
                        />
                    </div>
                    <div class="flex flex-1 flex-col p-7">
                        <span
                            class="grid size-11 place-items-center rounded-full bg-brand-500"
                        >
                            <SiteIcon :name="extra.icon" class="size-5" />
                        </span>
                        <h3 class="mt-5 font-display text-2xl font-semibold">
                            {{ extra.title }}
                        </h3>
                        <p class="mt-3 leading-relaxed text-white/65">
                            {{ extra.summary }}
                        </p>
                        <a
                            :href="
                                whatsappUrl(
                                    t('extras.whatsapp_message', {
                                        service: extra.title,
                                    }),
                                )
                            "
                            target="_blank"
                            rel="noopener"
                            class="group mt-auto inline-flex items-center gap-2 pt-7 font-semibold text-brand-400"
                        >
                            {{ t('package.ask_price') }}
                            <ArrowRight
                                class="size-4 transition-transform group-hover:translate-x-1"
                            />
                        </a>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- Rentals -->
    <section class="bg-white py-24 sm:py-28">
        <div
            class="mx-auto grid max-w-7xl items-center gap-12 px-5 sm:px-8 lg:grid-cols-2"
        >
            <SectionHeading
                :eyebrow="t('rentals.eyebrow')"
                :title="t('rentals.title')"
                :lead="t('rentals.lead')"
            >
                <Link
                    v-reveal="200"
                    :href="`${href('tents')}#add-ons`"
                    class="group mt-9 inline-flex items-center gap-2.5 rounded-full bg-ink-950 px-7 py-4 font-semibold text-white transition-colors duration-300 hover:bg-brand-500"
                >
                    {{ t('cta.addons') }}
                    <ArrowRight
                        class="size-4 transition-transform group-hover:translate-x-1"
                    />
                </Link>
            </SectionHeading>
            <ul class="grid gap-4 sm:grid-cols-2">
                <li
                    v-for="(item, i) in rentals"
                    :key="item.key"
                    v-reveal="i * 80"
                    class="rounded-3xl bg-cream p-7"
                >
                    <component :is="item.icon" class="size-7 text-brand-500" />
                    <h3 class="mt-5 font-display text-lg font-semibold">
                        {{ t(`rentals.${item.key}.title`) }}
                    </h3>
                    <p class="mt-2 text-[0.95rem] text-ink-600">
                        {{ t(`rentals.${item.key}.text`) }}
                    </p>
                </li>
            </ul>
        </div>
    </section>

    <CtaBand image="/media/gallery/colourful-stage.webp" />
</template>
