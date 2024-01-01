<script lang="ts" setup>
import { Head, Link, router, useForm } from "@inertiajs/vue3";
import PencilIcon from "vue-material-design-icons/Pencil.vue";
import { toast } from "vue3-toastify";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import FormField from "@/Components/General/FormField.vue";
import PrimaryButton from "@/Components/ElementsPrimitive/PrimaryButton.vue";
import SecondaryButton from "@/Components/ElementsPrimitive/SecondaryButton.vue";

const props = defineProps({
    user: Object,
});

const form = useForm({
    name: props.user?.name,
    nickname: props.user?.nickname,
    email: props.user?.email,
});

const handleUpdate = () => {
    if (props.user) {
        form.clearErrors();
        const path = route("admin.users.update", {
            user: props.user.id,
        });

        form.transform((data) => ({
            ...data,
            _method: "put",
        }));

        form.post(path, {
            preserveState: (page) => Object.keys(page.props.errors).length,
            onSuccess: () => {
                toast("Has editado el usuario correctamente", {
                    autoClose: 1000,
                    position: "top-right",
                    type: "success",
                });
                router.get(route("admin.users.index"));
            },
            onError: () => {
                toast("No se pudo editar el usuario", {
                    autoClose: 1000,
                    position: "top-right",
                    type: "error",
                });
            },
        });
    }
};
</script>

<template>
    <Head :title="`Editar ${user?.name}`" />
    <AuthenticatedLayout>
        <section
            class="h-[90vh] w-full overflow-x-hidden flex justify-center items-center px-4"
        >
            <div class="max-w-lg flex-grow shadow-md">
                <header
                    class="w-full flex justify-center items-center gap-2 bg-primary px-5 py-4 rounded-t-md"
                >
                    <PencilIcon fillColor="#fff" />
                    <span class="text-white text-xl"
                        >Editar Usuario: {{ user?.name }}</span
                    >
                </header>
                <form
                    @submit.prevent="handleUpdate"
                    class="bg-white rounded-b-md px-4 py-5 flex flex-col gap-5"
                >
                    <FormField
                        id="name"
                        type="text"
                        :label="$t('message.components.name')"
                        :is-required="true"
                        v-model="form.name"
                        :error="form.errors.name"
                    />

                    <FormField
                        id="nickname"
                        type="text"
                        :label="$t('message.components.nickname')"
                        :is-required="true"
                        v-model="form.nickname"
                        :error="form.errors.nickname"
                    />
                    <FormField
                        id="email"
                        class="mb-5"
                        type="email"
                        v-model="form.email"
                        :label="$t('message.components.email')"
                        :is-required="true"
                        :error="form.errors.email"
                    />
                    <div class="w-full flex gap-2">
                        <PrimaryButton
                            type="button"
                            @click.prevent="handleUpdate"
                            class="capitalize w-full mt-4"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Editar
                        </PrimaryButton>
                        <SecondaryButton
                            class="capitalize w-full mt-4 bg-gray-200"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            <Link
                                class="w-full"
                                :href="route('admin.users.index')"
                            >
                                Cancelar
                            </Link>
                        </SecondaryButton>
                    </div>
                </form>
            </div>
        </section>
    </AuthenticatedLayout>
</template>
