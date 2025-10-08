<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import AppLayout from '@layout/AppLayout.vue';
import StatCard from '@components/dashboard/StatCard.vue';
import Button from '@components/Button.vue';
import InputBlock from '@components/InputBlock.vue';
import { useAOSComposable } from '@composables/useAOS.js';
import { downloadJsonFile } from '@utils/download.js';
import { copyAddresses } from '@utils/copy.js';

const props = defineProps({
    addresses: {
        type: Object,
        default: () => ({
            data: [],
            links: [],
            meta: {},
        }),
    },
    recentUserAddresses: {
        type: Array,
        default: () => [],
    },
    stats: {
        type: Object,
        default: () => ({
            my_submissions: 0,
            my_verified: 0,
            my_pending: 0,
            total_scam: 0,
        }),
    },
});

useAOSComposable();

const page = usePage();

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

const form = useForm({
    address: '',
    token: '',
    comment: '',
});

const myScamCount = computed(() => props.stats?.my_submissions ?? 0);
const myVerifiedCount = computed(() => props.stats?.my_verified ?? 0);
const myPendingCount = computed(() => props.stats?.my_pending ?? 0);
const totalScamCount = computed(() => props.stats?.total_scam ?? 0);

const userRecentAddresses = computed(() => props.recentUserAddresses ?? []);
const scamAddresses = computed(() => {
    const items = addressesData.value;

    if (!Array.isArray(items)) {
        return [];
    }

    return items.filter((address) => address.status === 'scam');
});

const downloadScamAddresses = () => downloadJsonFile(scamAddresses.value ?? []);

const submissionMessage = computed(() => {
    if (form.recentlySuccessful) {
        return {
            type: 'success',
            text: 'Адрес отправлен на модерацию.',
        };
    }

    if (form.errors.general) {
        return {
            type: 'error',
            text: form.errors.general,
        };
    }

    return null;
});

const submitAddress = () => {
    form.clearErrors('general');

    form.post('/address/create', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset('address', 'token', 'comment');
        },
        onError: (errors) => {
            const hasFieldErrors = Object.keys(errors || {}).length > 0;

            if (!hasFieldErrors) {
                form.setError(
                    'general',
                    'Слишком много запросов. Подождите немного и попробуйте снова.'
                );
            }
        },
    }).catch((error) => {
        if (error?.response?.status === 429) {
            form.setError(
                'general',
                'Слишком много запросов. Подождите немного и попробуйте снова.'
            );

            return;
        }

        throw error;
    });
};

const truncateAddress = (address, maxLength = 15) => {
    if (!address) {
        return '';
    }

    return address.length <= maxLength ? address : `${address.substring(0, maxLength)}...`;
};
</script>

<template>
    <AppLayout>
        <Head title="Dashboard - Vornis" />

        <section class="mx-auto flex w-full max-w-[1728px] flex-col gap-8 px-6 py-12 lg:px-12">
            <div
                class="flex w-full flex-col gap-4 rounded-xl border border-white/5 bg-[#0F0F10] p-6"
                data-aos="fade-up"
                data-aos-delay="100"
            >
                <h2 class="text-2xl font-semibold text-white">Statistic</h2>
                <div class="grid gap-3 md:grid-cols-2 xl:grid-cols-4">
                    <StatCard
                        :value="myScamCount"
                        title="My submissions"
                        subtitle="Submitted wallets"
                        variant="primary"
                    />
                    <StatCard
                        :value="myVerifiedCount"
                        title="Confirmed"
                        subtitle="Confirmed reports"
                        variant="success"
                    />
                    <StatCard
                        :value="myPendingCount"
                        title="Pending review"
                        subtitle="Awaiting moderation"
                        variant="warning"
                    />
                    <StatCard
                        :value="totalScamCount"
                        title="Database total"
                        subtitle="Addresses in the public list"
                        variant="neutral"
                    />
                </div>
            </div>
                <form
                    @submit.prevent="submitAddress"
                    class="flex w-full flex-col gap-3 p-6 bg-[#0F0F10] border border-white/4 rounded-sm"
                    data-aos="fade-up"
                >
                    <span class="text-white text-2xl leading-[100%]">
                        Reporting
                    </span>
                    <InputBlock
                        type="text"
                        id="address"
                        placeholder="Insert suspicious Solana address"
                        label="Wallet address"
                        v-model="form.address"
                        :error="form.errors.address"
                    />
                    <InputBlock
                        type="text"
                        id="token"
                        placeholder="Paste token CA"
                        :error="form.errors.token"
                        v-model="form.token"
                        label="Attach token contract address (CA) linked to this wallet."
                    />
                    <InputBlock
                        type="text"
                        id="comment"
                        placeholder="Add short reason or note"
                        v-model="form.comment"
                        :error="form.errors.comment"
                        label="Comment (Up to 200 symbols)"
                    />
                    <Button :disabled="form.processing">
                        <span class="text-white text-lg leading-[100%]">
                            {{ form.processing ? 'Submitting...' : 'Submit' }}
                        </span>
                    </Button>
                    <div
                        v-if="submissionMessage"
                        :class="[
                            'rounded-sm border px-4 py-3 text-sm',
                            submissionMessage.type === 'error'
                                ? 'border-red-500/60 bg-red-500/10 text-red-300'
                                : 'border-emerald-500/60 bg-emerald-500/10 text-emerald-300',
                        ]"
                        role="alert"
                    >
                        {{ submissionMessage.text }}
                    </div>
                </form>

                <div
                    class="flex w-full flex-col gap-3 p-6 bg-[#0F0F10] border border-white/4 rounded-sm"
                    data-aos="fade-up"
                >
                    <span class="text-white text-2xl leading-[100%]">
                        Last Activity
                    </span>
                    <div v-if="userRecentAddresses.length > 0" class="flex flex-col gap-3 w-full">
                        <div
                            v-for="(address, index) in userRecentAddresses"
                            :key="address.id"
                            class="flex w-full py-3 px-6 gap-8 items-center bg-white/2 border border-white/2"
                        >
                            <div class="flex min-w-[86px]">
                                <span class="text-white text-lg leading-[100%]">
                                    #{{ index + 1 }}
                                </span>
                            </div>
                            <div
                                :class="[
                                    address.status == 'verified'
                                        ? 'bg-[#13DE94]/12'
                                        : address.status == 'pending'
                                        ? 'bg-white/12'
                                        : 'bg-[#FF5053]/12',
                                    'flex w-full items-center gap-2 px-1 rounded-lg max-w-[704px] ',
                                ]"
                            >
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
                                        :fill="[
                                            address.status == 'verified'
                                                ? '#13DE94'
                                                : address.status == 'pending'
                                                ? 'white'
                                                : '#FF5053',
                                        ]"
                                    />
                                    <path
                                        fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M16.0002 1.33325C7.89999 1.33325 1.3335 7.89974 1.3335 15.9999C1.3335 24.1001 7.89999 30.6666 16.0002 30.6666C24.1003 30.6666 30.6668 24.1001 30.6668 15.9999C30.6668 7.89974 24.1003 1.33325 16.0002 1.33325ZM4.00016 15.9999C4.00016 9.3725 9.37274 3.99992 16.0002 3.99992C22.6276 3.99992 28.0002 9.3725 28.0002 15.9999C28.0002 18.9614 26.9274 21.6723 25.1492 23.7652C23.9277 22.2817 22.0754 21.3333 20.0002 21.3333H12.0002C9.92506 21.3333 8.07269 22.2818 6.85116 23.7653C5.07297 21.6724 4.00016 18.9614 4.00016 15.9999Z"
                                        :fill="[
                                            address.status == 'verified'
                                                ? '#13DE94'
                                                : address.status == 'pending'
                                                ? 'white'
                                                : '#FF5053',
                                        ]"
                                    />
                                </svg>
                                <span
                                    :class="[
                                        address.status == 'verified'
                                            ? 'text-[#13DE94]'
                                            : address.status == 'pending'
                                            ? 'text-white'
                                            : 'text-[#FF5053]',
                                        'w-full text-lg leading-[100%]',
                                    ]"
                                >
                                    {{ truncateAddress(address.address) }}
                                </span>
                            </div>
                            <div class="flex min-w-[256px]">
                                <span
                                    :class="[
                                        address.status == 'verified'
                                            ? 'text-[#13DE94]'
                                            : address.status == 'pending'
                                            ? 'text-white'
                                            : 'text-[#FF5053]',
                                        'text-lg leading-[100%]',
                                    ]"
                                >
                                    {{
                                        address.status == "verified"
                                            ? "Verified Safe"
                                            : address.status == "pending"
                                            ? "Under Review..."
                                            : "Flagged as Scam"
                                    }}
                                </span>
                            </div>
                            <div class="flex min-w-[256px]">
                                <span class="text-white text-lg leading-[100%]">
                                    {{
                                        address.status == "pending"
                                            ? "PENDING"
                                            : address.status == "verified"
                                            ? "SAFE"
                                            : "PAID"
                                    }}
                                </span>
                            </div>
                            <div class="flex min-w-[194px]">
                                <span
                                    class="text-primary text-lg leading-[100%]"
                                >
                                    +{{ address.reward ? address.reward : "0" }}
                                    $VOR
                                </span>
                            </div>
                        </div>
                    </div>
                    <div v-else class="flex flex-col gap-3 w-full">
                        <span
                            class="text-white/60 text-center w-full text-lg leading-[100%]"
                        >
                            No activity found
                        </span>
                    </div>
                </div>

                <div
                    class="flex w-full flex-col gap-3 p-6 bg-[#0F0F10] border border-white/4 rounded-sm"
                >
                    <span class="text-white text-2xl leading-[100%]">
                        Community Updates
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
                                    STATUS
                                </span>
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
                                    REWARD
                                </span>
                            </div>
                            <div class="flex w-full max-w-[256px]">
                                <span
                                    class="text-white/30 text-lg leading-[100%]"
                                >
                                    DATE
                                </span>
                            </div>
                        </div>
                        <div
                            v-for="(address, index) in scamAddresses"
                            :key="address.id"
                            class="flex py-3 px-6 bg-white/2 border items-center w-full border-white/2 justify-between"
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
                                    <span
                                        class="text-white text-lg leading-[100%]"
                                    >
                                        {{ truncateAddress(address.address) }}
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
                                    class="text-[#FF5053] text-lg leading-[100%]"
                                >
                                    FLAGGED
                                </span>
                            </div>
                            <div class="flex w-full max-w-[256px]">
                                <span class="text-white text-lg leading-[100%]">
                                    {{ address.remark }}
                                </span>
                            </div>
                            <div class="flex w-full max-w-[256px]">
                                <span
                                    class="text-primary text-lg leading-[100%]"
                                >
                                    +{{ address.reward ? address.reward : "0" }}
                                    $VOR
                                </span>
                            </div>
                            <div class="flex w-full max-w-[256px]">
                                <span class="text-white text-lg leading-[100%]">
                                    {{ address.updated_at }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <nav
                        v-if="paginationLinks.length"
                        class="flex flex-wrap justify-end gap-2 pt-2"
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
                    <button
                        @click="downloadScamAddresses"
                        class="py-4 px-6 w-max hover:bg-white/5 transition-colors ease-in-out duration-300 rounded-sm border border-white"
                    >
                        <span
                            class="text-white text-lg leading-[100%] !font-Inter"
                        >
                            Download list
                        </span>
                    </button>
                </div>
        </section>
    </AppLayout>
</template>
