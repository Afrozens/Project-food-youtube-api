<script setup lang="ts">
defineProps({
    size: String,
});
</script>

<template>
    <div
        class="loader"
        :style="size && { height: '60px', width: '60px' }"
    ></div>
</template>

<style scoped>
.loader {
    border: 4px solid rgba(0, 0, 0, 0.1);
    border-left-color: transparent;
    border-radius: 50%;
    width: 24px;
    z-index: 999;
    height: 24px;
    opacity: 1;
    animation: spin89345 1s linear infinite;
}

@keyframes spin89345 {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}
</style>
