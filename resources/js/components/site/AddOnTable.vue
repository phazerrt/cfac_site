<script setup lang="ts">
import { useSite } from '@/composables/useSite';
import type { AddOn } from '@/types/site';

defineProps<{ rows: AddOn[] }>();

const { t, rm } = useSite();
</script>

<template>
    <div
        v-reveal
        class="overflow-hidden rounded-3xl bg-white ring-1 ring-ink-950/8"
    >
        <table class="w-full text-left text-[0.95rem]">
            <caption class="sr-only">
                {{
                    t('addons.title')
                }}
            </caption>
            <thead class="bg-ink-950 text-white">
                <tr>
                    <th scope="col" class="px-5 py-4 font-semibold sm:px-7">
                        {{ t('addons.item') }}
                    </th>
                    <th
                        scope="col"
                        class="px-4 py-4 text-right font-semibold whitespace-nowrap sm:px-6"
                    >
                        {{ t('category.arabian') }}
                    </th>
                    <th
                        scope="col"
                        class="px-5 py-4 text-right font-semibold whitespace-nowrap sm:px-7"
                    >
                        {{ t('category.block') }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="row in rows"
                    :key="row.slug"
                    class="border-t border-ink-950/6 odd:bg-cream/60"
                >
                    <th
                        scope="row"
                        class="px-5 py-3.5 font-medium text-ink-800 sm:px-7"
                    >
                        {{ row.name }}
                    </th>
                    <td
                        :colspan="row.block === null ? 2 : 1"
                        :class="[
                            'px-4 py-3.5 text-right font-semibold whitespace-nowrap text-ink-950 tabular-nums sm:px-6',
                            row.block === null ? 'pr-5 sm:pr-7' : '',
                        ]"
                    >
                        <span
                            v-if="row.block === null"
                            class="mr-2 hidden text-xs font-normal text-ink-400 sm:inline"
                            >{{ t('addons.both') }}</span
                        >RM{{ rm(row.arabian) }}
                    </td>
                    <td
                        v-if="row.block !== null"
                        class="px-5 py-3.5 text-right font-semibold whitespace-nowrap text-brand-600 tabular-nums sm:px-7"
                    >
                        RM{{ rm(row.block) }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
