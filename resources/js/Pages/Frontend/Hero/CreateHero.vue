<template>
    <Navbar />
    <div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8 bg-white rounded-lg shadow-md">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-6">Create Hero Section</h1>

        <form @submit.prevent="submitForm" class="space-y-6">
            <!-- Website Name -->
            <div class="space-y-2">
                <label for="website_name" class="block text-sm font-medium text-gray-700">Website Name*</label>
                <input id="website_name" v-model="form.website_name" type="text" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Enter website name" />
                <p v-if="errors.website_name" class="mt-1 text-sm text-red-600">{{ errors.website_name }}</p>
            </div>

            <!-- Website Logo -->
            <div class="space-y-2">
                <label for="website_logo" class="block text-sm font-medium text-gray-700">Website Logo</label>
                <div class="flex items-center space-x-4">
                    <div v-if="form.website_logo_preview"
                        class="relative h-20 w-20 border border-gray-300 rounded-md overflow-hidden">
                        <img :src="form.website_logo_preview" alt="Logo preview" class="h-full w-full object-contain" />
                        <button @click="removeWebsiteLogo" type="button"
                            class="absolute top-0 right-0 bg-red-500 text-white p-1 rounded-bl-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="flex-1">
                        <input id="website_logo" ref="websiteLogoInput" type="file" accept="image/*" class="hidden"
                            @change="onWebsiteLogoChange" />
                        <button type="button" @click="$refs.websiteLogoInput.click()"
                            class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ form.website_logo_preview ? 'Change Logo' : 'Upload Logo' }}
                        </button>
                        <p class="mt-1 text-xs text-gray-500">Recommended: Square image, max 2MB</p>
                    </div>
                </div>
                <p v-if="errors.website_logo" class="mt-1 text-sm text-red-600">{{ errors.website_logo }}</p>
            </div>

            <!-- Person Name -->
            <div class="space-y-2">
                <label for="person_name" class="block text-sm font-medium text-gray-700">Person Name*</label>
                <input id="person_name" v-model="form.person_name" type="text" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Enter person name" />
                <p v-if="errors.person_name" class="mt-1 text-sm text-red-600">{{ errors.person_name }}</p>
            </div>

            <!-- Person Image -->
            <div class="space-y-2">
                <label for="person_image" class="block text-sm font-medium text-gray-700">Person Image</label>
                <div class="flex items-center space-x-4">
                    <div v-if="form.person_image_preview"
                        class="relative h-32 w-32 border border-gray-300 rounded-md overflow-hidden">
                        <img :src="form.person_image_preview" alt="Person preview" class="h-full w-full object-cover" />
                        <button @click="removePersonImage" type="button"
                            class="absolute top-0 right-0 bg-red-500 text-white p-1 rounded-bl-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="flex-1">
                        <input id="person_image" ref="personImageInput" type="file" accept="image/*" class="hidden"
                            @change="onPersonImageChange" />
                        <button type="button" @click="$refs.personImageInput.click()"
                            class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ form.person_image_preview ? 'Change Image' : 'Upload Image' }}
                        </button>
                        <p class="mt-1 text-xs text-gray-500">Recommended: Professional portrait, max 5MB</p>
                    </div>
                </div>
                <p v-if="errors.person_image" class="mt-1 text-sm text-red-600">{{ errors.person_image }}</p>
            </div>

            <!-- Description -->
            <div class="space-y-2">
                <label for="description" class="block text-sm font-medium text-gray-700">Description*</label>
                <textarea id="description" v-model="form.description" rows="4" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Enter hero section description"></textarea>
                <div class="flex justify-between">
                    <p v-if="errors.description" class="text-sm text-red-600">{{ errors.description }}</p>
                    <p class="text-xs text-gray-500">{{ charCount }} / 500 recommended</p>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3 pt-4">
                <button type="button" @click="resetForm"
                    class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Reset
                </button>
                <button type="submit" :disabled="isSubmitting"
                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span v-if="isSubmitting" class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        Saving...
                    </span>
                    <span v-else>Save Hero Section</span>
                </button>
            </div>
        </form>

        <!-- Success Message -->
        <div v-if="showSuccessMessage" class="mt-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
            Hero section saved successfully!
        </div>
    </div>
</template>

<script setup>
import { ref, computed, reactive } from 'vue';
import Navbar from '@/Components/Application/Navbar.vue';

const props = defineProps({
    hero: Object
})

// Form state
const form = reactive({
    website_name: props.hero?.website_name || '',
    website_logo: null,
    website_logo_preview: props.hero?.website_logo ? `/storage/logos/${props.hero.website_logo}` : null,
    person_name: props.hero?.person_name || '',
    person_image: null,
    person_image_preview: props.hero?.person_image ? `/storage/images/${props.hero.person_image}` : null,
    description: props.hero?.description || '',
});

// UI state
const errors = reactive({});
const isSubmitting = ref(false);
const showSuccessMessage = ref(false);
const websiteLogoInput = ref(null);
const personImageInput = ref(null);

// Computed properties
const charCount = computed(() => form.description.length);

// Image handling functions
const onWebsiteLogoChange = (event) => {
    const file = event.target.files[0];
    if (!file) return;

    if (file.size > 2 * 1024 * 1024) {
        errors.website_logo = 'Image size should be less than 2MB';
        return;
    }

    form.website_logo = file;
    form.website_logo_preview = URL.createObjectURL(file);
    errors.website_logo = null;
};

const onPersonImageChange = (event) => {
    const file = event.target.files[0];
    if (!file) return;

    if (file.size > 5 * 1024 * 1024) {
        errors.person_image = 'Image size should be less than 5MB';
        return;
    }

    form.person_image = file;
    form.person_image_preview = URL.createObjectURL(file);
    errors.person_image = null;
};

const removeWebsiteLogo = () => {
    form.website_logo = null;
    form.website_logo_preview = null;
    if (websiteLogoInput.value) {
        websiteLogoInput.value.value = '';
    }
};

const removePersonImage = () => {
    form.person_image = null;
    form.person_image_preview = null;
    if (personImageInput.value) {
        personImageInput.value.value = '';
    }
};

// Form submission
const submitForm = async () => {
    // Reset errors
    Object.keys(errors).forEach(key => errors[key] = null);

    // Validate form
    let isValid = true;

    if (!form.website_name.trim()) {
        errors.website_name = 'Website name is required';
        isValid = false;
    }

    if (!form.person_name.trim()) {
        errors.person_name = 'Person name is required';
        isValid = false;
    }

    if (!form.description.trim()) {
        errors.description = 'Description is required';
        isValid = false;
    } else if (form.description.length > 1000) {
        errors.description = 'Description is too long (max 1000 characters)';
        isValid = false;
    }

    if (!isValid) return;

    try {
        isSubmitting.value = true;

        // Create FormData for file uploads
        const formData = new FormData();
        formData.append('website_name', form.website_name);
        formData.append('person_name', form.person_name);
        formData.append('description', form.description);

        if (form.website_logo) {
            formData.append('website_logo', form.website_logo);
        }

        if (form.person_image) {
            formData.append('person_image', form.person_image);
        }

        // Here you would implement your API call
        await axios.post(route('hero.store'), formData);

        // Show success message
        showSuccessMessage.value = true;
        setTimeout(() => {
            showSuccessMessage.value = false;
        }, 5000);

    } catch (error) {
        console.error('Error submitting form:', error);
    } finally {
        isSubmitting.value = false;
    }
};

// Reset form
const resetForm = () => {
    form.website_name = '';
    form.website_logo = null;
    form.website_logo_preview = null;
    form.person_name = '';
    form.person_image = null;
    form.person_image_preview = null;
    form.description = '';

    // Clear errors
    Object.keys(errors).forEach(key => errors[key] = null);

    // Reset file inputs
    if (websiteLogoInput.value) {
        websiteLogoInput.value.value = '';
    }
    if (personImageInput.value) {
        personImageInput.value.value = '';
    }
};
</script>
