<script lang="ts" setup>
defineProps({
    icon: Element,
    isBlack: Boolean,
    background: String,
    title: String,
    count: Number,
});
</script>

<template>
    <div
        class="flex justify-between items-center px-3 rounded-md py-4 shadow-xl w-full h-16"
        :class="[
            background === 'green' ? 'bg-[#4CAF50]' : 'bg-[#2196F3]',
            isBlack ? 'text-black' : 'text-white',
        ]"
    >
        <div class="flex gap-2">
            <component :is="icon" />
            <span class="text-lg"> {{ title }}: </span>
        </div>
        <span class="font-bold">{{ count }}</span>
    </div>
</template>
