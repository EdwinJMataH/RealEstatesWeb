<script setup>
import Form from '@/Components/Form.vue';
import Input from "@/Components/Input.vue";
import { useStoreProfile } from "../Store/useStoreProfile.js";

const storeProfile = useStoreProfile();
const { model, invalid } = storeToRefs(storeProfile);

</script>


<template>
    <Form
        :title="'Datos Generales'"
        :has_columns="true"
        :description="'Actualice la información del perfil y la dirección de correo electrónico de su cuenta.'">
        <template #form>
            <div class="lg:w-1/2">
                <Input
                    :label="'Nombre'"
                    :model="model"
                    :name="'name'"
                    :invalid="invalid"
                />
            </div>
            <div class="lg:w-1/2">
                <Input
                    :label="'Correo electrónico'"
                    :model="model"
                    :name="'email'"
                    :invalid="invalid"
                />
            </div>
        </template>
    </Form>
</template>
