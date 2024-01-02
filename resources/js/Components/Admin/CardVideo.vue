<script lang="ts" setup>
import { ref } from "vue";
import { Link, router } from "@inertiajs/vue3";
// @ts-ignore - iconos sin typings
import FileVideoOutlineIcon from "vue-material-design-icons/FileVideoOutline.vue";
// @ts-ignore - iconos sin typings
import NoteEditOutlineIcon from "vue-material-design-icons/NoteEditOutline.vue";
// @ts-ignore - iconos sin typings
import DeleteIcon from "vue-material-design-icons/Delete.vue";
import { VideoData } from "@/types/video";
import TertiaryButton from "../ElementsPrimitive/TertiaryButton.vue";
import Loader from "../General/Loader.vue";
import ModalDelete from "../Modals/ModalDelete.vue";
import { templateRef } from "@vueuse/core";

const props = defineProps<{
    video: VideoData;
}>();

const isHidden = ref(false);
const lazyOptions = ref({
    src: props.video.video_data.thumbnail,
    lifecycle: {
        loading: () => {
            isHidden.value = true;
        },
        loaded: () => {
            isHidden.value = false;
        },
    },
});

const isOpenDelete = ref(false);
const isLoading = ref(false);

const handleCloseDelete = () => {
    isOpenDelete.value = false;
};
</script>

<template>
    <li class="max-w-lg flex flex-col shadow-md rounded-md bg-white py-2">
        <header
            class="w-full px-4 py-2 flex rounded-t-md justify-start items-center"
        >
            <FileVideoOutlineIcon :size="40" class="opacity-80" />
            <Link
                :href="route('admin.videos.show', video.id)"
                class="text-xl hover:opacity-60 opacity-80 truncate"
            >
                {{ video.title }}
            </Link>
        </header>
        <div class="w-full h-[300px] relative hover:bg-gray-600 card">
            <img
                v-lazy="{
                    src: lazyOptions.src,
                    lifecycle: lazyOptions.lifecycle,
                }"
                :alt="video.title"
                :class="[
                    isHidden
                        ? ' animate-pulse blur-sm  opacity-50'
                        : ' animate-none blur-none bg-transparent opacity-100',
                ]"
                lazy="loading"
                class="bg-cover object-cover w-full h-full"
            />
            <Loader
                v-show="isHidden"
                class="absolute top-1/2 -translate-y-1/2 left-1/2 -translate-x-1/2"
            />
            <Link
                :href="route('admin.videos.show', video.id)"
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
        <div class="bg-white rounded-b-md items-center w-full h-48 px-5 py-5">
            <p
                style="
                    overflow: hidden;
                    display: -webkit-box;
                    -webkit-box-orient: vertical;
                    -webkit-line-clamp: 5;
                "
                v-html="video.description"
                class="line-clamp-3 text-[14px] mb-8 text-black opacity-60"
            />
            <div class="items-end justify-end w-full flex gap-4">
                <!-- Edit button msg -->
                <Link :href="route('admin.videos.edit', video.id)">
                    <TertiaryButton
                        type="button"
                        :class="isLoading ? 'bg-gray-200' : 'bg-green-600'"
                    >
                        <Loader v-show="isLoading" />
                        <NoteEditOutlineIcon v-show="!isLoading" />
                    </TertiaryButton>
                </Link>
                <!-- Delete button msg -->
                <TertiaryButton
                    type="button"
                    @click="isOpenDelete = true"
                    :class="isLoading ? 'bg-gray-200' : 'bg-red-600'"
                >
                    <Loader v-show="isLoading" />
                    <DeleteIcon v-show="!isLoading" />
                </TertiaryButton>
            </div>
        </div>
    </li>
    <ModalDelete
        v-if="isOpenDelete"
        routeDelete="admin.videos.destroy"
        module="video"
        :show="isOpenDelete"
        @close="handleCloseDelete"
        :id="(video.id as number)"
        title="¿Seguro que desea eliminar este video?"
    />
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
