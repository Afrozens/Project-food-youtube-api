<script setup lang="ts">
withDefaults(
    defineProps<{
        type?: "button" | "submit" | "reset";
    }>(),
    {
        type: "button",
    }
);
</script>

<template>
    <button
        :type="type"
        class="ring-1 ring-slate-300 border-0 bg-gray-100 hover:bg-gray-100/50 text-gray-800 rounded-lg w-full p-2 flex justify-center gap-3 items-center capitalize transition-all hover:opacity-80 hover:scale-95 active:scale-90 font-semibold"
    >
        <slot />
    </button>
</template>
