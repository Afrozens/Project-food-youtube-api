<script lang="ts" setup>
import { ref, computed, onMounted } from "vue";
import { Head, router, Link } from "@inertiajs/vue3";
import { watchDebounced } from "@vueuse/core";
// @ts-ignore - iconos sin typings
import VideoIcon from "vue-material-design-icons/Video.vue";
// @ts-ignore - iconos sin typings
import MagnifyIcon from "vue-material-design-icons/Magnify.vue";
// @ts-ignore - iconos sin typings
import PlusIcon from "vue-material-design-icons/Plus.vue";
import { Video } from "@/types/video";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TextInput from "@/Components/ElementsPrimitive/TextInput.vue";
import Paginate from "@/Components/General/Paginate.vue";
import CardVideo from "@/Components/Admin/CardVideo.vue";
import CardVideoSkeleton from "@/Components/Admin/CardVideoSkeleton.vue";

const props = defineProps({
    videos: Object,
});

const term = ref("");
const isLoading = ref(false);

const data = computed(() => {
    return props.videos as Video;
});

onMounted(() => {
    const termStorage = localStorage.getItem("term");
    if (termStorage) {
        term.value = termStorage;
    }
});

const handleSearch = (page: number | null) => {
    const path = route("admin.videos.index");
    localStorage.setItem("term", term.value);
    router.get(
        path,
        {
            search: term.value,
            page: page,
        },
        {
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
        handleSearch(null);
    },
    { debounce: 500, maxWait: 1000 }
);

const numberSkeleton = 8;
</script>

<template>
    <Head title="Videos" />

    <AuthenticatedLayout>
        <section
            class="min-h-screen w-full pl-4 pr-8 md:pl-16 md:pr-24 mt-8 overflow-x-hidden mb-5 relative"
        >
            <header class="mb-4 w-full flex items-center justify-start gap-2">
                <VideoIcon :size="70" fillColor="#757575" />
                <span class="font-semibold text-2xl md:text-3xl"
                    >Listado de Videos</span
                >
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
            <article class="w-full" v-if="isLoading">
                <TransitionGroup
                    class="w-full px-4 grid mb-4 grid-cols-1 sm:gap-2 lg:grid-cols-2 md:gap-2 lg:gap-4 lg:px-6"
                    name="list"
                    tag="ul"
                >
                    <CardVideoSkeleton
                        v-if="isLoading"
                        v-for="index in numberSkeleton"
                        :key="index"
                    />
                </TransitionGroup>
            </article>
            <article
                v-if="videos?.data.length === 0"
                class="w-full flex justify-center items-center mb-5"
            >
                <span class="font-semibold text-center mx-auto"
                    >No se encontraron videos
                </span>
            </article>
            <Transition v-else>
                <article
                    class="w-full px-4 grid mb-4 grid-cols-1 sm:gap-2 lg:grid-cols-2 md:gap-2 lg:gap-4 lg:px-6"
                >
                    <CardVideo
                        v-for="videoData in data.data"
                        :key="videoData.id"
                        :video="videoData"
                    />
                </article>
            </Transition>
            <Paginate
                @next="handleSearch"
                :length="data.meta.last_page"
                :current="data.meta.current_page"
            />
            <Link :href="route('admin.videos.create')">
                <button
                    class="fixed flex justify-center items-center bottom-4 right-3 bg-[#4caf50] h-[56px] w-[56px] z-10 rounded-full text-white"
                >
                    <PlusIcon />
                </button>
            </Link>
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
