<script lang="ts" setup>
import { ref, inject, Ref } from "vue";
import { toast } from "vue3-toastify";
import TextArea from "../ElementsPrimitive/TextArea.vue";
import TertiaryButton from "../ElementsPrimitive/TertiaryButton.vue";
import Loader from "../General/Loader.vue";
import VideoService from "@/Services/Video/VideoService";

const props = defineProps<{
    handleChange: () => void;
    data: string;
    commentId: string | number;
    videoId: number;
}>();

const serviceVideo = new VideoService();

const modelValue = inject("modelValue") as Ref<string>;
const isLoading = ref(false);
const comment = ref(props.data as string);

const handleSubmit = async () => {
    try {
        isLoading.value = true;
        const path = route("videos.comments.update", {
            video: props.videoId,
            comment: props.commentId,
        });
        const data = {
            content: comment.value,
        };
        await serviceVideo.fetchUpdatedCommentInVideo(path, data);
        modelValue.value = comment.value;
        isLoading.value = false;
        toast(serviceVideo.getMsgSuccess(), {
            autoClose: 1800,
            position: "top-right",
            type: "success",
        });
        if (props.handleChange) {
            props.handleChange();
        }
    } catch (error) {
        isLoading.value = false;
        toast(error as string, {
            autoClose: 1800,
            position: "top-right",
            type: "error",
        });
    }
};
</script>

<template>
    <div class="w-full bg-white rounded-md p-4 pt-6">
        <form class="w-full h-full">
            <TextArea
                label="Comment"
                class="mb-8"
                v-model="comment"
                :is-required="false"
            >
                <template #btn-left>
                    <div class="self-end w-full flex gap-4 items-center">
                        <TertiaryButton
                            @click="handleSubmit"
                            type="button"
                            :class="isLoading ? 'bg-gray-200' : 'bg-green-600'"
                        >
                            <Loader v-show="isLoading" />
                            <span v-show="!isLoading"> Actualizar</span>
                        </TertiaryButton>
                        <TertiaryButton
                            @click="handleChange"
                            type="button"
                            :class="isLoading ? 'bg-gray-200' : 'bg-red-600'"
                        >
                            <Loader v-show="isLoading" />
                            <span v-show="!isLoading"> Cancelar </span>
                        </TertiaryButton>
                    </div>
                </template>
            </TextArea>
        </form>
    </div>
</template>
