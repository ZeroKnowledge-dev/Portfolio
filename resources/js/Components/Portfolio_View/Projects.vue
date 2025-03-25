<script setup>
import { ref, computed } from 'vue';
const props = defineProps({
    projects: Array, // Assuming the projects data will be passed as a prop as well
});

const selectedCategory = ref(''); // To store the selected category

// Get unique project categories
const categories = props.projects.reduce((acc, project) => {
    if (!acc.includes(project.project_category)) {
        acc.push(project.project_category);
    }
    return acc;
}, []);  // Initialize the accumulator as an empty array


// Function to filter projects based on the selected category
const filteredProjects = computed(() => {
    if (!selectedCategory.value || selectedCategory.value === '') {
        return props.projects; // Show all if no category is selected
    }
    return props.projects.filter(project => project.project_category === selectedCategory.value);
});

// Function to handle category button click
const changeCategory = (category) => {
    selectedCategory.value = category;
};

function stringToArray(str) {
    return str.split(',');
}
</script>


<template>
    <!-- Projects Section -->
    <section id="projects" class="text-white py-20 px-6 bg-[var(--background-color)] relative overflow-hidden">
        <!-- Background elements -->
        <div class="absolute top-0 right-0 w-full h-full opacity-10">
            <div class="absolute top-1/3 right-1/4 w-80 h-80 rounded-full bg-indigo-600 filter blur-3xl"></div>
            <div class="absolute bottom-1/3 left-1/3 w-64 h-64 rounded-full bg-purple-600 filter blur-3xl"></div>
        </div>

        <div class="container mx-auto relative z-10">
            <!-- Section Header -->
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-lg text-purple-400 mb-4 code-font">
                    <span class="inline-block">&lt;</span>my projects<span class="inline-block">/&gt;</span>
                </h2>
                <h3 class="text-3xl lg:text-4xl font-bold">
                    My Recent <span class="gradient-text">Work</span>
                </h3>
                <p class="text-gray-300 mt-4 max-w-xl mx-auto">
                    Showcasing some of my best work that demonstrates my skills and experience.
                </p>
            </div>

            <!-- Filter Controls -->
            <div class="flex flex-wrap justify-center mb-12 gap-4" data-aos="fade-up" data-aos-delay="100">
                <button
                    class="filter-btn px-6 py-2 rounded-full bg-gray-800 hover:bg-gray-700 transition-colors font-medium"
                    :class="{ 'active': selectedCategory === '' }" @click="changeCategory('')">
                    All
                </button>
                <button v-for="category in categories"
                    class="filter-btn active px-6 py-2 rounded-full bg-gray-800 hover:bg-gray-700 transition-colors font-medium"
                    :class="{ 'active': selectedCategory === category }" @click="changeCategory(category)">
                    {{ category }}
                </button>
            </div>

            <!-- Projects Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16" id="projects-grid">
                <!-- Project Card 1 -->
                <div v-for="project in filteredProjects" class="project-card group" data-category="web"
                    data-aos="fade-up" data-aos-delay="200">
                    <div class="bg-gray-800 rounded-xl overflow-hidden relative">
                        <!-- Project Image -->
                        <div class="aspect-video overflow-hidden">
                            <img :src="`/storage/images/${project.project_image}`" alt="E-commerce Website"
                                class="w-full h-full object-cover object-center transform group-hover:scale-110 transition-transform duration-500">
                        </div>

                        <!-- Project Overlay -->
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-50 group-hover:opacity-80 transition-opacity duration-300 flex items-end">
                            <div class="p-6 w-full">
                                <span class="text-purple-400 text-sm font-medium mb-2 block">{{ project.project_category
                                    }}</span>
                                <h4 class="text-xl font-bold mb-2">{{ project.project_name }}</h4>
                                <p
                                    class="text-gray-300 text-sm mb-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    {{ project.project_description }}
                                </p>
                                <div
                                    class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <span v-for="stack in stringToArray(project.technology_used)"
                                        class="text-xs bg-gray-700 px-2 py-1 rounded-full">{{ stack }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div
                            class="absolute top-4 right-4 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <a :href="`${project.live_demo_link}`"
                                class="bg-purple-600 hover:bg-purple-700 rounded-full p-2 transition-colors">
                                <i class="fas fa-eye text-white"></i>
                            </a>
                            <a :href="`${project.additional_link}`"
                                class="bg-gray-700 hover:bg-gray-600 rounded-full p-2 transition-colors">
                                <i class="fab fa-github text-white"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- View More Projects Button -->
            <div class="text-center" data-aos="fade-up" data-aos-delay="800">
                <a href="#"
                    class="btn-primary inline-block px-8 py-3 rounded-full bg-gradient-to-r from-[var(--primary-color)] to-[var(--secondary-color)] hover:from-purple-700 hover:to-indigo-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    View All Projects
                </a>
            </div>

        </div>
    </section>
</template>
