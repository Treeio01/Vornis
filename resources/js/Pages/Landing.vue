<script setup>
import { Head } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import AppLayout from '@layout/AppLayout.vue';
import LandingHeroSection from '@components/landing/LandingHeroSection.vue';
import LandingAboutSection from '@components/landing/LandingAboutSection.vue';
import LandingHowItWorksSection from '@components/landing/LandingHowItWorksSection.vue';
import LandingRewardsSection from '@components/landing/LandingRewardsSection.vue';
import LandingRoadmapSection from '@components/landing/LandingRoadmapSection.vue';
import LandingFaqSection from '@components/landing/LandingFaqSection.vue';
import LandingFooterSection from '@components/landing/LandingFooterSection.vue';

const props = defineProps({
    text: {
        type: String,
        default: '',
    },
    twitter: {
        type: String,
        default: null,
    },
});

const showLoader = ref(true);
const isMenuOpen = ref(false);

const faqQuestions = [
    {
        id: 1,
        question: 'What is Vornis?',
        answer:
            'Vornis is a community-driven platform where users flag suspicious wallets, and our system (AI + moderation) verifies them and adds them to the public list.',
    },
    {
        id: 2,
        question: 'How does the reward system work?',
        answer:
            'For every confirmed wallet, users receive rewards in our native token. Rewards are funded from Pump.fun fees, which we convert and redistribute.',
    },
    {
        id: 3,
        question: 'Do I need to connect my wallet to use Vornis?',
        answer:
            'Yes, you connect your Phantom wallet — but never your seed phrase. We only use it to link your account to your wallet address.',
    },
    {
        id: 4,
        question: 'How do you verify if a wallet is really a scammer?',
        answer:
            'First, AI analyzes behavior patterns. Then human moderators confirm or reject the report.',
    },
    {
        id: 5,
        question: 'Can I import the wallet list into a trading panel?',
        answer:
            'Yes. We support export in formats ready for direct import into Axiom.',
    },
    {
        id: 6,
        question: 'Why should I participate?',
        answer:
            'You earn rewards, build your reputation, and help traders avoid pump & dump traps. It benefits both you and the entire ecosystem.',
    },
    {
        id: 7,
        question: 'When will the full dashboard launch?',
        answer: 'The beta is live now. The full dashboard release is scheduled for December 2025.',
    },
    {
        id: 8,
        question: 'Why should I participate?',
        answer:
            'You earn rewards, build your reputation, and help traders avoid pump & dump traps. It benefits both you and the entire ecosystem.',
    },
];

onMounted(() => {
    setTimeout(() => {
        showLoader.value = false;
    }, 1500);
});

const openMenu = () => {
    isMenuOpen.value = true;
};

const closeMenu = () => {
    isMenuOpen.value = false;
};

const scrollToSection = (id) => {
    const el = document.querySelector(id);
    if (el) {
        el.scrollIntoView({ behavior: 'smooth', block: 'start' });
        closeMenu();
    }
};
</script>

<template>
    <AppLayout :show-header="false" :show-footer="false">
        <Head title="Vornis" />
        <div class="flex flex-col items-center w-full bg-black overflow-x-hidden">
            <LandingHeroSection
                :text="text"
                :twitter="twitter"
                :show-loader="showLoader"
                :is-menu-open="isMenuOpen"
                @open-menu="openMenu"
                @close-menu="closeMenu"
                @navigate="scrollToSection"
            />
            <LandingAboutSection />
            <LandingHowItWorksSection />
            <LandingRewardsSection />
            <LandingRoadmapSection />
            <LandingFaqSection :questions="faqQuestions" />
            <LandingFooterSection :twitter="twitter" />
        </div>
    </AppLayout>
</template>
