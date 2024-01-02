<script lang="ts" setup>
import { ref, onMounted } from "vue";
import { Head, router, useForm, Link } from "@inertiajs/vue3";
import { MenuItem, Table } from "ant-design-vue";
import { toast } from "vue3-toastify";
import AccountIcon from "vue-material-design-icons/Account.vue";
import PlusIcon from "vue-material-design-icons/Plus.vue";
import MagnifyIcon from "vue-material-design-icons/Magnify.vue";
import CogRefreshOutlineIcon from "vue-material-design-icons/CogRefreshOutline.vue";
import DeleteIcon from "vue-material-design-icons/Delete.vue";
import EditIcon from "vue-material-design-icons/AccountEdit.vue";
import { columns } from "../../Setup/Admin/User";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TextInput from "@/Components/ElementsPrimitive/TextInput.vue";
import CustomSimpleSelect from "@/Components/ElementsPrimitive/CustomSimpleSelect.vue";
import PrimaryButton from "@/Components/ElementsPrimitive/PrimaryButton.vue";
import Paginate from "@/Components/General/Paginate.vue";
import ButtonAction from "@/Components/Admin/ButtonAction.vue";
import ModalDelete from "@/Components/Modals/ModalDelete.vue";
import Loader from "@/Components/General/Loader.vue";

const props = defineProps({
    users: Object,
    search: String,
    type: String,
});

const isLoading = ref(false);
const isOpenDelete = ref(false);

const form = useForm({
    search: "",
    type: [] as (
        | {
              type: string;
              value: null;
          }
        | {
              type: string;
              value: string;
          }
    )[],
});

onMounted(() => {
    if (props.search || props.type) {
        const type = optionsForSelect.filter(
            (option) => option.value === props.type
        );
        //Vue select type not default value
        form.type = type;
        console.log(type, "pepe");
        form.search = props.search as string;
    }
});

const handleCloseDelete = () => {
    isOpenDelete.value = false;
};

const optionsForSelect = [
    { type: "todos", value: null },
    { type: "solo usuarios", value: "user" },
    { type: "solo administradores", value: "admin" },
];

const handleChangeAdmin = (id: number) => {
    const path = route("admin.users.to_admin", {
        user: id,
    });
    router.put(
        path,
        {
            data: {
                _method: "put",
            },
            preserveState: (page) => Object.keys(page.props.errors).length,
        },
        {
            onStart: () => {
                isLoading.value = true;
            },
            onSuccess: () => {
                toast("Haz cambiado el rol con exito", {
                    autoClose: 1000,
                    position: "top-right",
                    type: "success",
                });
                isLoading.value = false;
            },
            onError: () => {
                toast("Hubo un error al cambiar el rol del usuario", {
                    autoClose: 1000,
                    position: "top-right",
                    type: "error",
                });
                isLoading.value = false;
            },
        }
    );
};

const handleGetUsers = (page: number | null) => {
    const path = route("admin.users.index");
    localStorage.setItem("type", JSON.stringify(form.type));
    form.transform((data) => ({
        ...data,
        type: form.type[0].value,
        page,
    }));

    form.get(path, {
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
    });
};
</script>

<template>
    <Head title="Usuarios" />

    <AuthenticatedLayout>
        <section
            class="min-h-screen w-full pl-4 pr-8 md:pl-16 md:pr-24 mt-8 overflow-x-hidden mb-5"
        >
            <header class="mb-4 w-full flex items-center justify-start gap-2">
                <AccountIcon :size="70" fillColor="#757575" />
                <span class="font-semibold text-2xl md:text-3xl">Usuarios</span>
            </header>
            <form
                @submit.prevent="handleGetUsers(null)"
                class="w-full flex-col flex lg:flex-row gap-3 mb-3 items-center"
            >
                <div class="w-full relative">
                    <TextInput
                        v-model="form.search"
                        type="text"
                        :withSearch="true"
                        label="Buscar"
                    />
                    <MagnifyIcon
                        class="absolute left-3 top-1/2 -translate-y-1/2"
                    />
                </div>
                <CustomSimpleSelect
                    :model-value="form.type"
                    @update:modelValue="form.type = $event"
                    :options="optionsForSelect"
                    class="lg:w-2/3"
                    label="Tipo"
                    title="type"
                />
                <PrimaryButton
                    :disabled="form.processing"
                    :class="{ 'bg-gray-200': form.processing }"
                    class="w-28 h-[44px] bg-sky-500"
                >
                    <span
                        v-show="!form.processing"
                        class="flex items-center gap-1"
                    >
                        <MagnifyIcon />
                        Buscar
                    </span>
                    <Loader v-show="form.processing" />
                </PrimaryButton>
            </form>
            <article class="w-full">
                <Table
                    :columns="columns"
                    class="mb-4 z-10 border border-slate-100"
                    :dataSource="users?.data"
                    :pagination="false"
                    :scroll="{ x: 750 }"
                    bordered
                >
                    <template #bodyCell="{ column, record }">
                        <template v-if="column.key === 'action'">
                            <div class="flex justify-center items-center">
                                <ButtonAction>
                                    <template #item-action>
                                        <MenuItem>
                                            <button
                                                @click="
                                                    handleChangeAdmin(record.id)
                                                "
                                                class="flex gap-2 justify-between items-center"
                                            >
                                                <CogRefreshOutlineIcon />
                                                <span class="word-break">{{
                                                    record.is_admin
                                                        ? "Quitar Administrador"
                                                        : "Agregar Administrador"
                                                }}</span>
                                            </button>
                                        </MenuItem>
                                        <MenuItem>
                                            <Link
                                                :href="
                                                    route('admin.users.edit', {
                                                        user: record.id,
                                                    })
                                                "
                                                class="flex gap-2 items-center"
                                            >
                                                <EditIcon />
                                                <span class="word-break"
                                                    >Editar</span
                                                >
                                            </Link>
                                        </MenuItem>
                                        <MenuItem>
                                            <button
                                                @click="isOpenDelete = true"
                                                class="flex gap-2 justify-between items-center"
                                            >
                                                <DeleteIcon />
                                                <span class="word-break"
                                                    >Eliminar</span
                                                >
                                            </button>
                                        </MenuItem>
                                        <ModalDelete
                                            v-if="isOpenDelete"
                                            routeDelete="admin.users.destroy"
                                            module="user"
                                            :show="isOpenDelete"
                                            @close="handleCloseDelete"
                                            :id="(record.id as number)"
                                            title="¿Seguro que desea eliminar este usuario?"
                                        />
                                    </template>
                                </ButtonAction>
                            </div>
                        </template>
                    </template>
                </Table>
                <Paginate
                    @next="handleGetUsers"
                    :current="users?.current_page"
                    :length="users?.last_page"
                />
            </article>
            <Link
                :href="route('admin.users.create')"
                class="fixed flex justify-center items-center bottom-4 right-3 bg-[#4caf50] h-[56px] w-[56px] z-10 rounded-full text-white"
            >
                <PlusIcon />
            </Link>
        </section>
    </AuthenticatedLayout>
</template>
