<script lang="ts" setup>
import { computed } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";
import ForumIcon from "vue-material-design-icons/Forum.vue";
import MessageTextIcon from "vue-material-design-icons/MessageText.vue";
import { MenuItem, Table } from "ant-design-vue";
import { columns } from "../../Setup/Admin/Chat";
import { ChatAdmin } from "../../types/chat";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Paginate from "@/Components/General/Paginate.vue";
import ButtonAction from "@/Components/Admin/ButtonAction.vue";

const props = defineProps({
    users: Object,
});

const data = computed(() => {
    return props.users as ChatAdmin;
});

const handleUsers = (page: number) => {
    const path = route("admin.chats.index");
    const data = {
        page: page,
    };
    router.get(path, {
        preserveState: (page) => Object.keys(page.props.errors).length,
    });
};
</script>

<template>
    <Head title="Mensajes" />

    <AuthenticatedLayout>
        <section
            class="min-h-screen w-full pl-4 pr-8 md:pl-16 md:pr-24 mt-8 overflow-x-hidden mb-5"
        >
            <header class="mb-4 w-full flex items-center justify-start gap-2">
                <ForumIcon :size="70" fillColor="#757575" />
                <span class="font-semibold text-2xl md:text-3xl">Mensajes</span>
            </header>
            <Table
                :columns="columns"
                class="mb-4 border border-slate-100"
                :pagination="false"
                :scroll="{ x: 750 }"
                :data-source="data.data"
                bordered
            >
                <template #bodyCell="{ column, record }">
                    <template v-if="column.key === 'action'">
                        <div class="flex justify-center items-center">
                            <ButtonAction>
                                <template #item-action>
                                    <MenuItem>
                                        <Link
                                            class="flex gap-2 justify-between items-center"
                                            :href="
                                                route('chats.edit', {
                                                    id: record.id,
                                                })
                                            "
                                        >
                                            <MessageTextIcon />
                                            <span class="word-break"
                                                >Ver Mensajes</span
                                            >
                                        </Link>
                                    </MenuItem>
                                </template>
                            </ButtonAction>
                        </div>
                    </template>
                </template>
            </Table>
            <Paginate
                @next="handleUsers"
                :current="data.current_page"
                :length="data.last_page"
            />
        </section>
    </AuthenticatedLayout>
</template>
