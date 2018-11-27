export class X5OERResource {
  constructor({ title, author, publishingYear, thumbsUps, thumbnail }) {
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

  addItemToList = item => {
    this.list = { ...this.list, item };
  };
}

export class X5OERCustomList {
  constructor(list = []) {
    this.list = list;
  }

  addItemToList = item => {
    this.list = { ...this.list, item };
  };

  removeFromList = id => {
    this.list.splice(id, 1);
  };
}
