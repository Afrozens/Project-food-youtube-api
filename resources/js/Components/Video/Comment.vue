<script lang="ts" setup>
import { ref, provide, computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";
// @ts-ignore - iconos sin typings
import NoteEditOutlineIcon from "vue-material-design-icons/NoteEditOutline.vue";
// @ts-ignore - iconos sin typings
import DeleteIcon from "vue-material-design-icons/Delete.vue";
import VideoService from "@/Services/Video/VideoService";
import { Comment as CommentType } from "../../types/chat";
import AvatarGenerate from "../General/AvatarGenerate.vue";
import TertiaryButton from "../ElementsPrimitive/TertiaryButton.vue";
import Loader from "../General/Loader.vue";
import CommentEditInVideo from "./CommentEditInVideo.vue";

const props = defineProps<{
    comment: CommentType;
    videoId: number;
}>();

const { props: propsPage } = usePage();

const serviceVideo = new VideoService();

const emits = defineEmits(["deleted"]);

const inEdit = ref(false);
const modelValue = ref("");
const isLoading = ref(false);

const handleSubmitDeleted = async () => {
    try {
        isLoading.value = true;
        const path = route("videos.comments.destroy", {
            video: props.videoId,
            comment: props.comment.id,
        });
        await serviceVideo.fetchDeleteCommentInVideo(path);
        isLoading.value = false;
        emits("deleted");
        toast(serviceVideo.getMsgSuccess(), {
            autoClose: 1800,
            position: "top-right",
            type: "success",
        });
    } catch (error) {
        toast(error as string, {
            autoClose: 1800,
            position: "top-right",
            type: "error",
        });
        isLoading.value = false;
    }
};

const handleChangeEdit = () => {
    inEdit.value = !inEdit.value;
};

const content = computed(() => {
    if (modelValue.value) {
        return modelValue.value;
    }
    return props.comment.content;
});

provide("modelValue", modelValue);
</script>

<template>
    <li class="border border-gray-300 rounded-md py-2 px-4 flex flex-col gap-5">
        <header class="w-full flex gap-4 items-center justify-start">
            <AvatarGenerate
                :is-rounded="true"
                size="40"
                :src="comment.img ?? undefined"
                :name="comment.name"
                class="w-10 h-10"
            />
            <span>@{{ comment.name }}</span>
        </header>

        <div v-if="!inEdit" class="w-full">
            <p
                class="mb-2 text-[14px] text-black opacity-60"
                v-html="content"
            ></p>
            <div
                v-if="comment.user_id === propsPage.auth.data.id"
                class="items-end justify-end w-full flex gap-4"
            >
                <!-- Edit button msg -->
                <TertiaryButton
                    @click="handleChangeEdit"
                    type="button"
                    :class="isLoading ? 'bg-gray-200' : 'bg-green-600'"
                >
                    <Loader v-show="isLoading" />
                    <NoteEditOutlineIcon v-show="!isLoading" />
                </TertiaryButton>
                <!-- Delete button msg -->
                <TertiaryButton
                    @click="handleSubmitDeleted"
                    type="button"
                    :class="isLoading ? 'bg-gray-200' : 'bg-red-600'"
                >
                    <Loader v-show="isLoading" />
                    <DeleteIcon v-show="!isLoading" />
                </TertiaryButton>
            </div>
        </div>

        <CommentEditInVideo
            :handle-change="handleChangeEdit"
            :data="content"
            :video-id="videoId"
            :comment-id="comment.id"
            v-else
        />
    </li>
</template>
