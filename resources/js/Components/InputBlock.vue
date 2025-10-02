<script setup>
defineProps({
    type: {
        type: String,
    },
    label: {
        type: String,
    },
    id: {
        type: String,
    },
    placeholder: {
        type: String,
    },
    modelValue: String,
    error: String,
});

defineEmits(["update:modelValue"]);
</script>

<template>
    <div class="flex flex-col gap-3">
        <label :for="id" class="text-sm leading-[100%] text-white/30">
            {{ label }}
        </label>
        <div
            class="flex py-4.5 px-4 focus-within:border-primary transition-colors ease-in-out duration-500 bg-[#0A0A0A] border border-white/8 rounded-sm"
        >
            <input
                :id="id"
                :name="id"
                :type="type"
                :value="modelValue"
                @input="$emit('update:modelValue', $event.target.value)"
                class="text-white w-full leading-[100%] outline-none !font-Inter"
                :placeholder="placeholder"
            />
        </div>
        <span v-if="error" class="text-sm text-red-500">
            {{ error }}
        </span>
    </div>
</template>
