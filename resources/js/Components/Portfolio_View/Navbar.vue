<script setup>
const props = defineProps({
    websiteLogo: String,
    websiteName: String
})
</script>

<template>
    <!-- Navbar -->
    <nav class="text-white navbar fixed w-full z-50 py-4 px-6">
        <div class="container mx-auto flex justify-between items-center">
            <a href="#" class="text-2xl font-bold code-font flex items-center" data-aos="fade-right">
                <img :src="`/storage/logos/${websiteLogo}`" alt="Website Logo" class="h-8 mr-2">
                <span class="ml-2">{{ websiteName }}</span>
            </a>

            <!-- Mobile menu button -->
            <button id="menu-toggle" class="md:hidden focus:outline-none">
                <i class="fas fa-bars text-xl"></i>
            </button>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex space-x-8 items-center">
                <a href="#hero" class="hover:text-purple-400 transition-colors duration-300" data-aos="fade-down"
                    data-aos-delay="100">Home</a>
                <a href="#about" class="hover:text-purple-400 transition-colors duration-300" data-aos="fade-down"
                    data-aos-delay="200">About</a>
                <a href="#projects" class="hover:text-purple-400 transition-colors duration-300" data-aos="fade-down"
                    data-aos-delay="300">Projects</a>
                <a href="#services" class="hover:text-purple-400 transition-colors duration-300" data-aos="fade-down"
                    data-aos-delay="400">Services</a>
                <a href="#contact" class="btn-primary px-6 py-2 rounded-full text-white font-medium"
                    data-aos="fade-left">Contact
                    Me</a>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div id="mobile-menu" class="md:hidden hidden bg-gray-900 mt-4 p-4 rounded-lg absolute left-0 right-0 mx-6">
            <div class="flex flex-col space-y-4">
                <a href="#hero" class="hover:text-purple-400 transition-colors duration-300">Home</a>
                <a href="#about" class="hover:text-purple-400 transition-colors duration-300">About</a>
                <a href="#projects" class="hover:text-purple-400 transition-colors duration-300">Projects</a>
                <a href="#services" class="hover:text-purple-400 transition-colors duration-300">Services</a>
                <a href="#contact" class="btn-primary px-6 py-2 rounded-full text-white font-medium text-center">Contact
                    Me</a>
            </div>
        </div>
    </nav>
</template>

<style scoped></style>
