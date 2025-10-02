<script setup>
import { useForm, usePage, Head } from "@inertiajs/vue3";
import Button from "../Components/Button.vue";
import InputBlock from "../Components/InputBlock.vue";
import { ref, onMounted, watch } from "vue";
import Header from "../Components/Header.vue";
import { downloadJsonFile } from "../utils/download.js";
import Layout from "../Layout/Layout.vue";
import { useAOSComposable } from "../composables/useAOS.js";

const props = defineProps({
    addresses: {
        type: Array,
        default: () => [],
    },
});

const { refreshAOS } = useAOSComposable();

const page = usePage();
const addressesList = ref([]);
onMounted(() => {
    addressesList.value = props.addresses;
});

watch(
    () => props.addresses,
    (newVal) => {
        addressesList.value = newVal;
    }
);

const form = useForm({
    address: "",
    token: "",
    comment: "",
});

// Функция для обрезки адреса
const truncateAddress = (address, maxLength = 15) => {
    if (!address) return "";
    if (address.length <= maxLength) return address;
    return address.substring(0, maxLength) + "...";
};
</script>

<template>
    <Layout>
        <Head title="Dashboard - Vornis" />
        <div class="flex flex-col w-full items-center justify-between bg-black">
            <Header :twitter="page.props.twitter" />
            <section
                class="flex flex-col mt-[58px] gap-8 w-full max-w-[1728px] items-center mb-[126px]"
            >
                <div
                    class="flex w-full flex-col gap-3 p-6 bg-[#0F0F10] border border-white/4 rounded-sm"
                    data-aos="fade-up"
                    data-aos-delay="100"
                >
                    <span class="text-white text-2xl leading-[100%]">
                        Statistic
                    </span>
                    <div class="flex gap-3 w-full lg:flex-row flex-col">
                        <div
                            class="flex w-full max-w-full lg:max-w-[411px] py-8 gap-1.5 flex-col items-center bg-[#1E79F9]/12 rounded-sm"
                        >
                            <div
                                class="flex py-3 px-4.5 rounded-full border border-white"
                            >
                                <span class="text-white text-lg leading-[100%]">
                                    {{
                                        addressesList.filter(
                                            (a) =>
                                                a.status == "scam" &&
                                                a.user_id ==
                                                    page.props.auth.user.id
                                        ).length
                                    }}
                                </span>
                            </div>
                            <div class="flex flex-col gap-1 items-center">
                                <span
                                    class="text-2xl leading-[100%] text-[#1E79F9]"
                                >
                                    My submissions
                                </span>
                                <span
                                    class="text-lg leading-[100%] text-white/50 font-light"
                                >
                                    Submitted wallets
                                </span>
                            </div>
                        </div>
                        <div
                            class="flex w-full max-w-full lg:max-w-[411px] py-8 gap-1.5 flex-col items-center bg-[#1EF993]/12 rounded-sm"
                        >
                            <div
                                class="flex py-3 px-4.5 rounded-full border border-white"
                            >
                                <span class="text-white text-lg leading-[100%]">
                                    {{
                                        addressesList.filter(
                                            (a) =>
                                                a.status == "scam" &&
                                                a.user_id ==
                                                    page.props.auth.user.id
                                        ).length
                                    }}
                                </span>
                            </div>
                            <div class="flex flex-col gap-1 items-center">
                                <span
                                    class="text-2xl leading-[100%] text-[#1EF993]"
                                >
                                    Confirmed
                                </span>
                                <span
                                    class="text-lg leading-[100%] text-white/50 font-light"
                                >
                                Confirmed Reports
                                </span>
                            </div>
                        </div>

                        <div
                            class="flex w-full max-w-full lg:max-w-[411px] py-8 gap-1.5 flex-col items-center bg-[#F9A51E]/12 rounded-sm"
                        >
                            <div
                                class="flex py-3 px-4.5 rounded-full border border-white"
                            >
                                <span class="text-white text-lg leading-[100%]">
                                    {{
                                        addressesList.filter(
                                            (a) =>
                                                a.status == "pending" &&
                                                a.user_id ==
                                                    page.props.auth.user.id
                                        ).length
                                    }}
                                </span>
                            </div>
                            <div class="flex flex-col gap-1 items-center">
                                <span
                                    class="text-2xl leading-[100%] text-[#F9A51E]"
                                >
                                    Pending review
                                </span>
                                <span
                                    class="text-lg leading-[100%] text-white/50 font-light"
                                >
                                    Number of addresses with “pending” status.
                                </span>
                            </div>
                        </div>

                        <div
                            class="flex w-full max-w-full lg:max-w-[411px] py-8 gap-1.5 flex-col items-center bg-[#758CED]/12 rounded-sm"
                        >
                            <div
                                class="flex py-3 px-4.5 rounded-full border border-white"
                            >
                                <span class="text-white text-lg leading-[100%]">
                                    {{ addressesList.filter(a => a.status == "scam").length }}
                                </span>
                            </div>
                            <div class="flex flex-col gap-1 items-center">
                                <span
                                    class="text-2xl leading-[100%] text-[#758CED]"
                                >
                                    Database total
                                </span>
                                <span
                                    class="text-lg leading-[100%] text-white/50 font-light"
                                >
                                    Number of addresses in the public list.
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <form
                    @submit.prevent="form.post('/address/create')"
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
                    <Button>
                        <span class="text-white text-lg leading-[100%]">
                            Submit
                        </span>
                    </Button>
                </form>

                <div
                    class="flex w-full flex-col gap-3 p-6 bg-[#0F0F10] border border-white/4 rounded-sm"
                    data-aos="fade-up"
                >
                    <span class="text-white text-2xl leading-[100%]">
                        Last Activity
                    </span>
                    <div
                        v-if="
                            addresses
                                .filter(
                                    (a) => a.user_id == page.props.auth.user.id
                                )
                                .reverse().length > 0
                        "
                        class="flex flex-col gap-3 w-full"
                    >
                        <div
                                v-for="(address, index) in addresses
                                    .filter(
                                        (a) => a.user_id == page.props.auth.user.id
                                    )
                                    .reverse() "
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
                            v-for="(address, index) in addresses.filter(
                                (a) => a.status == 'scam'
                            )"
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
                    <button
                        @click="downloadJsonFile(addresses)"
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
        </div>
    </Layout>
</template>
