<script setup>
import { computed } from "vue";

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    description: {
        type: String,
        default: ""
    },
    button_title: {
        type: String,
        default: "Guardar"
    },
    is_processing: {
        type: Boolean,
        default: true
    },
    is_modal: {
        type: Boolean,
        default: false
    },
});

const emits = defineEmits(["submit"]);

const sizeWidth = computed(() => !props.is_modal ? 'max-w-7xl' : 'max-w-lg');


const submit = (val) => {
    emits("submit", val);
};
</script>

<template>
    <div class="mx-auto px-4 lg:px-8 w-full" :class="sizeWidth">
        <div class="bg-white rounded-lg p-6 lg:p-8 w-full">
            <h2 class="font-medium text-lg text-gray-800 leading-tight">{{ title }}</h2>
            <p class="font-normal text-sm py-2"> {{ description }}</p>

                <form @submit.prevent="submit">
                    <div  class="flex flex-col gap-6">
                        <div class="flex w-full gap-6 lg:gap-6 flex-col pt-4">
                            <slot name="form"/>
                        </div>
                        <!-- <div class="card flex justify-content-center"> -->
                        <div class="flex flex-row justify-between items-center">
                            <slot name="remember"/>
                            <Button type="submit" @click="false" :label="button_title" />
                            <!-- :disabled="is_processing" -->
                        </div>
                    </div>
                    <Divider />
                    <div class="flex w-full gap-6 lg:gap-6 flex-col">
                        <slot name="options"/>
                    </div>
                </form>
        </div>

    </div>
</template>
