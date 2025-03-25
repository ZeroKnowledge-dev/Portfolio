<template>
    <Navbar />
    <div class="flex min-h-screen bg-gray-50">
        <!-- Main Content -->
        <main class="flex-grow p-8">
            <!-- Header -->
            <header class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800">Dashboard</h2>
            </header>

            <!-- Dashboard Widgets -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Portfolio Views -->
                <Link :href="`/portfolio/${props.user.random_key}`" class="bg-white rounded-lg shadow-md p-6">

                <h3 class="text-xl font-semibold mb-4 text-gray-800">See Your Portfolio</h3>
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-500 mr-4" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <div>
                        <p class="text-3xl font-bold text-blue-500">Click Here to Watch</p>
                    </div>
                </div>
                </Link>
            </div>

            <!-- Quick Actions -->
            <div class="mt-8">
                <h3 class="text-2xl font-semibold mb-6 text-gray-800">Quick Actions</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-4 text-purple-600"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <h4 class="text-lg font-medium mb-2">Portfolio Link</h4>
                        <p class="text-sm text-gray-600 mb-4">
                            {{ `${appURL}/portfolio/${user.random_key}` }}
                        </p>
                        <button @click="copyToClipboard(`${appURL}/portfolio/${user.random_key}`)"
                            class="bg-purple-50 text-purple-600 px-4 py-2 rounded-lg hover:bg-purple-100">Copy</button>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script setup>
import Navbar from '@/Components/Application/Navbar.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    user: Object,
    appURL: String
})

// Copy function
const copyToClipboard = async function (text) {
    try {
        await navigator.clipboard.writeText(text);  // Using the Clipboard API
        alert('Link copied to clipboard!');
    } catch (err) {
        console.error('Failed to copy: ', err);
        alert('Failed to copy. Please try again.');
    }
};
</script>
