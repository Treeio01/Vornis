<script setup>
import { Link } from '@inertiajs/vue3';
import { computed, toRefs } from 'vue';

const props = defineProps({
    text: {
        type: String,
        default: '',
    },
    twitter: {
        type: String,
        default: null,
    },
    showLoader: {
        type: Boolean,
        default: false,
    },
    isMenuOpen: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['open-menu', 'close-menu', 'navigate']);

const { text, twitter, showLoader, isMenuOpen } = toRefs(props);

const navigationItems = computed(() => [
    { label: 'About', target: '#about' },
    { label: 'How it Works', target: '#how-it-works' },
    { label: 'Rewards', target: '#rewards' },
    { label: 'Roadmap', target: '#roadmap' },
    { label: 'FAQ', target: '#faq' },
]);

const openMenu = () => emit('open-menu');
const closeMenu = () => emit('close-menu');
const navigate = (target) => emit('navigate', target);
</script>

<template>
    <div class="flex flex-col items-center w-full bg-black overflow-x-hidden">
        <!-- Backdrop -->
        <transition name="fade">
            <div
                v-if="isMenuOpen"
                class="fixed inset-0 z-[90] backdrop bg-black/60"
                @click="closeMenu"
            />
        </transition>
        <transition name="fade">
            <div v-if="showLoader" class="loader">
                <img
                    src="/assets/img/logo.svg"
                    class="w-12 h-12 loader_image"
                    alt=""
                />
            </div>
        </transition>
        <!-- Mobile Menu -->
        <aside
            :class="[
                'fixed top-0 right-0 z-[100] w-[300px] h-full bg-black transition-transform duration-300 ease-in-out',
                isMenuOpen ? 'translate-x-0' : 'translate-x-full',
            ]"
        >
            <div class="flex items-center justify-between p-6 border-b border-white/20">
                <img src="/assets/img/logo.svg" alt="Logo" />
                <button @click="closeMenu" class="text-white">✕</button>
            </div>

            <ul class="flex flex-col gap-2 p-6">
                <li v-for="item in navigationItems" :key="item.target">
                    <a
                        :href="item.target"
                        class="px-4 py-2 text-white/70 transition-colors hover:text-primary"
                        @click.prevent="navigate(item.target)"
                    >
                        {{ item.label }}
                    </a>
                </li>
            </ul>
        </aside>
        <div
            class="flex border-b border-x border-white/24 justify-between relative overflow-hidden items-center w-full max-w-[1824px] p-1.5 bg-primary"
        >
            <img
                src="/assets/img/ellipse1.png"
                class="flex absolute left-1/2 -translate-x-1/2 top-1/2 -translate-y-1/2 z-40 max-w-[1824px]"
                alt=""
            />

            <div
                class="absolute z-50 flex w-full top-1/2 left-1/2 -translate-1/2"
            >
                <img src="/assets/img/lines_light.png" alt="" />
            </div>
            <div class="flex flex-col items-center gap-3">
                <div class="flex w-[12px] h-[12px] border-t border-l border-white/30" />
                <div class="flex w-[12px] h-[12px] border-b border-l border-white/30" />
            </div>
            <span
                class="text-white z-30 !font-SF text-lg leading-[100%] tracking-[-0.00em]"
            >
                {{ text }}
            </span>
            <div class="flex flex-col items-center gap-3">
                <div class="flex w-[12px] h-[12px] border-t border-r border-white/30" />
                <div class="flex w-[12px] h-[12px] border-b border-r border-white/30" />
            </div>
        </div>
        <section
            class="flex flex-col border border-white/12 overflow-hidden rounded-b-lg max-w-[1824px] w-full"
        >
            <header class="flex items-center justify-between z-50 py-4 px-12 bg-[#101010]">
                <div class="flex items-center gap-3" data-aos="fade-right" data-aos-delay="100">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="42"
                        height="42"
                        viewBox="0 0 42 42"
                        fill="none"
                    >
                        <path
                            d="M42 3L20.2665 40L14.5688 30.2198C13.8639 28.9236 13.6172 26.0484 15.4499 23.0319L20.6189 14.3121L11.2206 14.3121C8.40115 14.3121 6.48233 12.5053 5.87536 11.6019L1 3.00001H10.2808C13.5702 3.00001 15.2149 4.88536 15.8023 5.88695L20.6189 14.3121C26.0229 4.41403 27.5501 3 31.3682 3H42Z"
                            fill="white"
                        />
                    </svg>
                    <span class="text-white font-SF text-lg leading-[100%] tracking-[-0.00em]">
                        Vornis
                    </span>
                </div>
                <ul class="items-center hidden lg:flex" data-aos="fade-down" data-aos-delay="200">
                    <li v-for="item in navigationItems" :key="`desktop-${item.target}`">
                        <a
                            :href="item.target"
                            class="py-2 px-4.5 text-white/20 transition-colors ease-in-out duration-500 hover:text-primary hover:bg-primary/12 rounded-sm"
                            @click.prevent="navigate(item.target)"
                        >
                            {{ item.label }}
                        </a>
                    </li>
                </ul>
                <div class="items-center hidden lg:flex" data-aos="fade-left" data-aos-delay="300">
                    <Link
                        href="/register"
                        class="flex py-3.5 px-[45px] rounded-full hover:bg-white/5 transition-all ease-in-out duration-500 border border-white"
                    >
                        <span class="text-white text-lg leading-[100%] tracking-[-0.00em]">
                            Sign Up
                        </span>
                    </Link>
                    <Link
                        href="/login"
                        class="flex py-3.5 px-[45px] rounded-full hover:bg-white/5 transition-all ease-in-out duration-500 border border-white"
                    >
                        <span class="text-white text-lg leading-[100%] tracking-[-0.00em]">
                            Log In
                        </span>
                    </Link>

                    <a
                        :href="twitter"
                        class="px-3 py-3 transition-all duration-500 ease-in-out border border-white rounded-full hover:bg-white/5"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                        >
                            <path
                                d="M21.096 20.8L14.06 10.5424L14.072 10.552L20.416 3.2H18.296L13.128 9.184L9.024 3.2H3.464L10.0328 12.7768L10.032 12.776L3.104 20.8H5.224L10.9696 14.1424L15.536 20.8H21.096ZM8.184 4.8L18.056 19.2H16.376L6.496 4.8H8.184Z"
                                fill="white"
                            />
                        </svg>
                    </a>
                </div>
                <button
                    @click="openMenu"
                    class="flex lg:hidden cursor-pointer gap-4 z-40 p-1 rounded-[6px]"
                >
                    <svg
                        width="25"
                        height="25"
                        viewBox="0 0 24 24"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M4 6H20M4 12H20M4 18H20"
                            stroke="white"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </button>
            </header>
            <div class="flex min-h-[767px] relative py-16 mx-auto" data-aos="fade-up" data-aos-delay="100">
                <img
                    src="/assets/img/hero_block.svg"
                    class="absolute left-1/2 -translate-x-1/2 max-w-[1824px] bottom-0"
                    alt=""
                    data-aos="fade-in"
                    data-aos-delay="200"
                />
                <div
                    class="flex flex-col gap-8 items-center max-w-[600px] z-50"
                    data-aos="zoom-in"
                    data-aos-delay="300"
                >
                    <span
                        style="display: ruby"
                        class="text-white text-[64px] font-SF font-medium leading-[100%] tracking-[-0.02em] text-center"
                        data-aos="fade-up"
                        data-aos-delay="400"
                    >
                        Turn shady
                        <div
                            class="flex p-3 border bg-primary rounded-2xl border-white/50 w-max"
                            data-aos="zoom-in"
                            data-aos-delay="500"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="48"
                                height="48"
                                viewBox="0 0 48 48"
                                fill="none"
                            >
                                <path
                                    fill-rule="evenodd"
                                    clip-rule="evenodd"
                                    d="M9.02461 3.00001H25.0861C25.5908 2.99995 26.0824 2.99989 26.4988 3.0339C26.9559 3.07125 27.4954 3.15939 28.0383 3.43598C28.7909 3.81948 29.4028 4.4314 29.7863 5.18405C30.0629 5.7269 30.1511 6.26636 30.1884 6.72355C30.2224 7.13986 30.2224 7.63143 30.2223 8.13618V11.4444L40.3457 11.4443C40.7355 11.4442 41.1527 11.4441 41.5026 11.4762C41.8638 11.5094 42.4793 11.5969 43.0519 12.0086C43.7366 12.5009 44.1825 13.2587 44.2803 14.0963C44.3621 14.7968 44.1397 15.3773 43.9933 15.7092C43.8514 16.0306 43.6487 16.3953 43.4593 16.736L40.5966 21.8888L43.4593 27.0415C43.6487 27.3823 43.8514 27.747 43.9933 28.0684C44.1397 28.4002 44.3621 28.9808 44.2803 29.6813C44.1825 30.5189 43.7366 31.2767 43.0519 31.769C42.4793 32.1807 41.8638 32.2682 41.5026 32.3014C41.1528 32.3335 40.7356 32.3334 40.3458 32.3333L25.0252 32.3332C24.5204 32.3333 24.0288 32.3334 23.6125 32.2994C23.1553 32.262 22.6158 32.1739 22.073 31.8973C21.3203 31.5138 20.7084 30.9019 20.3249 30.1492C20.0483 29.6064 19.9602 29.0669 19.9228 28.6097C19.8888 28.1934 19.8889 27.7018 19.889 27.197L19.889 23.8889L11.7839 23.8889L16.4403 42.5149C16.7082 43.5864 16.0567 44.6723 14.9851 44.9402C13.9135 45.2081 12.8277 44.5566 12.5598 43.485L4.03586 9.38952C3.88188 8.77389 3.73613 8.19116 3.65801 7.6969C3.57454 7.16872 3.52567 6.51216 3.73994 5.81889C4.02907 4.88335 4.65134 4.08637 5.48881 3.57895C6.10941 3.20294 6.75821 3.0911 7.29088 3.04398C7.78932 2.99988 8.39001 2.99994 9.02461 3.00001Z"
                                    fill="white"
                                />
                            </svg>
                        </div>
                        wallets into your next reward
                    </span>

                    <div class="flex items-center" data-aos="fade-up" data-aos-delay="600">
                        <Link
                            href="/register"
                            class="flex py-3.5 px-6 rounded-full border border-white/50 bg-primary hover:bg-primary/85 transition-colors ease-in-out duration-300"
                        >
                            <span class="text-white text-lg leading-[100%] tracking-[-0.00em]">
                                Try the dashboard
                            </span>
                        </Link>
                        <a
                            :href="twitter"
                            class="px-3 py-3 transition-all duration-500 ease-in-out border border-white rounded-full hover:bg-white/5"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                            >
                                <path
                                    d="M21.096 20.8L14.06 10.5424L14.072 10.552L20.416 3.2H18.296L13.128 9.184L9.024 3.2H3.464L10.0328 12.7768L10.032 12.776L3.104 20.8H5.224L10.9696 14.1424L15.536 20.8H21.096ZM8.184 4.8L18.056 19.2H16.376L6.496 4.8H8.184Z"
                                    fill="white"
                                />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
