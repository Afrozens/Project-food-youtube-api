<script lang="ts" setup>
import { ref, computed, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";
import { PageProps } from "../../types/index";
import { ChatContent } from "@/types/chat";
import useSubmit from "../../Hooks/Dashboard/useSubmit";
import Loader from "../General/Loader.vue";
import TertiaryButton from "../ElementsPrimitive/TertiaryButton.vue";
import TextArea from "../ElementsPrimitive/TextArea.vue";
import CommentInChat from "./CommentInChat.vue";

const { props } = usePage<PageProps>();

const propsDefine = defineProps({
    dataChat: Array<ChatContent>,
    idAuthUser: {
        required: false,
        type: Number,
    },
});

const { isLoading, handleSubmit, data } = useSubmit();

const comment = ref("");
const dataChat = ref<ChatContent[]>();
const path = route("chats.store");

onMounted(() => {
    if (propsDefine.dataChat) {
        dataChat.value = propsDefine.dataChat;
    }
});

const localHandleSubmit = async () => {
    const dataIn = {
        user_id: propsDefine.idAuthUser ?? props.auth.data.id,
        content: comment.value,
    };
    try {
        await handleSubmit(path, dataIn, "chat");
        comment.value = "";
    } catch (error) {
        console.log(error, "error in chat in dashboard");
    }
};

const delMsg = (index: number) => {
    dataChat.value?.splice(index, 1);
};

const dataWithMsg = computed(() => {
    if (dataChat.value) {
        if (data.value) {
            dataChat.value.push(data.value as ChatContent);
            return dataChat.value;
        }
        return dataChat.value;
    }
});
</script>

<template>
    <div class="w-full flex flex-col gap-4 mx-auto self-center lg:px-14">
        <div
            :class="Number(!dataWithMsg?.length) > 0 && 'h-[400px]'"
            class="w-full bg-white rounded-md py-8 px-6"
        >
            <h4
                v-if="Number(!dataWithMsg?.length) > 0"
                class="text-minus-base normal-case font-semibold text-center"
            >
                No hay comentarios
            </h4>
            <TransitionGroup
                name="list"
                tag="ul"
                class="max-h-[450px] overflow-y-auto"
            >
                <CommentInChat
                    v-for="(msg, index) in dataWithMsg"
                    :key="msg.id"
                    :id-auth-user="idAuthUser"
                    :data="msg"
                    @deleted="delMsg(index)"
                />
            </TransitionGroup>
        </div>
        <div class="w-full bg-white rounded-md p-4 pt-6">
            <form @submit.prevent="localHandleSubmit" class="w-full h-full">
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
                                @click="localHandleSubmit"
                                type="button"
                                :class="
                                    isLoading ? 'bg-gray-200' : 'bg-green-600'
                                "
                            >
                                <Loader v-show="isLoading" />
                                <span v-show="!isLoading"> Comentar</span>
                            </TertiaryButton>
                            <TertiaryButton
                                @click="comment = ''"
                                type="button"
                                :class="
                                    isLoading ? 'bg-gray-200' : 'bg-red-600'
                                "
                            >
                                <Loader v-show="isLoading" />
                                <span v-show="!isLoading"> Restaurar </span>
                            </TertiaryButton>
                        </div>
                    </template>
                </TextArea>
            </form>
        </div>
    </div>
</template>
