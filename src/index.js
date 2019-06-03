import './public_path';
import VModal from 'vue-js-modal';

import DozentVue from './app/Dozent';
import StudentVue from './app/Student';

const VueResource = require('vue-resource');

const bootstrap = () => {
    document.addEventListener('DOMContentLoaded', function(event) {
        startVue();
    });
};

const startVue = () => {
    Vue.use(VModal, { dialog: true, dynamic: true, injectModalsContainer: true });
    Vue.use(VueResource);

    const dozent_vue_element = document.getElementById('dozent_vue');
    const student_vue_element = document.getElementById('student_vue');

    if (dozent_vue_element) {
        new Vue(dozentVueInitOptions);
    }

    if (student_vue_element) {
        new Vue(studentVueInitOptions);
    }
};

const dozentVueInitOptions = {
    el: '#dozent_vue',
    template: '<DozentVue></DozentVue>',
    components: { DozentVue },
    data() {
        return {
            role: 'dozent'
        };
    }
};

const studentVueInitOptions = {
    el: '#student_vue',
    template: '<StudentVue></StudentVue>',
    components: { StudentVue },
    data() {
        return {
            role: 'student'
        };
    }
};

bootstrap();
