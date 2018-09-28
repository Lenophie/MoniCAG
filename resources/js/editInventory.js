import $ from 'jquery';
import 'bootstrap/dist/js/bootstrap.bundle.js';

// TODO : Add confirmation modal for deletions.

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
    const addGenreSelects = {};
    for (const inventoryItem of inventoryItems) {
        $(`#edit-item-${inventoryItem.id}-submit-button`).click((e) => handlePatchItemFormSubmit(e, inventoryItem.id));
        $(`#delete-button-${inventoryItem.id}`).click((e) => handleDeleteItemFormSubmit(e, inventoryItem.id));
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
                const genreSpan = $(e.target.parentElement.children).closest('.genre');
                handleRemoveGenreButtonClick(
                    e.target,
                    submitTypes.PATCH,
                    {
                        id: parseInt(genreSpan.attr('id').slice('genre-'.length)),
                        name: genreSpan.text()
                    },
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
    formattedForm.genres = $(`#genres-field-new .genre`).get().map(x => parseInt(x.id.slice('genre-'.length)));
    $('.error-text').remove();
    enableInputs(false);

    $.ajax({
        url: requestsURL,
        type: 'POST',
        data: formattedForm,
        success: () => {
            window.location.href = viewInventoryURL;
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
    formattedForm.genres = $(`#genres-field-${id} .genre`).get().map(x => parseInt(x.id.slice('genre-'.length)));
    $('.error-text').remove();
    enableInputs(false);

    $.ajax({
        url: requestsURL,
        type: 'PATCH',
        data: formattedForm,
        success: () => {
            window.location.href = viewInventoryURL;
        },
        error: (response) => {
            enableInputs(true);
            handleFormErrors(submitTypes.PATCH, response.responseJSON.errors, id);
        }
    });
};

const handleDeleteItemFormSubmit = (e, id) => {
    e.preventDefault();
    const serializedForm = $(`#delete-item-${id}-form`).serializeArray();
    const formattedForm = {};
    for (const elem of serializedForm) formattedForm[elem.name] = elem.value;
    formattedForm.inventoryItemId = id;
    enableInputs(false);

    $.ajax({
        url: requestsURL,
        type: 'DELETE',
        data: formattedForm,
        success: () => {
            window.location.href = viewInventoryURL;
        },
        error: (response) => {
            enableInputs(true);
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
    }
};

const handleAddGenreSelectChange = (submitType, selectedGenre, id) => {
    if (submitType === submitTypes.POST) {
        const addGenreSelect = $('#genres-ul-new .plus-li');
        addGenreSelect.before(`
            <li>
                <span id="genre-${selectedGenre.id}" class="genre">${selectedGenre.name}</span>
                <button class="btn btn-sm btn-danger remove-genre-button">
                    <i class="fas fa-times"></i>
                </button>
            </li>
        `);
        $('#add-genre-select-new').val('default');
        $(`#add-genre-${selectedGenre.id}-to-new-option`).attr('disabled', 'disabled');
        addGenreSelect.prev().find('.remove-genre-button').click((e) => handleRemoveGenreButtonClick(e.target, submitType, selectedGenre, id));
    } else if (submitType === submitTypes.PATCH) {
        const addGenreSelect = $(`#genres-ul-${id} .plus-li`);
        addGenreSelect.before(`
            <li>
                <span id="genre-${selectedGenre.id}" class="genre">${selectedGenre.name}</span>
                <button class="btn btn-sm btn-danger remove-genre-button">
                    <i class="fas fa-times"></i>
                </button>
            </li>
        `);
        $(`#add-genre-select-${id}`).val('default');
        $(`#add-genre-${selectedGenre.id}-to-${id}-option`).attr('disabled', 'disabled');
        addGenreSelect.prev().find('.remove-genre-button').click((e) => handleRemoveGenreButtonClick(e.target, submitType, selectedGenre, id));
    }
};

const handleRemoveGenreButtonClick = (clickedButton, submitType, selectedGenre, id) => {
    clickedButton.parentElement.remove();
    if (submitType === submitTypes.POST) {
        $(`#add-genre-${selectedGenre.id}-to-new-option`).removeAttr('disabled');
    } else if (submitType === submitTypes.PATCH) {
        $(`#add-genre-${selectedGenre.id}-to-${id}-option`).removeAttr('disabled');
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