<script setup>
import AddressModal from '@components/AddressModal.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import AppLayout from '@layout/AppLayout.vue';
import { useAOSComposable } from '@composables/useAOS.js';
import { copyAddresses } from '@utils/copy.js';

useAOSComposable();

const page = usePage();
const props = defineProps({
    addresses: {
        type: Array,
        default: () => [],
    },
});

// Modal state
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

// Функция для обрезки адреса
const truncateAddress = (address, maxLength = 15) => {
    if (!address) return "";
    if (address.length <= maxLength) return address;
    return address.substring(0, maxLength) + "...";
};
</script>

<template>
    <AppLayout>
        <Head title="Earnings - Vornis" />
        <section
            class="mx-auto flex w-full max-w-[1728px] flex-col gap-6 px-6 py-12 lg:px-12"
        >
                <div
                    class="flex w-full flex-col gap-3 p-6 bg-[#0F0F10] border border-white/4 rounded-sm"
                    data-aos="fade-up"
                >
                    <span class="text-white text-2xl leading-[100%]">
                        Earnings
                    </span>
                    <div class="flex gap-3 w-full">
                        <div
                            class="flex w-full py-8 gap-3 flex-col items-center bg-[#758CED]/12 rounded-sm"
                        >
                            <div
                                class="flex py-3 px-4.5 rounded-full border border-white"
                            >
                                <span class="text-white text-lg leading-[100%]">
                                    {{ page.props.auth.user.balance }} $VOR
                                </span>
                            </div>
                            <div class="flex flex-col gap-1 items-center">
                                <span
                                    class="text-2xl leading-[100%] text-[#758CED]"
                                >
                                    You’ve earned with Vornis
                                </span>
                                <span
                                    class="text-lg leading-[100%] text-white/50 font-light"
                                >
                                    Rewards earned through Vornis
                                </span>
                            </div>
                        </div>
                    </div>

                    <button
                        class="flex py-4 px-6 w-full justify-center rounded-sm hover:opacity-75 transition-opacity ease-in-out duration-300 bg-primary shadow-[0_2px_6px_0_rgba(0,0,0,0.12),0_0_2px_0_#FF898B]"
                    >
                        <span class="text-white text-lg leading-[100%]">
                            Withdraw Now
                            <span class="text-white/30"
                                >(Pending integration with live $VOR
                                token)</span
                            >
                        </span>
                    </button>
                    <div
                        class="flex flex-col gap-3 p-6 rounded-sm border border-white/4"
                    >
                        <span class="text-white text-2xl leading-[100%]">
                            Your rewards
                        </span>

                        <div class="flex flex-col gap-3 items-center w-full">
                            <div
                                class="flex py-3 px-6 items-center justify-between w-full"
                            >
                                <div class="flex w-full max-w-[86px]">
                                    <span
                                        class="text-white/30 text-lg leading-[100%]"
                                    >
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
                                    <span
                                        class="text-white/30 text-lg leading-[100%]"
                                    >
                                        REMARK
                                    </span>
                                </div>
                                <div class="flex w-full max-w-[256px]">
                                    <span
                                        class="text-white/30 text-lg leading-[100%]"
                                    >
                                        CONFIRMATION DATE
                                    </span>
                                </div>
                                <div class="flex w-full max-w-[256px]">
                                    <span
                                        class="text-white/30 text-lg leading-[100%]"
                                    >
                                        REWARD
                                    </span>
                                </div>
                            </div>
                            <div
                                v-for="(address, index) in addresses"
                                :key="address.id"
                                @click="openModal(address)"
                                class="flex py-3 px-6 bg-white/2 border items-center w-full border-white/2 justify-between cursor-pointer hover:bg-white/5 transition-colors duration-200"
                            >
                                <div class="flex w-full max-w-[86px]">
                                    <span
                                        class="text-white text-lg leading-[100%]"
                                    >
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
                                        <span
                                            class="text-white text-lg leading-[100%]"
                                        >
                                            {{
                                                truncateAddress(address.address)
                                            }}
                                        </span>
                                    </div>
                                    <button
                                        @click="copyAddresses(address)"
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
                                    <span
                                        class="text-white text-lg leading-[100%]"
                                    >
                                        {{ address.remark }}
                                    </span>
                                </div>

                                <div class="flex w-full max-w-[256px]">
                                    <div class="flex gap-3 items-center">
                                        <span
                                            class="text-white text-lg leading-[100%]"
                                        >
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
                                    <span
                                        class="text-primary text-lg leading-[100%]"
                                    >
                                        +{{
                                            address.reward
                                                ? address.reward
                                                : "0"
                                        }}
                                        $VOR
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="flex gap-6 items-center w-full"
                    data-aos="fade-up"
                    data-aos-delay="100"
                >
                    <div
                        class="flex p-6 gap-3 flex-col w-full bg-[#0F0F10] border border-white/6"
                    >
                        <span class="text-white leading-[120%] text-2xl">
                            Earnings
                        </span>
                        <span
                            class="text-white/50 text-lg font-light leading-[115%]"
                        >
                            Rewards for each confirmed address are decided by
                            moderators
                        </span>
                        <span
                            class="text-white/50 text-lg font-light leading-[115%]"
                        >
                            Extra bonuses may apply for detecting wallet groups
                            or submitting early reports.
                        </span>
                        <span
                            class="text-white/50 text-lg font-light leading-[115%]"
                        >
                            False or spam reports are not rewarded (systematic
                            abuse may lead to account suspension).
                        </span>
                        <span
                            class="text-white/50 text-lg font-light leading-[115%]"
                        >
                            Monthly top reporters can receive multipliers and
                            community recognition.
                        </span>
                        <span
                            class="text-white/50 text-lg font-light leading-[115%]"
                        >
                            Rewards are funded by Pump.fun trading fee sharing
                            and our continuous buyback program.
                        </span>
                    </div>
                    <div
                        class="flex relative p-6 w-full max-w-[852px] overflow-hidden"
                    >
                        <div
                            class="flex flex-col gap-[12px] z-50 max-w-[365px]"
                        >
                            <span
                                class="text-white text-[58px] leading-[100%] uppercase font-medium"
                            >
                                You are the Web3 Police
                            </span>
                            <div class="flex items-center">
                                <div
                                    class="flex w-full max-w-[66px] min-h-[66px] bg-[#0031FF] shadow-[inset_0_4px_12px_0_white] rounded-full"
                                ></div>
                                <div
                                    class="flex w-full max-w-[66px] min-h-[66px] ml-[-33px] bg-[#FF0004] shadow-[inset_0_4px_12px_0_white] rounded-full"
                                ></div>
                                <div
                                    class="flex w-full max-w-[66px] min-h-[66px] ml-[-33px] bg-white shadow-[inset_0_4px_12px_0_white] rounded-full"
                                ></div>
                            </div>
                        </div>
                        <span
                            class="absolute z-50 uppercase top-[153px] left-[220px] text-white/30 text-2xl"
                        >
                            and we are proud of you!
                        </span>
                        <img
                            src="/assets/img/earnings.png"
                            class="max-w-[852px] absolute top-1/2 left-1/2 -translate-1/2"
                            alt=""
                        />
                    </div>
                </div>
            </section>

        <!-- Address Modal -->
        <AddressModal
            :isOpen="isModalOpen"
            :address="selectedAddress"
            :isTwoButton="false"
            @close="closeModal"
        />
    </AppLayout>
</template>
