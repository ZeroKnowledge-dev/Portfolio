<template>
    <Navbar />
    <div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-indigo-700 p-6">
                <h2 class="text-2xl font-bold text-white">About Section</h2>
                <p class="text-purple-100 mt-1">Manage your personal information and portfolio highlights</p>
            </div>

            <div class="p-6">
                <form @submit.prevent="submitForm" class="space-y-8" enctype="multipart/form-data">
                    <!-- Loading Overlay -->
                    <div v-if="isSubmitting"
                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white p-6 rounded-lg shadow-xl flex items-center space-x-4">
                            <svg class="animate-spin h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span class="text-gray-700 font-medium">Saving your information...</span>
                        </div>
                    </div>

                    <!-- Personal Info Section -->
                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd" />
                            </svg>
                            Personal Information
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Profile Image Upload -->
                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Profile Image</label>
                                <div class="flex items-start space-x-5">
                                    <div
                                        class="relative flex-shrink-0 h-24 w-24 rounded-md overflow-hidden bg-gray-100 border border-gray-300">
                                        <img v-if="form.about_image_preview" :src="form.about_image_preview"
                                            alt="Profile preview" class="h-full w-full object-cover" />
                                        <div v-else
                                            class="h-full w-full flex items-center justify-center text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                    </div>

                                    <div class="flex flex-col space-y-2">
                                        <label for="about_image"
                                            class="px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 cursor-pointer">
                                            <span>Change photo</span>
                                            <input id="about_image" ref="aboutImageInput" name="about_image" type="file"
                                                class="sr-only" accept="image/*" @change="handleImageChange" />
                                        </label>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                        <div v-if="errors.about_image" class="text-sm text-red-600">{{
                                            errors.about_image }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Job Title -->
                            <div>
                                <label for="job_title" class="block text-sm font-medium text-gray-700 mb-1">Job
                                    Title</label>
                                <input id="job_title" v-model="form.job_title" type="text" :class="[
                                    'w-full px-4 py-2 border rounded-lg focus:ring-2 focus:outline-none transition-colors',
                                    errors.job_title
                                        ? 'border-red-300 focus:border-red-500 focus:ring-red-200'
                                        : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-200'
                                ]" placeholder="e.g. Full Stack Developer" />
                                <div v-if="errors.job_title" class="mt-1 text-sm text-red-600">{{ errors.job_title }}
                                </div>
                            </div>

                            <!-- Experience Years -->
                            <div>
                                <label for="experience_years" class="block text-sm font-medium text-gray-700 mb-1">Years
                                    of Experience</label>
                                <input id="experience_years" v-model="form.experience_years" type="text" :class="[
                                    'w-full px-4 py-2 border rounded-lg focus:ring-2 focus:outline-none transition-colors',
                                    errors.experience_years
                                        ? 'border-red-300 focus:border-red-500 focus:ring-red-200'
                                        : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-200'
                                ]" placeholder="e.g. 5+" />
                                <div v-if="errors.experience_years" class="mt-1 text-sm text-red-600">{{
                                    errors.experience_years }}</div>
                            </div>

                            <!-- Gmail -->
                            <div>
                                <label for="gmail" class="block text-sm font-medium text-gray-700 mb-1">Email
                                    Address</label>
                                <input id="gmail" v-model="form.gmail" type="email" :class="[
                                    'w-full px-4 py-2 border rounded-lg focus:ring-2 focus:outline-none transition-colors',
                                    errors.gmail
                                        ? 'border-red-300 focus:border-red-500 focus:ring-red-200'
                                        : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-200'
                                ]" placeholder="your.email@gmail.com" />
                                <div v-if="errors.gmail" class="mt-1 text-sm text-red-600">{{ errors.gmail }}</div>
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone
                                    Number</label>
                                <input id="phone" v-model="form.phone" type="tel" :class="[
                                    'w-full px-4 py-2 border rounded-lg focus:ring-2 focus:outline-none transition-colors',
                                    errors.phone
                                        ? 'border-red-300 focus:border-red-500 focus:ring-red-200'
                                        : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-200'
                                ]" placeholder="+1 (555) 123-4567" />
                                <div v-if="errors.phone" class="mt-1 text-sm text-red-600">{{ errors.phone }}</div>
                            </div>

                            <!-- Address -->
                            <div class="col-span-1 md:col-span-2">
                                <label for="address"
                                    class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                <input id="address" v-model="form.address" type="text" :class="[
                                    'w-full px-4 py-2 border rounded-lg focus:ring-2 focus:outline-none transition-colors',
                                    errors.address
                                        ? 'border-red-300 focus:border-red-500 focus:ring-red-200'
                                        : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-200'
                                ]" placeholder="123 Main St, City, Country" />
                                <div v-if="errors.address" class="mt-1 text-sm text-red-600">{{ errors.address }}</div>
                            </div>

                            <!-- Work Type -->
                            <div>
                                <label for="work_type" class="block text-sm font-medium text-gray-700 mb-1">Work
                                    Type</label>
                                <select id="work_type" v-model="form.work_type" :class="[
                                    'w-full px-4 py-2 border rounded-lg focus:ring-2 focus:outline-none transition-colors',
                                    errors.work_type
                                        ? 'border-red-300 focus:border-red-500 focus:ring-red-200'
                                        : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-200'
                                ]">
                                    <option value="" disabled>Select work type</option>
                                    <option value="Full-time">Full-time</option>
                                    <option value="Part-time">Part-time</option>
                                    <option value="Freelance">Freelance</option>
                                    <option value="Remote">Remote</option>
                                    <option value="Hybrid">Hybrid</option>
                                </select>
                                <div v-if="errors.work_type" class="mt-1 text-sm text-red-600">{{ errors.work_type }}
                                </div>
                            </div>

                            <!-- CV Upload -->
                            <div>
                                <label for="cv" class="block text-sm font-medium text-gray-700 mb-1">Resume/CV</label>
                                <div class="flex items-center mt-1">
                                    <label for="cv-upload"
                                        class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        <span v-if="form.cv">{{ formatFileName(form.cv) }}</span>
                                        <span v-else>Upload CV (PDF)</span>
                                        <input id="cv-upload" ref="cvInput" name="cv" type="file" class="sr-only"
                                            accept=".pdf,.doc,.docx" @change="handleCvChange" />
                                    </label>
                                </div>
                                <div v-if="errors.cv" class="mt-1 text-sm text-red-600">{{ errors.cv }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Portfolio Metrics Section -->
                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            Portfolio Metrics
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Total Projects -->
                            <div>
                                <label for="total_project" class="block text-sm font-medium text-gray-700 mb-1">Total
                                    Projects</label>
                                <input id="total_project" v-model="form.total_project" type="text" :class="[
                                    'w-full px-4 py-2 border rounded-lg focus:ring-2 focus:outline-none transition-colors',
                                    errors.total_project
                                        ? 'border-red-300 focus:border-red-500 focus:ring-red-200'
                                        : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-200'
                                ]" placeholder="e.g. 50+" />
                                <div v-if="errors.total_project" class="mt-1 text-sm text-red-600">{{
                                    errors.total_project }}</div>
                            </div>

                            <!-- Total Clients -->
                            <div>
                                <label for="total_client" class="block text-sm font-medium text-gray-700 mb-1">Total
                                    Clients</label>
                                <input id="total_client" v-model="form.total_client" type="text" :class="[
                                    'w-full px-4 py-2 border rounded-lg focus:ring-2 focus:outline-none transition-colors',
                                    errors.total_client
                                        ? 'border-red-300 focus:border-red-500 focus:ring-red-200'
                                        : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-200'
                                ]" placeholder="e.g. 30+" />
                                <div v-if="errors.total_client" class="mt-1 text-sm text-red-600">{{ errors.total_client
                                }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- About Me Description -->
                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                    clip-rule="evenodd" />
                            </svg>
                            About Me
                        </h3>

                        <div>
                            <label for="description"
                                class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea id="description" v-model="form.description" rows="6" :class="[
                                'w-full px-4 py-2 border rounded-lg focus:ring-2 focus:outline-none transition-colors',
                                errors.description
                                    ? 'border-red-300 focus:border-red-500 focus:ring-red-200'
                                    : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-200'
                            ]"
                                placeholder="Write a compelling description about yourself, your skills, and your professional journey..."></textarea>
                            <div v-if="errors.description" class="mt-1 text-sm text-red-600">{{ errors.description }}
                            </div>
                            <div class="mt-1 text-sm text-gray-500 flex justify-between">
                                <span>Markdown formatting supported</span>
                                <span>{{ characterCount }}/1000</span>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-4">
                        <button type="button"
                            class="px-6 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                            @click="resetForm" :disabled="isSubmitting">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                            :disabled="isSubmitting">
                            <span v-if="isSubmitting" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Saving...
                            </span>
                            <span v-else>Save Changes</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Success/Error Notification -->
        <div v-if="notification.show" :class="[
            'fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg transition-all transform duration-300 ease-in-out',
            notification.type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
        ]">
            <div class="flex items-center space-x-2">
                <svg v-if="notification.type === 'success'" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                <span>{{ notification.message }}</span>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, reactive } from 'vue';
import axios from 'axios';
import Navbar from '@/Components/Application/Navbar.vue';

const props = defineProps({
    about: Object,
});

// Form state
const form = reactive({
    job_title: props.about?.job_title || '',
    experience_years: props.about?.experience_years || '',
    gmail: props.about?.gmail || '',
    phone: props.about?.phone || '',
    address: props.about?.address || '',
    work_type: props.about?.work_type || '',
    total_project: props.about?.total_project || '',
    total_client: props.about?.total_client || '',
    cv: null,
    cv_preview: `/storage/cvs/${props.about?.cv || ''}`,
    description: props.about?.description || '',
    about_image: null,
    about_image_preview: `/storage/images/${props.about?.about_image || ''}`,
});

// UI state
const errors = reactive({});
const isSubmitting = ref(false);
const aboutImageInput = ref(null);
const cvInput = ref(null);
const notification = reactive({
    show: false,
    type: 'success',
    message: ''
});

// Computed properties
const characterCount = computed(() => form.description.length);

// Format file name for display
const formatFileName = (file) => {
    if (!file) return '';
    if (typeof file === 'string') return file;
    return file.name;
};

// Image handling functions
const handleImageChange = (event) => {
    const file = event.target.files[0];
    if (!file) return;

    if (file.size > 2 * 1024 * 1024) {
        errors.about_image = 'Image size should be less than 2MB';
        return;
    }

    form.about_image = file;
    form.about_image_preview = URL.createObjectURL(file);
    errors.about_image = null;
};

const handleCvChange = (event) => {
    const file = event.target.files[0];
    if (!file) return;

    if (file.size > 5 * 1024 * 1024) {
        errors.cv = 'CV size should be less than 5MB';
        return;
    }

    form.cv = file;
    errors.cv = null;
};

// Show notification
const showNotification = (type, message) => {
    notification.type = type;
    notification.message = message;
    notification.show = true;

    setTimeout(() => {
        notification.show = false;
    }, 5000);
};

// Form validation
const validateForm = () => {
    let isValid = true;

    // Validate each field
    if (!form.job_title.trim()) {
        errors.job_title = 'Job title is required';
        isValid = false;
    }

    if (!form.gmail.trim()) {
        errors.gmail = 'Email is required';
        isValid = false;
    }

    if (!form.description.trim()) {
        errors.description = 'Description is required';
        isValid = false;
    } else if (form.description.length > 1000) {
        errors.description = 'Description is too long (max 1000 characters)';
        isValid = false;
    }

    return isValid;
};

// Form submission
const submitForm = async () => {
    // Reset errors
    Object.keys(errors).forEach(key => errors[key] = null);

    // Validate form before submitting
    if (!validateForm()) return;

    try {
        isSubmitting.value = true;

        // Create FormData for file uploads
        const formData = new FormData();
        formData.append('job_title', form.job_title);
        formData.append('experience_years', form.experience_years);
        formData.append('gmail', form.gmail);
        formData.append('phone', form.phone);
        formData.append('address', form.address);
        formData.append('work_type', form.work_type);
        formData.append('total_project', form.total_project);
        formData.append('total_client', form.total_client);
        formData.append('description', form.description);

        if (form.about_image) {
            formData.append('about_image', form.about_image);
        }

        if (form.cv) {
            formData.append('cv', form.cv);
        }

        // Here you would implement your API call
        await axios.post(route('about.store'), formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });

        // Show success message
        showNotification('success', 'Information saved successfully!');
    } catch (error) {
        console.error('Error submitting form:', error);
        showNotification('error', 'There was a problem saving your information.');
    } finally {
        isSubmitting.value = false;
    }
};

// Reset form
const resetForm = () => {
    form.job_title = '';
    form.experience_years = '';
    form.gmail = '';
    form.phone = '';
    form.address = '';
    form.work_type = '';
    form.total_project = '';
    form.total_client = '';
    form.cv = null;
    form.cv_preview = null;
    form.description = '';
    form.about_image = null;
    form.about_image_preview = null;

    // Clear errors
    Object.keys(errors).forEach(key => errors[key] = null);

    // Reset file inputs
    if (aboutImageInput.value) {
        aboutImageInput.value.value = '';
    }
    if (cvInput.value) {
        cvInput.value.value = '';
    }
};
</script>
