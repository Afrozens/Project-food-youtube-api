<script lang="ts" setup>
import { ref, computed, provide } from "vue";
import moment from "moment";
import { usePage } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";
import { ChatContent } from "@/types/chat";
import AccountIcon from "vue-material-design-icons/Account.vue";
import Loader from "../General/Loader.vue";
import NoteEditOutlineIcon from "vue-material-design-icons/NoteEditOutline.vue";
import DeleteIcon from "vue-material-design-icons/Delete.vue";
import TertiaryButton from "../ElementsPrimitive/TertiaryButton.vue";
import ChatService from "@/Services/Dashboard/ChatService";
import CommentEditInChat from "./CommentEditInChat.vue";

const { props: propsPage } = usePage();

const props = defineProps<{
    data: ChatContent;
    idAuthUser?: number;
}>();

const emits = defineEmits(["deleted"]);

const inEdit = ref(false);
const isLoading = ref(false);
const modelValue = ref("");
const serviceChat = new ChatService();

const handleSubmitDeleted = async () => {
    try {
        isLoading.value = true;
        const path = route("chats.destroy", {
            id: props.data.id,
        });
        await serviceChat.fetchDeleteMsgInChat(path);
        isLoading.value = false;
        emits("deleted");
        toast(serviceChat.getMsgSuccess(), {
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
    }
};

const handleChangeEdit = () => {
    inEdit.value = !inEdit.value;
};

const content = computed(() => {
    if (modelValue.value) {
        return modelValue.value;
    }
    return props.data.content;
});

provide("modelValue", modelValue);
</script>

<template>
    <li class="w-full p-2 text-sm flex flex-col gap-2" v-if="data">
        <header class="w-full flex justify-between items-center">
            <span class="flex gap-2 items-center">
                <AccountIcon />
                {{ data.created_by.name }}</span
            >
            <span class="text-xs md:text-base">{{
                moment(data.updated_at).format("LL")
            }}</span>
        </header>
        <div
            v-if="!inEdit"
            class="indent-3 gap-5 justify-between flex flex-col border rounded-md border-gray-200 px-4 pb-2 text-sm"
        >
            <p class="pt-2">
                {{ content }}
            </p>
            <div
                v-if="propsPage.auth.data.id === data.created_by.id"
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
        <CommentEditInChat
            :handle-change="handleChangeEdit"
            :data="content"
            :id="data.id"
            v-else
        />
    </li>
</template>
