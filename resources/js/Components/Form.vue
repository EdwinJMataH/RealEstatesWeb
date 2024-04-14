<script setup>
defineProps({
    title: {
        type: String,
        required: true,
    },
    description: {
        type: String,
        default: ""
    },
});
</script>

<template>
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="bg-white rounded-lg p-6 lg:p-8">
            <h2 class="font-medium text-lg text-gray-800 leading-tight">{{ title }}</h2>
            <p class="font-normal text-sm py-2"> {{ description }}</p>

                <form action="" method="POST">
                    <div class="flex w-full lg:gap-6 flex-col lg:flex-row">
                        <slot name="form"></slot>

                    </div>

                    <div class="card flex justify-content-center pt-4">
                        <Button label="Guardar" />
                    </div>
                </form>
        </div>
    
    </div>
</template>
