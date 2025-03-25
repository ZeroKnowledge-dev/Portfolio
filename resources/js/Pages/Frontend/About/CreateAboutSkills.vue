<template>
    <Navbar />
    <div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-teal-500 p-6">
                <h2 class="text-2xl font-bold text-white">Skills Management</h2>
                <p class="text-blue-100 mt-1">Add, edit, and organize your professional skills</p>
            </div>

            <div class="p-6">
                <!-- Skills Form -->
                <form @submit.prevent="submitSkill" class="bg-gray-50 p-6 rounded-lg border border-gray-200 mb-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ editMode ? 'Edit Skill' : 'Add New Skill' }}
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Skill Name -->
                        <div>
                            <label for="skill_name" class="block text-sm font-medium text-gray-700 mb-1">Skill
                                Name</label>
                            <input id="skill_name" v-model="skillForm.skill_name" type="text" :class="[
                                'w-full px-4 py-2 border rounded-lg focus:ring-2 focus:outline-none transition-colors',
                                errors.skill_name
                                    ? 'border-red-300 focus:border-red-500 focus:ring-red-200'
                                    : 'border-gray-300 focus:border-blue-500 focus:ring-blue-200'
                            ]" placeholder="e.g. JavaScript, Photoshop, Project Management"
                                @input="errors.skill_name = ''" />
                            <div v-if="errors.skill_name" class="mt-1 text-sm text-red-600">{{ errors.skill_name }}
                            </div>
                        </div>

                        <!-- Skill Percentage -->
                        <div>
                            <label for="skill_percentage" class="block text-sm font-medium text-gray-700 mb-1">
                                Proficiency (%)
                                <span class="ml-1 text-blue-600 font-bold">{{ skillForm.skill_percentage }}%</span>
                            </label>
                            <input id="skill_percentage" v-model="skillForm.skill_percentage" type="range" min="0"
                                max="100" step="5"
                                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-blue-600"
                                @input="errors.skill_percentage = ''" />
                            <div class="flex justify-between text-xs text-gray-500 px-1 mt-1">
                                <span>Beginner</span>
                                <span>Intermediate</span>
                                <span>Expert</span>
                            </div>
                            <div v-if="errors.skill_percentage" class="mt-1 text-sm text-red-600">{{
                                errors.skill_percentage }}</div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-3 mt-6">
                        <button v-if="editMode" type="button"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-colors"
                            @click="cancelEdit" :disabled="isSubmitting">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-6 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors flex items-center"
                            :disabled="isSubmitting">
                            <span v-if="isSubmitting" class="inline-block mr-2">
                                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </span>
                            {{ editMode ? 'Update Skill' : 'Add Skill' }}
                        </button>
                    </div>
                </form>

                <!-- Skills List -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                <path fill-rule="evenodd"
                                    d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                                    clip-rule="evenodd" />
                            </svg>
                            Your Skills
                        </h3>
                        <div class="flex items-center">
                            <button @click="sortSkills"
                                class="flex items-center space-x-1 text-sm text-gray-600 hover:text-blue-600 transition-colors">
                                <span>Sort by {{ sortOrder === 'asc' ? 'Highest' : 'Lowest' }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path v-if="sortOrder === 'asc'" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                                    <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 4h13M3 8h9m-9 4h6m4 0l-4-4m0 8l4-4" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div v-if="isLoading" class="text-center py-12">
                        <svg class="animate-spin h-10 w-10 text-blue-500 mx-auto" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <p class="mt-3 text-gray-600">Loading your skills...</p>
                    </div>

                    <div v-else-if="props.skill.length === 0"
                        class="bg-gray-50 rounded-lg border border-gray-200 p-10 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No skills added yet</h3>
                        <p class="text-gray-600 mb-6">Showcase your expertise by adding skills to your profile</p>
                        <button @click="focusSkillNameInput"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            Add Your First Skill
                        </button>
                    </div>

                    <transition-group v-else name="skill-list" tag="div" class="space-y-4">
                        <div v-for="skill in sortedSkills" :key="skill.id"
                            class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow p-4">
                            <div class="flex justify-between items-center mb-2">
                                <h4 class="text-lg font-medium text-gray-900">{{ skill.skill_name }}</h4>
                                <div class="flex space-x-2">
                                    <button @click="editSkill(skill)"
                                        class="p-1.5 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-md transition-colors"
                                        title="Edit skill">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>
                                    <button @click="confirmDeleteSkill(skill)"
                                        class="p-1.5 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-md transition-colors"
                                        title="Delete skill">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="relative pt-1">
                                <div class="flex items-center justify-between mb-1">
                                    <div>
                                        <span
                                            class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full"
                                            :class="getLevelClass(skill.skill_percentage)">
                                            {{ getSkillLevel(skill.skill_percentage) }}
                                        </span>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-xs font-semibold inline-block text-blue-600">
                                            {{ skill.skill_percentage }}%
                                        </span>
                                    </div>
                                </div>
                                <div class="overflow-hidden h-2 text-xs flex rounded bg-gray-200">
                                    <div :style="`width: ${skill.skill_percentage}%`"
                                        :class="getProgressBarClass(skill.skill_percentage)"
                                        class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center transition-all duration-500">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </transition-group>
                </div>
            </div>
        </div>

        <!-- Confirmation Modal -->
        <div v-if="showDeleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6 transform transition-all">
                <div class="text-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-500 mx-auto" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mt-2">Delete Skill</h3>
                    <p class="text-gray-600 mt-1">Are you sure you want to delete "{{ skillToDelete?.skill_name }}"?
                        This action cannot be undone.</p>
                </div>
                <div class="flex justify-end space-x-3">
                    <button @click="showDeleteModal = false"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-colors">
                        Cancel
                    </button>
                    <button @click="deleteSkill"
                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors"
                        :disabled="isDeleting">
                        <span v-if="isDeleting" class="inline-block mr-2">
                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </span>
                        Delete
                    </button>
                </div>
            </div>
        </div>

        <!-- Toast Notification -->
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
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import Navbar from '@/Components/Application/Navbar.vue';

const props = defineProps({
    skill: Object
});

// State
const isLoading = ref(false);
const isSubmitting = ref(false);
const isDeleting = ref(false);
const editMode = ref(false);
const currentSkillId = ref(null);
const sortOrder = ref('desc'); // 'asc' or 'desc'
const showDeleteModal = ref(false);
const skillToDelete = ref(null);

// Form state
const skillForm = ref({
    skill_name: '',
    skill_percentage: 75
});

// Error handling
const errors = ref({
    skill_name: '',
    skill_percentage: ''
});

// Notification system
const notification = ref({
    show: false,
    type: 'success', // 'success' or 'error'
    message: ''
});

// Computed properties
const sortedSkills = computed(() => {
    return props.skill && Array.isArray(props.skill)
        ? [...props.skill].sort((a, b) => {
            const percentageA = parseInt(a.skill_percentage);
            const percentageB = parseInt(b.skill_percentage);

            if (sortOrder.value === 'desc') {
                return percentageB - percentageA;
            } else {
                return percentageA - percentageB;
            }
        })
        : [];
});

const submitSkill = async () => {
    // Clear previous errors
    errors.value.skill_name = '';
    errors.value.skill_percentage = '';

    // Validate form
    if (!skillForm.value.skill_name.trim()) {
        errors.value.skill_name = 'Skill name is required';
        return;
    }

    if (!skillForm.value.skill_percentage) {
        errors.value.skill_percentage = 'Proficiency level is required';
        return;
    }

    isSubmitting.value = true;

    try {
        if (editMode.value) {
            // Update existing skill
            await axios.put(route('about-skill.update', currentSkillId.value), skillForm.value);
            showNotification('Skill updated successfully!', 'success');
        } else {
            // Create new skill
            await axios.post(route('about-skill.store'), skillForm.value);
            showNotification('New skill added successfully!', 'success');
        }
        resetForm();
    } catch (error) {
        console.error('Error saving skill:', error);

        // Handle validation errors from backend
        if (error.response && error.response.data && error.response.data.errors) {
            const backendErrors = error.response.data.errors;

            if (backendErrors.skill_name) {
                errors.value.skill_name = backendErrors.skill_name[0];
            }

            if (backendErrors.skill_percentage) {
                errors.value.skill_percentage = backendErrors.skill_percentage[0];
            }
        } else {
            showNotification('Failed to save skill. Please try again.', 'error');
        }
    } finally {
        isSubmitting.value = false;
    }
};

const editSkill = (skill) => {
    editMode.value = true;
    currentSkillId.value = skill.id;
    skillForm.value.skill_name = skill.skill_name;
    skillForm.value.skill_percentage = skill.skill_percentage;

    // Scroll to form
    document.querySelector('form').scrollIntoView({ behavior: 'smooth' });
};

const cancelEdit = () => {
    resetForm();
};

const resetForm = () => {
    skillForm.value.skill_name = '';
    skillForm.value.skill_percentage = 75;
    editMode.value = false;
    currentSkillId.value = null;
    errors.value.skill_name = '';
    errors.value.skill_percentage = '';
};

const confirmDeleteSkill = (skill) => {
    skillToDelete.value = skill;
    showDeleteModal.value = true;
};

const deleteSkill = async () => {
    if (!skillToDelete.value) return;

    isDeleting.value = true;

    try {
        await axios.delete(route('about-skill.destroy', skillToDelete.value.id));
        showNotification('Skill deleted successfully!', 'success');
    } catch (error) {
        console.error('Error deleting skill:', error);
        showNotification('Failed to delete skill. Please try again.', 'error');
    } finally {
        isDeleting.value = false;
        showDeleteModal.value = false;
        skillToDelete.value = null;
    }
};

const sortSkills = () => {
    sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc';
};

const focusSkillNameInput = () => {
    document.getElementById('skill_name').focus();
};

// Helper methods
const getSkillLevel = (percentage) => {
    const value = parseInt(percentage);
    if (value >= 90) return 'Expert';
    if (value >= 75) return 'Advanced';
    if (value >= 50) return 'Intermediate';
    if (value >= 25) return 'Basic';
    return 'Beginner';
};

const getLevelClass = (percentage) => {
    const value = parseInt(percentage);
    if (value >= 90) return 'bg-blue-100 text-blue-800';
    if (value >= 75) return 'bg-green-100 text-green-800';
    if (value >= 50) return 'bg-yellow-100 text-yellow-800';
    if (value >= 25) return 'bg-orange-100 text-orange-800';
    return 'bg-red-100 text-red-800';
};

const getProgressBarClass = (percentage) => {
    const value = parseInt(percentage);
    if (value >= 90) return 'bg-blue-600';
    if (value >= 75) return 'bg-green-500';
    if (value >= 50) return 'bg-yellow-500';
    if (value >= 25) return 'bg-orange-500';
    return 'bg-red-500';
};

const showNotification = (message, type = 'success') => {
    notification.value = {
        show: true,
        type,
        message
    };

    // Auto-dismiss notification after 3 seconds
    setTimeout(() => {
        notification.value.show = false;
    }, 3000);
};
</script>

<style scoped>
/* Transition for skill list */
.skill-list-enter-active,
.skill-list-leave-active {
    transition: all 0.3s ease;
}

.skill-list-enter-from,
.skill-list-leave-to {
    opacity: 0;
    transform: translateY(20px);
}

input[type="range"] {
    -webkit-appearance: none;
    appearance: none;
    background: transparent;
    cursor: pointer;
}

/* Chrome, Safari, Edge */
input[type="range"]::-webkit-slider-runnable-track {
    background: #e2e8f0;
    height: 0.5rem;
    border-radius: 0.25rem;
}

input[type="range"]::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    margin-top: -4px;
    background-color: #3b82f6;
    height: 1rem;
    width: 1rem;
    border-radius: 50%;
}

/* Firefox */
input[type="range"]::-moz-range-track {
    background: #e2e8f0;
    height: 0.5rem;
    border-radius: 0.25rem;
}

input[type="range"]::-moz-range-thumb {
    background-color: #3b82f6;
    height: 1rem;
    width: 1rem;
    border: none;
    border-radius: 50%;
}

/* Focus styles */
input[type="range"]:focus {
    outline: none;
}

input[type="range"]:focus::-webkit-slider-thumb {
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
}

input[type="range"]:focus::-moz-range-thumb {
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
}
</style>
