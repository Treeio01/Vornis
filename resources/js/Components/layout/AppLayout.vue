<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import AppHeader from '@components/Header.vue';
import AppFooter from '@layout/AppFooter.vue';

const props = defineProps({
    showHeader: {
        type: Boolean,
        default: true,
    },
    showFooter: {
        type: Boolean,
        default: true,
    },
});

const page = usePage();

const twitter = computed(() => page.props?.twitter ?? null);
const pageKey = computed(() => page.url ?? page.component ?? 'page');
</script>

<template>
    <div class="min-h-screen bg-black text-white flex flex-col">
        <AppHeader v-if="showHeader" :twitter="twitter" />

        <main class="flex-1">
            <transition name="fade" mode="out-in" appear>
                <div class="h-full" :key="pageKey">
                    <slot />
                </div>
            </transition>
        </main>

    </div>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
