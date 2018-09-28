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
    const addGenreSelects = {};
    for (const inventoryItem of inventoryItems) {
        $(`#edit-item-${inventoryItem.id}-submit-button`).click((e) => handlePatchItemFormSubmit(e, inventoryItem.id));
        addGenreSelects[inventoryItem.id] = $(`#add-genre-select-${inventoryItem.id}`);
        addGenreSelects[inventoryItem.id].change(() => handleAddGenreSelectChange(submitTypes.PATCH, {id: parseInt(addGenreSelects[inventoryItem.id].val()), name: addGenreSelects[inventoryItem.id].find('option:selected').text()}, inventoryItem.id));
    }
    $('#add-item-submit-button').click((e) => handleAddItemFormSubmit(e));
    addGenreSelects.new = $(`#add-genre-select-new`);
    addGenreSelects.new.change(() => handleAddGenreSelectChange(submitTypes.POST, {id: parseInt(addGenreSelects.new.val()), name: addGenreSelects.new.find('option:selected').text()}));
    $('.remove-genre-button').click((e) => handleRemoveGenreButtonClick(e.target));
};

// Handlers
const handleAddItemFormSubmit = (e) => {
    e.preventDefault();
    const serializedForm = $('#add-item-form').serializeArray();
    const formattedForm = {};
    for (const elem of serializedForm) formattedForm[elem.name] = elem.value;
    formattedForm.genres = $(`#genres-field-new .genre`).get().map(x => parseInt(x.id.slice('genre-'.length)));
    $('.error-text').remove();

    $.ajax({
        url: requestsURL,
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
    formattedForm.inventoryItemId = id;
    formattedForm.genres = $(`#genres-field-${id} .genre`).get().map(x => parseInt(x.id.slice('genre-'.length)));
    $('.error-text').remove();

    $.ajax({
        url: requestsURL,
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

const handleAddGenreSelectChange = (submitType, selectedGenre, id) => {
    if (submitType === submitTypes.POST) {
        const addGenreLink = $('#genres-ul-new .plus-li');
        addGenreLink.before(`
            <li>
                <span id="genre-${selectedGenre.id}" class="genre">${selectedGenre.name}</span>
                <button class="btn btn-sm btn-danger remove-genre-button">
                    <i class="fas fa-times"></i>
                </button>
            </li>
        `);
        $('#add-genre-select-new').val('default');
        addGenreLink.prev().find('.remove-genre-button').click((e) => handleRemoveGenreButtonClick(e.target));
    } else if (submitType === submitTypes.PATCH) {
        const addGenreLink = $(`#genres-ul-${id} .plus-li`);
        addGenreLink.before(`
            <li>
                <span id="genre-${selectedGenre.id}" class="genre">${selectedGenre.name}</span>
                <button class="btn btn-sm btn-danger remove-genre-button">
                    <i class="fas fa-times"></i>
                </button>
            </li>
        `);
        $(`#add-genre-select-${id}`).val('default');
        addGenreLink.prev().find('.remove-genre-button').click((e) => handleRemoveGenreButtonClick(e.target));
    }
};

const handleRemoveGenreButtonClick = (clickedButton) => {
    clickedButton.parentElement.remove();
};