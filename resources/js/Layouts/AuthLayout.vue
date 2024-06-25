<script setup>
import { Head } from "@inertiajs/vue3";
import Alert from "@/Components/Alert.vue";

const props = defineProps({
    title: {
        type: String,
        default: "",
        required: true,
    },
    alerts: {
        type: Array,
        default: []
    },
});
</script>
<template>
    <Alert :alerts="props.alerts" />

    <Head :title="props.title" />

    <main class="bg-gray-600 w-screen h-screen overflow-hidden flex justify-center">
        <!-- <section class="form-side w-0 lg:w-4/6 xl:w-3/4 h-full">
            <img
                src="storage/BannerAuth.jpg"
                :alt="`Banner Auth`"
            />
        </section> -->
        <section class="w-full h-full flex justify-center content-center items-center">
            <slot name="content" />
        </section>
    </main>
</template>
