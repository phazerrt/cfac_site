<script setup lang="ts">
import { computed, ref } from 'vue';
import CtaBand from '@/components/site/CtaBand.vue';
import GalleryGrid from '@/components/site/GalleryGrid.vue';
import PageHero from '@/components/site/PageHero.vue';
import SiteSeo from '@/components/site/SiteSeo.vue';
import { useSite } from '@/composables/useSite';
import type { GalleryItem, GalleryTag } from '@/types/site';

const props = defineProps<{
    items: GalleryItem[];
    tags: GalleryTag[];
}>();

const { t } = useSite();

const active = ref<GalleryTag | 'all'>('all');

const visible = computed(() =>
    active.value === 'all'
        ? props.items
        : props.items.filter((item) => item.tag === active.value),
);

function count(tag: GalleryTag | 'all') {
    return tag === 'all'
        ? props.items.length
        : props.items.filter((item) => item.tag === tag).length;
}
</script>

<template>
    <SiteSeo
        :title="t('gallery_page.seo.title')"
        :description="t('gallery_page.seo.description')"
    />

    <PageHero
        :eyebrow="t('gallery_page.hero.eyebrow')"
        :title="t('gallery_page.hero.title')"
        :lead="t('gallery_page.hero.lead')"
        image="/media/gallery/golden-ceiling.webp"
    />

    <section class="bg-white pt-10 pb-24 sm:pb-32">
        <div class="mx-auto max-w-7xl px-5 sm:px-8">
            <div
                class="no-scrollbar -mx-5 flex gap-2 overflow-x-auto px-5 pb-8 sm:mx-0 sm:flex-wrap sm:px-0"
                role="group"
                :aria-label="t('gallery_page.filter')"
            >
                <button
                    v-for="tag in ['all', ...tags] as const"
                    :key="tag"
                    type="button"
                    :aria-pressed="active === tag"
                    :class="[
                        'inline-flex shrink-0 items-center gap-2 rounded-full px-5 py-2.5 text-sm font-semibold ring-1 transition-colors duration-300',
                        active === tag
                            ? 'bg-ink-950 text-white ring-ink-950'
                            : 'text-ink-700 ring-ink-950/10 hover:ring-ink-950/30',
                    ]"
                    @click="active = tag"
                >
                    {{ t(`gallery.tag.${tag}`) }}
                    <span
                        :class="[
                            'rounded-full px-2 py-0.5 text-xs tabular-nums',
                            active === tag
                                ? 'bg-white/15'
                                : 'bg-ink-100 text-ink-500',
                        ]"
                        >{{ count(tag) }}</span
                    >
                </button>
            </div>

            <GalleryGrid :items="visible" />
        </div>
    </section>

    <CtaBand />
</template>
