import './bootstrap';
import { createApp } from 'vue';

const app = createApp({});

import Welcome from './pages/Welcome.vue';

/* Register vue components */
app.component('welcome-component', Welcome);

app.mount('#app');
