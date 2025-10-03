<script setup>
import { computed } from 'vue';

const variants = {
    primary: {
        container: 'bg-[#1E79F9]/12',
        badge: 'border-white',
        accent: 'text-[#1E79F9]'
    },
    success: {
        container: 'bg-[#1EF993]/12',
        badge: 'border-white',
        accent: 'text-[#1EF993]'
    },
    warning: {
        container: 'bg-[#F9A51E]/12',
        badge: 'border-white',
        accent: 'text-[#F9A51E]'
    },
    neutral: {
        container: 'bg-[#758CED]/12',
        badge: 'border-white',
        accent: 'text-[#758CED]'
    }
};

const props = defineProps({
    value: {
        type: [Number, String],
        default: 0,
    },
    title: {
        type: String,
        required: true,
    },
    subtitle: {
        type: String,
        default: '',
    },
    variant: {
        type: String,
        default: 'primary',
        validator: (val) => ['primary', 'success', 'warning', 'neutral'].includes(val),
    },
});

const styles = computed(() => variants[props.variant] ?? variants.primary);
</script>

<template>
    <section :class="['flex w-full flex-col items-center gap-1.5 rounded-sm py-8', styles.container]">
        <div class="flex rounded-full border px-4.5 py-3" :class="styles.badge">
            <span class="text-lg font-medium leading-none text-white">
                {{ value }}
            </span>
        </div>
        <div class="flex flex-col items-center gap-1 text-center">
            <span class="text-2xl font-semibold leading-none" :class="styles.accent">
                {{ title }}
            </span>
            <span v-if="subtitle" class="text-sm font-light leading-snug text-white/60">
                {{ subtitle }}
            </span>
        </div>
    </section>
</template>
