import '../css/app.css';
import './bootstrap';

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'  // <-- jouw router

createApp(App)
    .use(router)
    .mount('#app')
