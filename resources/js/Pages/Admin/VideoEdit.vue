<script lang="ts" setup>
import { computed, ref, provide } from "vue";
import { Head, router, useForm } from "@inertiajs/vue3";
import VideoIcon from "vue-material-design-icons/Video.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import QuillField from "@/Components/General/QuillField.vue";
import { VideoData } from "@/types/video";
import FormField from "@/Components/General/FormField.vue";
import CustomSelect from "@/Components/ElementsPrimitive/CustomSelect.vue";
import UrlYoutube from "@/Components/Admin/UrlYoutube.vue";
import PrimaryButton from "@/Components/ElementsPrimitive/PrimaryButton.vue";
import Loader from "@/Components/General/Loader.vue";
import { toast } from "vue3-toastify";

const props = defineProps({
    tags: Object,
    video: Object,
});

const urlCurrent = ref("");
const videoId = ref("");

const data = computed(() => {
    if (props.video) return props.video.data as VideoData;
});
const form = useForm({
    tags: data.value?.has_more,
    videoId: "",
    title: data.value?.title,
    description: data.value?.description,
});

const handleSend = () => {
    const path = route("admin.videos.update", {
        video: data.value?.id,
    });
    form.videoId = videoId.value
        ? videoId.value
        : (data.value?.videoId as string);
    form.transform((data) => ({
        ...data,
        tags: form.tags?.map((tag) => tag.id),
        _method: "put",
    }));
    form.post(path, {
        preserveState: (page) => Object.keys(page.props.errors).length,
        forceFormData: true,
        onSuccess: () => {
            toast("Has editado con exito un video", {
                autoClose: 1000,
                position: "top-right",
                type: "success",
            });
            router.get(route("admin.videos.index"));
        },
        onError: () => {
            toast("No se pudo editar un video", {
                autoClose: 1000,
                position: "top-right",
                type: "error",
            });
        },
    });
};

provide("videoId", videoId);
provide("urlCurrent", urlCurrent);
</script>

<template>
    <Head title="Videos" />

    <AuthenticatedLayout>
        <section
            class="min-h-screen w-full pl-4 pr-8 md:pl-16 md:pr-24 mt-8 overflow-x-hidden mb-5 relative"
        >
            <header class="mb-4 w-full flex items-center justify-start gap-2">
                <VideoIcon :size="70" fillColor="#757575" />
                <span class="font-semibold text-3xl"
                    >Editar video: {{ data?.title }}</span
                >
            </header>
            <form @submit.prevent="handleSend" class="w-full flex flex-col">
                <Transition>
                    <UrlYoutube
                        :url="urlCurrent ? urlCurrent : data?.video_data.url"
                    />
                </Transition>
                <FormField
                    class="my-6"
                    type="text"
                    :label="'Titulo'"
                    :is-required="true"
                    v-model="form.title"
                    :error="form.errors.title"
                />
                <CustomSelect
                    :withWhite="true"
                    label="Tags"
                    title="id"
                    class="mb-6"
                    :model-value="form.tags"
                    @update:modelValue="form.tags = $event"
                    :options="tags?.data"
                    :is-required="true"
                    :is-multiple="true"
                />
                <QuillField
                    placeholder="Write your description..."
                    :modelValue="form.description"
                    @update:modelValue="form.description = $event"
                />
                <PrimaryButton
                    @click.prevent="handleSend"
                    class="mb-2 bg-primary self-center w-56 mt-4 capitalize"
                    :class="{
                        'bg-gray-200 opacity-25': form.processing,
                    }"
                    :disabled="form.processing"
                >
                    <Loader v-show="form.processing" />
                    <span v-show="!form.processing">Actualizar</span>
                </PrimaryButton>
            </form>
        </section>
    </AuthenticatedLayout>
</template>
