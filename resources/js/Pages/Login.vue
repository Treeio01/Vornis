<script setup>
import { Head, Link, usePage, useForm } from "@inertiajs/vue3";
import InputBlock from "../Components/InputBlock.vue";
import Button from "../Components/Button.vue";
import Layout from "../Layout/Layout.vue";

const form = useForm({
    email: "",
    password: "",
});

const { props } = usePage();
const errors = props.errors || {};
</script>

<template>
    <Layout>
        <Head title="Login - Vornis" />
        <div
            class="flex flex-col w-full items-center justify-between bg-black min-h-screen pt-[25px] pb-[38px]"
        >
            <Link
                href="/"
                class="flex hover:bg-primary/5 transition-colors ease-in-out duration-300 cursor-pointer py-4 px-6 rounded-2xl gap-2 items-center border border-primary"
            >
                <svg
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M10.7071 6.70711C11.0976 6.31658 11.0976 5.68342 10.7071 5.29289C10.3166 4.90237 9.68342 4.90237 9.29289 5.29289L3.29289 11.2929C2.90237 11.6834 2.90237 12.3166 3.29289 12.7071L9.29289 18.7071C9.68342 19.0976 10.3166 19.0976 10.7071 18.7071C11.0976 18.3166 11.0976 17.6834 10.7071 17.2929L6.41421 13L20 13C20.5523 13 21 12.5523 21 12C21 11.4477 20.5523 11 20 11L6.41421 11L10.7071 6.70711Z"
                        fill="#758CED"
                    />
                </svg>
                <span
                    class="text-primary text-lg leading-[100%] tracking-[-0.04em] !font-Inter"
                >
                    Back to landing page
                </span>
            </Link>
            <form
                @submit.prevent="form.post('/login')"
                class="flex p-8 bg-[#0F0F10] rounded-[6px] flex-col gap-4.5 border border-white/4 w-full max-w-[576px]"
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
                <div class="flex w-full h-[1px] bg-white/8"></div>
                <InputBlock
                    id="email"
                    label="Email"
                    placeholder="Email"
                    type="email"
                    v-model="form.email"
                    :error="form.errors.email"
                />
                <InputBlock
                    id="password"
                    label="Password"
                    placeholder="Password"
                    type="password"
                    v-model="form.password"
                    :error="form.errors.password"
                />
                <div class="flex w-full h-[1px] bg-white/8"></div>
                <Button>
                    <div class="flex gap-2 items-center">
                        <svg
                            width="25"
                            height="24"
                            viewBox="0 0 25 24"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M17.0307 2.03699C17.2663 1.99967 17.5284 1.99983 17.8329 2.00003L17.9825 2.00004C18.4595 1.99988 18.813 1.99977 19.1257 2.0493C20.8373 2.32039 22.1797 3.66275 22.4507 5.37432C22.5003 5.68707 22.5002 6.04056 22.5 6.51754L22.5 17.4826C22.5002 17.9596 22.5003 18.313 22.4507 18.6258C22.1797 20.3374 20.8373 21.6797 19.1257 21.9508C18.813 22.0003 18.4594 22.0002 17.9825 22.0001L17.8329 22.0001C17.5284 22.0003 17.2663 22.0004 17.0307 21.9631C15.747 21.7598 14.7402 20.753 14.5369 19.4694C14.4996 19.2337 14.4998 18.9717 14.5 18.6672V17.9055C14.5 17.6609 14.5 17.5386 14.5276 17.4235C14.5521 17.3215 14.5925 17.2239 14.6473 17.1345C14.7092 17.0335 14.7956 16.9471 14.9686 16.7741L17.6213 14.1214C18.7929 12.9498 18.7929 11.0503 17.6213 9.87874L14.9686 7.22602C14.7956 7.05306 14.7092 6.96659 14.6473 6.86567C14.5925 6.7762 14.5521 6.67866 14.5276 6.57662C14.5 6.46153 14.5 6.33924 14.5 6.09465V5.33295C14.4998 5.02842 14.4996 4.76641 14.5369 4.53075C14.7402 3.24708 15.747 2.24031 17.0307 2.03699Z"
                                fill="white"
                            />
                            <path
                                d="M9.79289 6.29295C10.1834 5.90243 10.8166 5.90243 11.2071 6.29295L16.2071 11.293C16.5976 11.6835 16.5976 12.3166 16.2071 12.7072L11.2071 17.7072C10.8166 18.0977 10.1834 18.0977 9.79289 17.7072C9.40237 17.3166 9.40237 16.6835 9.79289 16.293L13.0858 13.0001H3.5C2.94772 13.0001 2.5 12.5523 2.5 12.0001C2.5 11.4478 2.94772 11.0001 3.5 11.0001H13.0858L9.79289 7.70717C9.40237 7.31664 9.40237 6.68348 9.79289 6.29295Z"
                                fill="white"
                            />
                        </svg>
                        <span class="text-white text-lg leading-[100%]">
                            Log In
                        </span>
                    </div>
                </Button>
            </form>
            <div class="flex gap-2 items-center">
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
                <span
                    class="leading-[100%] tracking-[-0.04em] text-white/30 !font-Inter"
                >
                    © 2025 Vornis servise. All Rights Reserved.
                </span>
            </div>
        </div>
    </Layout>
</template>
