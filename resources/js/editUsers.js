import $ from 'jquery';
import 'bootstrap/dist/js/bootstrap.bundle.js';

// After page is loaded
$().ready(() => {
    addListeners();
});

// Listeners setting
const addListeners = () => {
    for (const user of users) {
        $(`#edit-user-${user.id}-button`).click((e) => handleEditUserButtonClick(e, user.id));
        $(`#delete-user-${user.id}-button`).click((e) => handleDeleteUserButtonClick(e, user.id));
    }
};

// Listeners handlers
const handleEditUserButtonClick = (e, id) => {
    e.preventDefault();
    const serializedForm = $(`#edit-user-${id}-form`).serializeArray();
    const formattedForm = {};
    for (const elem of serializedForm) formattedForm[elem.name] = elem.value;
    formattedForm.userId = id;
    $('.error-text').remove();
    enableInputs(false);

    $.ajax({
        url: requestsURL,
        type: 'PATCH',
        data: formattedForm,
        success: () => {
            window.location.href = '';
        },
        error: (response) => {
            enableInputs(true);
        }
    });
};

const handleDeleteUserButtonClick = (e, id) => {
    e.preventDefault();
    const serializedForm = $(`#delete-user-${id}-form`).serializeArray();
    const formattedForm = {};
    for (const elem of serializedForm) formattedForm[elem.name] = elem.value;
    formattedForm.userId = id;
    $('.error-text').remove();
    enableInputs(false);

    $.ajax({
        url: requestsURL,
        type: 'DELETE',
        data: formattedForm,
        success: () => {
            window.location.href = '';
        },
        error: (response) => {
            enableInputs(true);
        }
    });
};

const enableInputs = (bool) => {
    const buttons = $('button');
    const selects = $('select');
    if (!bool) {
        buttons.attr('disabled', 'disabled');
        selects.attr('disabled', 'disabled');
    } else {
        buttons.removeAttr('disabled');
        selects.removeAttr('disabled');
    }
};