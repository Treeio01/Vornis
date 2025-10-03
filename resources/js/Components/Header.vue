<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';

const props = defineProps({
    twitter: {
        type: String,
        default: null,
    },
});

const page = usePage();

const isMenuOpen = ref(false);

const navigation = computed(() => [
    { label: 'Dashboard', href: '/dashboard' },
    { label: 'Public list', href: '/publicList' },
    { label: 'My reports', href: '/myReports' },
    { label: 'Earnings', href: '/earnings' },
]);

const currentUrl = computed(() => page.url || '');

const toggleMenu = () => {
    isMenuOpen.value = !isMenuOpen.value;
};

const closeMenu = () => {
    isMenuOpen.value = false;
};

const handleEscape = (event) => {
    if (event.key === 'Escape') {
        closeMenu();
    }
};

const handleResize = () => {
    if (window.innerWidth >= 1024) {
        closeMenu();
    }
};

onMounted(() => {
    window.addEventListener('keydown', handleEscape);
    window.addEventListener('resize', handleResize);
});

onBeforeUnmount(() => {
    window.removeEventListener('keydown', handleEscape);
    window.removeEventListener('resize', handleResize);
});
</script>

<template>
    <header class="sticky top-0 z-50 border-b border-white/10 bg-[#101010]/95 backdrop-blur">
        <div class="mx-auto flex w-full max-w-[1728px] items-center justify-between gap-6 px-6 py-4 lg:px-12">
            <div class="flex items-center gap-3">
                <Link href="/" class="flex items-center gap-3 text-white">
                    <img src="/assets/img/logo.svg" alt="Vornis" class="h-10 w-10" />
                    <span class="text-lg font-semibold tracking-tight">Vornis</span>
                </Link>
            </div>

            <nav class="hidden items-center gap-2 lg:flex" aria-label="Main navigation">
                <Link
                    v-for="item in navigation"
                    :key="item.href"
                    :href="item.href"
                    :class="[
                        'rounded-sm px-4.5 py-2 text-sm transition-colors',
                        currentUrl.startsWith(item.href)
                            ? 'bg-primary/12 text-primary'
                            : 'text-white/60 hover:bg-white/10 hover:text-white'
                    ]"
                >
                    {{ item.label }}
                </Link>
            </nav>

            <div class="flex items-center gap-3">
                <a
                    v-if="props.twitter"
                    :href="props.twitter"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="hidden rounded-full border border-white px-4 py-2 text-sm text-white transition-colors hover:bg-white/10 lg:inline-flex"
                >
                    Twitter
                </a>

                <button
                    type="button"
                    class="inline-flex items-center justify-center rounded-md border border-white/20 p-2 text-white transition-colors hover:bg-white/10 lg:hidden"
                    @click="toggleMenu"
                    :aria-expanded="isMenuOpen"
                    aria-controls="mobile-navigation"
                >
                    <span class="sr-only">Toggle navigation</span>
                    <svg
                        v-if="!isMenuOpen"
                        class="h-6 w-6"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.5"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <svg
                        v-else
                        class="h-6 w-6"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.5"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <transition name="fade">
            <div
                v-if="isMenuOpen"
                id="mobile-navigation"
                class="lg:hidden"
            >
                <div class="border-t border-white/10 bg-[#0F0F10] px-6 py-4">
                    <nav class="flex flex-col gap-2" aria-label="Mobile navigation">
                        <Link
                            v-for="item in navigation"
                            :key="item.href"
                            :href="item.href"
                            class="rounded-md px-4 py-2 text-sm text-white/80 transition-colors hover:bg-white/10 hover:text-white"
                            :class="{ 'bg-primary/12 text-primary': currentUrl.startsWith(item.href) }"
                            @click="closeMenu"
                        >
                            {{ item.label }}
                        </Link>
                        <a
                            v-if="props.twitter"
                            :href="props.twitter"
                            class="rounded-md px-4 py-2 text-sm text-white/80 transition-colors hover:bg-white/10 hover:text-white"
                            target="_blank"
                            rel="noopener noreferrer"
                            @click="closeMenu"
                        >
                            Twitter
                        </a>
                    </nav>
                </div>
            </div>
        </transition>
    </header>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

.sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border-width: 0;
}
</style>
