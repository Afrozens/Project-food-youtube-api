<script lang="ts" setup>
import { computed, ref } from "vue";
import { Link } from "@inertiajs/vue3";
import { HasOrExcept, VideoData } from "../../types/video";
import TagInCard from "./TagInCard.vue";

const props = defineProps<{
    dataIn?: VideoData;
    tagsCurrents: string[];
}>();

const isHidden = ref(false);
const lazyOptions = ref({
    src: props.dataIn?.video_data.thumbnail,
    lifecycle: {
        loading: () => {
            isHidden.value = true;
        },
        loaded: () => {
            isHidden.value = false;
        },
    },
});

const tagsWithoutCurrents = computed(() => {
    if (props.dataIn) {
        const filteredTags = props.dataIn.has_more.filter((tags) => {
            return !props.tagsCurrents.some((tagsTwo) => tags.name === tagsTwo);
        });
        return filteredTags;
    }
});
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

        <div class="w-full h-[300px] relative hover:bg-gray-600 card">
            <img
                v-lazy="{
                    src: lazyOptions.src,
                    lifecycle: lazyOptions.lifecycle,
                }"
                :alt="dataIn?.title"
                :class="[
                    isHidden
                        ? ' animate-pulse blur-sm  opacity-50'
                        : ' animate-none blur-none bg-transparent opacity-100',
                ]"
                lazy="loading"
                class="bg-cover object-cover w-full h-full"
            />
            <Link
                :href="route('videos.show', dataIn?.id)"
                style="background-color: #63606073"
                class="btn absolute base-transition cursor-pointer top-1/2 -translate-y-1/2 left-1/2 -translate-x-1/2 h-full w-full bg-[#63606073] flex justify-center items-center"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    x="0px"
                    y="0px"
                    width="100"
                    height="100"
                    viewBox="0 0 48 48"
                >
                    <path
                        fill="#FF3D00"
                        d="M43.2,33.9c-0.4,2.1-2.1,3.7-4.2,4c-3.3,0.5-8.8,1.1-15,1.1c-6.1,0-11.6-0.6-15-1.1c-2.1-0.3-3.8-1.9-4.2-4C4.4,31.6,4,28.2,4,24c0-4.2,0.4-7.6,0.8-9.9c0.4-2.1,2.1-3.7,4.2-4C12.3,9.6,17.8,9,24,9c6.2,0,11.6,0.6,15,1.1c2.1,0.3,3.8,1.9,4.2,4c0.4,2.3,0.9,5.7,0.9,9.9C44,28.2,43.6,31.6,43.2,33.9z"
                    ></path>
                    <path fill="#FFF" d="M20 31L20 17 32 24z"></path>
                </svg>
            </Link>
        </div>

        <div class="-mb-4 w-full whitespace-normal leading-[1.4] p-4">
            <span
                v-html="dataIn?.description"
                class="line-clamp-5 text-[14px]"
            ></span>
        </div>
        <div class="w-full p-4 flex flex-col gap-2 justify-between">
            <div class="w-full flex gap-2 flex-wrap">
                <TagInCard
                    v-for="(data, index) in tagsCurrents"
                    :key="index"
                    color="green"
                    :current="data"
                />
            </div>
            <span class="leading-[1.4] capitalize text-base">
                Tambien Necesitarás:
            </span>
            <div class="w-full flex flex-wrap gap-2">
                <TagInCard
                    v-for="(data, index) in tagsWithoutCurrents"
                    :key="index"
                    color="blue"
                    :data="(data as HasOrExcept)"
                />
            </div>
        </div>
    </li>
</template>

<style scoped>
.btn {
    opacity: 0;
    visibility: hidden;
}
.card:hover > .btn {
    opacity: 1;
    visibility: visible;
}
</style>
