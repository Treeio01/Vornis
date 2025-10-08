<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import AppLayout from '@layout/AppLayout.vue';
import AddressModal from '@components/AddressModal.vue';
import { useAOSComposable } from '@composables/useAOS.js';
import { downloadJsonFile } from '@utils/download.js';
import { copyAddresses } from '@utils/copy.js';

useAOSComposable();

const props = defineProps({
    addresses: {
        type: Object,
        default: () => ({
            data: [],
            links: [],
            meta: {},
        }),
    },
});

const addressesData = computed(() => {
    const source = props.addresses ?? [];

    if (Array.isArray(source)) {
        return [...source];
    }

    if (Array.isArray(source?.data)) {
        return [...source.data];
    }

    if (Array.isArray(source?.value)) {
        return [...source.value];
    }

    return [];
});

const paginationLinks = computed(() => {
    const source = props.addresses;

    if (Array.isArray(source?.links)) {
        return source.links;
    }

    return [];
});

const isModalOpen = ref(false);
const selectedAddress = ref(null);

const openModal = (address) => {
    selectedAddress.value = address;
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    selectedAddress.value = null;
};

const handleDownload = () => {
    downloadJsonFile(addressesData.value);
};

const truncateAddress = (address, maxLength = 15) => {
    if (!address) return '';
    if (address.length <= maxLength) return address;
    return `${address.substring(0, maxLength)}...`;
};
</script>

<template>
    <AppLayout>
        <Head title="Public List - Vornis" />

        <section
            class="mx-auto flex w-full max-w-[1728px] flex-col gap-8 px-6 py-12 lg:px-12"
        >
            <div
                class="flex w-full flex-col gap-3 p-6 bg-[#0F0F10] border border-white/4 rounded-sm"
                data-aos="fade-up"
            >
                <span class="text-white text-2xl leading-[100%]">
                    Community Updates
                </span>
                <div class="flex w-full items-center gap-3">
                    <button
                        @click="copyAddresses(addressesData)"
                        class="py-4 flex px-6 w-full justify-center gap-2 items-center hover:bg-white/5 transition-colors ease-in-out duration-300 rounded-sm border border-white"
                    >
                        <span
                            class="text-white text-lg leading-[100%] !font-Inter"
                        >
                            Copy to AXIOM
                        </span>
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="23"
                            height="18"
                            viewBox="0 0 23 18"
                            fill="none"
                        >
                            <mask
                                id="mask0_7_815"
                                style="mask-type: luminance"
                                maskUnits="userSpaceOnUse"
                                x="0"
                                y="0"
                                width="23"
                                height="18"
                            >
                                <path
                                    d="M22.136 0H0.863281V18H22.136V0Z"
                                    fill="white"
                                />
                            </mask>
                            <g mask="url(#mask0_7_815)">
                                <path
                                    d="M16.5216 8.49885H6.47754L11.4994 0L16.5216 8.49885Z"
                                    fill="white"
                                />
                                <path
                                    d="M22.136 18.0002H0.863281L4.92772 11.1217H18.0716L22.136 18.0002Z"
                                    fill="white"
                                />
                            </g>
                        </svg>
                    </button>
                    <button
                        @click="handleDownload"
                        class="py-4 flex px-6 w-full justify-center gap-2 items-center hover:bg-white/5 transition-colors ease-in-out duration-300 rounded-sm border border-white"
                    >
                        <span
                            class="text-white text-lg leading-[100%] !font-Inter"
                        >
                            Download full list
                        </span>
                    </button>
                </div>
                <div class="flex flex-col gap-3 items-center w-full">
                    <div
                        class="flex py-3 px-6 items-center justify-between w-full"
                    >
                        <div class="flex w-full max-w-[86px]">
                            <span class="text-white/30 text-lg leading-[100%]">
                                NUMBER
                            </span>
                        </div>
                        <div class="flex w-full max-w-[312px]">
                            <div class="flex gap-2.5 items-center">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="32"
                                    height="32"
                                    viewBox="0 0 32 32"
                                    fill="none"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M9.3335 12.6666C9.3335 8.98469 12.3183 5.99992 16.0002 5.99992C19.6821 5.99992 22.6668 8.98469 22.6668 12.6666C22.6668 16.3485 19.6821 19.3333 16.0002 19.3333C12.3183 19.3333 9.3335 16.3485 9.3335 12.6666Z"
                                        fill="white"
                                        fill-opacity="0.3"
                                    />
                                    <path
                                        fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M16.0002 1.33325C7.89999 1.33325 1.3335 7.89974 1.3335 15.9999C1.3335 24.1001 7.89999 30.6666 16.0002 30.6666C24.1003 30.6666 30.6668 24.1001 30.6668 15.9999C30.6668 7.89974 24.1003 1.33325 16.0002 1.33325ZM4.00016 15.9999C4.00016 9.3725 9.37274 3.99992 16.0002 3.99992C22.6276 3.99992 28.0002 9.3725 28.0002 15.9999C28.0002 18.9614 26.9274 21.6723 25.1492 23.7652C23.9277 22.2817 22.0754 21.3333 20.0002 21.3333H12.0002C9.92506 21.3333 8.07269 22.2818 6.85116 23.7653C5.07297 21.6724 4.00016 18.9614 4.00016 15.9999Z"
                                        fill="white"
                                        fill-opacity="0.3"
                                    />
                                </svg>
                                <span
                                    class="text-white/30 text-lg leading-[100%]"
                                >
                                    WALLET ADDRESS
                                </span>
                            </div>
                        </div>
                        <div class="flex w-full max-w-[256px]">
                            <span class="text-white/30 text-lg leading-[100%]">
                                REMARK
                            </span>
                        </div>
                        <div class="flex w-full max-w-[256px]">
                            <span class="text-white/30 text-lg leading-[100%]">
                                CONFIRMATION DATE
                            </span>
                        </div>
                        <div class="flex w-full max-w-[256px]">
                            <span class="text-white/30 text-lg leading-[100%]">
                                VALIDATED BY
                            </span>
                        </div>
                    </div>
                    <div
                        v-for="(address, index) in addressesData"
                        :key="address.id"
                        @click="openModal(address)"
                        class="flex py-3 px-6 bg-white/2 border items-center w-full border-white/2 justify-between cursor-pointer hover:bg-white/5 transition-colors duration-200"
                    >
                        <div class="flex w-full max-w-[86px]">
                            <span class="text-white text-lg leading-[100%]">
                                #{{ index + 1 }}
                            </span>
                        </div>
                        <div
                            class="flex w-full max-w-[312px] justify-between items-center"
                        >
                            <div class="flex gap-2.5 items-center">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="32"
                                    height="32"
                                    viewBox="0 0 32 32"
                                    fill="none"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M9.3335 12.6666C9.3335 8.98469 12.3183 5.99992 16.0002 5.99992C19.6821 5.99992 22.6668 8.98469 22.6668 12.6666C22.6668 16.3485 19.6821 19.3333 16.0002 19.3333C12.3183 19.3333 9.3335 16.3485 9.3335 12.6666Z"
                                        fill="white"
                                    />
                                    <path
                                        fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M16.0002 1.33325C7.89999 1.33325 1.3335 7.89974 1.3335 15.9999C1.3335 24.1001 7.89999 30.6666 16.0002 30.6666C24.1003 30.6666 30.6668 24.1001 30.6668 15.9999C30.6668 7.89974 24.1003 1.33325 16.0002 1.33325ZM4.00016 15.9999C4.00016 9.3725 9.37274 3.99992 16.0002 3.99992C22.6276 3.99992 28.0002 9.3725 28.0002 15.9999C28.0002 18.9614 26.9274 21.6723 25.1492 23.7652C23.9277 22.2817 22.0754 21.3333 20.0002 21.3333H12.0002C9.92506 21.3333 8.07269 22.2818 6.85116 23.7653C5.07297 21.6724 4.00016 18.9614 4.00016 15.9999Z"
                                        fill="white"
                                    />
                                </svg>
                                <span class="text-white text-lg leading-[100%]">
                                    {{ truncateAddress(address.address) }}
                                </span>
                            </div>
                            <button
                                @click.stop="copyAddresses(address)"
                                class="hover:opacity-75 transition-opacity ease-in-out duration-300"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                >
                                    <path
                                        d="M16 12.9V17.1C16 20.6 14.6 22 11.1 22H6.9C3.4 22 2 20.6 2 17.1V12.9C2 9.4 3.4 8 6.9 8H11.1C14.6 8 16 9.4 16 12.9Z"
                                        fill="white"
                                    />
                                    <path
                                        d="M17.0996 2H12.8996C9.81646 2 8.37052 3.09409 8.06929 5.73901C8.00627 6.29235 8.46454 6.75 9.02145 6.75H11.0996C15.2996 6.75 17.2496 8.7 17.2496 12.9V14.9781C17.2496 15.535 17.7072 15.9933 18.2606 15.9303C20.9055 15.629 21.9996 14.1831 21.9996 11.1V6.9C21.9996 3.4 20.5996 2 17.0996 2Z"
                                        fill="white"
                                    />
                                </svg>
                            </button>
                        </div>
                        <div class="flex w-full max-w-[256px]">
                            <span class="text-white text-lg leading-[100%]">
                                {{ address.remark }}
                            </span>
                        </div>

                        <div class="flex w-full max-w-[256px]">
                            <div class="flex gap-3 items-center">
                                <span class="text-white text-lg leading-[100%]">
                                    {{ address.updated_date }}
                                </span>
                                <span
                                    class="text-white/30 text-lg leading-[100%]"
                                >
                                    {{ address.updated_time }}
                                </span>
                            </div>
                        </div>
                        <div class="flex w-full max-w-[256px]">
                            <span class="text-primary text-lg leading-[100%]">
                                Moderator
                            </span>
                        </div>
                    </div>
                    <nav
                        v-if="paginationLinks.length"
                        class="flex flex-wrap justify-end gap-2 pt-2 w-full"
                    >
                        <Link
                            v-for="link in paginationLinks"
                            :key="link.label"
                            :href="link.url || '#'"
                            class="px-3 py-2 text-sm rounded border transition-colors duration-150"
                            :class="[
                                link.active
                                    ? 'bg-primary border-primary text-white'
                                    : 'border-white/20 text-white/70 hover:bg-white/10',
                                !link.url ? 'pointer-events-none opacity-40' : '',
                            ]"
                            v-html="link.label"
                            preserve-scroll
                            preserve-state
                        />
                    </nav>
                </div>
            </div>
        </section>
        
        <!-- Address Modal -->
        <AddressModal
            :isOpen="isModalOpen"
            :address="selectedAddress"
            :isTwoButton="true"
            @close="closeModal"
        />
    </AppLayout>
</template>
