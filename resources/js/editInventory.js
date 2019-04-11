import './modal.js';
import {HTTPVerbs, makeAjaxRequest} from './ajax.js';
import {cloneAndReplace, getAllBySelector, getByClass, getById, getBySelector, ready, remove} from './toolbox.js';

const submitTypes = {
    POST: 0,
    PATCH: 1,
    DELETE: 2
};

let previousDeleteModalId = null;

// After page is loaded
ready(() => {
    addListeners();
});

// Listeners setting
const addListeners = () => {
    const addGenreSelects = {};
    for (const inventoryItem of inventoryItems) {
        getById(`edit-item-${inventoryItem.id}-submit-button`).addEventListener('click', (e) => handlePatchItemFormSubmit(e, inventoryItem.id));
        getById(`delete-button-${inventoryItem.id}`).addEventListener('click', () => {if (inventoryItem.status.id !== 3) handleDeleteModalOpening(inventoryItem.id)});
        addGenreSelects[inventoryItem.id] = getById(`add-genre-select-${inventoryItem.id}`);
        addGenreSelects[inventoryItem.id].addEventListener('change', () => handleAddGenreSelectChange(
            submitTypes.PATCH,
            {
                id: parseInt(addGenreSelects[inventoryItem.id].value),
                name: addGenreSelects[inventoryItem.id].options[addGenreSelects[inventoryItem.id].selectedIndex].innerHTML
            },
            inventoryItem.id
        ));
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
    getById('add-item-submit-button').addEventListener('click', (e) => handleAddItemFormSubmit(e));
    addGenreSelects.new = getById('add-genre-select-new');
    addGenreSelects.new.addEventListener('change', () => handleAddGenreSelectChange(
        submitTypes.POST,
        {
            id: parseInt(addGenreSelects.new.value),
            name: addGenreSelects.new.options[addGenreSelects.new.selectedIndex].innerHTML
        }
    ));
};

// Handlers
const handleAddItemFormSubmit = (e) => {
    e.preventDefault();
    const serializedForm = Array.from(new FormData(getById('add-item-form')));
    const formattedForm = {};
    for (const elem of serializedForm) formattedForm[elem[0]] = elem[1];
    formattedForm.genres = Array.from(getAllBySelector('#genres-field-new .genre-li')).map(x => parseInt(x.id.split('-')[1]));
    remove(getByClass('error-text'));
    enableInputs(false);
    const successCallback = () => window.location.href = successRedirectionURL;
    const errorCallback = (response) => {
        enableInputs(true);
        handleFormErrors(submitTypes.POST, JSON.parse(response).errors)
    };

    makeAjaxRequest(HTTPVerbs.POST, requestsURL, JSON.stringify(formattedForm), successCallback, errorCallback);
};

const handlePatchItemFormSubmit = (e, id) => {
    e.preventDefault();
    const serializedForm = Array.from(new FormData(getById(`edit-item-${id}-form`)));
    const formattedForm = {};
    for (const elem of serializedForm) formattedForm[elem[0]] = elem[1];
    formattedForm.inventoryItemId = id;
    formattedForm.genres = Array.from(getAllBySelector(`#genres-field-${id} .genre-li`)).map(x => parseInt(x.id.split('-')[1]));
    remove(getByClass('error-text'));
    enableInputs(false);
    const successCallback = () => window.location.href = successRedirectionURL;
    const errorCallback = (response) => {
        enableInputs(true);
        handleFormErrors(submitTypes.PATCH, JSON.parse(response).errors, id);
    };

    makeAjaxRequest(HTTPVerbs.PATCH, requestsURL, JSON.stringify(formattedForm), successCallback, errorCallback);
};

const handleDeleteModalOpening = (id) => {
    const deleteForm = getById('delete-form');
    const deleteConfirmButtonByClass = getById('delete-confirm-button');

    deleteForm.setAttribute('id', `delete-item-${id}-form`);
    deleteConfirmButtonByClass.setAttribute('id', `delete-confirm-button-${id}`);

    let deleteConfirmButton = getById(`delete-confirm-button-${id}`);
    if (previousDeleteModalId != null) deleteConfirmButton = cloneAndReplace(deleteConfirmButton);
    previousDeleteModalId = id;
    deleteConfirmButton.addEventListener('click', (e) => handleDeleteItemFormSubmit(e, id));
};

const handleDeleteItemFormSubmit = (e, id) => {
    e.preventDefault();
    const serializedForm = Array.from(new FormData(getById(`delete-item-${id}-form`)));
    const formattedForm = {};
    for (const elem of serializedForm) formattedForm[elem[0]] = elem[1];
    formattedForm.inventoryItemId = id;
    remove(getByClass('error-text'));
    enableInputs(false);
    const successCallback = () => window.location.href = successRedirectionURL;
    const errorCallback = (response) => {
        enableInputs(true);
        handleFormErrors(submitTypes.DELETE, JSON.parse(response).errors);
    };

    makeAjaxRequest(HTTPVerbs.DELETE, requestsURL, JSON.stringify(formattedForm), successCallback, errorCallback);
};

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

const createErrorDiv = (content) => {
  const errorDiv = document.createElement('div');
  errorDiv.classList.add('error-text');
  errorDiv.innerHTML = content;
  return errorDiv;
};

const handleAddGenreSelectChange = (submitType, selectedGenre, id) => {
    if (submitType === submitTypes.POST) {
        const addGenreSelect = getBySelector('#genres-ul-new .plus-li');
        addGenreSelect.insertAdjacentHTML('beforebegin', `
            <li class="genre-li" id="genre-${selectedGenre.id}-for-new-li">
                <span>${selectedGenre.name}</span>
                <a class="button is-small is-danger remove-genre-button" id="button-remove-genre-${selectedGenre.id}-for-new" type="button">
                    <i class="fas fa-times"></i>
                </a>
            </li>
        `);
        getById('add-genre-select-new').value = 'default';
        getById(`add-genre-${selectedGenre.id}-to-new-option`).setAttribute('disabled', 'disabled');
        addGenreSelect.previousElementSibling.querySelector('.remove-genre-button').addEventListener('click', () => handleRemoveGenreButtonClick(submitType, selectedGenre.id, 'new'));
    } else if (submitType === submitTypes.PATCH) {
        const addGenreSelect = getBySelector(`#genres-ul-${id} .plus-li`);
        addGenreSelect.insertAdjacentHTML('beforebegin', `
            <li class="genre-li" id="genre-${selectedGenre.id}-for-${id}-li">
                <span>${selectedGenre.name}</span>
                <button class="button is-small is-danger remove-genre-button" id="button-remove-genre-${selectedGenre.id}-for-${id}">
                    <i class="fas fa-times"></i>
                </button>
            </li>
        `);
        getById(`add-genre-select-${id}`).value = 'default';
        getById(`add-genre-${selectedGenre.id}-to-${id}-option`).setAttribute('disabled', 'disabled');
        addGenreSelect.previousElementSibling.querySelector('.remove-genre-button').addEventListener('click', () => handleRemoveGenreButtonClick(submitType, selectedGenre.id, id));
    }
};

const handleRemoveGenreButtonClick = (submitType, genreId, itemId) => {
    remove(getById(`genre-${genreId}-for-${itemId}-li`));
    if (submitType === submitTypes.POST) {
        getById(`add-genre-${genreId}-to-new-option`).removeAttribute('disabled');
    } else if (submitType === submitTypes.PATCH) {
        getById(`add-genre-${genreId}-to-${itemId}-option`).removeAttribute('disabled');
    }
};

const enableInputs = (bool) => {
  const elems = getAllBySelector('.button, select, input');
  if (!bool) {
      for (const elem of elems) elem.setAttribute('disabled', 'disabled');
  } else {
      for (const elem of elems) elem.removeAttribute('disabled');
  }
};
