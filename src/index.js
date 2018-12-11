import App from './app/App.vue';

const bootstrap = () => {
    document.addEventListener('DOMContentLoaded', function(event) {
        startVue();
    });
};

const startVue = () => {
    new Vue({
        el: '#vue_app',
        template: '<App></App>',
        components: { App }
    });
};

bootstrap();
