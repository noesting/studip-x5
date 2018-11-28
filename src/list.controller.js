import { LISTTYPES } from './globals';

export class X5ListController {
    constructor() {}

    addListItemToDom(parentNode, item, list) {
        const domListItem = this.getEmptyDomListElement();
        domListItem.setAttribute('id', list + '_' + item.id);

        this.dli_setThumbnail(item, domListItem);
        this.dli_setTitle(item, domListItem);
        this.dli_setSubtitle(item, domListItem);
        this.dli_setAction(item, domListItem, list);

        parentNode.appendChild(domListItem);
    }

    getEmptyDomListElement() {
        const domListItem = document.createElement('div');
        domListItem.setAttribute('class', 'x5_list_item');

        return domListItem;
    }

    dli_setThumbnail(item, domListItem) {
        const domThumbnail = document.createElement('div');
        domThumbnail.setAttribute('class', 'x5_list_item_thumbnail');
        domListItem.appendChild(domThumbnail);
    }

    dli_setTitle(item, domListItem) {
        const domTitle = document.createElement('div');
        domTitle.setAttribute('class', 'x5_list_item_title');
        domTitle.innerText = item.title;

        domListItem.appendChild(domTitle);
    }

    dli_setSubtitle(item, domListItem) {
        const domSubtitle = document.createElement('div');
        domSubtitle.setAttribute('class', 'x5_list_item_subtitle');
        domSubtitle.innerText = '(' + item.thumbsUps + ') - ' + item.publishingYear + ': ' + item.author;

        domListItem.appendChild(domSubtitle);
    }

    dli_setAction(item, domListItem, listType) {
        const domAction = document.createElement('div');
        domAction.setAttribute('class', 'x5_list_item_action');
        const domIcon = this.getDomStudIPIcon(item, listType);
        domAction.appendChild(domIcon);

        domListItem.appendChild(domAction);
    }

    getDomStudIPIcon(item, listType) {
        let iconPath = this.getIconPathForAction(listType);

        const domIcon = document.createElement('h3');
        const domIconImg = document.createElement('img');
        domIconImg.setAttribute('class', 'icon-role-clickable icon-shape-arr_1right');
        domIconImg.setAttribute('src', iconPath);
        domIconImg.setAttribute('item_id', item.id);
        domIcon.setAttribute('name', listType + '_actionButton');
        domIcon.appendChild(domIconImg);

        return domIcon;
    }

    // TODO: find path
    getIconPathForAction(listType) {
        return listType === LISTTYPES.CUSTOM
            ? 'http://localhost/studip-42/assets/images/icons/blue/decline.svg'
            : 'http://localhost/studip-42/assets/images/icons/blue/arr_1right.svg';
    }
}
