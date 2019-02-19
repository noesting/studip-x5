import { data } from '../../../data';
import * as DBX5ListsGet from './db-methods/x5lists/x5lists_get';

export const processRecommendations = (recommendations, currentCustomList, filters, searchtext, vueInstance) => {
    recommendations = data.recommendations;
    recommendations = prepareRecommendations(recommendations, currentCustomList, vueInstance);

    recommendations = setRecommendationsBySearchText(recommendations, searchtext);
    recommendations = setRecommendationsByFilters(recommendations, filters);

    return recommendations;
};

export const prepareRecommendations = (recommendations, currentCustomList, vueInstance) => {
    DBX5ListsGet.enrichRecommendations(vueInstance, recommendations);
    return markRecommendationsAsAdded(recommendations, currentCustomList);
};

const markRecommendationsAsAdded = (recommendations, currentCustomList) => {
    if (!recommendations || recommendations.length <= 0) {
        return;
    }

    recommendations.forEach(recommendation => {
        if (currentCustomList && currentCustomList.list) {
            let found = false;
            for (let i = 0; i < currentCustomList.list.length; i++) {
                if (recommendation.id === currentCustomList.list[i].id) {
                    found = true;
                }
            }
            recommendation.inList = found;
        }
    });

    return recommendations;
};

const setRecommendationsBySearchText = (recommendations, searchtext) => {
    if (!searchtext) {
        return recommendations;
    }

    return recommendations.filter(recommendation => {
        const regexp = new RegExp(searchtext, 'i');
        return recommendation.title.match(regexp);
    });
};

const setRecommendationsByFilters = (recommendations, filters) => {
    if (!filters) {
        return recommendations;
    }

    if (!filters.checkedLangs) {
        filters.checkedLangs = [];
    }

    if (!filters.checkedFormats) {
        filters.checkedFormats = [];
    }

    if (filters.checkedLangs.length === 0 && filters.checkedFormats.length === 0) {
        return recommendations;
    }

    return recommendations.filter(recommendation => {
        return (
            recommendationFitsByLangAndFormat(recommendation, filters) ||
            recommendationFitsByLang(recommendation, filters) ||
            recommendationFitsByFormat(recommendation, filters)
        );
    });
};

const recommendationFitsByLangAndFormat = (recommendation, filters) => {
    return recommendationIsInLangs(recommendation, filters) && recommendationIsInFormats(recommendation, filters);
};

const recommendationFitsByLang = (recommendation, filters) => {
    return recommendationIsInLangs(recommendation, filters) && filters.checkedFormats.length === 0;
};

const recommendationFitsByFormat = (recommendation, filters) => {
    return filters.checkedLangs.length === 0 && recommendationIsInFormats(recommendation, filters);
};

const recommendationIsInLangs = (recommendation, filters) => {
    return filters.checkedLangs.indexOf(recommendation.language) > -1;
};

const recommendationIsInFormats = (recommendation, filters) => {
    return filters.checkedFormats.indexOf(recommendation.type) > -1;
};
