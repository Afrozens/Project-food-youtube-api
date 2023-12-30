<script lang="ts" setup>
import { ref } from "vue";
import DeleteIcon from "vue-material-design-icons/Delete.vue";
import NoteEditOutlineIcon from "vue-material-design-icons/NoteEditOutline.vue";
import { HasOrExcept } from "@/types/video";
import Loader from "../General/Loader.vue";
import ModalEditTag from "../Admin/ModalEditTag.vue";
import ModalDelete from "../Modals/ModalDelete.vue";

defineProps<{
    tag: HasOrExcept;
}>();

const isOpenEdit = ref(false);
const isOpenDelete = ref(false);
const isLoading = ref(false);

const handleCloseEdit = () => {
    isOpenEdit.value = false;
};

const handleCloseDelete = () => {
    isOpenDelete.value = false;
};
</script>

<template>
    <div
        class="rounded-md flex justify-between items-center gap-6 w-max h-[66px] bg-[#53B257] px-3 py-6"
    >
        <span class="text-white">{{ tag.name }}</span>
        <div class="flex">
            <!-- Edit button msg -->
            <button
                @click="isOpenEdit = true"
                type="button"
                class="bg-transparent hover:bg-[#c8c7c742] transition-all rounded-full p-2"
            >
                <Loader v-show="isLoading" />
                <NoteEditOutlineIcon v-show="!isLoading" fillColor="#fff" />
            </button>
            <!-- Delete button msg -->
            <button
                type="button"
                @click="isOpenDelete = true"
                class="bg-transparent hover:bg-[#c8c7c742] transition-all rounded-full p-2"
            >
                <Loader v-show="isLoading" />
                <DeleteIcon v-show="!isLoading" fillColor="#dc2626" />
            </button>
        </div>
        <ModalEditTag
            v-if="isOpenEdit"
            :show="isOpenEdit"
            :name="tag.name"
            @close="handleCloseEdit"
            :id="(tag.id as number)"
        />
        <ModalDelete
            v-if="isOpenDelete"
            routeDelete="admin.tags.destroy"
            module="tag"
            :show="isOpenDelete"
            @close="handleCloseDelete"
            :id="(tag.id as number)"
            title="¿Seguro que desea eliminar este tag?"
        />
    </div>
</template>
