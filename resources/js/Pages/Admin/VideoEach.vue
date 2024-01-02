<script lang="ts" setup>
import { computed, ref } from "vue";
import { Head } from "@inertiajs/vue3";
// @ts-ignore - iconos sin typings
import VideoIcon from "vue-material-design-icons/Video.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TextArea from "@/Components/ElementsPrimitive/TextArea.vue";
import TertiaryButton from "@/Components/ElementsPrimitive/TertiaryButton.vue";
import { VideoData } from "@/types/video";

const props = defineProps({
    video: Object,
});

const comment = ref("");
const isLoading = ref(false);

const data = computed(() => {
    if (props.video) return props.video.data as VideoData;
});
</script>

<template>
    <Head :title="`Panel Administrador | ${video?.title}`" />

    <AuthenticatedLayout>
        <section
            class="min-h-screen w-full pl-4 pr-8 md:pl-16 md:pr-24 mt-8 overflow-x-hidden mb-5"
        >
            <header class="mb-4 w-full flex items-center justify-start gap-2">
                <VideoIcon :size="70" fillColor="#757575" />
                <span class="font-semibold text-2xl md:text-3xl">{{
                    data?.title
                }}</span>
            </header>
            <article class="w-full flex flex-col gap-5">
                <div class="w-full col-span-1">
                    <iframe
                        :src="data?.video_data.url"
                        frameborder="0"
                        class="bg-cover w-full h-[500px] bg-no-repeat bg-center"
                    />
                    <p
                        v-html="data?.description"
                        class="mb-8 text-black opacity-60"
                    />
                </div>
                <div class="border w-full bg-white h-96 py-5 px-2">
                    <h4
                        class="text-minus-base normal-case font-semibold text-center"
                    >
                        No hay comentarios
                    </h4>
                </div>
                <div class="w-full bg-white rounded-md p-4 pt-6">
                    <form class="w-full h-full">
                        <TextArea
                            class="mb-8"
                            id="comments"
                            v-model="comment"
                            label="Comments"
                            :is-required="true"
                        >
                            <template #btn-left>
                                <div
                                    class="self-end w-full flex gap-4 items-center"
                                >
                                    <TertiaryButton
                                        type="button"
                                        :class="
                                            isLoading
                                                ? 'bg-gray-200'
                                                : 'bg-green-600'
                                        "
                                    >
                                        <Loader v-show="isLoading" />
                                        <span v-show="!isLoading">
                                            Comentar</span
                                        >
                                    </TertiaryButton>
                                    <TertiaryButton
                                        @click="comment = ''"
                                        type="button"
                                        :class="
                                            isLoading
                                                ? 'bg-gray-200'
                                                : 'bg-red-600'
                                        "
                                    >
                                        <Loader v-show="isLoading" />
                                        <span v-show="!isLoading">
                                            Restaurar
                                        </span>
                                    </TertiaryButton>
                                </div>
                            </template>
                        </TextArea>
                    </form>
                </div>
            </article>
        </section>
    </AuthenticatedLayout>
</template>
