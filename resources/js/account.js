import './modal.js';
import {getAllBySelector, getByClass, getById, ready, remove} from './toolbox.js';
import {HTTPVerbs, makeAjaxRequest} from './ajax.js';

// After page is loaded
ready(() => {
    addListeners();
    overrideDefaultFormBehaviour();
});

// Listeners setting
const addListeners = () => {
    getById('delete-confirm-button').addEventListener('click', handleDeletion);
};

const handleDeletion = () => {
    const serializedForm = Array.from(new FormData(getById('delete-form')));
    const formattedForm = {};
    for (const elem of serializedForm) formattedForm[elem[0]] = elem[1];
    remove(getByClass('error-text'));
    enableInputs(false);

    const successCallback = () => window.location.href = '/';
    const errorCallback = (response) => {
        enableInputs(true);
        handleFormErrors(JSON.parse(response).errors);
    };
    makeAjaxRequest(HTTPVerbs.DELETE, deleteRequestURL, JSON.stringify(formattedForm), successCallback, errorCallback);
};

const handleFormErrors = (errors) => {
    for (const fieldName in errors) {
        for (const error of errors[fieldName]) {
            getById('errors-field-password').innerHTML += `<div class="error-text">${error}</div>`;
        }
    }
};

const enableInputs = (bool) => {
    const elems = getAllBySelector('.button, input');
    if (!bool) {
        for (const elem of elems) elem.setAttribute('disabled', 'disabled');
    } else {
        for (const elem of elems) elem.removeAttribute('disabled');
    }
};

const overrideDefaultFormBehaviour = () => {
    getById('delete-form').onkeypress = (e) => {
        const key = e.charCode || e.keyCode || 0;
        if (key === 13) {
            e.preventDefault();
            handleDeletion();
        }
    };
};

