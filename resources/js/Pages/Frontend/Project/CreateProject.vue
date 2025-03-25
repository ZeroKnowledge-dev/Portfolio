<!-- Improved Project Management Component -->
<template>
    <Navbar />
    <div class="bg-gray-50 min-h-screen py-10">
        <div class="container mx-auto px-4 space-y-10">
            <!-- Project Creation/Edit Form -->
            <div class="bg-white shadow-xl rounded-2xl p-8">
                <h2 class="text-3xl font-extrabold text-gray-900 mb-6">
                    {{ isEditing ? 'Edit Project' : 'Add New Project' }}
                </h2>

                <form @submit.prevent="submitForm" class="space-y-6">
                    <!-- Project Name Input -->
                    <div>
                        <label for="project_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Project Name
                        </label>
                        <input id="project_name" v-model="formData.project_name" type="text" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 transition duration-300"
                            :class="errors.project_name ? 'border-red-500' : ''" />
                        <p v-if="errors.project_name" class="text-red-500 text-sm mt-1">
                            {{ errors.project_name }}
                        </p>
                    </div>

                    <!-- Project Category Dropdown -->
                    <div>
                        <label for="project_category" class="block text-sm font-medium text-gray-700 mb-2">
                            Project Category
                        </label>
                        <select id="project_category" v-model="formData.project_category" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 transition duration-300"
                            :class="errors.project_category ? 'border-red-500' : ''">
                            <option value="" disabled>Select a category</option>
                            <option v-for="category in categories" :key="category" :value="category">
                                {{ category }}
                            </option>
                        </select>
                        <p v-if="errors.project_category" class="text-red-500 text-sm mt-1">
                            {{ errors.project_category }}
                        </p>
                    </div>

                    <!-- Technology Stack Input -->
                    <div>
                        <label for="technology" class="block text-sm font-medium text-gray-700 mb-2">
                            Technology Stack
                        </label>
                        <div class="flex space-x-2">
                            <input id="technology" v-model="techInput" type="text" placeholder="Add technology"
                                @keyup.enter="addTechnology"
                                class="flex-grow px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 transition duration-300" />
                            <button type="button" @click="addTechnology"
                                class="px-4 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-300">
                                Add
                            </button>
                        </div>

                        <!-- Technology Chips -->
                        <div v-if="formData.technology_used" class="flex flex-wrap gap-2 mt-3">
                            <span v-for="(tech, index) in formData.technology_used.split(',')" :key="index"
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-indigo-100 text-indigo-800">
                                {{ tech.trim() }}
                                <button type="button" @click="removeTechnology(index)"
                                    class="ml-2 text-indigo-500 hover:text-indigo-700">
                                    ✕
                                </button>
                            </span>
                        </div>
                    </div>

                    <!-- Live Demo Link -->
                    <div>
                        <label for="live_demo_link" class="block text-sm font-medium text-gray-700 mb-2">
                            Live Demo Link
                        </label>
                        <input id="live_demo_link" v-model="formData.live_demo_link" type="url"
                            placeholder="https://your-project-demo.com"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 transition duration-300"
                            :class="errors.live_demo_link ? 'border-red-500' : ''" />
                        <p v-if="errors.live_demo_link" class="text-red-500 text-sm mt-1">
                            {{ errors.live_demo_link }}
                        </p>
                    </div>

                    <!-- Additional Link -->
                    <div>
                        <label for="additional_link" class="block text-sm font-medium text-gray-700 mb-2">
                            Additional Link
                            <span class="text-gray-500 text-xs">(GitHub, Figma, etc.)</span>
                        </label>
                        <input id="additional_link" v-model="formData.additional_link" type="url"
                            placeholder="https://github.com/username/project"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 transition duration-300"
                            :class="errors.additional_link ? 'border-red-500' : ''" />
                        <p v-if="errors.additional_link" class="text-red-500 text-sm mt-1">
                            {{ errors.additional_link }}
                        </p>
                    </div>

                    <!-- Project Description -->
                    <div>
                        <label for="project_description" class="block text-sm font-medium text-gray-700 mb-2">
                            Project Description
                        </label>
                        <textarea id="project_description" v-model="formData.project_description" rows="4"
                            maxlength="500"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 transition duration-300"
                            :class="errors.project_description ? 'border-red-500' : ''"></textarea>
                        <div class="flex justify-between text-sm text-gray-500 mt-1">
                            <p v-if="errors.project_description" class="text-red-500">
                                {{ errors.project_description }}
                            </p>
                            <p>{{ characterCount }}/500 characters</p>
                        </div>
                    </div>

                    <!-- Image Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Project Image
                        </label>
                        <div class="border-2 border-dashed rounded-lg p-6 text-center cursor-pointer hover:bg-gray-50 transition duration-300"
                            :class="errors.project_image ? 'border-red-500' : 'border-gray-300'">
                            <input type="file" @change="handleImageUpload" accept="image/png,image/jpeg,image/gif"
                                class="hidden" ref="imageUpload" />
                            <div @click="$refs.imageUpload.click()" class="space-y-2">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-sm text-gray-600">
                                    Click to upload or drag and drop
                                </p>
                                <p class="text-xs text-gray-500">
                                    PNG, JPG, GIF (max 5MB)
                                </p>
                            </div>

                            <!-- Image Preview -->
                            <div v-if="imagePreview" class="mt-4 relative">
                                <img :src="imagePreview" class="mx-auto max-h-48 rounded-lg object-cover" />
                                <button type="button" @click.stop="removeImage"
                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 text-xs">
                                    ✕
                                </button>
                            </div>
                        </div>
                        <p v-if="errors.project_image" class="text-red-500 text-sm mt-1">
                            {{ errors.project_image }}
                        </p>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-4">
                        <button type="button" @click="resetForm"
                            class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition duration-300">
                            Reset
                        </button>
                        <button type="submit" :disabled="isSubmitting"
                            class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-300 flex items-center">
                            <svg v-if="isSubmitting" class="animate-spin mr-2 h-5 w-5"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            {{ isEditing ? 'Update Project' : 'Create Project' }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- Project List Section -->
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 mb-6">
                    My Projects ({{ projects.length }})
                </h2>

                <!-- Empty State -->
                <div v-if="projects.length === 0" class="bg-white shadow-lg rounded-2xl p-12 text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                    </svg>
                    <h3 class="mt-4 text-xl font-semibold text-gray-900">
                        No Projects Yet
                    </h3>
                    <p class="mt-2 text-gray-600">
                        Start by creating your first project and showcasing your work!
                    </p>
                </div>

                <!-- Project Grid -->
                <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div v-for="project in projects" :key="project.id"
                        class="bg-white rounded-2xl shadow-lg overflow-hidden transition transform hover:-translate-y-2 hover:shadow-xl">
                        <img :src="`/storage/images/${project.project_image}`" :alt="project.project_name"
                            class="w-full h-48 object-cover" />
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">
                                {{ project.project_name }}
                            </h3>
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-sm text-gray-600 bg-gray-100 px-3 py-1 rounded-full">
                                    {{ project.project_category }}
                                </span>
                            </div>
                            <div class="mb-4 flex flex-wrap gap-2">
                                <span v-for="(tech, index) in formatTechnologies(project.technology_used)" :key="index"
                                    class="text-xs px-2 py-1 bg-indigo-100 text-indigo-800 rounded-full">
                                    {{ tech }}
                                </span>
                            </div>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                {{ project.project_description }}
                            </p>
                            <div class="flex justify-between items-center">
                                <button @click="editProject(project)"
                                    class="text-indigo-600 hover:text-indigo-800 transition">
                                    Edit
                                </button>
                                <button @click="deleteProject(project.id)"
                                    class="text-red-600 hover:text-red-800 transition">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import axios from 'axios';
import Navbar from '@/Components/Application/Navbar.vue';

// Props and Initial State
const props = defineProps({
    projects: {
        type: Array,
        default: () => []
    }
});

// Reactive State
const projects = ref(props.projects);
const formData = ref({
    id: null,
    project_name: '',
    project_category: '',
    technology_used: '',
    live_demo_link: '',
    additional_link: '',
    project_description: '',
    project_image: null
});

// State Management
const isEditing = ref(false);
const isSubmitting = ref(false);
const imagePreview = ref(null);
const techInput = ref('');
const currentProjectId = ref(null);
const errors = ref({});

// Constants
const categories = ref([
    'Web Development',
    'Mobile App',
    'UI/UX Design',
    'Machine Learning',
    'Data Analysis',
    'Game Development',
    'Blockchain',
    'IoT'
]);

// Computed Properties
const characterCount = computed(() => formData.value.project_description.length);

// Validation Utilities
const isValidUrl = (url) => {
    try {
        new URL(url);
        return true;
    } catch (e) {
        return false;
    }
};

// Submit Project
const submitForm = async () => {
    // Clear previous errors
    errors.value = {};

    // Basic validation
    if (!formData.value.project_name.trim()) {
        errors.value.project_name = 'Project name is required';
        return;
    }

    if (!formData.value.project_category) {
        errors.value.project_category = 'Please select a project category';
        return;
    }

    if (!formData.value.project_description.trim()) {
        errors.value.project_description = 'Project description is required';
        return;
    }

    if (formData.value.project_description.length > 500) {
        errors.value.project_description = 'Description should be max 500 characters';
        return;
    }

    if (formData.value.live_demo_link && !isValidUrl(formData.value.live_demo_link)) {
        errors.value.live_demo_link = 'Please enter a valid URL';
        return;
    }

    if (formData.value.additional_link && !isValidUrl(formData.value.additional_link)) {
        errors.value.additional_link = 'Please enter a valid URL';
        return;
    }

    if (!formData.value.project_image && !isEditing.value) {
        errors.value.project_image = 'Project image is required';
        return;
    }

    isSubmitting.value = true;

    const formPayload = new FormData();
    Object.entries(formData.value).forEach(([key, value]) => {
        if (value !== null && value !== undefined) {
            formPayload.append(key, value);
        }
    });

    try {
        if (isEditing.value) {
            await axios.post(`/project/${currentProjectId.value}?_method=PUT`, formPayload, {
                headers: { 'Content-Type': 'multipart/form-data' }
            });
            showNotification('Project updated successfully!', 'success');
        } else {
            const response = await axios.post('/project', formPayload, {
                headers: { 'Content-Type': 'multipart/form-data' }
            });
            projects.value.push(response.data);
            showNotification('New project added successfully!', 'success');
        }

        resetForm();
    } catch (error) {
        console.error('Error saving project:', error);

        if (error.response?.data?.errors) {
            Object.assign(errors.value, error.response.data.errors);
        } else {
            showNotification('Failed to save project. Please try again.', 'error');
        }
    } finally {
        isSubmitting.value = false;
    }
};

// Edit Project
const editProject = (project) => {
    isEditing.value = true;
    currentProjectId.value = project.id;

    formData.value = {
        project_name: project.project_name,
        project_category: project.project_category,
        technology_used: project.technology_used,
        live_demo_link: project.live_demo_link,
        additional_link: project.additional_link,
        project_description: project.project_description,
        project_image: null // Will be set via preview
    };

    imagePreview.value = project.project_image
        ? `/storage/images/${project.project_image}`
        : null;

    document.querySelector('form').scrollIntoView({ behavior: 'smooth' });
};

// Cancel Edit
const cancelEdit = () => {
    resetForm();
};

// Technology Management
const addTechnology = () => {
    if (!techInput.value.trim()) return;

    const techs = formData.value.technology_used
        ? formData.value.technology_used.split(',').map(t => t.trim())
        : [];

    const newTech = techInput.value.trim();
    if (!techs.includes(newTech)) {
        techs.push(newTech);
        formData.value.technology_used = techs.join(', ');
    }

    techInput.value = '';
};

const removeTechnology = (index) => {
    const techs = formData.value.technology_used.split(',').map(t => t.trim());
    techs.splice(index, 1);
    formData.value.technology_used = techs.join(', ');
};

// Image Handling
const handleImageUpload = (event) => {
    const file = event.target.files[0];
    if (!file) return;

    const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
    const maxSize = 5 * 1024 * 1024; // 5MB

    if (!validTypes.includes(file.type)) {
        errors.value.project_image = 'Please upload a valid image (PNG, JPG, GIF)';
        return;
    }

    if (file.size > maxSize) {
        errors.value.project_image = 'Image size must be less than 5MB';
        return;
    }

    formData.value.project_image = file;

    const reader = new FileReader();
    reader.onload = (e) => {
        imagePreview.value = e.target.result;
    };
    reader.readAsDataURL(file);

    errors.value.project_image = null;
};

const removeImage = () => {
    formData.value.project_image = null;
    imagePreview.value = null;
};

// Project Management
const deleteProject = async (id) => {
    if (!confirm('Are you sure you want to delete this project?')) return;

    try {
        await axios.delete(`/project/${id}`);
        projects.value = projects.value.filter(project => project.id !== id);
        alert('Project deleted successfully!');
    } catch (error) {
        console.error('Project deletion failed', error);
        alert('Failed to delete project');
    }
};

// Form Reset
const resetForm = () => {
    // Reset form data
    formData.value = {
        id: null,
        project_name: '',
        project_category: '',
        technology_used: '',
        live_demo_link: '',
        additional_link: '',
        project_description: '',
        project_image: null
    };

    // Reset other states
    isEditing.value = false;
    imagePreview.value = null;
    techInput.value = '';
    errors.value = {};
};

// Utility for formatting technologies
const formatTechnologies = (techString) => {
    return techString ? techString.split(',').map(tech => tech.trim()) : [];
};

// Show notification
const showNotification = (message, type) => {
    alert(`${type.toUpperCase()}: ${message}`);
};
</script>

<style scoped>
.line-clamp-3 {
    display: -webkit-box;
    --webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
