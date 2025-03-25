<template>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-white flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow-sm py-4 px-6 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <h1 class="text-2xl font-bold text-gray-800">PortfolioQuick</h1>
            </div>
            <nav class="space-x-4">
                <a href="/login" class="text-gray-600 hover:text-blue-600">Login</a>
                <a href="/register" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">Get
                    Started</a>
            </nav>
        </header>

        <!-- Main Content -->
        <main class="flex-grow container mx-auto px-6 py-16 grid md:grid-cols-2 items-center gap-12 min-h-screen">
            <div class="space-y-6">
                <h2 class="text-4xl font-bold text-gray-900 leading-tight">
                    Build Your Professional Portfolio in Minutes
                </h2>
                <p class="text-xl text-gray-600">
                    No coding skills required. Create a stunning portfolio that showcases your skills, experience, and
                    achievements with just a few clicks.
                </p>
                <div class="flex space-x-4">
                    <a href="/hero"
                        class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path
                                d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
                        </svg>
                        <span>Create Your Portfolio</span>
                    </a>
                    <a href="#how-it-works"
                        class="border border-blue-600 text-blue-600 px-6 py-3 rounded-lg hover:bg-blue-50 transition flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>How It Works</span>
                    </a>
                </div>
            </div>

            <div class="hidden md:flex justify-center">
                <img src="/api/placeholder/500/400" alt="Portfolio Builder Illustration"
                    class="max-w-full rounded-xl shadow-lg" />
            </div>
        </main>




        <!-- Main Content -->
        <main id="how-it-works" class="container mx-auto px-6 py-16 max-w-4xl">
            <h2 class="text-4xl font-bold text-center mb-12 text-gray-900">
                How PortfolioQuick Works
            </h2>

            <!-- Process Steps -->
            <div class="space-y-12">
                <div class="bg-white rounded-xl shadow-md p-8 flex items-center space-x-6">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-2xl font-bold text-blue-600">1</span>
                    </div>
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-800 mb-3">Create Your Account</h3>
                        <p class="text-gray-600">
                            Sign up with your email or using a social media account. It's quick, easy, and free to
                            get started.
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-8 flex items-center space-x-6">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                        <span class="text-2xl font-bold text-green-600">2</span>
                    </div>
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-800 mb-3">Fill Out Basic Information</h3>
                        <p class="text-gray-600">
                            Complete a simple form with your personal details, professional summary, contact
                            information, and profile picture.
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-8 flex items-center space-x-6">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center">
                        <span class="text-2xl font-bold text-purple-600">3</span>
                    </div>
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-800 mb-3">Add Your Experience</h3>
                        <p class="text-gray-600">
                            Input your work history, education, skills, and achievements. Our intuitive form makes
                            it easy to showcase your professional journey.
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-8 flex items-center space-x-6">
                    <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center">
                        <span class="text-2xl font-bold text-orange-600">4</span>
                    </div>
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-800 mb-3">Customize Your Portfolio</h3>
                        <p class="text-gray-600">
                            Choose from pre-designed templates, select color schemes, and arrange sections to
                            personalize your portfolio's look and feel.
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-8 flex items-center space-x-6">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center">
                        <span class="text-2xl font-bold text-red-600">5</span>
                    </div>
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-800 mb-3">Publish and Share</h3>
                        <p class="text-gray-600">
                            Generate a unique URL for your portfolio. Share it with potential employers, clients, or
                            network connections with just one click.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="text-center mt-16">
                <a href="/signup"
                    class="bg-blue-600 text-white px-8 py-4 rounded-lg text-xl hover:bg-blue-700 transition inline-block shadow-md">
                    Start Building Your Portfolio Now
                </a>
            </div>
        </main>
    </div>
</template>

<script setup>
// You can add any necessary imports or reactive variables here if needed
</script>

<style scoped>
/* Any additional scoped styles can be added here */
</style>
