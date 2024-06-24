<script setup>
import { defineProps, defineEmits } from "vue";
import { modalDimensions } from "@/helpers.js";

const emits = defineEmits(["update:is_dialog_visible", "submit"]);

const props = defineProps({
    is_dialog_visible: {
        type: Boolean,
        default: false,
    },
    is_disabled: {
        type: Boolean,
        default: true,
    },
    title: {
        type: String,
        default: 'Modal',
    },
});

const hideDialog = () => {
    emits("update:is_dialog_visible", false);
};

const submit = (val) => {
    emits("submit", val);
};


</script>

<template>
    <div class="card flex justify-content-center">
        <Dialog
            :visible="props.is_dialog_visible"
            modal
            @update:visible="hideDialog"
            :header="props.title"
            :style="modalDimensions"
        >

            <form @submit.prevent="submit">
                <div class="flex w-full gap-4 flex-col">
                    <slot name="form"></slot>

                </div>


                <div class="flex justify-end gap-2 mt-8">
                    <Button
                        type="button"
                        label="Cancelar"
                        severity="secondary"
                        @click="hideDialog"
                    ></Button>
                    <Button type="submit" label="Guardar" @click="false" :disabled="props.is_disabled" ></Button>
                </div>
            </form>
        </Dialog>
    </div>
</template>
