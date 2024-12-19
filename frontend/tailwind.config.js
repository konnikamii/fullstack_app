/** @type {import('tailwindcss').Config} */
import typography from '@tailwindcss/typography';  
// import vue from '@vitejs/plugin-vue'
export default {
  darkMode: 'class',
  content: ['./*.html',"./src/**/*.{html,js,jsx,ts,tsx,vue}"],
  theme: { 
    screens: {
      '2xs': '375px',
      xs: '425px',
      sm: '640px',
      md: '768px',
      lg: '1024px',
      xl: '1280px',
      '2xl': '1440px',
    },
    extend: {
      fontFamily: {
        roboto: ["Roboto", "sans-serif"],
        mont: ["Montserrat", "sans-serif"],
      },
      colors: {
        color1: "#003366",
        color2: "#004080",
        color3: "#ffa500",
        color4: "hsl(208, 100%, 97%)",
        fbcolor: "#3e5dfa",
        fbcolorbg: "#f0f2f5",
      },
      boxShadow: {
        'round': '0 0px 3px 1px',
      },
    }
  }, 
  variants: { }, 
  css: {
    postcss: './postcss.config.js',
  },
  plugins: [ 
    typography,
    // require('@tailwindcss/typography')
  ],
}

