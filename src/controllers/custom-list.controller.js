import { LISTTYPES } from '../globals';
import { X5ListController } from './list.controller';
import { X5OERCustomList } from '../models/models';

import { data } from '../data';

export class X5CustomListController extends X5ListController {
    constructor() {
        super();
        this.init();
    }

    init() {
        this.customLists = [];
        this.currentCustomListIndex = -1;
        this.setCustomListsFromData(data);
        this.addCustomListsToDom();
        this.addListeners();
        this.preselectList();
    }

    addListeners() {
        $(document).on('click', "button[name='addListButton']", event => {
            this.addListClick(event);
        });
        $(document).on('click', 'h3[name="' + LISTTYPES.CUSTOM + '_actionButton"]', event =>
            this.performCustomListItemAction(event)
        );
        $(document).on('click', 'div[name="x5_item_action"]', event => {
            this.showListOptionsClick(event);
        });
        $(document).on('click', 'div[name="customListEntry"]', event => this.chooseListClick(event));
        $(document).on('click', 'div[name="editListButton"]', event => this.editListClick(event));
        $(document).on('focusout', 'input[name="x5_current_list_text"]', event => this.editListFocusOut(event));
    }

    addCustomListsToDom() {
        const domSelect = document.getElementById('choose_custom_list_select');
        this.removeAllChildrenFromDomElement(domSelect);
        this.customLists.forEach(list => {
            const domCustomListEntry = document.createElement('div');
            domCustomListEntry.setAttribute('id', 'listEntry_' + list.title);
            domCustomListEntry.setAttribute('name', 'customListEntry');
            domCustomListEntry.setAttribute('class', 'customListEntry');
            domCustomListEntry.innerText = list.title;
            domSelect.appendChild(domCustomListEntry);
        });
    }

    preselectList() {
        if (!this.customLists || this.customLists.length === 0) {
            return;
        }

        this.selectList(0);
    }

    selectList(index) {
        this.currentCustomListIndex = index;
        this.setCurrentListTextToDom(this.customLists[index].title);
        this.renderCurrentCustomList();
    }

    addItemToCurrentList(item) {
        if (this.itemExistsInCurrentList(item)) {
            return;
        }

        this.addItemToCurrentListArray(item);
        this.addItemToCurrentListDom(item);
    }

    itemExistsInCurrentList(item) {
        for (let i = 0; i < this.customLists[this.currentCustomListIndex].list.length; i++) {
            if (this.customLists[this.currentCustomListIndex].list[i].id === item.id) {
                return true;
            }
        }

        return false;
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

    chooseListClick(event) {
        const value = event.target.id.split('_')[1];
        const currentListIndex = this.getCurrentListIndexFromValue(value);
        this.currentCustomListIndex = currentListIndex;
        this.setCurrentListTextToDom(value);
        this.renderCurrentCustomList();
    }

    getCurrentListIndexFromValue(value) {
        let index = 0;
        while (index < this.customLists.length && this.customLists[index].title !== value) {
            index++;
        }

        return index;
    }

    setCurrentListTextToDom(value) {
        const currentListTextDom = document.getElementById('x5_current_list_text');
        currentListTextDom.value = value;
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

    removeListsFromDom() {
        const domSelect = document.getElementById('choose_custom_list_select');
        this.removeAllChildrenFromDomElement(domSelect);
    }

    removeListItemsFromDom() {
        const domList = document.getElementById('x5_custom_list');
        this.removeAllChildrenFromDomElement(domList);
    }

    removeAllChildrenFromDomElement(domElement) {
        while (domElement.firstChild) {
            domElement.removeChild(domElement.firstChild);
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
        if (data.customLists) {
            data.customLists.forEach(item => {
                this.customLists.push(new X5OERCustomList(item.title, item.list));
            });
        }
    }

    showListOptionsClick(event) {
        console.log('click', 'showListOptionsClick');
    }

    editListClick(event) {
        if (this.currentCustomListIndex > -1) {
            switch (event.target.id) {
                case 'shareListClick':
                    this.shareListClick();
                    break;
                case 'renameListClick':
                    this.renameListAction();
                    break;
                case 'deleteListClick':
                    this.deleteListClick();
                    break;
                default:
                    console.log('no method for action');
            }
        } else {
            console.log('No List selected');
        }
    }

    shareListClick() {
        console.log('sharing current List');
    }

    renameListAction() {
        const currentListTextDom = document.getElementById('x5_current_list_text');
        currentListTextDom.removeAttribute('disabled');
        currentListTextDom.focus();
        console.log('renaming current List');
    }

    deleteListClick() {
        this.customLists.splice(this.currentCustomListIndex, 1);
        this.addCustomListsToDom();
        this.currentCustomListIndex = -1;
        this.removeListItemsFromDom();
        this.setCurrentListTextToDom('Keine Liste ausgewählt');
    }

    editListFocusOut(event) {
        event.target.setAttribute('disabled', 'disabled');
        this.customLists[this.currentCustomListIndex].title = event.target.value;
        this.addCustomListsToDom();
    }

    addListClick(event) {
        this.setCurrentListTextToDom('Neue Liste');
        this.currentCustomListIndex = this.customLists.length;
        this.customLists.push({ title: 'Neue Liste', list: [] });
        this.renameListAction();
    }
}
