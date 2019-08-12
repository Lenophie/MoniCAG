import get from "lodash.get";
import {makeAjaxPromise, HTTPVerbs} from "./ajax.js";

const storeTranslationFile = json => {
    window.i18n = json;
};

export const requestTranslationFile = async () => {
    await makeAjaxPromise(HTTPVerbs.GET, '/res/lang.json', '')
        .then(res => storeTranslationFile(JSON.parse(res)))
        .catch(() => storeTranslationFile({}));
};

export const trans = string => {
    const translatedString = get(window.i18n, string);
    if (!translatedString) return string;
    return translatedString;
};