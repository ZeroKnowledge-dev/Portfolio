<script setup>
import { Head } from '@inertiajs/vue3';
import Navbar from '../Components/Portfolio_View/Navbar.vue';
import Hero from '../Components/Portfolio_View/Hero.vue';
import About from '../Components/Portfolio_View/About.vue';
import Projects from '../Components/Portfolio_View/Projects.vue';
import Services from '../Components/Portfolio_View/Services.vue';
import Contact from '../Components/Portfolio_View/Contact.vue';

const props = defineProps({
    heroSection: Object,
    heroSectionSkills: Object,
    heroSectionProfessions: Object,
    aboutSection: Object,
    aboutSectionSkills: Object,
    projectSection: Object,
    serviceSection: Object
});

if (props.heroSection === null) {
    window.location.href = '/hero';
} else if (props.aboutSection === null) {
    window.location.href = '/about';
} else if (props.projectSection === null) {
    window.location.href = '/projects';
} else if (props.serviceSection === null) {
    window.location.href = '/services';
} else if (props.heroSectionProfessions === null) {
    window.location.href = '/hero-profession';
} else if (props.heroSectionSkills === null) {
    window.location.href = '/hero-skill';
} else if (props.aboutSectionSkills === null) {
    window.location.href = '/about-skill';
}

</script>

<template>

    <Head :title="`${props.heroSection.website_name}`" />
    <Navbar :websiteName="`${props.heroSection.website_name}`" :websiteLogo="`${props.heroSection.website_logo}`" />
    <Hero :Profession="props.heroSectionProfessions.map((profession) => profession.profession_name)"
        :personName="`${props.heroSection.person_name}`" :description="`${props.heroSection.description}`"
        :techStack="props.heroSectionSkills.map((skill) => skill.icon_class)"
        :personImage="`${props.heroSection.person_image}`" />
    <About :Image="`${props.aboutSection.about_image}`" :experienceYears="`${props.aboutSection.experience_years}`"
        :personName="`${props.heroSection.person_name}`" :jobTitle="`${props.aboutSection.job_title}`"
        :description="`${props.aboutSection.description}`" :skills="props.aboutSectionSkills"
        :gmail="`${props.aboutSection.gmail}`" :phone="`${props.aboutSection.phone}`"
        :address="`${props.aboutSection.address}`" :workType="`${props.aboutSection.work_type}`" />
    <Projects :projects="props.projectSection" />
    <Services :services="props.serviceSection" />
    <Contact />

</template>

<style scoped></style>
