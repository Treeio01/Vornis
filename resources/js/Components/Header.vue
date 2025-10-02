<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    twitter: {
        type: String,
    },
});

const openTwitter = () => {
    if (props.twitter) {
        window.open(props.twitter, '_blank');
    }
};

</script>

<template>
    <header
        class="flex items-center justify-between z-50 py-4 px-12 bg-[#101010] w-full"
    >
        <div class="flex gap-3 items-center">
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
            <span
                class="text-white font-SF text-lg leading-[100%] tracking-[-0.00em]"
            >
                Vornis
            </span>
        </div>
        <ul class="flex items-center">
            <li>
                <Link
                    href="/dashboard"
                    :class="[
                        'py-2 px-4.5 text-white/20 transition-colors ease-in-out duration-500 rounded-sm',
                        {
                            '!text-primary bg-primary/12':
                                $page.url === '/dashboard',
                        },
                    ]"
                    >Dashboard</Link
                >
            </li>
            <li>
                <Link
                    href="/publicList"
                    :class="[
                        'py-2 px-4.5 text-white/20 transition-colors ease-in-out duration-500 rounded-sm',
                        {
                            '!text-primary bg-primary/12':
                                $page.url === '/publicList',
                        },
                    ]"
                    >Public list</Link
                >
            </li>
            <li>
                <Link
                    href="/myReports"
                    :class="[
                        'py-2 px-4.5 text-white/20 transition-colors ease-in-out duration-500 rounded-sm',
                        {
                            '!text-primary bg-primary/12':
                                $page.url === '/myReports',
                        },
                    ]"
                    >My reports</Link
                >
            </li>
            <li>
                <Link
                    href="/earnings"
                    :class="[
                        'py-2 px-4.5 text-white/20 transition-colors ease-in-out duration-500 rounded-sm',
                        {
                            '!text-primary bg-primary/12':
                                $page.url === '/earnings',
                        },
                    ]"
                    >Earnings</Link
                >
            </li>
        </ul>
        <div class="flex items-center">
            <button
                class="flex opacity-0 py-3.5 px-[45px] rounded-full hover:bg-white/5 transition-all ease-in-out duration-500 border border-white"
              
            >
                <span
                    class="text-white text-lg leading-[100%] tracking-[-0.00em]"
                >
                    Sign Up
                </span>
            </button>
            <button
                class="py-3 px-3 rounded-full border border-white hover:bg-white/5 transition-all ease-in-out duration-500"
                @click="openTwitter"
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
            </button>
        </div>
    </header>
</template>
