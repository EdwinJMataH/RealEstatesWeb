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
            :feedback="false"
        />

        <InputText
            v-if="!is_password"
            :id="name"
            v-model="model[name]"
            :invalid="invalid[name]"
        />

    </div>
</template>
