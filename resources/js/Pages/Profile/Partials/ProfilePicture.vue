<script setup>
import Form from '@/Components/Form.vue';
import Alert from "@/Components/Alert.vue";
import FileUploadIndividual from "@/Components/FileUploadIndividual.vue";
import { useStoreProfileImage } from "@/Pages/Profile/Store/useStoreProfileImage.js";
import { useStoreProfile } from "@/Pages/Profile/Store/useStoreProfile.JS";
const storeProfile = useStoreProfile();
const storeImage   = useStoreProfileImage();
const { model } = storeToRefs(storeImage);
const alerts  = ref([]);

const upload = async (image) => {
    model.value.image      = image.base64;
    model.value.image_send = image.file;

    await storeImage.update( async(response) => {
        const { severity, detail, status } = response;
        alerts.value = [];
        alerts.value.push({ severity: severity, detail: detail })

        if (status) await storeProfile.show();

        if (!status) {
            setTimeout(() => {
                storeImage.clearModel();
            }, 1000);
        }
    });
};
</script>


<template>
    <Alert :alerts="alerts" />
    <Form
        :title="'Actualizar imagen de perfil'"
        :show_submit="false"
        :description="'Personaliza tú pefil con una imagen.'">
        <template #form>
            <FileUploadIndividual @upload="upload" :maxFileSizeMB="4" :image="model.image"/>
        </template>
    </Form>
</template>
