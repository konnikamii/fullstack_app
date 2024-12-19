<script setup lang="ts">
import { defineComponent,onMounted } from "vue";   

  // Dark mode toggler 
  onMounted(() => {
    const htmlEl = document.documentElement; // Get the <html> element
    const themeToggler = document.getElementById('theme-toggle-desktop');
    const themeTogglerMobile = document.getElementById('theme-toggle-mobile');
    const heroSection = document.getElementById('hero');
    let newTheme = localStorage.getItem('theme') as 'light' | 'dark' | null;

    if (!newTheme) {
      newTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
      localStorage.setItem('theme', newTheme);
    }

    // Set the initial theme
    if (newTheme === 'dark') {
      htmlEl.classList.add('dark');
      heroSection?.classList.remove('bg-light');
      heroSection?.classList.add('bg-dark');
    } else {
      htmlEl.classList.remove('dark');
      heroSection?.classList.remove('bg-dark');
      heroSection?.classList.add('bg-light');
    }

    // Toggle theme function
    const toggleTheme = () => {
      const currentTheme = htmlEl.classList.contains('dark') ? 'dark' : 'light';
      const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
      htmlEl.classList.toggle('dark');
      if (newTheme === 'dark') {
        heroSection?.classList.remove('bg-light');
        heroSection?.classList.add('bg-dark');
      } else {
        heroSection?.classList.remove('bg-dark');
        heroSection?.classList.add('bg-light');
      }
      localStorage.setItem('theme', newTheme);
    };

    // Add event listener to the theme toggle button
    if (themeToggler) {
      themeToggler.addEventListener('click', toggleTheme);
    }
    if (themeTogglerMobile) {
      themeTogglerMobile.addEventListener('click', toggleTheme);
    }

    // Cleanup event listener on component unmount
    return () => {
      if (themeToggler) {
        themeToggler.removeEventListener('click', toggleTheme);
      }
      if (themeTogglerMobile) {
        themeTogglerMobile.removeEventListener('click', toggleTheme);
      }
    };
  }); 
</script>

<template>
  <nav
    id="navbar"
    class="fixed w-full h-[80px] transition-all duration-300 border-b bg-gray-100/90 shadow-lg shadow-gray-400/40 border-gray-400/80 dark:bg-black/80 dark:shadow-2xl dark:shadow-gray-700/60 dark:border-gray-600/80 flex justify-between items-center gap-2 lg:pl-[220px] lg:pr-[200px] pl-[25px] pr-[25px] backdrop-blur z-10 text-nowrap"
  >
    <a
      href="https://www.conda.at/en/home-en/"
      class="flex lg:gap-4 gap-2 items-center cursor-pointer group"
      target="_blank"
      rel="noopener noreferrer"
      draggable="false"
    >
      <img
        width="150"
        src="https://conda-wp.cdn-conda.com/uploads/2024/01/cropped-Conda_Crowdinvesting_2c_positiv@1x.png"
        class="responsive mr-3"
        alt="CONDA Crowdinvesting - investieren in Startups und KMU"
        decoding="async"
        fetchpriority="high"
        srcset="
          https://conda-wp.cdn-conda.com/uploads/2024/01/cropped-Conda_Crowdinvesting_2c_positiv@1x.png         657w,
          https://conda-wp.cdn-conda.com/uploads/2024/01/cropped-Conda_Crowdinvesting_2c_positiv@1x-300x143.png 300w
        "
        sizes="(max-width: 657px) 100vw, 657px"
      />
    </a>
    <div
      id="menu"
      class="flex lg:gap-8 md:gap-4 items-center text-black dark:text-white"
    >
      <button id="theme-toggle-desktop"
        class="relative inline-flex items-center justify-center w-12 h-6 bg-gray-500 dark:bg-gray-600 rounded-full transition duration-300 focus:outline-none shadow-md shadow-gray-700 hover:shadow-gray-800 dark:hover:shadow-gray-600"
        draggable="false"
        aria-label="theme-toggle"
      >
        <svg
          class="absolute left-1 size-4 bg-white fill-[#ffa700] rounded-full transition duration-300 transform dark:translate-x-6 dark:opacity-0"
          viewBox="0 0 32 32"
        >
          <path
            d="M20.8538 3.41119L16.2684 6.32918C16.1047 6.4334 15.8953 6.4334 15.7316 6.32918L11.1462 3.41119C10.8417 3.21742 10.4384 3.40026 10.3835 3.757L9.55575 9.1376C9.52257 9.35331 9.35331 9.52257 9.1376 9.55575L3.8109 10.3752C3.44083 10.4322 3.26233 10.8607 3.48256 11.1635L6.78612 15.7059C6.91363 15.8812 6.91363 16.1188 6.78612 16.2941L3.48256 20.8365C3.26233 21.1393 3.44082 21.5678 3.8109 21.6248L9.1376 22.4442C9.35331 22.4774 9.52257 22.6467 9.55575 22.8624L10.3835 28.243C10.4384 28.5997 10.8417 28.7826 11.1462 28.5888L15.7316 25.6708C15.8953 25.5666 16.1047 25.5666 16.2684 25.6708L20.8538 28.5888C21.1583 28.7826 21.5616 28.5997 21.6165 28.243L22.4442 22.8624C22.4774 22.6467 22.6467 22.4774 22.8624 22.4442L28.243 21.6165C28.5997 21.5616 28.7826 21.1583 28.5888 20.8538L25.6708 16.2684C25.5666 16.1047 25.5666 15.8953 25.6708 15.7316L28.5888 11.1462C28.7826 10.8417 28.5997 10.4384 28.243 10.3835L22.8624 9.55575C22.6467 9.52257 22.4774 9.35331 22.4442 9.1376L21.6165 3.757C21.5616 3.40026 21.1583 3.21742 20.8538 3.41119Z"
            stroke="none"
          ></path>
          <circle cx="16" cy="16" r="9" fill="white" stroke="none"></circle>
          <circle cx="16" cy="16" r="6" stroke="none"></circle>
        </svg>
        <svg
          class="absolute left-1 size-4 bg-white fill-black rounded-full transition duration-300 transform dark:translate-x-6 opacity-0 -rotate-180 dark:opacity-100 dark:rotate-0"
          viewBox="0 0 32 32"
        >
          <path
            d="M17.7999 3C10.727 3 5 8.5971 5 15.5C5 22.4029 10.727 28 17.7999 28C21.2704 28 24.4146 26.6496 26.7226 24.4621C27.0089 24.1886 27.0834 23.7645 26.9001 23.4185C26.7168 23.0725 26.3217 22.8772 25.9265 22.9442C25.3653 23.0391 24.7926 23.0893 24.2027 23.0893C18.6532 23.0893 14.1518 18.692 14.1518 13.2679C14.1518 9.59598 16.2135 6.39844 19.266 4.71317C19.6153 4.51786 19.7929 4.12723 19.707 3.74777C19.6211 3.3683 19.2889 3.08371 18.888 3.05022C18.5272 3.02232 18.1664 3.00558 17.7999 3.00558V3Z"
            stroke="none"
          ></path>
        </svg>
      </button>
      <div class="group-fast">
        <a
          href="https://www.conda.at/en/about-crowdinvesting/"
          id="nav-desktop-features"
          class="relative underline-animation font-medium hover:text-[#63ab8e] transition duration-300"
          target="_blank"
          rel="noopener noreferrer"
          draggable="false"
          >start investing</a
        >
      </div>
      <div class="group-fast">
        <a
          href="https://www.conda.at/en/unternehmen-finanzieren-en/"
          id="nav-desktop-faq"
          class="relative underline-animation font-medium hover:text-[#63ab8e] transition duration-300"
          target="_blank"
          rel="noopener noreferrer"
          draggable="false"
          >raise funding</a
        >
      </div>
      <div class="group-fast">
        <a
          href="https://www.conda.at/en/?page_id=113223"
          id="nav-desktop-contact"
          class="relative underline-animation font-medium hover:text-[#63ab8e] transition duration-300"
          target="_blank"
          rel="noopener noreferrer"
          draggable="false"
          >about us</a
        >
      </div>
      <div class="group-fast">
        <a
          href="https://www.conda.at/en/newsletter-subscription/"
          id="nav-desktop-contact"
          class="relative underline-animation font-medium hover:text-[#63ab8e] transition duration-300"
          target="_blank"
          rel="noopener noreferrer"
          draggable="false"
          >newsletter</a
        >
      </div> 
    </div>
  </nav>
</template>

<script lang="ts">
export default defineComponent({});
</script>

<style scoped></style>
