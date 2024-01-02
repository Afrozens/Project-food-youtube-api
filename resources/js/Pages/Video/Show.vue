<script lang="ts" setup>
import { ref, computed } from "vue";
import { Head } from "@inertiajs/vue3";
// @ts-ignore - iconos sin typings
import VideoIcon from "vue-material-design-icons/Video.vue";
// @ts-ignore - iconos sin typings
import CommentMultipleIcon from "vue-material-design-icons/CommentMultiple.vue";
import { VideoData } from "../../types/video";
import { Comment as CommentType } from "../../types/chat";
import VideoService from "../../Services/Video/VideoService";
import Comment from "../../Components/Video/Comment.vue";
import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    video: Object,
});

const serviceVideo = new VideoService();

const dataInComment = ref<CommentType[]>([]);

const data = computed(() => {
    if (props.video) {
        const dataIn = props.video.data as VideoData;
        return dataIn;
    }
});

const handleComment = async () => {
    if (data.value?.id) {
        try {
            const path = route("videos.comments.index", {
                video: data.value.id,
            });

            await serviceVideo.fetchGetComment(path);
            dataInComment.value = serviceVideo.getData();
        } catch (error) {
            console.log(error);
        }
    }
};

if (data.value) {
    handleComment();
}
</script>

<template>
    <Head :title="data?.title" />

    <AuthenticatedLayout>
        <section class="w-full px-4 md:px-12 py-4">
            <header class="w-full">
                <h1
                    class="text-2xl font-medium tracking-tight truncate capitalize text-gray-600 flex gap-4 items-center"
                >
                    <VideoIcon :size="60" fillColor="#757575" />
                    {{ data?.title }}
                </h1>
            </header>
            <iframe
                :src="data?.video_data.url"
                frameborder="0"
                class="bg-cover w-full h-[500px] bg-no-repeat bg-center"
            />
            <p
                class="text-[14px] mb-8 text-black opacity-60"
                v-html="data?.description"
            ></p>
            <article
                class="border p-4 border-gray-300 rounded-md w-full flex flex-col gap-4"
            >
                <header class="w-full flex gap-4 items-center">
                    <CommentMultipleIcon fillColor="#757575" />
                    <span class="text-[20px] leading-[30px]">Comments</span>
                </header>
                <TransitionGroup
                    name="list"
                    tag="ul"
                    class="flex flex-col gap-4"
                >
                    <Comment
                        v-for="comment in dataInComment"
                        :comment="comment"
                        :key="comment.id"
                    />
                </TransitionGroup>
            </article>
        </section>
    </AuthenticatedLayout>
</template>

<style scoped>
.list-enter-active,
.list-leave-active {
    transition: all 0.5s ease;
}
.list-enter-from,
.list-leave-to {
    opacity: 0;
    transform: translateY(30px);
}
</style>
