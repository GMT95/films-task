import './bootstrap';
import { createApp } from 'vue';
import Notifications from '@kyvg/vue3-notification'

const app = createApp({});
app.use(Notifications)


/* Register vue components */

Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
    app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
});

app.mount('#app');
