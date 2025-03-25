<script setup>
const props = defineProps({
    services: Array
})
</script>

<template>
    <!-- Services Section -->
    <section id="services" class="text-white relative py-24 bg-[var(--background-color)] px-6">
        <div class="container mx-auto text-center">
            <h2 class="text-lg text-purple-400 mb-4 code-font" data-aos="fade-up">
                <span class="inline-block">&lt;</span>What I Do<span class="inline-block">/&gt;</span>
            </h2>
            <h1 class="text-xl lg:text-4xl font-bold mb-6 text-white" data-aos="fade-up" data-aos-delay="100">
                My <span class="gradient-text">Services</span>
            </h1>
            <p class="text-gray-300 max-w-2xl mx-auto mb-12 text-lg" data-aos="fade-up" data-aos-delay="200">
                I provide high-quality development services that transform ideas into powerful digital solutions.
            </p>
        </div>

        <div class="container mx-auto grid md:grid-cols-3 gap-8">
            <!-- Service Card -->
            <div v-for="service in services"
                class="relative bg-gray-800 p-8 rounded-2xl text-center shadow-lg overflow-hidden group"
                data-aos="fade-up" data-aos-delay="300">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 opacity-10 group-hover:opacity-20 transition">
                </div>
                <i :class="service.service_icon_class"></i>
                <h3 class="text-xl font-semibold text-white mb-3">{{ service.service_name }}</h3>
                <p class="text-gray-300">{{ service.service_description }}</p>
            </div>
        </div>
    </section>
</template>

<style scoped></style>
