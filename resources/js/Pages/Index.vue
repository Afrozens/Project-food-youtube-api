<script lang="ts" setup>
import { Head, router, useForm } from "@inertiajs/vue3";
// @ts-ignore - iconos sin typings
import FoodVariantIcon from "vue-material-design-icons/FoodVariant.vue";
// @ts-ignore - iconos sin typings
import FoodVariantOffIcon from "vue-material-design-icons/FoodVariantOff.vue";
// @ts-ignore - iconos sin typings
import MagnifyIcon from "vue-material-design-icons/Magnify.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/ElementsPrimitive/PrimaryButton.vue";
import CustomSelect from "@/Components/ElementsPrimitive/CustomSelect.vue";
import Card from "@/Components/Video/Card.vue";
import CardSkeleton from "@/Components/Video/CardSkeleton.vue";
import { HasOrExcept, Video } from "@/types/video";
import Loader from "@/Components/General/Loader.vue";
import Paginate from "@/Components/General/Paginate.vue";
import { ref } from "vue";
import Banner from "@/Components/General/Banner.vue";

interface Tags {
    data: [];
}

const props = defineProps<{
    tags: Tags;
    videos?: Video;
    has?: number[];
    except?: number[] | null;
    last_page?: number;
    current_page?: number;
}>();

const isLoading = ref(false);

const form = useForm({
    has: [] as HasOrExcept[],
    except: [] as HasOrExcept[],
});

const handleSend = () => {
    const path = route("videos.index");
    form.get(path);
};

const handleNext = (page: number) => {
    const path = route("videos.index");
    const data = {
        has: props.has,
        except: props.except,
        page: page,
    };
    router.visit(path, {
        method: "get",
        data: data as any,
        onStart: () => {
            isLoading.value = true;
        },
        onError: () => {
            isLoading.value = false;
        },
        onFinish: () => {
            isLoading.value = false;
        },
    });
};

const numberSkeleton = 8;
</script>

<template>
    <Head title="Inicio" />

    <AuthenticatedLayout>
        <header
            class="px-14 w-full pb-14 py-20 bg-primary bg-index-background bg-cover bg-no-repeat object-cover flex gap-4 items-center flex-col md:flex-row justify-between rounded-b-xl"
        >
            <div
                class="w-full flex-col self-center pb-4 md:pb-0 flex-grow gap-4 flex lg:flex-row justify-between"
            >
                <div class="relative w-full self-end">
                    <div
                        class="absolute inset-y-0 left-4 flex items-center pr-3 pointer-events-none z-40"
                    >
                        <FoodVariantIcon :size="30" fillColor="#4BB543" />
                    </div>
                    <CustomSelect
                        :model-value="form.has"
                        @update:modelValue="form.has = $event"
                        :options="tags?.data"
                        label="¿Qué debe contener?"
                        title="name"
                        :is-required="true"
                        :is-multiple="true"
                    />
                </div>
                <div class="relative w-full self-end">
                    <div
                        class="absolute inset-y-0 left-4 flex items-center pr-3 pointer-events-none z-40"
                    >
                        <FoodVariantOffIcon :size="30" fillColor="#FF000a" />
                    </div>
                    <CustomSelect
                        :model-value="form.except"
                        @update:modelValue="form.except = $event"
                        :options="tags?.data"
                        label="¿Qué no debe contener?"
                        title="name"
                        :is-required="true"
                        :is-multiple="true"
                    />
                </div>
            </div>
            <PrimaryButton
                @click.prevent="handleSend"
                :class="{ 'bg-gray-200': form.processing }"
                :disabled="form.processing"
                class="w-28 h-[48.21px] bg-sky-500"
            >
                <span v-show="!form.processing" class="flex items-center gap-1">
                    <MagnifyIcon />
                    Buscar
                </span>
                <Loader v-show="form.processing" />
            </PrimaryButton>
        </header>

        <hr class="h-px my-5 bg-gray-300 border-0 col-span-2" />

        <!-- Loader skeleton for cards in video -->
        <section class="w-full" v-if="form.processing || isLoading">
            <TransitionGroup
                class="w-full px-4 grid mb-4 grid-cols-1 sm:gap-2 md:grid-cols-3 md:gap-2 lg:grid-cols-4 lg:gap-4 lg:px-6"
                name="list"
                tag="ul"
            >
                <CardSkeleton
                    v-if="form.processing || isLoading"
                    v-for="index in numberSkeleton"
                    :key="index"
                />
            </TransitionGroup>
        </section>

        <!-- really data for cards in video -->
        <Transition
            v-if="
                videos &&
                !form.processing &&
                !isLoading &&
                videos.data.length > 0
            "
            enter-active-class="ease-out duration-300"
            enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            enter-to-class="opacity-100 translate-y-0 sm:scale-100"
            leave-active-class="ease-in duration-200"
            leave-from-class="opacity-100 translate-y-0 sm:scale-100"
            leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        >
            <section class="w-full">
                <TransitionGroup
                    class="w-full px-4 grid mb-4 grid-cols-1 sm:gap-2 md:grid-cols-3 md:gap-2 lg:grid-cols-4 lg:gap-4 lg:px-6"
                    name="list"
                    tag="ul"
                >
                    <Card
                        v-if="!form.processing && !isLoading"
                        class="mb-5 md:mb-0"
                        v-for="dataIn in videos.data"
                        :key="dataIn.id"
                        :dataIn="dataIn"
                    />
                </TransitionGroup>
                <Paginate
                    @next="handleNext"
                    :length="last_page"
                    :current="current_page"
                />
            </section>
        </Transition>
        <section
            v-else-if="
                !form.processing && !isLoading && videos?.data.length === 0
            "
            class="mt-5 w-full flex justify-center items-center"
        >
            <span class="text-center text-lg font-medium">
                No se encontraron videos.
            </span>
        </section>
        <Banner v-if="videos?.data || videos?.data.length === 0" />
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
