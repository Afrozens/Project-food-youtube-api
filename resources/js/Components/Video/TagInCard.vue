<script lang="ts" setup>
import { HasOrExcept } from "@/types/video";
type typeColor = "green" | "blue";

defineProps<{
    data: HasOrExcept;
    color: typeColor;
}>();
</script>

<template>
    <div
        class="text-xs font-semibold me-2 px-2.5 py-0.5 rounded border w-max inline-flex items-center justify-center"
        :class="
            color === 'blue'
                ? 'border-blue-400 bg-blue-100 text-blue-800'
                : 'border-green-400 bg-green-100 text-green-800'
        "
    >
        {{ data.name }}
    </div>
</template>
