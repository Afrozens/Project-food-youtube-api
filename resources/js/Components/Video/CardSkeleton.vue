<script lang="ts" setup>
import FileVideoIcon from "vue-material-design-icons/FileVideo.vue";

const numberTag = 3;
const numberTagNeed = 3;
</script>

<template>
    <li
        role="status"
        class="w-full pt-2 border-gray-200 rounded shadow animate-pulse"
    >
        <div class="h-5 bg-gray-400 rounded-full w-full mb-3"></div>
        <div
            class="flex items-center justify-center h-[300px] mb-10 bg-gray-400 rounded"
        >
            <FileVideoIcon :size="50" />
        </div>

        <div class="h-2 bg-gray-400 rounded-full mb-2.5"></div>
        <div class="h-2 bg-gray-400 rounded-full mb-2.5"></div>
        <div class="h-2 bg-gray-400 rounded-full mb-2.5"></div>
        <div class="h-2 bg-gray-400 rounded-full"></div>
        <div class="flex flex-col mt-6">
            <div class="mb-2 flex flex-wrap gap-2">
                <div
                    v-for="index in numberTag"
                    :key="index"
                    class="h-5 bg-gray-400 rounded-md w-14 mb-2"
                />
            </div>
            <div class="w-48 h-3 mb-3 bg-gray-400 rounded-full"></div>
        </div>
        <div class="flex flex-wrap gap-2">
            <div class="h-5 bg-gray-400 rounded-md w-36 mb-2" />
            <div
                v-for="index in numberTagNeed"
                :key="index"
                class="h-5 bg-gray-400 rounded-md w-20 mb-2"
            />
        </div>
        <span class="sr-only">Loading...</span>
    </li>
</template>
