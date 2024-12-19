import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import Antd from 'ant-design-vue';
import 'ant-design-vue/dist/reset.css';

const MODE = import.meta.env.MODE?.trim()  
const PROD_DEBUG = import.meta.env.VITE_PROD_DEBUG 


// declare gtag for cookies
declare global {
  interface Window {
    gtag: any;
  }
} 

// turn off logs for production
if (MODE === 'production' && PROD_DEBUG !== 'on') {  
  console.log = function () {};
  console.info = function () {};
  console.warn = function () {};
  console.error = function () {};
}

const app = createApp(App);
app.use(Antd);
app.mount('#app');