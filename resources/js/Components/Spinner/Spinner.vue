
<script setup>
import ProgressSpinner from 'primevue/progressspinner';
import { useStoreSpinner } from "./Store/useStoreSpinner.js";
const storeSpinner = useStoreSpinner();
const { visible } = storeToRefs(storeSpinner);


</script>
<template >
    <div v-if="visible" class="fixed top-0 left-0 z-[100] bg-white opacity-70 w-screen h-screen overflow-hidden flex items-center spinner-dev">
        <!-- <ProgressSpinner /> -->
        <ProgressSpinner style="width: 150px; height: 150px; stroke: #ff0000" strokeWidth="3"
        class="text-red-600"
    animationDuration=".5s" aria-label="Custom ProgressSpinner" />
    </div>
</template>

<style scoped>

    .spinner-dev {

        z-index: 10 !important;
    }

</style>

