<script setup>
const props = defineProps({
    twitter: {
        type: String,
        default: null,
    },
});

const year = new Date().getFullYear();
</script>

<template>
    <footer class="border-t border-white/10 bg-[#0F0F10]">
        <div class="mx-auto flex w-full max-w-[1728px] flex-col gap-4 px-6 py-6 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
                <img src="/assets/img/logo.svg" alt="Vornis" class="h-8 w-8" />
                <span class="text-sm text-white/70">© {{ year }} Vornis. All rights reserved.</span>
            </div>
            <div class="flex flex-wrap gap-4">
                <a
                    v-if="props.twitter"
                    :href="props.twitter"
                    class="text-sm text-white/60 transition-colors hover:text-primary"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    Twitter
                </a>
                <a href="mailto:support@vornis.com" class="text-sm text-white/60 transition-colors hover:text-primary">
                    support@vornis.com
                </a>
            </div>
        </div>
    </footer>
</template>
