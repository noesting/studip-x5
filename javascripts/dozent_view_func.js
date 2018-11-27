// import {
//   X5OERRecommendationsList,
//   X5OERCustomList,
//   X5OERResource
// } from "./models";

// ------------------------------------------------------------------------------------------------ DATA

const data = {
  recommendations: [
    {
      id: "0",
      title:
        "Möbelindustrie 2030: Super krasse Möbel möblieren das ohnehin fantastische Mobiliar",
      author: "Feyen, F.",
      publishingYear: "2016",
      thumbsUps: 23,
      thumbnail: "ein thumbnail"
    },
    {
      id: "1",
      title:
        "Anwendungsmöglichkeiten von WLAN Fingerprinting basierter indoor-Lokalisierung in Lernmanagementsystemen am Beispiel von Stud.IP",
      author: "Oesting, N.",
      publishingYear: "2016",
      thumbsUps: 2,
      thumbnail: "ein thumbnail"
    },
    {
      id: "2",
      title:
        "Seismische Vibrationsmessung für Rasterkraftelektronenmikroskopie",
      author: "Leißner, J.F.",
      publishingYear: "2018",
      thumbsUps: 230,
      thumbnail: "ein thumbnail"
    },
    {
      id: "3",
      title: "Die Arbeit eines Arbeiters",
      author: "Autorium, A.",
      publishingYear: "1999",
      thumbsUps: 1,
      thumbnail: "ein thumbnail"
    }
  ]
};

// ------------------------------------------------------------------------------------------------ MODELS

class X5OERResource {
  constructor({ id, title, author, publishingYear, thumbsUps, thumbnail }) {
    this.id = id;
    this.title = title;
    this.author = author;
    this.publishingYear = publishingYear;
    this.thumbsUps = thumbsUps;
    this.thumbnail = thumbnail;
  }
}

class X5OERRecommendationsList {
  constructor(list = []) {
    this.list = list;
  }

  addItemToList(item) {
    this.list.push(item);
  }
}

class X5OERCustomList {
  constructor(list = []) {
    this.list = list;
  }

  addItemToList(item) {
    this.list.push(item);
  }

  removeFromList(id) {
    this.list.splice(id, 1);
  }
}

// ------------------------------------------------------------------------------------------------ Controller

let recommendationsList;
let customList;

const bootstrap = () => {
  console.log("Hello Dozent View!");
  recommendationsList = new X5OERRecommendationsList();
  setRecommendationsToList(data, recommendationsList);
  customList = new X5OERCustomList();

  renderLists();
};

const chooseFilterClick = () => {
  console.log("click", "chooseFilterClick");
};

const chooseSortClick = () => {
  console.log("click", "chooseSortClick");
};

const chooseListClick = () => {
  console.log("click", "chooseListClick");
};

const addListClick = () => {
  console.log("click", "addListClick");
};

const copyItemToListClick = id => {
  const domList = document.getElementById("x5_custom_list");
  const item = recommendationsList.list.filter(item => item.id === id)[0];
  addToDom(domList, item, "custom");
};

const removeItemFromListClick = id => {
  console.log("removing", id);
  const domList = document.getElementById("x5_custom_list");
  const item = document.getElementById("custom_" + id);

  domList.removeChild(item);
};

const showListOptionsClick = () => {
  console.log("click", "showListOptionsClick");
};

const renderLists = () => {
  recommendationsList.list.forEach(item => {
    const domList = document.getElementById("x5_material_list");
    addToDom(domList, item, "recommendations");
  });
};

const addToDom = (parentNode, item, list) => {
  const domListItem = getEmptyDomListElement();
  domListItem.setAttribute("id", list + "_" + item.id);

  dli_setThumbnail(item, domListItem);
  dli_setTitle(item, domListItem);
  dli_setSubtitle(item, domListItem);
  dli_setAction(item, domListItem, list);

  parentNode.appendChild(domListItem);
};

const getEmptyDomListElement = () => {
  const domListItem = document.createElement("div");
  domListItem.setAttribute("class", "x5_list_item");

  return domListItem;
};

const dli_setThumbnail = (item, domListItem) => {
  const domThumbnail = document.createElement("div");
  domThumbnail.setAttribute("class", "x5_list_item_thumbnail");
  domListItem.appendChild(domThumbnail);
};

const dli_setTitle = (item, domListItem) => {
  const domTitle = document.createElement("div");
  domTitle.setAttribute("class", "x5_list_item_title");
  domTitle.innerText = item.title;

  domListItem.appendChild(domTitle);
};

const dli_setSubtitle = (item, domListItem) => {
  const domSubtitle = document.createElement("div");
  domSubtitle.setAttribute("class", "x5_list_item_subtitle");
  domSubtitle.innerText =
    "(" + item.thumbsUps + ") - " + item.publishingYear + ": " + item.author;

  domListItem.appendChild(domSubtitle);
};

const dli_setAction = (item, domListItem, listType) => {
  const domAction = document.createElement("div");
  domAction.setAttribute("class", "x5_list_item_action");
  const domIcon = getDomStudIPIcon(item, listType);
  domAction.appendChild(domIcon);

  domListItem.appendChild(domAction);
};

const getDomStudIPIcon = (item, listType) => {
  let iconPath = getIconPathForAction(listType);
  let actionMethod = getMethodForAction(listType, item);

  const domIcon = document.createElement("h3");
  const domIconImg = document.createElement("img");
  domIconImg.setAttribute("class", "icon-role-clickable icon-shape-arr_1right");
  domIconImg.setAttribute("src", iconPath);
  domIcon.setAttribute("onclick", actionMethod);
  domIcon.appendChild(domIconImg);

  return domIcon;
};

// TODO: find path
const getIconPathForAction = listType => {
  return listType === "custom"
    ? "http://localhost/studip-42/assets/images/icons/blue/decline.svg"
    : "http://localhost/studip-42/assets/images/icons/blue/arr_1right.svg";
};

const getMethodForAction = (listType, item) => {
  return listType === "custom"
    ? "removeItemFromListClick('" + item.id + "')"
    : "copyItemToListClick('" + item.id + "')";
};

const setRecommendationsToList = (data, list) => {
  data.recommendations.forEach(item => {
    list.addItemToList(new X5OERResource(item));
  });
};

// ------------------------------------------------------------------------------------------------ START JS

document.addEventListener("DOMContentLoaded", function(event) {
  bootstrap();
});
