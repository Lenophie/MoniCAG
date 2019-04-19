/**
 * @typedef {string} HTTPVerb
 **/

/**
 * @enum HTTPVerb
 */
export const HTTPVerbs = {
    GET: 'GET',
    POST: 'POST',
    PATCH: 'PATCH',
    PUT: 'PUT',
    DELETE: 'DELETE'
};

/**
 * Determines whether or not a string is a valid HTTP verb
 * @param {string} method A string to compare to the HTTP verbs enum
 * @returns {boolean}
 */
const isMethodInEnum = (method) => {
    for (const methodFromEnum in HTTPVerbs) {
        if (method === HTTPVerbs[methodFromEnum]) return true;
    }
    return false;
};


/**
 * An Ajax request wrapper
 * @param {HTTPVerb} method The HTTP verb used to make the request
 * @param {string} url The URL at which the request is made
 * @param {JSON} data The payload to send along the request
 * @param {function} successCallback The function to call in case of success
 * @param {function} errorCallback The function to call in case of error
 */
export const makeAjaxRequest = (method, url, data, successCallback, errorCallback) => {
    if (isMethodInEnum(method) && typeof(url) === 'string') {
        const request = new XMLHttpRequest();
        request.open(method, url, true);
        request.setRequestHeader("Content-Type", "application/json");
        request.setRequestHeader("Accept", "application/json");
        request.onload = () => {
            if (request.status >= 200 && request.status < 400) {
                if (typeof(successCallback) === 'function') successCallback(request.response);
            } else {
                if (typeof(errorCallback) === 'function') errorCallback(request.response);
            }
        };

        request.onerror = () => {
            if (typeof(errorCallback) === 'function') errorCallback(request.response);
        };

        request.send(data);
    }
};
