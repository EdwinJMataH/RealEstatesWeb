<script setup>
import Form from '@/Components/Form.vue';
</script>


<template>
    <Form 
        :title="'Datos Generales'" 
        :description="'Actualice la información del perfil y la dirección de correo electrónico de su cuenta.'">
        <template #form>
            <div class="pt-4 flex flex-col gap-4 lg:w-1/2">
                <div class="flex flex-col gap-2">
                    <label class="font-medium text-sm" for="username">Nombre</label>
                    <InputText id="username" v-model="value"/>
                </div>
            </div>
            <div class="pt-4 flex flex-col gap-4 lg:w-1/2">
                <div class="flex flex-col gap-2">
                    <label class="font-medium text-sm" for="email">Email</label>
                    <InputText id="email" v-model="value"/>
                </div>
            </div>
        </template>
    </Form>
</template>