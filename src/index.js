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
    $(document).on('click', "button[name='addListButton']", event => {
        customListsController.addListClick(event);
    });

    $(document).on('click', 'div[name="customListEntry"]', event => customListsController.chooseListClick(event));

    $(document).on('click', 'h3[name="' + LISTTYPES.CUSTOM + '_actionButton"]', event =>
        customListsController.performCustomListItemAction(event)
    );
    $(document).on('click', 'h3[name="' + LISTTYPES.RECOMMENDATIONS + '_actionButton"]', event =>
        recommendtionsListController.performRecommendationsListItemAction(event)
    );
    $(document).on('click', 'div[name="x5_item_action"]', event => {
        customListsController.showListOptionsClick(event);
    });

    $(document).on('click', 'div[name="editListButton"]', event => customListsController.editListClick(event));
    $(document).on('focusout', 'input[name="x5_current_list_text"]', event =>
        customListsController.editListFocusOut(event)
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

// ------------------------------------------------------------------------------------------------ START JS

bootstrap();
