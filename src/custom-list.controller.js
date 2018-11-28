import { LISTTYPES } from './globals';
import { X5ListController } from './list.controller';
import { X5OERCustomList } from './models';

import { data } from './data';

export class X5CustomListController extends X5ListController {
    constructor() {
        super();
        this.customLists = [];
        this.currentCustomListIndex = -1;
        this.setCustomListsFromData(data);
        this.addCustomListsToDom();
        console.log('this.customLists', this.customLists);
    }

    addCustomListsToDom() {
        const domSelect = document.getElementById('choose_custom_list_select');

        this.customLists.forEach(list => {
            const domOption = document.createElement('option');
            domOption.setAttribute('value', list.title);
            domOption.text = list.title;

            domSelect.appendChild(domOption);
        });
    }

    chooseListClick() {
        console.log('click', 'chooseListClick');
        const domSelect = document.getElementById('choose_custom_list_select');
        const selectValue = domSelect.value;
        let index = 0;
        console.log('this', this);
        while (index < this.customLists.length && this.customLists[index].title !== selectValue) {
            index++;
        }
        const currentListText = document.getElementById('x5_current_list_text');
        currentListText.innerText = selectValue;
        this.currentCustomListIndex = index;
        this.renderCurrentCustomList();
    }

    removeItemFromCustomList(id) {
        this.customLists[this.currentCustomListIndex].removeFromList(id);

        const domList = document.getElementById('x5_custom_list');
        const item = document.getElementById(LISTTYPES.CUSTOM + '_' + id);

        domList.removeChild(item);
    }

    renderCurrentCustomList() {
        const domList = document.getElementById('x5_custom_list');
        for (let child of domList.children) {
            child.remove();
        }

        if (this.currentCustomListIndex > -1) {
            this.customLists[this.currentCustomListIndex].list.forEach(item =>
                this.addListItemToDom(domList, item, LISTTYPES.CUSTOM)
            );
        }
    }

    performCustomListItemAction(event) {
        const itemId = event.target.attributes.item_id.value;
        this.removeItemFromCustomList(itemId);
    }

    setCustomListsFromData(data) {
        data.customLists.forEach(item => {
            this.customLists.push(new X5OERCustomList(item.title, item.list));
        });
    }
}
