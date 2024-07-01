<script setup>
import { defineProps } from "vue";

import Password from 'primevue/password';

defineProps({
    label: {
        type: String,
        default: "",
        required: true,
    },
    model: {
        type: Object,
        required: true,
    },
    invalid: {
        type: Object,
        required: false,
        default: {}
    },
    name: {
        type: String,
        required: true,
    },
    is_password: {
        type: Boolean,
        default: false,
    },
    feedback_password: {
        type: Boolean,
        default: true,
    },
});
</script>

<template>
    <div class="flex flex-col gap-2">
        <label class="font-medium text-sm" :for="name">{{ label }}</label>

        <Password
            v-if="is_password"
            :id="name"
            v-model="model[name]"
            toggleMask
            :invalid="invalid[name]"
            :feedback="feedback_password"
            :weakLabel="'Débil'"
            :mediumLabel="'Medio'"
            :strongLabel="'Fuerte'"
        >
            <template #footer>
                <Divider />
                <ul class="pl-2 ml-2 my-0 leading-normal">
                    <li>Al menos una minúscula</li>
                    <li>Al menos una mayúscula</li>
                    <li>Al menos un número</li>
                    <li>Mínimo 8 caracteres</li>
                </ul>
            </template>
        </Password>

        <InputText
            v-if="!is_password"
            :id="name"
            v-model="model[name]"
            :invalid="invalid[name]"
        />

    </div>
</template>
