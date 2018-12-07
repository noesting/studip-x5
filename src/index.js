import './x5_plugin.scss';

import { X5ListController } from './controllers/list.controller';
import { X5RecommendationsListController } from './controllers/recommendations-list.controller';
import { X5CustomListController } from './controllers/custom-list.controller';

import { LISTTYPES } from './globals';

import App from './app/App.vue';

export let recommendtionsListController;
export let customListsController;

const bootstrap = () => {
    document.addEventListener('DOMContentLoaded', function(event) {
        initControllers();
        addListeners();
        startRender();
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

const initControllers = () => {
    recommendtionsListController = new X5RecommendationsListController();
    customListsController = new X5CustomListController();
};

const startRender = () => {
    recommendtionsListController.renderLists();
};

const addListeners = () => {
    $(document).on('click', "button[name='filterButton']", chooseFilterClick);

    $(document).on('click', "button[name='sortButton']", chooseSortClick);
};

const chooseFilterClick = event => {
    console.log('click', 'chooseFilterClick');
    console.log('event', event);
};

const chooseSortClick = () => {
    console.log('click', 'chooseSortClick');
};

// ------------------------------------------------------------------------------------------------ START JS

bootstrap();
