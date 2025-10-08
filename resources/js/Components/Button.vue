<script setup>
const props = defineProps({
    type: {
        type: String,
        default: 'submit',
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <button
        :type="props.type"
        :disabled="props.disabled"
        :aria-busy="props.disabled"
        class="flex w-full justify-center gap-2 rounded-sm bg-primary py-4 px-6 font-medium text-white shadow-[0_2px_6px_0_rgba(0,0,0,0.12),0_0_2px_0_#FF898B] transition-opacity duration-300 ease-in-out focus:outline-none focus-visible:ring-2 focus-visible:ring-primary/80 disabled:cursor-not-allowed disabled:opacity-60"
    >
        <slot />
    </button>
</template>
