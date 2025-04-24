import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

import { createApp } from 'vue';
import App from './App.vue';
import Antd from 'ant-design-vue';
import store from './store';
import router from './router';
import './axios'; // Import để khởi tạo axios instance

// import 'ant-design-vue/dist/antd.css';

import 'bootstrap/dist/css/bootstrap.min.css';
import 'flag-icon-css/css/flag-icons.min.css';

const app = createApp(App);

app.use(store);
app.use(router);
app.use(Antd);

app.mount('#app');
