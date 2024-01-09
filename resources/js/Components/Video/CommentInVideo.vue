<script lang="ts" setup>
import { ref, inject, Ref } from "vue";
import TextArea from "@/Components/ElementsPrimitive/TextArea.vue";
import TertiaryButton from "@/Components/ElementsPrimitive/TertiaryButton.vue";
import Loader from "@/Components/General/Loader.vue";
import useSubmit from "@/Hooks/Dashboard/useSubmit";

const props = defineProps({
    videoId: Number,
});

const { isLoading, handleSubmit, data: dataInSubmit } = useSubmit();

const dataNewComment = inject("dataNewComment") as Ref;
const comment = ref("");

const handleLocalSubmit = async () => {
    if (comment.value.length) {
        const path = route("videos.comments.store", {
            video: props.videoId,
        });

        const data = {
            content: comment.value,
        };

        try {
            await handleSubmit(path, data, "video");
            dataNewComment.value = dataInSubmit.value;
            comment.value = "";
        } catch (error) {
            console.log(error, "error in comment in video");
        }
    }
};
</script>

<template>
    <form @submit.prevent="handleLocalSubmit" class="w-full border-b">
        <TextArea
            class="mb-8"
            id="comentario"
            v-model="comment"
            label="Comentario"
            :is-required="true"
        >
            <template #btn-left>
                <div class="self-end w-full flex gap-4 items-center">
                    <TertiaryButton
                        @click.prevent="handleLocalSubmit"
                        type="button"
                        class="w-48"
                        :class="isLoading ? 'bg-gray-200' : 'bg-green-600'"
                    >
                        <Loader v-show="isLoading" />
                        <span v-show="!isLoading">Enviar</span>
                    </TertiaryButton>
                </div>
            </template>
        </TextArea>
    </form>
</template>
