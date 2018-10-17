const html = document.querySelector('html');

const addListenersToModalTogglers = () => {
    const modalTogglers = document.querySelectorAll("[data-toggle='modal']");
    for (const modalToggler of modalTogglers) {
        const targetModalId = modalToggler.getAttribute("data-target");
        if (targetModalId != null) {
            const targetModal = document.getElementById(targetModalId);
            modalToggler.addEventListener('click', () => toggleModal(targetModal));
        }
    }
};

const toggleModal = (targetModal) => {
    targetModal.classList.add('is-active');
    html.classList.add('is-clipped');
    const modalClosers = targetModal.querySelectorAll('.modal-background, .delete');
    for (const modalCloser of modalClosers) modalCloser.addEventListener('click', (e) => closeModal(e, targetModal));
};

const closeModal = (event, targetModal) => {
    event.preventDefault();
    targetModal.classList.remove('is-active');
    html.classList.remove('is-clipped');
};

addListenersToModalTogglers();