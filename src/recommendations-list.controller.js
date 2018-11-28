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

        console.log('1');

        const domList = document.getElementById('x5_custom_list');
        console.log('2');
        const item = this.recommendations.list.filter(item => item.id === id)[0];
        console.log(customListsController.currentCustomListIndex);
        console.log(customListsController.customLists);
        customListsController.customLists[customListsController.currentCustomListIndex].list.push(item);
        console.log('4');
        this.addListItemToDom(domList, item, LISTTYPES.CUSTOM);
    }

    renderLists() {
        this.recommendations.list.forEach(item => {
            const domList = document.getElementById('x5_material_list');
            this.addListItemToDom(domList, item, LISTTYPES.RECOMMENDATIONS);
        });
    }

    performRecommendationsListItemAction(event) {
        const itemId = event.target.attributes.item_id.value;
        this.copyItemToCustomList(itemId);
    }

    setRecommendationsToList(data) {
        data.recommendations.forEach(item => {
            this.recommendations.addItemToList(new X5OERResource(item));
        });
    }
}
