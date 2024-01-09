<script lang="ts" setup>
import { Head, Link, router, useForm } from "@inertiajs/vue3";
// @ts-ignore - iconos sin typings
import AccountMultiplePlusIcon from "vue-material-design-icons/AccountMultiplePlus.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import FormField from "@/Components/General/FormField.vue";
import PrimaryButton from "@/Components/ElementsPrimitive/PrimaryButton.vue";
import SecondaryButton from "@/Components/ElementsPrimitive/SecondaryButton.vue";
import { toast } from "vue3-toastify";

const form = useForm({
    name: "",
    nickname: "",
    email: "",
    password: "",
    password_confirmation: "",
});

const handleCreate = () => {
    form.clearErrors();
    const path = route("admin.users.store");
    form.post(path, {
        onError: () => {
            form.reset("password", "password_confirmation");
            toast("No se pudo crear el usuario", {
                autoClose: 1000,
                position: "top-right",
                type: "error",
            });
        },
        onSuccess: () => {
            toast("Has creado el usuario correctamente", {
                autoClose: 1000,
                position: "top-right",
                type: "success",
            });
            router.get(route("admin.users.index"));
        },
    });
};
</script>

<template>
    <Head title="Crear usuario" />
    <AuthenticatedLayout>
        <section
            class="h-[90vh] w-full overflow-x-hidden flex justify-center items-center px-4"
        >
            <div class="max-w-lg flex-grow shadow-md">
                <header
                    class="w-full flex justify-center items-center gap-2 bg-primary px-5 py-4 rounded-t-md"
                >
                    <AccountMultiplePlusIcon fillColor="#fff" />
                    <span class="text-white text-xl">Crear Usuario</span>
                </header>
                <form
                    @submit.prevent="handleCreate"
                    class="bg-white rounded-b-md px-4 py-5 flex flex-col gap-5"
                >
                    <div
                        class="w-full flex-col md:flex-row flex gap-4 items-center"
                    >
                        <FormField
                            id="name"
                            type="text"
                            label="Nombre"
                            :is-required="true"
                            v-model="form.name"
                            :error="form.errors.name"
                        />

                        <FormField
                            id="nickname"
                            type="text"
                            label="Apodo"
                            :is-required="true"
                            v-model="form.nickname"
                            :error="form.errors.nickname"
                        />
                    </div>

                    <FormField
                        id="email"
                        type="email"
                        v-model="form.email"
                        label="Correo eléctronico"
                        :is-required="true"
                        :error="form.errors.email"
                    />

                    <FormField
                        id="password"
                        type="password"
                        label="Contraseña"
                        v-model="form.password"
                        :is-required="true"
                        :error="form.errors.password"
                    />

                    <FormField
                        class="-mb-2"
                        id="password_confirmation"
                        type="password"
                        v-model="form.password_confirmation"
                        label="Confirma contraseña"
                        :is-required="true"
                        :error="form.errors.password_confirmation"
                    />
                    <div class="w-full flex gap-2">
                        <PrimaryButton
                            @click.prevent="handleCreate"
                            type="button"
                            class="capitalize w-full mt-4"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Crear
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
