import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import Components from 'unplugin-vue-components/vite';
import { AntDesignVueResolver } from 'unplugin-vue-components/resolvers';

// https://vite.dev/config/
export default defineConfig({
  server: {
    host: '0.0.0.0', 
    port: 3000,
    strictPort: true,
    watch: {
      usePolling: true,
    },
    // proxy: {
    //   "/": "http://localhost:7000",
    // }, 
  },
  plugins: [vue(),
    Components({
      resolvers: [
        AntDesignVueResolver({
          importStyle: false, // css in js
        }),
      ],
    }),],
})
