<script setup>
import Form from '@/Components/Form.vue';
import Input from "@/Components/Input.vue";
import { useStoreProfile } from "../Store/useStoreProfile.js";

const storeProfile = useStoreProfile();
const { model, invalid } = storeToRefs(storeProfile);
</script>


<template>
    <Form
        :title="'Actualizar Contraseña'"
        :has_columns="true"
        :description="'Asegúrese de que su cuenta utilice una contraseña larga y aleatoria para mantenerse segura.'">
        <template #form>
            <div class="lg:w-1/2 space-y-6">
                <Input
                    :label="'Contraseña actual'"
                    :model="model"
                    :name="'current_password'"
                    :invalid="invalid"
                    :is_password="true"
                />
                <Input
                    :label="'Nueva contraseña'"
                    :model="model"
                    :name="'new_password'"
                    :invalid="invalid"
                    :is_password="true"
                />
            </div>
            <div class="lg:w-1/2 ">
                <Input
                    :label="'Repetir contraseña'"
                    :model="model"
                    :name="'repeat_password'"
                    :invalid="invalid"
                    :is_password="true"
                />
            </div>
        </template>
    </Form>
</template>
