import './modal.js';
import {HTTPVerbs, makeAjaxRequest} from './ajax.js';
import {getAllBySelector, getByClass, getById, getBySelector, ready, remove} from './toolbox.js';

/**
 * @typedef {number} submitType
 */

/**
 * @enum submitType
 */
const submitTypes = {
    POST: 0,
    PATCH: 1,
    DELETE: 2
};

// After page is loaded
ready(() => {
    addListeners();
});

/**
 * Adds listeners to the buttons and selects of the page
 */
const addListeners = () => {
    const addGenreSelects = {};

    for (const inventoryItem of inventoryItems) {
        // Add inventory item buttons listeners
        getById(`edit-item-${inventoryItem.id}-submit-button`)
            .addEventListener('click', (e) => handlePatchItemFormSubmit(e, inventoryItem.id));
        getById(`delete-button-${inventoryItem.id}`)
            .addEventListener('click', () => {
                if (inventoryItem.status.id !== 3) getById('item-to-delete-id-field').value = inventoryItem.id;
            });

        // Reference the item's genre select in the genre selects list
        addGenreSelects[inventoryItem.id] = getById(`add-genre-select-${inventoryItem.id}`);

        // Add event listener to the item's genre select
        addGenreSelects[inventoryItem.id].addEventListener('change', () => handleAddGenreSelectChange(
            submitTypes.PATCH,
            {
                id: parseInt(addGenreSelects[inventoryItem.id].value),
                name: addGenreSelects[inventoryItem.id].options[addGenreSelects[inventoryItem.id].selectedIndex]
                    .innerHTML
            },
            inventoryItem.id
        ));

        // Add event listeners to the item's genre removal buttons
        const removeGenreButtons = getAllBySelector(`#genres-ul-${inventoryItem.id} .remove-genre-button`);
        for (const button of removeGenreButtons) button.addEventListener('click', (e) =>
            {
                const genreId = e.currentTarget.parentElement.id.split('-')[1];
                handleRemoveGenreButtonClick(
                    submitTypes.PATCH,
                    genreId,
                    inventoryItem.id
                );
            }
        );
    }

    // Add new item's button and select event listeners
    getById('add-item-submit-button').addEventListener('click', e => handleAddItemFormSubmit(e));
    addGenreSelects.new = getById('add-genre-select-new');
    addGenreSelects.new.addEventListener('change', () => handleAddGenreSelectChange(
        submitTypes.POST,
        {
            id: parseInt(addGenreSelects.new.value),
            name: addGenreSelects.new.options[addGenreSelects.new.selectedIndex].innerHTML
        }
    ));

    // Add item deletion button event listener
    getById('delete-confirm-button').addEventListener('click', e => handleDeleteItemFormSubmit(e));
};

/**
 * Handles the form submission of a new inventory item
 * @param {Event} e The event that triggered the form submission
 */
const handleAddItemFormSubmit = (e) => {
    e.preventDefault();

    // Serialize the form
    const serializedForm = Array.from(new FormData(getById('add-item-form')));
    const formattedForm = {};
    for (const elem of serializedForm) formattedForm[elem[0]] = elem[1];
    formattedForm.genres = Array.from(getAllBySelector('#genres-field-new .genre-li'))
        .map(x => parseInt(x.id.split('-')[1]));

    // Remove the error texts
    remove(getByClass('error-text'));

    // Disable inputs
    enableInputs(false);

    // Prepare the request callbacks
    const successCallback = () => window.location.href = successRedirectionURL;
    const errorCallback = (response) => {
        enableInputs(true);
        handleFormErrors(submitTypes.POST, JSON.parse(response).errors)
    };

    // Make the request
    makeAjaxRequest(HTTPVerbs.POST, inventoryItemsApiUrl, JSON.stringify(formattedForm), successCallback, errorCallback);
};

/**
 * Handles the form submission of an existing item patch
 * @param {Event} e The event that triggered the form submission
 * @param {number} id The id of the item to patch
 */
const handlePatchItemFormSubmit = (e, id) => {
    e.preventDefault();

    // Serialize the form
    const serializedForm = Array.from(new FormData(getById(`edit-item-${id}-form`)));
    const formattedForm = {};
    for (const elem of serializedForm) formattedForm[elem[0]] = elem[1];
    formattedForm.inventoryItemId = id;
    formattedForm.genres = Array.from(getAllBySelector(`#genres-field-${id} .genre-li`))
        .map(x => parseInt(x.id.split('-')[1]));

    // Remove the error texts
    remove(getByClass('error-text'));

    // Disable inputs
    enableInputs(false);

    // Prepare the request callbacks
    const successCallback = () => window.location.href = successRedirectionURL;
    const errorCallback = (response) => {
        enableInputs(true);
        handleFormErrors(submitTypes.PATCH, JSON.parse(response).errors, id);
    };

    // Make the request
    makeAjaxRequest(HTTPVerbs.PATCH, requestsURL, JSON.stringify(formattedForm), successCallback, errorCallback);
};

/**
 * Handles the form submission of an item deletion
 * @param {Event} e The event that triggered the form submission
 */
const handleDeleteItemFormSubmit = (e) => {
    e.preventDefault();

    // Serialize the form
    const serializedForm = Array.from(new FormData(getById('delete-form')));
    const formattedForm = {};
    for (const elem of serializedForm) formattedForm[elem[0]] = elem[1];
    formattedForm.inventoryItemId = parseInt(formattedForm.inventoryItemId);

    // Remove the error texts
    remove(getByClass('error-text'));

    // Disable inputs
    enableInputs(false);

    // Prepare the request callbacks
    const successCallback = () => window.location.href = successRedirectionURL;
    const errorCallback = (response) => {
        enableInputs(true);
        handleFormErrors(submitTypes.DELETE, JSON.parse(response).errors);
    };

    // Make the request
    makeAjaxRequest(
        HTTPVerbs.DELETE,
        `${inventoryItemsApiUrl}/${formattedForm.inventoryItemId}`,
        null,
        successCallback,
        errorCallback
    );
};

/**
 * Handles form errors
 * @param {submitType} submitType Indicates the type of request that threw the errors
 * @param {Array} errors
 * @param {?number} id The id of the inventory item when the submitType is PATCH
 */
const handleFormErrors = (submitType, errors, id) => {
    if (submitType === submitTypes.POST) {
        for (const fieldName in errors) {
            for (const error of errors[fieldName]) {
                const errorDiv = createErrorDiv(error);
                if (!fieldName.startsWith('genres.')) getById(`${fieldName}-field-new`).appendChild(errorDiv);
                else getById('genres-field-new').appendChild(errorDiv);
            }
        }
    } else if (submitType === submitTypes.PATCH) {
        for (const fieldName in errors) {
            for (const error of errors[fieldName]) {
                const errorDiv = createErrorDiv(error);
                if (!fieldName.startsWith('genres.')) getById(`${fieldName}-field-${id}`).appendChild(errorDiv);
                else getById(`genres-field-${id}`).appendChild(errorDiv);
            }
        }
    } else if (submitType === submitTypes.DELETE) {
        for (const fieldName in errors) {
            for (const error of errors[fieldName]) {
                const errorDiv = createErrorDiv(error);
                getById('delete-modal-body').appendChild(errorDiv);
            }
        }
    }
};

/**
 * Creates a HTML element to display an error
 * @param {string} content The content of the error to display
 * @returns {HTMLElement} The created HTML element
 */
const createErrorDiv = (content) => {
  const errorDiv = document.createElement('div');
  errorDiv.classList.add('error-text');
  errorDiv.innerHTML = content;
  return errorDiv;
};

/**
 * Handles changements in an item genre addition select
 * @param {submitType} submitType Indicates whether the select is for a new item or an existing one
 * @param {{id: number, name: string}} selectedGenre The selected genre during the change
 * @param {?number} id The id of the inventory item when the select is for an existing one
 */
const handleAddGenreSelectChange = (submitType, selectedGenre, id) => {
    if (submitType === submitTypes.POST) {
        const addGenreSelect = getBySelector('#genres-ul-new .plus-li');

        // Add a new element to the list
        addGenreSelect.insertAdjacentHTML('beforebegin', `
            <li class="genre-li" id="genre-${selectedGenre.id}-for-new-li">
                <span>${selectedGenre.name}</span>
                <a class="button is-small is-danger remove-genre-button" id="button-remove-genre-${selectedGenre.id}-for-new" type="button">
                    <i class="fas fa-times"></i>
                </a>
            </li>
        `);

        // Reset the select
        getById('add-genre-select-new').value = 'default';

        // Disable the selected option in the select
        getById(`add-genre-${selectedGenre.id}-to-new-option`).setAttribute('disabled', 'disabled');

        // Add the event listener to the new genre removal button
        addGenreSelect.previousElementSibling.querySelector('.remove-genre-button')
            .addEventListener('click', () => handleRemoveGenreButtonClick(submitType, selectedGenre.id, 'new'));
    } else if (submitType === submitTypes.PATCH) {
        const addGenreSelect = getBySelector(`#genres-ul-${id} .plus-li`);

        // Add a new element to the list
        addGenreSelect.insertAdjacentHTML('beforebegin', `
            <li class="genre-li" id="genre-${selectedGenre.id}-for-${id}-li">
                <span>${selectedGenre.name}</span>
                <button class="button is-small is-danger remove-genre-button" id="button-remove-genre-${selectedGenre.id}-for-${id}">
                    <i class="fas fa-times"></i>
                </button>
            </li>
        `);

        // Reset the select
        getById(`add-genre-select-${id}`).value = 'default';

        // Disable the selected option in the select
        getById(`add-genre-${selectedGenre.id}-to-${id}-option`).setAttribute('disabled', 'disabled');

        // Add the event listener to the new genre removal button
        addGenreSelect.previousElementSibling.querySelector('.remove-genre-button')
            .addEventListener('click', () => handleRemoveGenreButtonClick(submitType, selectedGenre.id, id));
    }
};

/**
 * Handles a click on a genre removal button
 * @param {submitType} submitType Indicates whether the genre is for a new item or an existing one
 * @param {number} genreId The id of the genre to remove from the item's genres list
 * @param {?number} itemId The id of the item when submitType is PATCH
 */
const handleRemoveGenreButtonClick = (submitType, genreId, itemId) => {
    // Remove the list element
    remove(getById(`genre-${genreId}-for-${itemId}-li`));

    // Enable the option in the corresponding select
    if (submitType === submitTypes.POST)
        getById(`add-genre-${genreId}-to-new-option`).removeAttribute('disabled');
    else if (submitType === submitTypes.PATCH)
        getById(`add-genre-${genreId}-to-${itemId}-option`).removeAttribute('disabled');
};

/**
 * Enables or disables the page inputs, buttons and selects
 * @param {boolean} bool If true, enables inputs, buttons and selects.
 * If false, disables inputs, buttons and selects.
 */
const enableInputs = (bool) => {
  const elems = getAllBySelector('.button, select, input');
  if (!bool) {
      for (const elem of elems) elem.setAttribute('disabled', 'disabled');
  } else {
      for (const elem of elems) elem.removeAttribute('disabled');
  }
};
