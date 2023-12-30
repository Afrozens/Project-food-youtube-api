<script lang="ts" setup>
import { computed, ref, onMounted } from "vue";
import { watchDebounced } from "@vueuse/core";
import { Head, router } from "@inertiajs/vue3";
import MagnifyIcon from "vue-material-design-icons/Magnify.vue";
import PlusIcon from "vue-material-design-icons/Plus.vue";
import TagMultipleIcon from "vue-material-design-icons/TagMultiple.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { HasOrExcept } from "@/types/video";
import TextInput from "@/Components/ElementsPrimitive/TextInput.vue";
import TagOfList from "@/Components/Admin/TagOfList.vue";
import ModalCreateTag from "@/Components/Admin/ModalCreateTag.vue";

const props = defineProps({
    tags: Object,
});

const isOpen = ref(false);
const isLoading = ref(false);
const term = ref("");
const handleClose = () => {
    isOpen.value = false;
};

onMounted(() => {
    const termStorage = localStorage.getItem("term");
    if (termStorage) {
        term.value = termStorage;
    }
});

const handleSearch = () => {
    const path = route("admin.tags.index");
    localStorage.setItem("term", term.value);
    router.get(
        path,
        {
            search: term.value,
        },
        {
            preserveState: (page) => Object.keys(page.props.errors).length,
            onStart: () => {
                isLoading.value = true;
            },
            onError: () => {
                isLoading.value = false;
            },
            onFinish: () => {
                isLoading.value = false;
            },
        }
    );
};
watchDebounced(
    term,
    () => {
        const termStorage = localStorage.getItem("term");

        if (term.value === termStorage) return;
        handleSearch();
    },
    { debounce: 500, maxWait: 1000 }
);

const tagsData = computed(() => {
    if (props.tags) {
        return props.tags.data as HasOrExcept[];
    }
});
</script>

<template>
    <Head title="Panel Administrativo" />

    <AuthenticatedLayout>
        <section
            class="min-h-screen w-full pl-4 pr-8 md:pl-16 md:pr-24 mt-8 overflow-x-hidden mb-5"
        >
            <header class="mb-4 w-full flex items-center justify-start gap-2">
                <TagMultipleIcon :size="70" fillColor="#757575" />
                <span class="font-semibold text-3xl">Listado de Tags</span>
            </header>
            <hr class="h-px bg-gray-300 mb-4 border-0 col-span-2 opacity-80" />
            <div class="w-full relative mb-8">
                <TextInput
                    v-model="term"
                    :withSearch="true"
                    type="text"
                    label="Search"
                />
                <MagnifyIcon class="absolute left-3 top-1/2 -translate-y-1/2" />
            </div>
            <article class="w-full flex gap-4 flex-wrap">
                <TagOfList v-for="tag in tagsData" :tag="tag" :key="tag.id" />
            </article>
        </section>
        <button
            @click="isOpen = true"
            class="fixed flex justify-center items-center bottom-4 right-3 bg-[#4caf50] h-[56px] w-[56px] z-10 rounded-full text-white"
        >
            <PlusIcon />
        </button>
        <ModalCreateTag :show="isOpen" @close="handleClose" />
    </AuthenticatedLayout>
</template>
