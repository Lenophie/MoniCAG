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
    targetModal.querySelector('.modal-background').addEventListener('click', (e) => {
        e.preventDefault();
        targetModal.classList.remove('is-active');
        html.classList.remove('is-clipped');
    });
};

addListenersToModalTogglers();