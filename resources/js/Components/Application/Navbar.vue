<template>
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo Section -->
                <div class="flex items-center">
                    <Link href="/" class="flex-shrink-0 flex items-center">
                    <span class="text-xl font-bold text-gray-800">
                        PortfolioBuilder
                    </span>
                    </Link>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-center space-x-4">
                        <template v-for="(item, index) in menuItems" :key="index">
                            <Link v-if="!item.dropdown" :href="item.link" :class="[
                                currentRoute === item.link
                                    ? 'bg-gray-100 text-gray-900'
                                    : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900',
                                'px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200'
                            ]">
                            {{ item.label }}
                            </Link>

                            <!-- Dropdown Menu -->
                            <div v-else class="relative" @mouseenter="item.isOpen = true"
                                @mouseleave="item.isOpen = false">
                                <button :class="[
                                    item.isOpen
                                        ? 'bg-gray-100 text-gray-900'
                                        : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900',
                                    'px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 flex items-center'
                                ]">
                                    {{ item.label }}
                                    <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <transition enter-active-class="transition ease-out duration-200"
                                    enter-from-class="opacity-0 translate-y-1"
                                    enter-to-class="opacity-100 translate-y-0"
                                    leave-active-class="transition ease-in duration-150"
                                    leave-from-class="opacity-100 translate-y-0"
                                    leave-to-class="opacity-0 translate-y-1">
                                    <div v-if="item.isOpen"
                                        class="absolute z-10 left-1/2 transform -translate-x-1/2 mt-3 px-2 w-screen max-w-xs sm:px-0">
                                        <div
                                            class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
                                            <div class="relative grid gap-6 bg-white px-5 py-6 sm:gap-8 sm:p-8">
                                                <Link v-for="(subItem, subIndex) in item.dropdownItems" :key="subIndex"
                                                    :href="subItem.link"
                                                    class="flex items-center p-3 -m-3 rounded-lg hover:bg-gray-50 transition ease-in-out duration-150">
                                                <div class="ml-4">
                                                    <p class="text-base font-medium text-gray-900">
                                                        {{ subItem.label }}
                                                    </p>
                                                    <p v-if="subItem.description" class="mt-1 text-sm text-gray-500">
                                                        {{ subItem.description }}
                                                    </p>
                                                </div>
                                                </Link>
                                            </div>
                                        </div>
                                    </div>
                                </transition>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Mobile Menu Toggle -->
                <div class="-mr-2 flex md:hidden">
                    <button @click="toggleMobileMenu" type="button"
                        class="bg-gray-100 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                        <span class="sr-only">Open main menu</span>
                        <svg v-if="!mobileMenuOpen" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg v-else class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <transition enter-active-class="transition duration-200 ease-out" enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100" leave-active-class="transition duration-100 ease-in"
            leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
            <div v-if="mobileMenuOpen" class="md:hidden">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                    <template v-for="(item, index) in menuItems" :key="index">
                        <Link v-if="!item.dropdown" :href="item.link" :class="[
                            currentRoute === item.link
                                ? 'bg-gray-100 text-gray-900'
                                : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900',
                            'block px-3 py-2 rounded-md text-base font-medium'
                        ]">
                        {{ item.label }}
                        </Link>

                        <!-- Mobile Dropdown -->
                        <div v-else class="relative">
                            <button @click="item.mobileOpen = !item.mobileOpen" :class="[
                                item.mobileOpen
                                    ? 'bg-gray-100 text-gray-900'
                                    : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900',
                                'w-full text-left px-3 py-2 rounded-md text-base font-medium flex justify-between items-center'
                            ]">
                                {{ item.label }}
                                <svg :class="[
                                    item.mobileOpen ? 'rotate-180' : '',
                                    'h-5 w-5 transform transition-transform duration-200'
                                ]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div v-if="item.mobileOpen" class="pl-4 mt-1 space-y-1">
                                <Link v-for="(subItem, subIndex) in item.dropdownItems" :key="subIndex"
                                    :href="subItem.link"
                                    class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                {{ subItem.label }}
                                <p v-if="subItem.description" class="text-xs text-gray-500">
                                    {{ subItem.description }}
                                </p>
                                </Link>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </transition>
    </nav>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
    menuItems: {
        type: Array,
        default: () => [
            { label: 'Hero', link: '/hero' },
            { label: 'Hero Profession', link: '/hero-profession' },
            { label: 'Hero Skill', link: '/hero-skill' },
            { label: 'About', link: '/about' },
            { label: 'About Skill', link: '/about-skill' },
            { label: 'Project', link: '/project' },
            { label: 'Services', link: '/service' }
        ]
    }
});

const mobileMenuOpen = ref(false);

const currentRoute = computed(() => usePage().url);

const toggleMobileMenu = () => {
    mobileMenuOpen.value = !mobileMenuOpen.value;
};
</script>
