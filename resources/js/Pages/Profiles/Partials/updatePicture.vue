<script setup>
import Form from '@/Components/Form.vue';
</script>


<template>
    <Form 
        :title="'Imagen de Perfil'" 
        :description="'Personaliza tú pefil con una imagen.'">
        <template #form>
            <div class="py-4 flex flex-col w-full">
                <FileUpload name="demo" url="/api/upload" @upload="onAdvancedUpload" @select="select" accept="image/*" :maxFileSize="1000000" chooseLabel="Seleccionar" uploadLabel="Guardar" cancelLabel="Cancelar">
                    <template #empty>
                        <p>Arrastre y suelte archivos aquí para cargarlos.</p>
                    </template>
                </FileUpload>
            </div>
        </template>
    </Form>
</template>