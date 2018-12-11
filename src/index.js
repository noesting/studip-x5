import VModal from 'vue-js-modal';

import App from './app/App.vue';

const bootstrap = () => {
    document.addEventListener('DOMContentLoaded', function(event) {
        startVue();
    });
};

const startVue = () => {
    Vue.use(VModal, { dialog: true });

    new Vue({
        el: '#vue_app',
        template: '<App></App>',
        components: { App }
    });
};

bootstrap();
