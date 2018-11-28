import './x5_plugin.scss';

import { X5ListController } from './list.controller';
import { X5RecommendationsListController } from './recommendations-list.controller';
import { X5CustomListController } from './custom-list.controller';

import { LISTTYPES } from './globals';

export let recommendtionsListController;
export let customListsController;

const bootstrap = () => {
    document.addEventListener('DOMContentLoaded', function(event) {
        initControllers();
        addListeners();
        startRender();
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
    $(document).on('click', "button[name='addListButton']", addListClick);

    $(document).on('change', 'select[name="choose_custom_list_select"]', event =>
        customListsController.chooseListClick(event)
    );

    $(document).on('click', 'h3[name="' + LISTTYPES.CUSTOM + '_actionButton"]', event =>
        customListsController.performCustomListItemAction(event)
    );
    $(document).on('click', 'h3[name="' + LISTTYPES.RECOMMENDATIONS + '_actionButton"]', event =>
        recommendtionsListController.performRecommendationsListItemAction(event)
    );
};

const chooseFilterClick = event => {
    console.log('click', 'chooseFilterClick');
    console.log('event', event);
};

const chooseSortClick = () => {
    console.log('click', 'chooseSortClick');
};

const addListClick = () => {
    console.log('click', 'addListClick');
};

const showListOptionsClick = () => {
    console.log('click', 'showListOptionsClick');
};

// ------------------------------------------------------------------------------------------------ START JS

bootstrap();
