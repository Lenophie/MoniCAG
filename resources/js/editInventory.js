import $ from 'jquery';
import './modal.js';

const submitTypes = {
    POST: 0,
    PATCH: 1,
    DELETE: 2
};

// After page is loaded
$().ready(() => {
    addListeners();
});

// Listeners setting
const addListeners = () => {
    const addGenreSelects = {};
    for (const inventoryItem of inventoryItems) {
        $(`#edit-item-${inventoryItem.id}-submit-button`).click((e) => handlePatchItemFormSubmit(e, inventoryItem.id));
        $(`#delete-button-${inventoryItem.id}`).click(() => {if (inventoryItem.status.id !== 3) handleDeleteModalOpening(inventoryItem.id)});
        addGenreSelects[inventoryItem.id] = $(`#add-genre-select-${inventoryItem.id}`);
        addGenreSelects[inventoryItem.id].change(() => handleAddGenreSelectChange(
            submitTypes.PATCH,
            {
                id: parseInt(addGenreSelects[inventoryItem.id].val()),
                name: addGenreSelects[inventoryItem.id].find('option:selected').text()
            },
            inventoryItem.id
        ));
        $(`#genres-ul-${inventoryItem.id} .remove-genre-button`).click((e) =>
            {
                const genreId = $(e.currentTarget.parentElement).attr('id').split('-')[1];
                handleRemoveGenreButtonClick(
                    submitTypes.PATCH,
                    genreId,
                    inventoryItem.id
                );
            }
        );
    }
    $('#add-item-submit-button').click((e) => handleAddItemFormSubmit(e));
    addGenreSelects.new = $(`#add-genre-select-new`);
    addGenreSelects.new.change(() => handleAddGenreSelectChange(
        submitTypes.POST,
        {
            id: parseInt(addGenreSelects.new.val()),
            name: addGenreSelects.new.find('option:selected').text()
        }
    ));
};

// Handlers
const handleAddItemFormSubmit = (e) => {
    e.preventDefault();
    const serializedForm = $('#add-item-form').serializeArray();
    const formattedForm = {};
    for (const elem of serializedForm) formattedForm[elem.name] = elem.value;
    formattedForm.genres = $(`#genres-field-new .genre-li`).get().map(x => parseInt(x.id.split('-')[1]));
    $('.error-text').remove();
    enableInputs(false);

    $.ajax({
        url: requestsURL,
        type: 'POST',
        data: formattedForm,
        success: () => {
            window.location.href = successRedirectionURL;
        },
        error: (response) => {
            enableInputs(true);
            handleFormErrors(submitTypes.POST, response.responseJSON.errors)
        }
    });
};

const handlePatchItemFormSubmit = (e, id) => {
    e.preventDefault();
    const serializedForm = $(`#edit-item-${id}-form`).serializeArray();
    const formattedForm = {};
    for (const elem of serializedForm) formattedForm[elem.name] = elem.value;
    formattedForm.inventoryItemId = id;
    formattedForm.genres = $(`#genres-field-${id} .genre-li`).get().map(x => parseInt(x.id.split('-')[1]));
    $('.error-text').remove();
    enableInputs(false);

    $.ajax({
        url: requestsURL,
        type: 'PATCH',
        data: formattedForm,
        success: () => {
            window.location.href = successRedirectionURL;
        },
        error: (response) => {
            enableInputs(true);
            handleFormErrors(submitTypes.PATCH, response.responseJSON.errors, id);
        }
    });
};

const handleDeleteModalOpening = (id) => {
    console.log('ho');
    const deleteForm = $('.delete-form');
    const deleteConfirmButtonByClass = $('.delete-confirm-button');

    deleteForm.attr('id', `delete-item-${id}-form`);
    deleteConfirmButtonByClass.attr('id', `delete-confirm-button-${id}`);

    const deleteConfirmButton = $(`#delete-confirm-button-${id}`);
    deleteConfirmButton.off();
    deleteConfirmButton.click((e) => handleDeleteItemFormSubmit(e, id));
    $('#delete-confirm-modal').on('hidden.bs.modal', () => {
        deleteConfirmButton.off();
        deleteForm.removeAttr('id');
        deleteConfirmButtonByClass.removeAttr('id');
    });
};

const handleDeleteItemFormSubmit = (e, id) => {
    e.preventDefault();
    const serializedForm = $(`#delete-item-${id}-form`).serializeArray();
    const formattedForm = {};
    for (const elem of serializedForm) formattedForm[elem.name] = elem.value;
    formattedForm.inventoryItemId = id;
    $('.error-text').remove();
    enableInputs(false);

    $.ajax({
        url: requestsURL,
        type: 'DELETE',
        data: formattedForm,
        success: () => {
            window.location.href = successRedirectionURL;
        },
        error: (response) => {
            enableInputs(true);
            handleFormErrors(submitTypes.DELETE, response.responseJSON.errors);
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
                    $(`#genres-field-new`).append(`<div class="error-text">${error}</div>`);
                }
            }
        }
    } else if (submitType === submitTypes.PATCH) {
        for (const fieldName in errors) {
            for (const error of errors[fieldName]) {
                if (!fieldName.startsWith('genres.')) {
                    $(`#${fieldName}-field-${id}`).append(`<div class="error-text">${error}</div>`);
                } else {
                    $(`#genres-field-${id}`).append(`<div class="error-text">${error}</div>`);
                }
            }
        }
    } else if (submitType === submitTypes.DELETE) {
        for (const fieldName in errors) {
            for (const error of errors[fieldName]) {
                $('#delete-modal-body').append(`<div class="error-text">${error}</div>`);
            }
        }
    }
};

const handleAddGenreSelectChange = (submitType, selectedGenre, id) => {
    if (submitType === submitTypes.POST) {
        const addGenreSelect = $('#genres-ul-new .plus-li');
        addGenreSelect.before(`
            <li class="genre-li" id="genre-${selectedGenre.id}-for-new-li">
                <span>${selectedGenre.name}</span>
                <a class="button is-small is-danger remove-genre-button" id="button-remove-genre-${selectedGenre.id}-for-new" type="button">
                    <i class="fas fa-times"></i>
                </a>
            </li>
        `);
        $('#add-genre-select-new').val('default');
        $(`#add-genre-${selectedGenre.id}-to-new-option`).attr('disabled', 'disabled');
        addGenreSelect.prev().find('.remove-genre-button').click(() => handleRemoveGenreButtonClick(submitType, selectedGenre.id, 'new'));
    } else if (submitType === submitTypes.PATCH) {
        const addGenreSelect = $(`#genres-ul-${id} .plus-li`);
        addGenreSelect.before(`
            <li class="genre-li" id="genre-${selectedGenre.id}-for-${id}-li">
                <span>${selectedGenre.name}</span>
                <button class="button is-small is-danger remove-genre-button" id="button-remove-genre-${selectedGenre.id}-for-${id}">
                    <i class="fas fa-times"></i>
                </button>
            </li>
        `);
        $(`#add-genre-select-${id}`).val('default');
        $(`#add-genre-${selectedGenre.id}-to-${id}-option`).attr('disabled', 'disabled');
        addGenreSelect.prev().find('.remove-genre-button').click(() => handleRemoveGenreButtonClick(submitType, selectedGenre.id, id));
    }
};

const handleRemoveGenreButtonClick = (submitType, genreId, itemId) => {
    $(`#genre-${genreId}-for-${itemId}-li`).remove();
    if (submitType === submitTypes.POST) {
        $(`#add-genre-${genreId}-to-new-option`).removeAttr('disabled');
    } else if (submitType === submitTypes.PATCH) {
        $(`#add-genre-${genreId}-to-${itemId}-option`).removeAttr('disabled');
    }
};

const enableInputs = (bool) => {
  const buttons = $('button');
  const selects = $('select');
  const inputs = $('input');
  if (!bool) {
      buttons.attr('disabled', 'disabled');
      selects.attr('disabled', 'disabled');
      inputs.attr('disabled', 'disabled');
  } else {
      buttons.removeAttr('disabled');
      selects.removeAttr('disabled');
      inputs.removeAttr('disabled');
  }
};