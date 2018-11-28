export class X5OERResource {
    constructor({ id, title, author, publishingYear, thumbsUps, thumbnail }) {
        this.id = id;
        this.title = title;
        this.author = author;
        this.publishingYear = publishingYear;
        this.thumbsUps = thumbsUps;
        this.thumbnail = thumbnail;
    }
}

export class X5OERRecommendationsList {
    constructor(list = []) {
        this.list = list;
    }

    addItemToList(item) {
        this.list.push(item);
    }
}

export class X5OERCustomList {
    constructor(title, list = []) {
        this.title = title;
        this.list = list;
    }

    addItemToList(item) {
        this.list.push(item);
    }

    removeFromList(id) {
        this.list.splice(id, 1);
    }
}
