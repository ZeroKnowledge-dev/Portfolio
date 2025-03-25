<script setup>

</script>

<template>
    <!-- Contact Section -->
    <section id="contact" class="text-white relative py-24 bg-[var(--background-color)] px-6">
        <div class="container mx-auto text-center">
            <h2 class="text-lg text-purple-400 mb-4 code-font" data-aos="fade-up">
                <span class="inline-block">&lt;</span>Get in Touch<span class="inline-block">/&gt;</span>
            </h2>
            <h1 class="text-xl lg:text-4xl font-bold mb-6 text-white" data-aos="fade-up" data-aos-delay="100">
                Contact <span class="gradient-text">Me</span>
            </h1>
            <p class="text-gray-300 max-w-2xl mx-auto mb-12 text-lg" data-aos="fade-up" data-aos-delay="200">
                Have a project in mind or just want to say hi? Feel free to reach out!
            </p>
        </div>

        <div class="container mx-auto grid md:grid-cols-2 gap-12">
            <!-- Contact Info -->
            <div class="text-white space-y-6" data-aos="fade-right" data-aos-delay="300">
                <div class="flex items-center gap-4">
                    <div class="bg-gray-800 p-4 rounded-lg">
                        <i class="fas fa-envelope text-purple-400 text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold">Email</h3>
                        <p class="text-gray-300">akash@example.com</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="bg-gray-800 p-4 rounded-lg">
                        <i class="fas fa-phone-alt text-purple-400 text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold">Phone</h3>
                        <p class="text-gray-300">+123 456 7890</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="bg-gray-800 p-4 rounded-lg">
                        <i class="fas fa-map-marker-alt text-purple-400 text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold">Location</h3>
                        <p class="text-gray-300">Your City, Your Country</p>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="bg-gray-800 p-8 rounded-xl shadow-lg" data-aos="fade-left" data-aos-delay="400">
                <form action="#" method="POST" class="space-y-6">
                    <div>
                        <label class="text-gray-300 block mb-2">Your Name</label>
                        <input type="text"
                            class="w-full p-3 rounded-lg bg-gray-900 text-white focus:outline-none focus:ring-2 focus:ring-purple-500"
                            placeholder="Enter your name" required>
                    </div>
                    <div>
                        <label class="text-gray-300 block mb-2">Your Email</label>
                        <input type="email"
                            class="w-full p-3 rounded-lg bg-gray-900 text-white focus:outline-none focus:ring-2 focus:ring-purple-500"
                            placeholder="Enter your email" required>
                    </div>
                    <div>
                        <label class="text-gray-300 block mb-2">Message</label>
                        <textarea
                            class="w-full p-3 rounded-lg bg-gray-900 text-white focus:outline-none focus:ring-2 focus:ring-purple-500"
                            rows="5" placeholder="Write your message..." required></textarea>
                    </div>
                    <button type="submit"
                        class="btn-primary w-full py-3 rounded-full text-white font-medium flex justify-center items-center">
                        <span>Send Message</span>
                        <i class="fas fa-paper-plane ml-2"></i>
                    </button>
                </form>
            </div>
        </div>
    </section>
</template>

<style scoped></style>
