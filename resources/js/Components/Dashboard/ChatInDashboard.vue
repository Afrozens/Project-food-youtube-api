<script lang="ts" setup>
import TertiaryButton from "../ElementsPrimitive/TertiaryButton.vue";
import TextInput from "../ElementsPrimitive/TextInput.vue";
</script>

<template>
    <div class="w-full flex flex-col gap-4 mx-auto self-center lg:px-14">
        <div class="w-full h-[400px] bg-white rounded-md py-8 px-6">
            <h4 class="text-minus-base normal-case font-semibold text-center">
                No hay comentarios
            </h4>
        </div>
        <div class="h-[150px] w-full bg-white rounded-md p-4">
            <form class="w-full h-full">
                <div class="relative mb-8 w-full">
                    <TextInput
                        :label="'Comments'"
                        :is-required="true"
                        type="text"
                        autofocus
                    />
                </div>
                <div
                    class="self-end w-full flex gap-4 justify-center items-center"
                >
                    <TertiaryButton class="bg-green-600">
                        Comentar</TertiaryButton
                    >
                    <TertiaryButton class="bg-red-600">
                        Restaurar</TertiaryButton
                    >
                </div>
            </form>
        </div>
    </div>
</template>
