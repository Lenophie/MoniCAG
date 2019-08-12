import {HTTPVerbs, makeAjaxRequest} from './ajax.js';
import {getAllBySelector, getByClass, getById, ready, remove} from './toolbox.js';

// Icons
import { library } from '@fortawesome/fontawesome-svg-core';
import { faChess } from '@fortawesome/free-solid-svg-icons';

library.add(faChess);

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

const handleRequestError = (id) => (responseBody, code) => {
    enableInputs(true);
    if (code === 422) handleFormErrors(JSON.parse(responseBody).errors, code, id);
    else handleFormErrors(JSON.parse(responseBody).message, code, id);
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
    makeAjaxRequest(HTTPVerbs.PATCH, `${usersApiUrl}/${id}/role`, JSON.stringify(formattedForm), successCallback, handleRequestError(id));
};

const handleDeleteUserButtonClick = (e, id) => {
    e.preventDefault();
    const serializedForm = Array.from(new FormData(getById(`delete-user-${id}-form`)));
    const formattedForm = {};
    for (const elem of serializedForm) formattedForm[elem[0]] = elem[1];
    remove(getByClass('error-text'));
    enableInputs(false);

    const successCallback = () => window.location.href = id === currentUserID ? '/' : '';
    makeAjaxRequest(HTTPVerbs.DELETE, `${usersApiUrl}/${id}`, JSON.stringify(formattedForm), successCallback, handleRequestError(id));
};

const handleFormErrors = (errors, code, id) => {
    if (code === 422) {
        for (const fieldName in errors) {
            for (const error of errors[fieldName]) {
                getById(`errors-field-${id}`).innerHTML += `<div class="error-text">${error}</div>`;
            }
        }
    } else {
        getById(`errors-field-${id}`).innerHTML += `<div class="error-text">${errors}</div>`;
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
