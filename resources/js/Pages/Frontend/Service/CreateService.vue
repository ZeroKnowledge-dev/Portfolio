<template>
    <Navbar />
    <div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8 bg-white rounded-lg shadow-md">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-6">Manage Service Sections</h1>

        <!-- Add New Service Section Form -->
        <div class="mb-8 p-4 bg-gray-50 rounded-lg border border-gray-200">
            <h2 class="text-lg font-medium text-gray-800 mb-4">Add New Service</h2>

            <form @submit.prevent="addServiceSection" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label for="service_name" class="block text-sm font-medium text-gray-700">Service Name*</label>
                        <input id="service_name" v-model="newServiceSection.service_name" type="text" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Enter service name" />
                        <p v-if="errors.service_name" class="mt-1 text-sm text-red-600">{{ errors.service_name }}</p>
                    </div>

                    <div class="space-y-2">
                        <label for="service_icon_class" class="block text-sm font-medium text-gray-700">Service
                            Icon*</label>
                        <div class="flex space-x-2">
                            <div class="relative flex-1">
                                <input id="service_icon_class" v-model="newServiceSection.service_icon_class"
                                    type="text" required
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="e.g., fa-code, devicon-react-plain" />
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i
                                        :class="[newServiceSection.service_icon_class || 'fa fa-question', 'text-gray-400']"></i>
                                </div>
                            </div>

                            <button type="button" @click="openIconSelector"
                                class="px-4 py-2 border border-gray-300 bg-gray-50 text-gray-700 rounded-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                Browse Icons
                            </button>
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="service_description" class="block text-sm font-medium text-gray-700">Service
                        Description*</label>
                    <textarea id="service_description" v-model="newServiceSection.service_description" rows="4" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Describe the service in detail"></textarea>
                    <p v-if="errors.service_description" class="mt-1 text-sm text-red-600">{{ errors.service_description
                        }}</p>
                </div>

                <div class="flex justify-end">
                    <button type="submit" :disabled="isSubmitting"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span v-if="isSubmitting" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Adding...
                        </span>
                        <span v-else>Add Service</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Existing Service Sections List -->
        <div>
            <h2 class="text-lg font-medium text-gray-800 mb-4">Your Services</h2>

            <!-- Empty State -->
            <div v-if="services.length === 0" class="p-8 text-center bg-gray-50 rounded-lg border border-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <p class="mt-2 text-sm text-gray-600">No services added yet. Add your first service above.</p>
            </div>

            <!-- Services Grid -->
            <div v-else class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                <div v-for="service in services" :key="service.id"
                    class="p-4 bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 flex items-center justify-center bg-indigo-100 rounded-full">
                                <i :class="[service.service_icon_class, 'text-xl text-indigo-600']"></i>
                            </div>
                            <span class="font-medium text-gray-700">{{ service.service_name }}</span>
                        </div>

                        <div class="flex space-x-1">
                            <button @click="editServiceSection(service)"
                                class="p-1 text-gray-500 hover:text-gray-700 focus:outline-none" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>

                            <button @click="confirmDeleteServiceSection(service)"
                                class="p-1 text-gray-500 hover:text-red-600 focus:outline-none" title="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <p class="text-sm text-gray-600 line-clamp-3">{{ service.service_description }}</p>
                </div>
            </div>
        </div>

        <!-- Icon Selector Modal -->
        <div v-if="showIconSelector"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
            <div class="bg-white rounded-lg max-w-2xl w-full max-h-[80vh] overflow-auto">
                <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-medium">Select an Icon</h3>
                    <button @click="showIconSelector = false" class="text-gray-500 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="p-4">
                    <div class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 gap-4">
                        <button v-for="iconClass in commonIcons" :key="iconClass" @click="selectIcon(iconClass)"
                            class="p-3 flex flex-col items-center justify-center border border-gray-200 rounded-md hover:bg-gray-50">
                            <i :class="[iconClass, 'text-2xl text-gray-700']"></i>
                            <span class="mt-2 text-xs text-gray-500 truncate w-full text-center">{{ iconClass }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Service Section Modal -->
        <div v-if="showEditModal"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
            <div class="bg-white rounded-lg max-w-md w-full">
                <div class="p-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Edit Service</h3>
                </div>

                <div class="p-4 space-y-4">
                    <div class="space-y-2">
                        <label for="edit_service_name" class="block text-sm font-medium text-gray-700">Service
                            Name*</label>
                        <input id="edit_service_name" v-model="editingServiceSection.service_name" type="text" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    <div class="space-y-2">
                        <label for="edit_service_icon_class" class="block text-sm font-medium text-gray-700">Service
                            Icon*</label>
                        <div class="relative">
                            <input id="edit_service_icon_class" v-model="editingServiceSection.service_icon_class"
                                type="text" required
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i
                                    :class="[editingServiceSection.service_icon_class || 'fa fa-question', 'text-gray-400']"></i>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="edit_service_description" class="block text-sm font-medium text-gray-700">Service
                            Description*</label>
                        <textarea id="edit_service_description" v-model="editingServiceSection.service_description"
                            rows="4" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                    </div>
                </div>

                <div class="p-4 border-t border-gray-200 flex justify-end space-x-3">
                    <button @click="showEditModal = false"
                        class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Cancel
                    </button>
                    <button @click="updateServiceSection" :disabled="isSubmitting"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span v-if="isSubmitting" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
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
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div v-if="showDeleteConfirmation"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
            <div class="bg-white rounded-lg max-w-md w-full">
                <div class="p-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Confirm Deletion</h3>
                </div>

                <div class="p-4">
                    <p class="text-sm text-gray-600">Are you sure you want to delete this service? This action cannot be
                        undone.</p>
                </div>

                <div class="p-4 border-t border-gray-200 flex justify-end space-x-3">
                    <button @click="showDeleteConfirmation = false"
                        class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Cancel
                    </button>
                    <button @click="deleteServiceSection"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from 'axios';
import { ref, reactive } from 'vue';
import Navbar from '@/Components/Application/Navbar.vue';

const props = defineProps({
    services: Array
});

const emit = defineEmits(['update:services']);

// Local state
const newServiceSection = reactive({
    service_name: '',
    service_description: '',
    service_icon_class: ''
});

const editingServiceSection = reactive({
    id: null,
    service_name: '',
    service_description: '',
    service_icon_class: ''
});

const errors = reactive({});
const isSubmitting = ref(false);
const showIconSelector = ref(false);
const showEditModal = ref(false);
const showDeleteConfirmation = ref(false);
const serviceToDelete = ref(null);

// Sample icons for mock icon selector
const commonIcons = [
    'fab fa-html5',
    'fab fa-css3-alt',
    'fab fa-js',
    'fab fa-vuejs',
    'fab fa-laravel',
    'fab fa-php',
    'fab fa-github',
    'fab fa-node',
    'fab fa-react',
    'fab fa-wordpress',
    'fab fa-bootstrap',
    'fab fa-sass',
];

// Add new service section
const addServiceSection = async () => {
    isSubmitting.value = true;
    errors.service_name = '';
    errors.service_description = '';
    errors.service_icon_class = '';

    try {
        const response = await axios.post(route('service.store'), {
            service_name: newServiceSection.service_name,
            service_description: newServiceSection.service_description,
            service_icon_class: newServiceSection.service_icon_class
        });

        emit('update:services', [...props.services, response.data]);

        // Reset form
        newServiceSection.service_name = '';
        newServiceSection.service_description = '';
        newServiceSection.service_icon_class = '';
    } catch (err) {
        if (err.response && err.response.data && err.response.data.errors) {
            const responseErrors = err.response.data.errors;
            errors.service_name = responseErrors.service_name?.[0];
            errors.service_description = responseErrors.service_description?.[0];
            errors.service_icon_class = responseErrors.service_icon_class?.[0];
        }
    } finally {
        isSubmitting.value = false;
    }
};

// Edit service section setup
const editServiceSection = (service) => {
    editingServiceSection.id = service.id;
    editingServiceSection.service_name = service.service_name;
    editingServiceSection.service_description = service.service_description;
    editingServiceSection.service_icon_class = service.service_icon_class;
    showEditModal.value = true;
};

// Update service section
const updateServiceSection = async () => {
    isSubmitting.value = true;
    errors.service_name = '';
    errors.service_description = '';
    errors.service_icon_class = '';

    try {
        const response = await axios.put(route('service.update', editingServiceSection.id), {
            service_name: editingServiceSection.service_name,
            service_description: editingServiceSection.service_description,
            service_icon_class: editingServiceSection.service_icon_class
        });

        const updatedservices = props.services.map((service) =>
            service.id === editingServiceSection.id ? response.data : service
        );
        emit('update:services', updatedservices);
        showEditModal.value = false;
    } catch (err) {
        if (err.response?.data?.errors) {
            const responseErrors = err.response.data.errors;
            errors.service_name = responseErrors.service_name?.[0];
            errors.service_description = responseErrors.service_description?.[0];
            errors.service_icon_class = responseErrors.service_icon_class?.[0];
        }
    } finally {
        isSubmitting.value = false;
    }
};

// Delete service section
const confirmDeleteServiceSection = (service) => {
    serviceToDelete.value = service;
    showDeleteConfirmation.value = true;
};

const deleteServiceSection = async () => {
    try {
        await axios.delete(route('service.destroy', serviceToDelete.value.id));
        emit('update:services', props.services.filter(s => s.id !== serviceToDelete.value.id));
        showDeleteConfirmation.value = false;
    } catch (err) {
        console.error(err);
    }
};

// Icon selector
const openIconSelector = () => {
    showIconSelector.value = true;
};

const selectIcon = (iconClass) => {
    newServiceSection.service_icon_class = iconClass;
    showIconSelector.value = false;
};
</script>
