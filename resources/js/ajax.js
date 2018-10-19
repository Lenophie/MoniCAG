export const HTTPVerbs = {
    GET: 'GET',
    POST: 'POST',
    PATCH: 'PATCH',
    PUT: 'PUT',
    DELETE: 'DELETE'
};

const isMethodInEnum = (method) => {
    for (const methodFromEnum in HTTPVerbs) {
        if (method === HTTPVerbs[methodFromEnum]) return true;
    }
    return false;
};

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