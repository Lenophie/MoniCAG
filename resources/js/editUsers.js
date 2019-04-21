import {HTTPVerbs, makeAjaxRequest} from './ajax.js';
import {getAllBySelector, getByClass, getById, ready, remove} from './toolbox.js';

// After page is loaded
ready(() => {
    addListeners();
});

// Listeners setting
const addListeners = () => {
    for (const user of users) {
        getById(`edit-user-${user.id}-button`).addEventListener('click', (e) => handleEditUserButtonClick(e, user.id));
        getById(`delete-user-${user.id}-button`).addEventListener('click', (e) => handleDeleteUserButtonClick(e, user.id));
    }
};

// Listeners handlers
const handleEditUserButtonClick = (e, id) => {
    e.preventDefault();
    const serializedForm = Array.from(new FormData(getById(`edit-user-${id}-form`)));
    const formattedForm = {};
    for (const elem of serializedForm) formattedForm[elem[0]] = elem[1];
    remove(getByClass('error-text'));
    enableInputs(false);

    const successCallback = () => window.location.href = id === currentUserID ? '/' : '';
    const errorCallback = (response) => {
        enableInputs(true);
        handleFormErrors(JSON.parse(response).errors, id);
    };
    makeAjaxRequest(HTTPVerbs.PATCH, `${usersApiUrl}/${id}/role`, JSON.stringify(formattedForm), successCallback, errorCallback);
};

const handleDeleteUserButtonClick = (e, id) => {
    e.preventDefault();
    const serializedForm = Array.from(new FormData(getById(`delete-user-${id}-form`)));
    const formattedForm = {};
    for (const elem of serializedForm) formattedForm[elem[0]] = elem[1];
    remove(getByClass('error-text'));
    enableInputs(false);

    const successCallback = () => window.location.href = id === currentUserID ? '/' : '';
    const errorCallback = (response) => {
        enableInputs(true);
        handleFormErrors(JSON.parse(response).errors, id);
    };
    makeAjaxRequest(HTTPVerbs.DELETE, `${usersApiUrl}/${id}`, JSON.stringify(formattedForm), successCallback, errorCallback);
};

const handleFormErrors = (errors, id) => {
    for (const fieldName in errors) {
        for (const error of errors[fieldName]) {
            getById(`errors-field-${id}`).innerHTML += `<div class="error-text">${error}</div>`;
        }
    }
};

const enableInputs = (bool) => {
    const elems = getAllBySelector('.button, select');
    if (!bool) {
        for (const elem of elems) elem.setAttribute('disabled', 'disabled');
    } else {
        for (const elem of elems) elem.removeAttribute('disabled');
    }
};
