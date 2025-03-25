<template>
    <Navbar />
    <div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8 bg-white rounded-lg shadow-md">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-6">Manage Hero Section Skills</h1>

        <!-- Add New Skill Form -->
        <div class="mb-8 p-4 bg-gray-50 rounded-lg border border-gray-200">
            <h2 class="text-lg font-medium text-gray-800 mb-4">Add New Skill</h2>

            <form @submit.prevent="addSkill" class="space-y-4">
                <div class="space-y-2">
                    <label for="icon_class" class="block text-sm font-medium text-gray-700">Icon Class*</label>
                    <div class="flex space-x-2">
                        <div class="relative flex-1">
                            <input id="icon_class" v-model="newSkill.icon_class" type="text" required
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="e.g., fa-code, devicon-react-plain" />
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i :class="[newSkill.icon_class || 'fa fa-question', 'text-gray-400']"></i>
                            </div>
                        </div>

                        <button type="button" @click="openIconSelector"
                            class="px-4 py-2 border border-gray-300 bg-gray-50 text-gray-700 rounded-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            Browse Icons
                        </button>
                    </div>
                    <p v-if="errors.icon_class" class="mt-1 text-sm text-red-600">{{ errors.icon_class }}</p>
                    <p class="text-xs text-gray-500">Enter a valid icon class from Font Awesome, Devicon, or other icon
                        libraries you're using.</p>
                </div>

                <!-- Icon Preview -->
                <div v-if="newSkill.icon_class" class="p-4 bg-white border border-gray-200 rounded-md">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Preview:</h3>
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 flex items-center justify-center bg-indigo-100 rounded-full">
                            <i :class="[newSkill.icon_class, 'text-2xl text-indigo-600']"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">{{ newSkill.icon_class }}</p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" :disabled="isSubmitting || !newSkill.icon_class"
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
                        <span v-else>Add Skill</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Existing Skills List -->
        <div>
            <h2 class="text-lg font-medium text-gray-800 mb-4">Your Skills</h2>

            <!-- Empty State -->
            <div v-if="skills.length === 0" class="p-8 text-center bg-gray-50 rounded-lg border border-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <p class="mt-2 text-sm text-gray-600">No skills added yet. Add your first skill above.</p>
            </div>

            <!-- Skills Grid -->
            <div v-else class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                <div v-for="skill in skills" :key="skill.id"
                    class="p-4 bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 flex items-center justify-center bg-indigo-100 rounded-full">
                                <i :class="[skill.icon_class, 'text-xl text-indigo-600']"></i>
                            </div>
                            <span class="font-medium text-gray-700">{{ skill.icon_class }}</span>
                        </div>

                        <div class="flex space-x-1">
                            <button @click="editSkill(skill)"
                                class="p-1 text-gray-500 hover:text-gray-700 focus:outline-none" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>

                            <button @click="confirmDeleteSkill(skill)"
                                class="p-1 text-gray-500 hover:text-red-600 focus:outline-none" title="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination (if needed) -->
            <div v-if="skills.length > 0" class="mt-6 flex justify-between items-center">
                <p class="text-sm text-gray-600">Showing {{ skills.length }} skill{{ skills.length !== 1 ? 's' : '' }}
                </p>

                <nav class="flex space-x-2" aria-label="Pagination">
                    <!-- Pagination controls would go here -->
                </nav>
            </div>
        </div>

        <!-- Success Message -->
        <div v-if="showSuccessMessage" class="mt-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
            {{ successMessage }}
        </div>

        <!-- Icon Selector Modal (placeholder for integration with an icon picker) -->
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
                    <!-- Mock icon browser - in a real app, you would integrate with an icon library -->
                    <div class="mb-4">
                        <input type="text" placeholder="Search icons..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-md" />
                    </div>

                    <div class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 gap-4">
                        <button v-for="iconClass in commonIcons" :key="iconClass" @click="selectIcon(iconClass)"
                            class="p-3 flex flex-col items-center justify-center border border-gray-200 rounded-md hover:bg-gray-50">
                            <i :class="[iconClass, 'text-2xl text-gray-700']"></i>
                            <span class="mt-2 text-xs text-gray-500 truncate w-full text-center">{{ iconClass }}</span>
                        </button>
                    </div>
                </div>

                <div class="p-4 border-t border-gray-200 flex justify-end">
                    <button @click="showIconSelector = false"
                        class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Cancel
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
                    <p class="text-sm text-gray-600">Are you sure you want to delete this skill? This action cannot be
                        undone.</p>
                </div>

                <div class="p-4 border-t border-gray-200 flex justify-end space-x-3">
                    <button @click="showDeleteConfirmation = false"
                        class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Cancel
                    </button>
                    <button @click="deleteSkill"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                        Delete
                    </button>
                </div>
            </div>
        </div>

        <!-- Edit Skill Modal -->
        <div v-if="showEditModal"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
            <div class="bg-white rounded-lg max-w-md w-full">
                <div class="p-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Edit Skill</h3>
                </div>

                <div class="p-4">
                    <div class="space-y-2">
                        <label for="edit_icon_class" class="block text-sm font-medium text-gray-700">Icon Class*</label>
                        <div class="relative">
                            <input id="edit_icon_class" v-model="editingSkill.icon_class" type="text" required
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="e.g., fa-code, devicon-react-plain" />
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i :class="[editingSkill.icon_class || 'fa fa-question', 'text-gray-400']"></i>
                            </div>
                        </div>
                        <p v-if="errors.edit_icon_class" class="mt-1 text-sm text-red-600">{{ errors.edit_icon_class }}
                        </p>
                    </div>

                    <!-- Icon Preview -->
                    <div v-if="editingSkill.icon_class" class="mt-4 p-4 bg-gray-50 border border-gray-200 rounded-md">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Preview:</h3>
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 flex items-center justify-center bg-indigo-100 rounded-full">
                                <i :class="[editingSkill.icon_class, 'text-2xl text-indigo-600']"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">{{ editingSkill.icon_class }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-4 border-t border-gray-200 flex justify-end space-x-3">
                    <button @click="showEditModal = false"
                        class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Cancel
                    </button>
                    <button @click="updateSkill" :disabled="isSubmitting || !editingSkill.icon_class"
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
    </div>
</template>

<script setup>
import axios from 'axios';
import { ref, reactive, watch } from 'vue';
import Navbar from '@/Components/Application/Navbar.vue';

const props = defineProps({
    skills: Array
});

const emit = defineEmits(['update:skills']);

// Local state
const newSkill = reactive({
    icon_class: ''
});
const editingSkill = reactive({
    id: null,
    icon_class: ''
});

const errors = reactive({});
const isSubmitting = ref(false);
const showSuccessMessage = ref(false);
const successMessage = ref('');
const showIconSelector = ref(false);
const showDeleteConfirmation = ref(false);
const showEditModal = ref(false);
const skillToDelete = ref(null);

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

// Add new skill
const addSkill = async () => {
    isSubmitting.value = true;
    errors.icon_class = '';

    try {
        const response = await axios.post(route('hero-skill.store'), { icon_class: newSkill.icon_class });
        emit('update:skills', [...props.skills, response.data]);
        newSkill.icon_class = '';
        successMessage.value = 'Skill added successfully!';
        showSuccessMessage.value = true;
    } catch (err) {
        if (err.response && err.response.data && err.response.data.errors) {
            errors.icon_class = err.response.data.errors.icon_class?.[0] || 'An error occurred.';
        }
    } finally {
        isSubmitting.value = false;
    }
};

// Edit skill setup
const editSkill = (skill) => {
    editingSkill.id = skill.id;
    editingSkill.icon_class = skill.icon_class;
    errors.edit_icon_class = '';
    showEditModal.value = true;
};

// Update skill
const updateSkill = async () => {
    isSubmitting.value = true;
    errors.edit_icon_class = '';

    try {
        const response = await axios.put(route('hero-skill.update', editingSkill.id), {
            icon_class: editingSkill.icon_class
        });

        const updatedSkills = props.skills.map((skill) =>
            skill.id === editingSkill.id ? response.data : skill
        );
        emit('update:skills', updatedSkills);
        successMessage.value = 'Skill updated successfully!';
        showSuccessMessage.value = true;
        showEditModal.value = false;
    } catch (err) {
        if (err.response?.data?.errors) {
            errors.edit_icon_class = err.response.data.errors.icon_class?.[0] || 'An error occurred.';
        }
    } finally {
        isSubmitting.value = false;
    }
};

// Delete skill
const confirmDeleteSkill = (skill) => {
    skillToDelete.value = skill;
    showDeleteConfirmation.value = true;
};

const deleteSkill = async () => {
    try {
        await axios.delete(route('hero-skill.destroy', skillToDelete.value.id));
        emit('update:skills', props.skills.filter(s => s.id !== skillToDelete.value.id));
        successMessage.value = 'Skill deleted successfully!';
        showSuccessMessage.value = true;
    } catch (err) {
        console.error(err);
    } finally {
        showDeleteConfirmation.value = false;
    }
};

// Icon selector
const openIconSelector = () => {
    showIconSelector.value = true;
};

const selectIcon = (iconClass) => {
    newSkill.icon_class = iconClass;
    showIconSelector.value = false;
};

// Auto-hide success message
watch(showSuccessMessage, (val) => {
    if (val) {
        setTimeout(() => {
            showSuccessMessage.value = false;
        }, 3000);
    }
});
</script>
