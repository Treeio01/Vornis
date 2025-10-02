<script setup>
import Header from "../Components/Header.vue";
import { usePage } from "@inertiajs/vue3";
import { ref, onMounted, onUnmounted, watch, computed } from "vue";
import { useAOSComposable } from "../composables/useAOS.js";
import Layout from "../Layout/Layout.vue";
const { refreshAOS } = useAOSComposable();

const search = ref("");
const selectedStatus = ref("all");
const isDropdownOpen = ref(false);

const props = defineProps({
    addresses: {
        type: Array,
        default: () => [],
    },
});

const page = usePage();
const addressesList = ref([]);

const statusOptions = [
    { value: "all", label: "All Status" },
    { value: "scam", label: "Scam" },
    { value: "verified", label: "Verified" },
    { value: "pending", label: "Pending" },
];

watch(
    () => props.addresses,
    (newVal) => {
        addressesList.value = newVal;
    }
);

const toggleDropdown = () => {
    isDropdownOpen.value = !isDropdownOpen.value;
};

const selectStatus = (status) => {
    selectedStatus.value = status;
    isDropdownOpen.value = false;
};

// Close dropdown when clicking outside
const closeDropdown = (event) => {
    if (!event.target.closest(".relative")) {
        isDropdownOpen.value = false;
    }
};

// Функция для обрезки адреса
const truncateAddress = (address, maxLength = 15) => {
    if (!address) return "";
    if (address.length <= maxLength) return address;
    return address.substring(0, maxLength) + "...";
};

onMounted(() => {
    addressesList.value = props.addresses;
    document.addEventListener("click", closeDropdown);
});

// Clean up event listener
onUnmounted(() => {
    document.removeEventListener("click", closeDropdown);
});

const filteredAddresses = computed(() => {
    let filtered = addressesList.value.filter((a) =>
        a.address.toLowerCase().includes(search.value.toLowerCase())
    );

    if (selectedStatus.value !== "all") {
        filtered = filtered.filter((a) => a.status === selectedStatus.value);
    }

    return filtered;
});
</script>

<template>
    <Layout>
        <Head title="My Reports - Vornis" />
        <div class="flex flex-col w-full items-center justify-between bg-black">
            <Header :twitter="page.props.twitter" />
            <section
                class="flex flex-col mt-[58px] gap-8 w-full max-w-[1728px] items-center mb-[126px]"
            >
                <div
                    class="flex w-full flex-col gap-3 p-6 bg-[#0F0F10] border border-white/4 rounded-sm"
                    data-aos="fade-up"
                >
                    <span class="text-white text-2xl leading-[100%]">
                        My report list
                    </span>
                    <div class="flex gap-3 items-center">
                        <div
                            class="flex p-4 items-center w-full max-w-[512px] gap-2 bg-white/2 border border-white/6 rounded-lg"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                            >
                                <path
                                    fill-rule="evenodd"
                                    clip-rule="evenodd"
                                    d="M17.9697 17.9697C18.2626 17.6768 18.7374 17.6768 19.0303 17.9697L21.5303 20.4697C21.8232 20.7626 21.8232 21.2374 21.5303 21.5303C21.2374 21.8232 20.7626 21.8232 20.4697 21.5303L17.9697 19.0303C17.6768 18.7374 17.6768 18.2626 17.9697 17.9697Z"
                                    fill="white"
                                />
                                <path
                                    fill-rule="evenodd"
                                    clip-rule="evenodd"
                                    d="M11.0529 18.6058C15.2243 18.6058 18.6058 15.2243 18.6058 11.0529C18.6058 6.88155 15.2243 3.5 11.0529 3.5C6.88155 3.5 3.5 6.88155 3.5 11.0529C3.5 15.2243 6.88155 18.6058 11.0529 18.6058ZM11.0529 20.1058C16.0527 20.1058 20.1058 16.0527 20.1058 11.0529C20.1058 6.05312 16.0527 2 11.0529 2C6.05312 2 2 6.05312 2 11.0529C2 16.0527 6.05312 20.1058 11.0529 20.1058Z"
                                    fill="white"
                                />
                            </svg>
                            <input
                                type="text"
                                v-model="search"
                                class="text-white w-full !font-Roboto leading-[130%] outline-none"
                                placeholder="Enter wallet"
                            />
                        </div>
                        <div class="relative">
                            <div
                                @click="toggleDropdown"
                                class="flex w-full min-h-[56px] rounded-lg max-w-[156px] bg-white/2 justify-between items-center p-4 cursor-pointer hover:bg-white/4 transition-colors"
                            >
                                <span class="text-white leading-[130%]">
                                    {{
                                        statusOptions.find(
                                            (option) =>
                                                option.value === selectedStatus
                                        )?.label || "Status"
                                    }}
                                </span>
                                <svg
                                    :class="{ 'rotate-180': isDropdownOpen }"
                                    class="transition-transform duration-200"
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                >
                                    <g clip-path="url(#clip0_7_580)">
                                        <path
                                            fill-rule="evenodd"
                                            clip-rule="evenodd"
                                            d="M12.5311 14.7705C12.2378 15.0765 11.7622 15.0765 11.4689 14.7705L7.22 10.3377C6.92667 10.0317 6.92667 9.53554 7.22 9.22951C7.51332 8.9235 7.98889 8.9235 8.28222 9.22951L12 13.1082L15.7177 9.22951C16.0111 8.9235 16.4866 8.9235 16.78 9.22951C17.0733 9.53554 17.0733 10.0317 16.78 10.3377L12.5311 14.7705Z"
                                            fill="white"
                                        />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_7_580">
                                            <rect
                                                width="24"
                                                height="24"
                                                fill="white"
                                            />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </div>

                            <!-- Dropdown menu -->
                            <div
                                v-if="isDropdownOpen"
                                class="absolute top-full left-0 right-0 mt-1 bg-[#0F0F10] border border-white/6 rounded-lg shadow-lg z-50"
                            >
                                <div
                                    v-for="option in statusOptions"
                                    :key="option.value"
                                    @click="selectStatus(option.value)"
                                    :class="[
                                        'px-4 py-3 cursor-pointer hover:bg-white/4 transition-colors',
                                        selectedStatus === option.value
                                            ? 'bg-white/8'
                                            : '',
                                    ]"
                                >
                                    <span class="text-white leading-[130%]">
                                        {{ option.label }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                    REWARD
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

                            <div class="flex min-w-[24px] min-h-[32px]"></div>
                        </div>

                        <div
                            v-for="address in filteredAddresses"
                            class="flex w-full py-3 px-6 justify-between items-center bg-white/2 border border-white/2"
                        >
                            <div class="flex w-full max-w-[86px]">
                                <span class="text-white text-lg leading-[100%]">
                                    #{{ address.id }}
                                </span>
                            </div>
                            <div
                                :class="[
                                    address.status == 'verified'
                                        ? 'bg-[#13DE94]/12'
                                        : address.status == 'pending'
                                        ? 'bg-white/12'
                                        : 'bg-[#FF5053]/12',
                                    'flex w-full items-center gap-2 px-1 rounded-lg max-w-[312px] ',
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
                            <div class="flex min-w-[256px]">
                                <span
                                    class="text-primary text-lg leading-[100%]"
                                >
                                    +{{
                                        address.reward ? address.reward : "0"
                                    }}
                                    $VOR
                                </span>
                            </div>

                            <div class="flex min-w-[256px] items-center gap-3">
                                <span class="text-white text-lg leading-[100%]">
                                    {{ address.updated_date }}
                                </span>
                                <span
                                    class="text-white/30 text-lg leading-[100%]"
                                >
                                    {{ address.updated_time }}
                                </span>
                            </div>
                            <div class="flex min-w-[24px] min-h-[24px]"></div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </Layout>
</template>
