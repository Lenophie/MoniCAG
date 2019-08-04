import get from "lodash.get";
import {makeAjaxRequest, HTTPVerbs} from "./ajax.js";

const storeTranslationFile = (json) => {
    window.i18n = json;
};

export const requestTranslationFile = () => {
    makeAjaxRequest(HTTPVerbs.GET,
        '/res/lang.json',
        '',
        res => storeTranslationFile(JSON.parse(res)),
        () => storeTranslationFile({}));
};

export const trans = string => {
    const translatedString = get(window.i18n, string);
    if (!translatedString) return string;
    return translatedString;
};
