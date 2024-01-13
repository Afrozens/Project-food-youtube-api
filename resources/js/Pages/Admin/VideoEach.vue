<script lang="ts" setup>
import { computed, ref, provide } from "vue";
import { Head } from "@inertiajs/vue3";
// @ts-ignore - iconos sin typings
import VideoIcon from "vue-material-design-icons/Video.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { VideoData } from "@/types/video";
import Loader from "@/Components/General/Loader.vue";
import Comment from "@/Components/Video/Comment.vue";
import useComment from "@/Hooks/Video/useComment";
import CommentInVideo from "@/Components/Video/CommentInVideo.vue";

const props = defineProps({
    video: Object,
});

const { isLoading, dataInComment, handleComment } = useComment();

const dataNewComment = ref();

const data = computed(() => {
    if (props.video) return props.video.data as VideoData;
});

if (data.value) {
    handleComment(data.value.id);
}

const delMsg = (index: number) => {
    dataInComment.value?.splice(index, 1);
};

const dataInCommentTotal = computed(() => {
    if (dataNewComment.value) {
        dataInComment.value.unshift(dataNewComment.value);
        return dataInComment.value;
    }
    return dataInComment.value;
});

provide("dataNewComment", dataNewComment);
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
                        class="mb-8 mt-4 text-black"
                    />
                </div>
                <CommentInVideo :video-id="data?.id" />
                <div
                    v-if="isLoading"
                    class="w-full my-4 flex justify-center items-center"
                >
                    <Loader size="200" />
                </div>
                <TransitionGroup
                    v-else
                    name="list"
                    tag="ul"
                    class="flex flex-col gap-4 mt-2"
                >
                    <Comment
                        v-for="(comment, index) in dataInCommentTotal"
                        :comment="comment"
                        :key="comment.id"
                        :video-id="(data?.id as number)"
                        @deleted="delMsg(index)"
                    />
                </TransitionGroup>
            </article>
        </section>
    </AuthenticatedLayout>
</template>
