<script lang="ts" setup>
import ImageAreaIcon from "vue-material-design-icons/ImageArea.vue";

const numberTag = 2;
</script>

<template>
    <li
        role="status"
        class="max-w-lg pt-2 border-gray-200 rounded shadow animate-pulse"
    >
        <div class="h-6 bg-gray-400 rounded-full w-full mb-3"></div>
        <div
            class="flex items-center justify-center h-[300px] mb-10 bg-gray-400 rounded"
        >
            <ImageAreaIcon :size="50" />
        </div>

        <div class="flex flex-col px-2">
            <div class="h-2 bg-gray-400 rounded-full mb-2.5"></div>
            <div class="h-2 bg-gray-400 rounded-full mb-2.5"></div>
            <div class="h-2 bg-gray-400 rounded-full"></div>
        </div>
        <div class="flex flex-col mt-6 px-4">
            <div class="mb-2 flex self-end flex-wrap gap-2">
                <div
                    v-for="index in numberTag"
                    :key="index"
                    class="h-5 bg-gray-400 rounded-md w-14 mb-2"
                />
            </div>
        </div>

        <span class="sr-only">Loading...</span>
    </li>
</template>
