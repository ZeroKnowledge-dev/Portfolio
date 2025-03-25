<script setup>
import { ref, onMounted } from "vue";
import AOS from "aos";

const menuToggle = ref(null);
const mobileMenu = ref(null);
const typingElement = ref(null);
const particlesContainer = ref(null);
const navbar = ref(null);

const props = defineProps({
    personName: String,
    description: String,
    personImage: String,
    Profession: Array,
    techStack: Array
})

onMounted(() => {
    AOS.init({
        duration: 1000,
        once: true,
        easing: 'ease-out',
    });

    if (menuToggle.value && mobileMenu.value) {
        menuToggle.value.addEventListener('click', () => {
            mobileMenu.value.classList.toggle('hidden');
        });
    }

    // Typing animation with cursor effect
    const texts = props.Profession;
    let count = 0;
    let index = 0;
    let isDeleting = false;

    function type() {
        if (!typingElement.value) return;

        let currentText = texts[count];

        if (isDeleting) {
            typingElement.value.innerHTML = `${currentText.substring(0, index - 1)}<span class='cursor'>|</span>`;
            index--;
        } else {
            typingElement.value.innerHTML = `${currentText.substring(0, index + 1)}<span class='cursor'>|</span>`;
            index++;
        }

        if (!isDeleting && index === currentText.length) {
            isDeleting = true;
            setTimeout(type, 2000);
        } else if (isDeleting && index === 0) {
            isDeleting = false;
            count = (count + 1) % texts.length;
            setTimeout(type, 500);
        } else {
            setTimeout(type, isDeleting ? 100 : 150);
        }
    }
    setTimeout(type, 1000);

    // Floating particles effect
    const createParticle = () => {
        if (!particlesContainer.value) return;

        const particle = document.createElement('div');
        particle.classList.add('particle');

        const size = Math.random() * 10 + 5;
        const posX = Math.random() * window.innerWidth;
        const duration = Math.random() * 15 + 10;

        particle.style.width = `${size}px`;
        particle.style.height = `${size}px`;
        particle.style.left = `${posX}px`;
        particle.style.animation = `float ${duration}s linear infinite`;
        particlesContainer.value.appendChild(particle);

        setTimeout(() => {
            particle.remove();
        }, duration * 1000);
    };

    for (let i = 0; i < 30; i++) {
        createParticle();
    }

    setInterval(createParticle, 2000);

    // Navbar shrink effect on scroll
    window.addEventListener('scroll', () => {
        if (!navbar.value) return;
        navbar.value.classList.toggle('shrink', window.scrollY > 50);
    });
});
</script>

<template>
    <!-- Hero Section -->
    <section id="hero" class="text-white relative min-h-screen flex items-center justify-center px-6 overflow-hidden">
        <!-- Animated particles -->
        <div id="particles-container" class="absolute top-0 left-0 w-full h-full"></div>

        <div class="container mx-auto grid md:grid-cols-2 gap-12 items-center pt-24">
            <!-- Left Content -->
            <div class="z-10">
                <h2 class="text-lg text-purple-400 mb-4 code-font" data-aos="fade-right">
                    <span class="inline-block">&lt;</span>Hello World<span class="inline-block">/&gt;</span>
                </h2>
                <h1 class="text-xl lg:text-4xl font-bold mb-6" data-aos="fade-right" data-aos-delay="100">
                    I'm {{ personName }}, a
                    <span class="gradient-text typing-animation" ref="typingElement">Web Developer</span>
                </h1>
                <p class="text-gray-300 mb-8 text-lg" data-aos="fade-right" data-aos-delay="200">
                    {{ description }}
                </p>
                <div class="flex flex-wrap gap-4" data-aos="fade-up" data-aos-delay="300">
                    <a href="#projects"
                        class="btn-primary px-8 py-3 rounded-full text-white font-medium flex items-center">
                        <span>See My Work</span>
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                    <a href="#contact" class="btn-outline px-8 py-3 rounded-full font-medium flex items-center">
                        <i class="fas fa-envelope mr-2"></i>
                        <span>Get In Touch</span>
                    </a>
                </div>

                <!-- Tech Stack -->
                <div class="mt-12" data-aos="fade-up" data-aos-delay="400">
                    <p class="text-gray-400 mb-4 text-sm">TECH STACK</p>
                    <div class="flex flex-wrap gap-4">
                        <div v-for="tech in techStack"
                            class="bg-gray-800 p-3 rounded-lg hover:bg-gray-700 transition-colors">
                            <i :class="tech"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Content - Hero Image -->
            <div class="z-10 order-first md:order-last" data-aos="fade-left" data-aos-delay="200">
                <div class="relative">
                    <div
                        class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-full blur opacity-75 animate-pulse">
                    </div>
                    <div class="relative aspect-square rounded-full p-2 ">
                        <img :src="`/storage/images/${personImage}`" alt="Developer Avatar"
                            class="h-full w-full rounded-full">
                    </div>

                    <!-- Floating badges -->
                    <div v-for="(tech, index) in techStack.slice(0, 4)" :key="index"
                        class="absolute bg-indigo-900 p-3 rounded-lg shadow-lg" :class="{
                            'bottom-12 -left-8': tech === techStack[0],
                            '-bottom-4 right-20': tech === techStack[1],
                            ' -top-14 -right-4': tech === techStack[2],
                            'top-0 left-0': tech === techStack[3]
                        }" data-aos="fade-down" data-aos-delay="600" style="animation: float 6s ease-in-out infinite;">
                        <i :class="tech"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll down indicator -->
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
            <i class="fas fa-chevron-down text-gray-400"></i>
        </div>
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <i class="fas fa-chevron-down text-gray-400"></i>
        </div>
    </section>
</template>

<style scoped>
.particle {
    position: absolute;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 50%;
}

@keyframes float {
    0% {
        transform: translateY(0);
    }

    100% {
        transform: translateY(-100vh);
    }
}

@keyframes glow {

    0%,
    100% {
        opacity: 0.75;
    }

    50% {
        opacity: 1;
    }
}

.cursor {
    display: inline-block;
    animation: blink 1s step-end infinite;
}

@keyframes blink {
    50% {
        opacity: 0;
    }
}

.shrink {
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
}

.border-gradient {
    border-image: linear-gradient(to right, #4f46e5, #d946ef, #ec4899) 1;
}
</style>
