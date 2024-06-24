<script setup>
import { defineProps, defineEmits } from "vue";
import Dropdown from 'primevue/dropdown';

const emits = defineEmits(["option_selected", "click_icon"]);

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
    options: {
        type: Array,
        required: true,
    },
    show_icon: {
        type: Boolean,
        default: false,
    },
});

const optionSelected = (val) => {
    emits("option_selected", val);
};

const clickIcon = (val) => {
    emits("click_icon", true);
};
</script>

<template>
    <div class="flex flex-col gap-2">
        <label  class="font-medium text-sm" :for="name">{{ label }}</label>
        <InputGroup class="flex items-center gap-2" >
            <Dropdown
                v-model="model[name]"
                :invalid="invalid[name]"
                @update:modelValue="optionSelected"
                :options="options"
                optionLabel="label"
                optionValue="value"
                placeholder="Seleccionar..."
                class="w-full md:w-14rem"
            />
            <i v-if="show_icon"
                class="text-xl cursor-pointer pi pi-eye border-blue-500 text-blue-500 hover:bg-blue-100"
                @click="clickIcon">
            </i>
        </InputGroup>
    </div>
</template>
