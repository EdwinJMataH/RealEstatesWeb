<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { Link } from "@inertiajs/vue3";

const page = usePage();
const appName = computed(() => page.props.appName);
</script>


<template>
      <footer class="py-4 border-b-slate-200 border-t">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            <div class="flex justify-between items-center ">
                <span class="text-center">
                    &copy;
                    {{ new Date().getFullYear() }}
                    Made With
                    <i class="pi pi-heart-fill" style="color: red"></i>
                    By
                    <a
                        href="https://github.com/EdwinJMataH?tab=repositories"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="text-primary-500"
                    >Edwin Mata</a>
                </span>
                <span class="text-center text-primary-500">
                    <Link :href="route('dashboard')">
                        {{ appName }}
                    </Link>
                </span>
            </div>
        </div>
    </footer>
</template>

