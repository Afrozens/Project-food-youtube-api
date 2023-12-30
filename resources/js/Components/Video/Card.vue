<script lang="ts" setup>
import { Link } from "@inertiajs/vue3";
import { HasOrExcept, VideoData } from "../../types/video";
import TagInCard from "./TagInCard.vue";

defineProps<{
    dataIn?: VideoData;
}>();
</script>

<template>
    <li class="w-full rounded-lg list-none shadow-lg bg-gray-50">
        <header
            class="w-full flex items-center gap-4 justify-between px-3 py-1"
        >
            <Link
                :href="route('videos.show', dataIn?.id)"
                class="text-2xl font-medium tracking-tight truncate capitalize text-primary"
            >
                {{ dataIn?.title }}
            </Link>
        </header>

        <Link
            :href="route('videos.show', dataIn?.id)"
            class="z-10 w-full h-[300px]"
        >
            <iframe
                :src="dataIn?.video_data.url"
                frameborder="0"
                :disabled="true"
                class="bg-cover w-full h-[300px] bg-no-repeat bg-center"
            />
        </Link>

        <div class="-mb-4 w-full whitespace-normal leading-[1.4] p-4">
            <span v-html="dataIn?.description" class="text-[14px]"></span>
        </div>
        <div class="w-full p-4 flex flex-col gap-2 justify-between">
            <div class="w-full flex gap-2 flex-wrap">
                <TagInCard
                    v-for="(data, index) in dataIn?.tags"
                    :key="index"
                    color="green"
                    :data="(data as HasOrExcept)"
                />
            </div>
            <span class="leading-[1.4] capitalize text-base">
                Tambien Necesitarás:
            </span>
            <div class="w-full flex flex-wrap gap-2">
                <TagInCard
                    v-for="(data, index) in dataIn?.has_more"
                    :key="index"
                    color="blue"
                    :data="(data as HasOrExcept)"
                />
            </div>
        </div>
    </li>
</template>