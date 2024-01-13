<script lang="ts" setup>
import { ref, provide } from "vue";
import { Head, router, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
// @ts-ignore - iconos sin typings
import VideoIcon from "vue-material-design-icons/Video.vue";
import FormField from "@/Components/General/FormField.vue";
import UrlYoutube from "@/Components/Admin/UrlYoutube.vue";
import CustomSelect from "@/Components/ElementsPrimitive/CustomSelect.vue";
import PrimaryButton from "@/Components/ElementsPrimitive/PrimaryButton.vue";
import WysywygField from "@/Components/General/WysywygField.vue";
import Loader from "@/Components/General/Loader.vue";
import { toast } from "vue3-toastify";
interface Tags {
    data: [];
}
defineProps<{
    tags: Tags;
}>();

const urlCurrent = ref("");
const videoId = ref("");
const verifyUrl = ref(false);

const form = useForm({
    title: "",
    tags: [],
    videoId: "",
    description: "",
});

const handleSend = () => {
    form.clearErrors();
    const path = route("admin.videos.store");
    form.videoId = videoId.value;
    form.post(path, {
        forceFormData: true,
        onSuccess: () => {
            toast("Has creado con exito un video", {
                autoClose: 1000,
                position: "top-right",
                type: "success",
            });
            router.get(route("admin.videos.index"));
        },
        onError: (res) => {
            toast("No se pudo crear un video", {
                autoClose: 1000,
                position: "top-right",
                type: "error",
            });
            console.log(res);
        },
    });
};

provide("videoId", videoId);
provide("urlCurrent", urlCurrent);
provide("verifyUrl", verifyUrl);
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
                    >Nuevo Video</span
                >
            </header>
            <Transition>
                <UrlYoutube :url="urlCurrent" :open="true" />
            </Transition>
            <Transition name="list">
                <form
                    @submit.prevent="handleSend"
                    v-if="verifyUrl"
                    class="w-full flex flex-col"
                >
                    <FormField
                        class="my-6"
                        type="text"
                        :label="'Titulo'"
                        :is-required="true"
                        v-model="form.title"
                        :error="form.errors.title"
                    />

                    <CustomSelect
                        :model-value="form.tags"
                        @update:modelValue="form.tags = $event"
                        :options="tags?.data"
                        label="Tags"
                        title="name"
                        :is-required="true"
                        :is-multiple="true"
                        :withWhite="true"
                        style="margin-bottom: 24px"
                    />
                    <WysywygField
                        :modelValue="form.description"
                        @update:modelValue="form.description = $event"
                    />
                    <PrimaryButton
                        @click.prevent="handleSend"
                        type="button"
                        class="mb-2 bg-primary self-center w-56 mt-4 capitalize"
                        :class="{
                            'bg-gray-200 opacity-25': form.processing,
                        }"
                        :disabled="form.processing"
                    >
                        <Loader v-show="form.processing" />
                        <span v-show="!form.processing">Agregar</span>
                    </PrimaryButton>
                </form>
            </Transition>
        </section>
    </AuthenticatedLayout>
</template>
