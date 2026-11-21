<script setup lang="ts">
import { ChevronLeft, ChevronRight, X } from '@lucide/vue';
import { computed, nextTick, onBeforeUnmount, ref, watch } from 'vue';
import { useSite } from '@/composables/useSite';
import type { GalleryItem } from '@/types/site';

const props = withDefaults(
    defineProps<{ items: GalleryItem[]; columns?: 'default' | 'compact' }>(),
    { columns: 'default' },
);

const { t } = useSite();

const open = ref<number | null>(null);
const closeButton = ref<HTMLButtonElement | null>(null);
let opener: HTMLElement | null = null;

const current = computed(() =>
    open.value === null ? null : props.items[open.value],
);

function show(index: number, event: Event) {
    opener = event.currentTarget as HTMLElement;
    open.value = index;
}

function close() {
    open.value = null;
    opener?.focus();
}

function step(delta: number) {
    if (open.value === null) {
        return;
    }

    const count = props.items.length;
    open.value = (open.value + delta + count) % count;
}

function onKey(event: KeyboardEvent) {
    if (open.value === null) {
        return;
    }

    if (event.key === 'Escape') {
        close();
    } else if (event.key === 'ArrowRight') {
        step(1);
    } else if (event.key === 'ArrowLeft') {
        step(-1);
    }
}

watch(open, async (value, previous) => {
    if (value !== null && previous === null) {
        document.documentElement.style.overflow = 'hidden';
        window.addEventListener('keydown', onKey);
        await nextTick();
        closeButton.value?.focus();
    } else if (value === null) {
        document.documentElement.style.overflow = '';
        window.removeEventListener('keydown', onKey);
    }
});

// The filter on the gallery page can shrink the list under an open photo.
watch(
    () => props.items,
    () => (open.value = null),
);

onBeforeUnmount(() => {
    document.documentElement.style.overflow = '';
    window.removeEventListener('keydown', onKey);
});
</script>

<template>
    <div
        :class="[
            'masonry',
            columns === 'compact'
                ? 'columns-2 lg:columns-4'
                : 'columns-1 sm:columns-2 lg:columns-3',
        ]"
    >
        <button
            v-for="(item, i) in items"
            :key="item.src"
            type="button"
            class="group relative block w-full overflow-hidden rounded-2xl bg-ink-100 focus-visible:ring-4 focus-visible:ring-brand-500/60 focus-visible:outline-none"
            :aria-label="t('gallery.open', { alt: item.alt })"
            @click="show(i, $event)"
        >
            <img
                :src="item.src"
                :alt="item.alt"
                :width="item.w"
                :height="item.h"
                loading="lazy"
                class="h-auto w-full transition-transform duration-700 ease-out-expo group-hover:scale-[1.04]"
            />
            <span
                class="absolute inset-0 flex items-end bg-gradient-to-t from-ink-950/75 via-ink-950/0 to-transparent p-4 text-left text-sm font-medium text-white opacity-0 transition-opacity duration-500 group-hover:opacity-100"
            >
                {{ item.alt }}
            </span>
        </button>
    </div>

    <Transition
        enter-active-class="transition duration-300"
        enter-from-class="opacity-0"
        leave-active-class="transition duration-200"
        leave-to-class="opacity-0"
    >
        <div
            v-if="current"
            class="fixed inset-0 z-[60] flex flex-col bg-ink-950/95 backdrop-blur-sm"
            role="dialog"
            aria-modal="true"
            :aria-label="current.alt"
            @click.self="close"
        >
            <div class="flex items-center justify-between p-4 text-white/70">
                <p class="text-sm tabular-nums">
                    {{ (open ?? 0) + 1 }} / {{ items.length }}
                </p>
                <button
                    ref="closeButton"
                    type="button"
                    class="grid size-11 place-items-center rounded-full bg-white/10 text-white transition-colors hover:bg-white/20"
                    :aria-label="t('gallery.close')"
                    @click="close"
                >
                    <X class="size-5" />
                </button>
            </div>

            <div
                class="relative flex min-h-0 flex-1 items-center justify-center px-4 sm:px-20"
                @click.self="close"
            >
                <img
                    :key="current.src"
                    :src="current.src"
                    :alt="current.alt"
                    class="max-h-full max-w-full animate-fade rounded-xl object-contain shadow-2xl"
                />
                <button
                    type="button"
                    class="absolute left-2 grid size-12 place-items-center rounded-full bg-white/10 text-white transition-colors hover:bg-brand-500 sm:left-6"
                    :aria-label="t('gallery.previous')"
                    @click="step(-1)"
                >
                    <ChevronLeft class="size-6" />
                </button>
                <button
                    type="button"
                    class="absolute right-2 grid size-12 place-items-center rounded-full bg-white/10 text-white transition-colors hover:bg-brand-500 sm:right-6"
                    :aria-label="t('gallery.next')"
                    @click="step(1)"
                >
                    <ChevronRight class="size-6" />
                </button>
            </div>

            <p class="p-5 text-center text-sm text-white/75">
                {{ current.alt }}
            </p>
        </div>
    </Transition>
</template>
