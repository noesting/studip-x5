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

    addItemToCurrentList(item) {
        this.addItemToCurrentListArray(item);
        this.addItemToCurrentListDom(item);
    }

    addItemToCurrentListArray(item) {
        if (this.currentCustomListIndex > -1) {
            this.customLists[this.currentCustomListIndex].list.push(item);
        }
    }

    addItemToCurrentListDom(item) {
        const domList = document.getElementById('x5_custom_list');
        this.addListItemToDom(domList, item, LISTTYPES.CUSTOM);
    }

    chooseListClick() {
        const currentListIndex = this.getCurrentListFromValue();
        this.currentCustomListIndex = currentListIndex;
        this.setCurrentListTextToDom();
        this.renderCurrentCustomList();
    }

    getCurrentListFromValue() {
        const domSelect = document.getElementById('choose_custom_list_select');
        const selectValue = domSelect.value;

        let index = 0;
        while (index < this.customLists.length && this.customLists[index].title !== selectValue) {
            index++;
        }

        return index;
    }

    setCurrentListTextToDom() {
        const domSelect = document.getElementById('choose_custom_list_select');
        const selectValue = domSelect.value;
        const currentListTextDom = document.getElementById('x5_current_list_text');
        currentListTextDom.innerText = selectValue;
    }

    removeItemFromCustomList(id) {
        this.customLists[this.currentCustomListIndex].removeFromList(id);

        const domList = document.getElementById('x5_custom_list');
        const item = document.getElementById(LISTTYPES.CUSTOM + '_' + id);

        domList.removeChild(item);
    }

    renderCurrentCustomList() {
        this.removeListItemsFromDom();
        this.addAllItemsFromCurrentListToDom();
    }

    removeListItemsFromDom() {
        const domList = document.getElementById('x5_custom_list');
        while (domList.firstChild) {
            domList.removeChild(domList.firstChild);
        }
    }

    addAllItemsFromCurrentListToDom() {
        if (this.currentCustomListIndex > -1) {
            const domList = document.getElementById('x5_custom_list');
            this.customLists[this.currentCustomListIndex].list.forEach(item =>
                this.addListItemToDom(domList, item, LISTTYPES.CUSTOM)
            );
        }
    }

    performCustomListItemAction(event) {
        let itemId;
        if (event.target.firstChild) {
            itemId = event.target.firstChild.attributes.item_id.value;
        } else {
            itemId = event.target.attributes.item_id.value;
        }

        this.removeItemFromCustomList(itemId);
    }

    setCustomListsFromData(data) {
        data.customLists.forEach(item => {
            this.customLists.push(new X5OERCustomList(item.title, item.list));
        });
    }
}
