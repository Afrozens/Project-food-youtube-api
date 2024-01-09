<script lang="ts" setup>
import { HasOrExcept } from "@/types/video";
type typeColor = "green" | "blue";

defineProps<{
    data?: HasOrExcept;
    current?: string;
    color: typeColor;
}>();
</script>

<template>
    <div
        class="text-[14px] me-2 px-3 py-1.5 rounded border w-max inline-flex items-center justify-center"
        :class="
            color === 'blue'
                ? 'bg-[#2A9AF3] text-white'
                : 'bg-[#53B257] text-white'
        "
    >
        {{ current ?? data?.name }}
    </div>
</template>
