<script setup lang="ts">
import {
    BriefcaseBusiness,
    Camera,
    FerrisWheel,
    Flower2,
    Gem,
    HeartHandshake,
    PartyPopper,
    Printer,
    Sparkles,
} from '@lucide/vue';
import type { Component } from 'vue';
import { computed } from 'vue';

const props = defineProps<{ name: string }>();

// Icon keys stored on services.icon (database) -> lucide components.
const icons: Record<string, Component> = {
    party: PartyPopper,
    rings: Gem,
    briefcase: BriefcaseBusiness,
    festival: FerrisWheel,
    charity: HeartHandshake,
    printer: Printer,
    camera: Camera,
    flower: Flower2,
};

const icon = computed(() => icons[props.name] ?? Sparkles);
</script>

<template>
    <component :is="icon" aria-hidden="true" />
</template>
