import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

import { createApp } from 'vue';
import App from './App.vue';
import Antd from 'ant-design-vue';
import store from './store';

// import 'ant-design-vue/dist/antd.css';

import 'bootstrap/dist/css/bootstrap.min.css';
import 'flag-icon-css/css/flag-icons.min.css';

const app = createApp(App);

app.use(store); // Sử dụng Vuex store
app.use(Antd);

app.directive('clear', {
    mounted(el, binding) {
        const input = el.querySelector('input');
        const clearButton = el.querySelector('.clear-button');

        if (!input || !clearButton) return;

        clearButton.addEventListener('click', () => {
            input.value = '';
            if (binding.value) {
                binding.value();
            }
        });
    }
});

app.directive("format-currency", {
    beforeMount(el, binding) {
        el.innerText = formatCurrency(binding.value);
    },
    updated(el, binding) {
        el.innerText = formatCurrency(binding.value);
    },
});

const formatCurrency = (amount) => {
    return new Intl.NumberFormat("vi-VN", {
        style: "currency",
        currency: "VND",
    }).format(amount);
};

app.mount("#app")
