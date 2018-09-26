import $ from 'jquery';
import 'bootstrap/dist/js/bootstrap.bundle.js';

const submitTypes = {
    POST: 0,
    PATCH: 1
};

// After page is loaded
$().ready(() => {
    addListeners();
});

// Listeners setting
const addListeners = () => {
    for (const inventoryItem of inventoryItems) $(`#edit-item-${inventoryItem.id}-submit-button`).click((e) => handlePatchItemFormSubmit(e, inventoryItem.id));
    $('#add-item-submit-button').click((e) => handleAddItemFormSubmit(e));
};

// Handlers
const handleAddItemFormSubmit = (e) => {
    e.preventDefault();
    const serializedForm = $('#add-item-form').serializeArray();
    const formattedForm = {};
    for (const elem of serializedForm) formattedForm[elem.name] = elem.value;
    $('.error-text').remove();

    $.ajax({
        url: "/edit-inventory",
        type: 'POST',
        data: formattedForm,
        success: () => {
            window.location.href = "/view-inventory"
        },
        error: (response) => {
            handleFormErrors(submitTypes.POST, response.responseJSON.errors)
        }
    });
};

const handlePatchItemFormSubmit = (e, id) => {
    e.preventDefault();
    const serializedForm = $(`#edit-item-${id}-form`).serializeArray();
    const formattedForm = {};
    for (const elem of serializedForm) formattedForm[elem.name] = elem.value;
    formattedForm.inventoryItemID = id;
    $('.error-text').remove();

    $.ajax({
        url: "/edit-inventory",
        type: 'PATCH',
        data: formattedForm,
        success: () => {
            window.location.href = "/view-inventory"
        },
        error: (response) => {
            handleFormErrors(submitTypes.PATCH, response.responseJSON.errors, id);
        }
    });
};

const handleFormErrors = (submitType, errors, id) => {
    if (submitType === submitTypes.POST) {
        for (const fieldName in errors) {
            for (const error of errors[fieldName]) {
                if (!fieldName.startsWith('genres.')) {
                    $(`#${fieldName}-field-new`).append(`<div class="error-text">${error}</div>`);
                } else {
                    $(`#${fieldName}-field-new`).append(`<div class="error-text">${error}</div>`);
                }
            }
        }
    } else if (submitType === submitTypes.PATCH) {
        for (const fieldName in errors) {
            for (const error of errors[fieldName]) {
                if (!fieldName.startsWith('genres.')) {
                    $(`#${fieldName}-field-${id}`).append(`<div class="error-text">${error}</div>`);
                } else {
                    $(`#${fieldName}-field-${id}`).append(`<div class="error-text">${error}</div>`);
                }
            }
        }
    }
};