<template>
    <Navbar />
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-6">
                <h2 class="text-xl font-bold text-white">Manage Hero Section Professions</h2>
                <p class="text-blue-100 mt-1">Add or update professions that appear in your hero section</p>
            </div>

            <div class="p-6">
                <!-- Form -->
                <form @submit.prevent="submitForm" class="space-y-6">
                    <!-- Profession Name Input -->
                    <div>
                        <label for="profession_name" class="block text-sm font-medium text-gray-700 mb-1">
                            Profession Name
                        </label>
                        <div class="relative">
                            <input id="profession_name" v-model="form.profession_name" type="text" :class="[
                                'w-full px-4 py-2 border rounded-lg focus:ring-2 focus:outline-none transition-colors',
                                errors.profession_name
                                    ? 'border-red-300 focus:border-red-500 focus:ring-red-200'
                                    : 'border-gray-300 focus:border-blue-500 focus:ring-blue-200'
                            ]" placeholder="e.g. Web Developer, Designer, Consultant"
                                @input="errors.profession_name = ''" />
                            <div v-if="errors.profession_name" class="text-red-500 text-sm mt-1">
                                {{ errors.profession_name }}
                            </div>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">
                            This profession will be displayed in your hero section rotation
                        </p>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-end gap-4">
                        <button type="button" @click="resetForm"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-colors"
                            :disabled="loading">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-6 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors flex items-center"
                            :disabled="loading">
                            <span v-if="loading" class="inline-block mr-2">
                                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </span>
                            {{ formMode === 'create' ? 'Add Profession' : 'Update Profession' }}
                        </button>
                    </div>
                </form>

                <!-- List of Professions -->
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Your Professions</h3>

                    <div v-if="loading" class="text-center py-6">
                        <svg class="animate-spin h-8 w-8 text-blue-500 mx-auto" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </div>

                    <div v-else-if="props.professions.length === 0"
                        class="text-center py-8 bg-gray-50 rounded-lg border border-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mx-auto mb-3" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <p class="text-gray-500 mb-1">No professions added yet</p>
                        <p class="text-sm text-gray-400">Add your first profession to display in your hero section</p>
                    </div>

                    <div v-else class="space-y-3">
                        <transition-group name="list" tag="div">
                            <div v-for="profession in props.professions" :key="profession.id"
                                class="flex items-center justify-between p-4 bg-white border border-gray-200 rounded-lg hover:shadow-sm transition-all">
                                <div>
                                    <p class="font-medium text-gray-800">{{ profession.profession_name }}</p>
                                    <p class="text-xs text-gray-500">Added {{ formatDate(profession.created_at) }}</p>
                                </div>
                                <div class="flex space-x-2">
                                    <button @click="editProfession(profession)"
                                        class="p-1.5 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-md transition-colors"
                                        title="Edit profession">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>
                                    <button @click="deleteProfession(profession.id)"
                                        class="p-1.5 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-md transition-colors"
                                        title="Delete profession">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </transition-group>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import Navbar from '@/Components/Application/Navbar.vue';


const loading = ref(false);
const formMode = ref('create');
const currentProfessionId = ref(null);


const props = defineProps({
    professions: Array,
});

const form = ref({
    profession_name: '',
});

const errors = ref({
    profession_name: '',
});

const submitForm = async () => {
    // Validate form
    if (!form.value.profession_name.trim()) {
        errors.value.profession_name = 'Profession name is required';
        return;
    }

    loading.value = true;
    try {
        if (formMode.value === 'create') {
            // Create new profession
            await axios.post(route('hero-profession.store'), form.value);
        } else {
            // Update existing profession
            await axios.put(route('hero-profession.update', currentProfessionId.value), form.value);
        }

        // Show success notification (implementation will depend on your notification system)
        showNotification(
            formMode.value === 'create' ? 'Profession added successfully!' : 'Profession updated successfully!',
            'success'
        );

        // Reset the form
        resetForm();
    } catch (error) {
        console.error('Error submitting form:', error);

        // Handle validation errors from backend
        if (error.response && error.response.data && error.response.data.errors) {
            errors.value = error.response.data.errors;
        } else {
            showNotification('An error occurred. Please try again.', 'error');
        }
    } finally {
        loading.value = false;
    }
};

const editProfession = (profession) => {
    formMode.value = 'edit';
    currentProfessionId.value = profession.id;
    form.value.profession_name = profession.profession_name;

    // Scroll to form
    document.querySelector('form').scrollIntoView({ behavior: 'smooth' });
};

const deleteProfession = async (id) => {
    if (!confirm('Are you sure you want to delete this profession?')) {
        return;
    }

    loading.value = true;
    try {
        await axios.delete(route('hero-profession.destroy', id));
        showNotification('Profession deleted successfully!', 'success');
    } catch (error) {
        console.error('Error deleting profession:', error);
        showNotification('An error occurred while deleting the profession.', 'error');
    } finally {
        loading.value = false;
    }
};

const resetForm = () => {
    form.value.profession_name = '';
    errors.value.profession_name = '';
    formMode.value = 'create';
    currentProfessionId.value = null;
};

// Utility function to format date
const formatDate = (dateString) => {
    if (!dateString) return '';
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric'
    }).format(date);
};

// This is a placeholder - implement based on your notification system
const showNotification = (message, type) => {
    console.log(`${type.toUpperCase()}: ${message}`);
    // Example implementation might look like:
    // toast.add({
    //   type: type,
    //   message: message,
    //   duration: 3000
    // });
};
</script>

<style scoped>
/* Optional animations for list changes */
.list-enter-active,
.list-leave-active {
    transition: all 0.3s ease;
}

.list-enter-from,
.list-leave-to {
    opacity: 0;
    transform: translateY(30px);
}
</style>
