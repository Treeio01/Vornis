<script setup>
import { copySingleAddress } from '@/utils/copy';
import { ref, watch } from 'vue';

const props = defineProps({
    isOpen: {
        type: Boolean,
        default: false
    },
    address: {
        type: Object,
        default: () => ({})
    },
    isTwoButton: {
        type: Boolean,
        default: true
    }
});

const emit = defineEmits(['close']);

const closeModal = () => {
    emit('close');
};

const copyAndClose = (address) => {
    copySingleAddress(address);
    closeModal();
};
</script>

<template>
    <!-- Backdrop -->
    <transition
        enter-active-class="transition-opacity duration-200 ease-out"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition-opacity duration-150 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div
            v-if="isOpen"
            class="fixed inset-0 z-[80] bg-black/80 backdrop-blur-[5px]"
            @click="closeModal"
        ></div>
    </transition>

    <!-- Modal -->
    <transition
        enter-active-class="transition-all duration-300 ease-out"
        enter-from-class="opacity-0 scale-95"
        enter-to-class="opacity-100 scale-100"
        leave-active-class="transition-all duration-200 ease-in"
        leave-from-class="opacity-100 scale-100"
        leave-to-class="opacity-0 scale-95"
    >
        <div
            v-if="isOpen"
            class="fixed top-1/2 left-1/2 flex -translate-x-1/2 -translate-y-1/2 z-[99] bg-[#0F0F10] border border-white/4 w-full max-w-[912px] rounded-sm flex-col gap-6 p-6 items-center"
        >
            <div class="flex w-full justify-between items-center">
                <div class="flex gap-3 items-center">
                    <svg
                        width="32"
                        height="32"
                        viewBox="0 0 32 32"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M9.33301 12.6667C9.33301 8.98478 12.3178 6.00001 15.9997 6.00001C19.6816 6.00001 22.6663 8.98478 22.6663 12.6667C22.6663 16.3486 19.6816 19.3333 15.9997 19.3333C12.3178 19.3333 9.33301 16.3486 9.33301 12.6667Z"
                            fill="#FF5053"
                        />
                        <path
                            fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M15.9997 1.33334C7.8995 1.33334 1.33301 7.89983 1.33301 16C1.33301 24.1002 7.8995 30.6667 15.9997 30.6667C24.0998 30.6667 30.6663 24.1002 30.6663 16C30.6663 7.89983 24.0998 1.33334 15.9997 1.33334ZM3.99967 16C3.99967 9.37259 9.37226 4.00001 15.9997 4.00001C22.6271 4.00001 27.9997 9.37259 27.9997 16C27.9997 18.9615 26.9269 21.6724 25.1487 23.7653C23.9272 22.2818 22.0749 21.3333 19.9997 21.3333H11.9997C9.92457 21.3333 8.0722 22.2819 6.85067 23.7654C5.07248 21.6725 3.99967 18.9615 3.99967 16Z"
                            fill="#FF5053"
                        />
                    </svg>
                    <span class="text-2xl text-[#FF5053] leading-[100%]">
                        {{ address.address || 'ASBVbYRtyCY6BgZZM6tsNpLcZ6zMxfNiXDJecst3w6j' }}
                    </span>
                    <button
                        class="hover:opacity-55 transition-opacity ease-in-out duration-500"
                        @click="copySingleAddress(address)"
                    >
                        <svg
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
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
                <span class="text-white text-lg"> 
                    {{ address.status === 'verified' ? 'VERIFIED' : address.status === 'pending' ? 'PENDING' : 'FLAGGED' }}
                </span>
            </div>
            
            <div class="flex w-full justify-between items-center">
                <span class="text-white/30 text-lg leading-[100%] font-light">
                    Confirmation Date
                </span>
                <div class="flex items-center gap-3">
                    <span class="text-white/50 text-lg leading-[130%] font-light">
                        {{ address.updated_date}}
                    </span>
                    <span class="text-white/30 text-lg leading-[130%] font-light">
                        {{ address.updated_time  }}
                    </span>
                </div>
            </div>
            <div class="flex w-full h-[1px] bg-white/12"></div>

            <div class="flex w-full justify-between items-center">
                <span class="text-white/30 text-lg leading-[100%] font-light">
                    Report Date
                </span>
                <div class="flex items-center gap-3">
                    <span class="text-white/50 text-lg leading-[130%] font-light">
                        {{ address.created_date }}
                    </span>
                    <span class="text-white/30 text-lg leading-[130%] font-light">
                        {{ address.created_time}}
                    </span>
                </div>
            </div>
            <div class="flex w-full h-[1px] bg-white/12"></div>

            <div class="flex w-full justify-between items-center">
                <span class="text-white/30 text-lg leading-[100%] font-light">
                    Token:
                </span>
                <span class="text-white text-lg leading-[100%]">
                    {{ address.token || '9BB6NFEcjBCtnNLFko2FqVQBq8HHM13kCyYcdQbgpump' }}
                </span>
            </div>
            <div class="flex w-full h-[1px] bg-white/12"></div>
            
            <div class="flex flex-col gap-3 w-full">
                <span class="text-white/30 text-lg leading-[100%]">
                    Comment
                </span>
                <span class="text-white text-lg font-light leading-[150%]">
                    {{ address.comment || address.remark || 'This wallet has been flagged as suspicious by multiple users. Likely involved in pump-and-dump or scam activity. Exercise caution.' }}
                </span>
            </div>
            
            <div class="flex gap-3 w-full items-center">
                <button
                    @click="closeModal()"
                    class="flex py-4 px-6 w-full rounded-sm transition-colors ease-in-out duration-300 hover:bg-primary/5 border-white/24 border shadow-[0_2px_6px_0_rgba(0,0,0,0.12),0_0_2px_0_#FF898B]"
                >
                    <span class="text-white text-lg leading-[100%]">
                        Close
                    </span>
                </button>

                <button
                    v-show="isTwoButton"
                    @click="copyAndClose(address)"
                    class="flex py-4 px-6 w-full rounded-sm hover:opacity-75 transition-opacity ease-in-out duration-300 bg-primary shadow-[0_2px_6px_0_rgba(0,0,0,0.12),0_0_2px_0_#FF898B]"
                >
                    <span class="text-white text-lg leading-[100%]">
                        Appeal
                    </span>
                </button>
            </div>
        </div>
    </transition>
</template>
