<script setup>
import { ref, onMounted } from "vue";
import { Link } from "@inertiajs/vue3";
import useStoreModule from "@/Composables/useStoreModule.js";
const { index, itemsMenu } = useStoreModule();

const toggle = (event) => menu.value.toggle(event);
const items = ref([
    {
        label: 'Home',
        icon: 'pi pi-home'
    },
    {
        label: 'Features',
        icon: 'pi pi-star'
    },
    {
        label: 'Projects',
        icon: 'pi pi-search',
        items: [
            {
                label: 'Core',
                icon: 'pi pi-bolt',
                shortcut: '⌘+S'
            },
            {
                label: 'Blocks',
                icon: 'pi pi-server',
                shortcut: '⌘+B'
            },
            {
                label: 'UI Kit',
                icon: 'pi pi-pencil',
                shortcut: '⌘+U'
            },
            {
                separator: true
            },
            {
                label: 'Templates',
                icon: 'pi pi-palette',
                items: [
                    {
                        label: 'Apollo',
                        icon: 'pi pi-palette',
                        badge: 2
                    },
                    {
                        label: 'Ultima',
                        icon: 'pi pi-palette',
                        badge: 3
                    }
                ]
            }
        ]
    },
    {
        label: 'Contact',
        icon: 'pi pi-envelope',
        badge: 3
    }
]);
// const items2 = ref([
//     {
//         label: 'Profile',
//         icon: 'pi pi-user',
//         route: 'profile'
//     },
//     {
//         label: 'Usuarios',
//         icon: 'pi pi-users',
//         route: 'users.index'
//     },
//     {
//         label: 'Sign Out',
//         icon: 'pi pi-sign-out',
//         route: 'dashboard'
//     }
// ]);
const menu = ref(null);

onMounted(() => {
    index();
});
</script>

<template>
    <div class="flex flex-col h-screen">

    <header class="container-custom">
        <Menubar :model="items" class="container-content border-0 bg-white">
            <template #start >
                <div class="pr-8">
                    <Link :href="route('dashboard')">
                        <svg width="35" height="40" viewBox="0 0 35 40" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-8">
                            <path
                                d="M25.87 18.05L23.16 17.45L25.27 20.46V29.78L32.49 23.76V13.53L29.18 14.73L25.87 18.04V18.05ZM25.27 35.49L29.18 31.58V27.67L25.27 30.98V35.49ZM20.16 17.14H20.03H20.17H20.16ZM30.1 5.19L34.89 4.81L33.08 12.33L24.1 15.67L30.08 5.2L30.1 5.19ZM5.72 14.74L2.41 13.54V23.77L9.63 29.79V20.47L11.74 17.46L9.03 18.06L5.72 14.75V14.74ZM9.63 30.98L5.72 27.67V31.58L9.63 35.49V30.98ZM4.8 5.2L10.78 15.67L1.81 12.33L0 4.81L4.79 5.19L4.8 5.2ZM24.37 21.05V34.59L22.56 37.29L20.46 39.4H14.44L12.34 37.29L10.53 34.59V21.05L12.42 18.23L17.45 26.8L22.48 18.23L24.37 21.05ZM22.85 0L22.57 0.69L17.45 13.08L12.33 0.69L12.05 0H22.85Z"
                                class="fill-primary-500 dark:fill-primary-400"
                            />
                            <path
                                d="M30.69 4.21L24.37 4.81L22.57 0.69L22.86 0H26.48L30.69 4.21ZM23.75 5.67L22.66 3.08L18.05 14.24V17.14H19.7H20.03H20.16H20.2L24.1 15.7L30.11 5.19L23.75 5.67ZM4.21002 4.21L10.53 4.81L12.33 0.69L12.05 0H8.43002L4.22002 4.21H4.21002ZM21.9 17.4L20.6 18.2H14.3L13 17.4L12.4 18.2L12.42 18.23L17.45 26.8L22.48 18.23L22.5 18.2L21.9 17.4ZM4.79002 5.19L10.8 15.7L14.7 17.14H14.74H15.2H16.85V14.24L12.24 3.09L11.15 5.68L4.79002 5.2V5.19Z"
                                class="fill-surface-700 dark:fill-surface-0/80"
                            />
                        </svg>
                    </Link>
                </div>
            </template>
            <template #item="{ item, props, hasSubmenu, root }">
                <a v-ripple class="flex items-center" v-bind="props.action">
                    <span :class="item.icon" />
                    <span class="ml-2">{{ item.label }}</span>
                    <Badge v-if="item.badge" :class="{ 'ml-auto': !root, 'ml-2': root }" :value="item.badge" />
                    <span v-if="item.shortcut" class="ml-auto border border-surface-200 dark:border-surface-500 rounded-md bg-surface-100 dark:bg-surface-800 text-xs p-1">{{ item.shortcut }}</span>
                    <i v-if="hasSubmenu" :class="['pi pi-angle-down text-primary-500 dark:text-primary-400-500 dark:text-primary-400', { 'pi-angle-down ml-2': root, 'pi-angle-right ml-auto': !root }]"></i>
                </a>
            </template>
            <template #end>
                <div class="flex items-center gap-2">
                    <Avatar image="https://primefaces.org/cdn/primevue/images/avatar/amyelsner.png" shape="circle" @click="toggle" class="cursor-pointer"/>
                    <Menu :model="itemsMenu" ref="menu" popup>
                        <template #item="{ item, props }">
                            <Link v-ripple :href="route(item.route)" :target="item.target" v-bind="props.action">
                                <span :class="item.icon" />
                                <span class="ml-2">{{ item.label }}</span>
                            </Link>
                        </template>
                    </Menu>
                </div>
            </template>
        </Menubar>
    </header>

    <div class="border-b-slate-200 border-y container-custom">
        <div class="container-content">
            <h1 class="font-semibold text-xl text-gray-800 leading-tight py-4 ">
                <slot name="title"></slot>
            </h1>
        </div>
    </div>

    <main class="py-10 bg-slate-100 flex-grow">
        <div class="container-custom space-y-16">
            <slot name="content"></slot>
        </div>
    </main>

    <footer class="py-4 border-b-slate-200 border-t">
        <div class="flex flex-col md:flex-row justify-center gap-1 content-center">
            <p class="text-center">Copyright © 2024</p>
            <p class="text-center">All right reserved by HOLA</p>
        </div>
    </footer>
</div>

</template>