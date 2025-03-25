<script setup>
import { onMounted, nextTick, ref } from "vue";
import AOS from "aos";
import "aos/dist/aos.css";

const props = defineProps({
    Image: String,
    experienceYears: String,
    personName: String,
    jobTitle: String,
    gmail: String,
    phone: String,
    address: String,
    workType: String,
    description: String,
    skills: Array
});

// Track animation state
const skillVisible = ref(false);
const animatedSkills = ref([]);

// Function to animate numbers
const animateNumber = (target, index) => {
    let current = 0;
    const step = target / 50; // Smooth transition (divided into 50 steps)

    const updateCounter = () => {
        current += step;
        if (current < target) {
            animatedSkills.value[index] = Math.ceil(current); // Update displayed value
            requestAnimationFrame(updateCounter);
        } else {
            animatedSkills.value[index] = target; // Ensure final value is accurate
        }
    };

    updateCounter();
};

onMounted(async () => {
    await nextTick();
    AOS.init({ duration: 800, easing: "ease-in-out", once: true });

    // Initialize animatedSkills array
    animatedSkills.value = props.skills.map(() => 0);

    // Observe when skills section enters viewport
    const skillObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    skillVisible.value = true;

                    // Animate each skill's number
                    props.skills.forEach((skill, i) => animateNumber(skill.skill_percentage, i));

                    skillObserver.unobserve(entry.target); // Stop observing after animation
                }
            });
        },
        { threshold: 0.3 }
    );

    const skillSection = document.querySelector("#skills");
    if (skillSection) {
        skillObserver.observe(skillSection);
    }
});
</script>

<template>
    <section id="about" class=" text-white bg-[var(--background-color)] relative overflow-hidden">
        <div class="container mx-auto relative z-10">
            <!-- Section Header -->
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-lg text-purple-400 mb-4 code-font">
                    <span class="inline-block">&lt;</span>about me<span class="inline-block">/&gt;</span>
                </h2>
                <h3 class="text-3xl lg:text-4xl font-bold">
                    Get to know <span class="gradient-text">who I am</span>
                </h3>
            </div>

            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Left: Image -->
                <div data-aos="fade-right">
                    <div class="relative">
                        <div class="relative aspect-square overflow-hidden rounded-xl border-2 border-gray-800">
                            <img :src="`/storage/images/${Image}`" alt="Developer Avatar">
                            <div
                                class="absolute -right-6 bottom-1/4 bg-gray-900 p-4 rounded-full border-4 border-gray-800 shadow-xl">
                                <div class="text-center">
                                    <span class="block text-3xl font-bold gradient-text">{{ experienceYears }}+</span>
                                    <span class="text-xs text-gray-300">Years of<br>Experience</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Text -->
                <div data-aos="fade-left">
                    <h4 class="text-2xl font-bold mb-4">
                        I'm <span class="gradient-text">{{ personName }}</span>, a passionate {{ jobTitle }}
                    </h4>
                    <p class="text-gray-300 mb-6" v-html="description.replace(/\n/g, '<br>')"></p>

                    <!-- Skills -->
                    <div id="skills" class="mb-8">
                        <h5 class="text-lg font-semibold mb-4">My Skills</h5>
                        <div class="grid grid-cols-2 gap-y-4 gap-x-8">
                            <div v-for="(skill, index) in skills" :key="skill.skill_name"
                                class="col-span-2 md:col-span-1">
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium">{{ skill.skill_name }}</span>
                                    <span class="text-sm text-purple-400">
                                        {{ animatedSkills[index] }}%
                                    </span>
                                </div>
                                <div class="h-2 bg-gray-800 rounded-full">
                                    <div class="h-full rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 transition-all duration-[1500ms]"
                                        :style="{ width: skillVisible ? skill.skill_percentage + '%' : '0%' }">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                        <div class="flex items-center">
                            <i class="fas fa-envelope text-purple-400 mr-3"></i>
                            <span>{{ gmail }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-phone text-purple-400 mr-3"></i>
                            <span>{{ phone }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt text-purple-400 mr-3"></i>
                            <span>{{ address }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-calendar text-purple-400 mr-3"></i>
                            <span>Available for {{ workType }}</span>
                        </div>
                    </div>

                    <!-- CTA -->
                    <div class="flex flex-wrap gap-4">
                        <a href="#" class="btn-primary px-8 py-3 rounded-full text-white font-medium flex items-center">
                            <i class="fas fa-download mr-2"></i>
                            <span>Download CV</span>
                        </a>
                        <a href="#contact" class="btn-outline px-8 py-3 rounded-full font-medium flex items-center">
                            <i class="fas fa-handshake mr-2"></i>
                            <span>Hire Me</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
