<script setup>
import Image from "primevue/image";
import Alert from "@/Components/Alert.vue";
import { ref, watch } from "vue";

const emit = defineEmits(["upload"]);
const props = defineProps({
    maxFileSizeMB: {
        type: Number,
        default: 1,
    },
    accept: {
        type: String,
        default: 'image/png, image/jpeg, image/jpg'
    },
    image: {
        type: String,
        default: 'placeholder.jpg',
    }
});
const mb        = 1048576;
const viewImage = ref("placeholder.jpg");
const alerts    = ref([]);
const inputFile = ref(null);


const onFileSelect = (event) => {
    let files    = event.target.files;
    let maxSize  = props.maxFileSizeMB * mb;
    alerts.value = [];

    if (!files.length) {
        alerts.value.push({ severity: 'warn', detail: 'No se han encontado archivos.' })
        return;
    }

    if (files[0].size > maxSize) {
        alerts.value.push({ severity: 'warn', detail: `${files[0].name}: Tiene un peso mayor de ${props.maxFileSizeMB}MB` })
        files = [];
        console.log("files", files);
        return;
    }

    showUpload(files[0]);
};

const showUpload = (file) => {
    const fileReader = new FileReader()

    fileReader.readAsDataURL(file)
    fileReader.onload = () => {

    if (typeof fileReader.result === 'string')
        viewImage.value = fileReader.result
        emit('upload', { base64: fileReader.result, file: file } )
    }
};

const onUpload = () => inputFile.value.click();

</script>
<template>
    <div class="flex justify-center items-center flex-col gap-8 w-full">
        <Alert :alerts="alerts" />
        <input type="file" ref="inputFile" class="hidden" @change="onFileSelect" :accept="accept" capture>
        <Image
            class="h-56 w-56"
            :src="props.image"
            alt="Image"
            width="50"
            height="50"
        />

        <Button type="button" label="Elegir" icon="pi pi-upload" :loading="false" @click="onUpload" />
    </div>
</template>
