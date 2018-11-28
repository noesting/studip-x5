import { LISTTYPES } from './globals';
import { customListsController } from './index';
import { X5ListController } from './list.controller';
import { X5OERRecommendationsList, X5OERResource } from './models';

import { data } from './data';

export class X5RecommendationsListController extends X5ListController {
    constructor() {
        super();
        this.init();
    }

    init() {
        this.recommendations = new X5OERRecommendationsList();
        this.setRecommendationsToList(data);
    }

    copyItemToCustomList(id) {
        if (customListsController.currentCustomListIndex < 0) {
            console.log('Please choose a list');
            return;
        }

        const item = this.recommendations.list.filter(item => item.id === id)[0];
        customListsController.addItemToCurrentList(item);
    }

    renderLists() {
        this.recommendations.list.forEach(item => {
            const domList = document.getElementById('x5_material_list');
            this.addListItemToDom(domList, item, LISTTYPES.RECOMMENDATIONS);
        });
    }

    performRecommendationsListItemAction(event) {
        let itemId;
        if (event.target.firstChild) {
            itemId = event.target.firstChild.attributes.item_id.value;
        } else {
            itemId = event.target.attributes.item_id.value;
        }
        this.copyItemToCustomList(itemId);
    }

    setRecommendationsToList(data) {
        data.recommendations.forEach(item => {
            this.recommendations.addItemToList(new X5OERResource(item));
        });
    }
}
