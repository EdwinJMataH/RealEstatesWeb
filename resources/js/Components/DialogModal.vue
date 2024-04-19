<script setup>
import { defineProps, defineEmits } from "vue";
import { modalDimensions } from "@/helpers.js";

const emits = defineEmits(["update:is_dialog_visible"]);

const props = defineProps({
    is_dialog_visible: {
        type: Boolean,
        default: false,
    },
});

const hideDialog = () => {
    emits("update:is_dialog_visible", false);
};


</script>

<template>
    <div class="card flex justify-content-center">
        <Dialog
            :visible="props.is_dialog_visible"
            modal
            @update:visible="hideDialog"
            header="Edit Profile"
            :style="modalDimensions"
        >

            <form action="" method="POST">
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
                    <Button type="button" label="Guardar" @click="false"></Button>
                </div>
            </form>
        </Dialog>
    </div>
</template>
