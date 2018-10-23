export const ready = (fn) => {
    if (document.readyState !== 'loading') fn();
    else if (document.addEventListener) document.addEventListener('DOMContentLoaded', fn);
    else {
        document.attachEvent('onreadystatechange', () => {
            if (document.readyState !== 'loading')
                fn();
        });
    }
};

export const remove = (element) => {
    if (NodeList.prototype.isPrototypeOf(element) || HTMLCollection.prototype.isPrototypeOf(element)) {
        Array.from(element).forEach((item) => item.parentNode.removeChild(item));
    } else element.parentNode.removeChild(element);
};

export const getById = (id) => {
    return document.getElementById(id);
};

export const getByClass = (classname) => {
    return document.getElementsByClassName(classname);
};

export const getBySelector = (selector) => {
    return document.querySelector(selector);
};

export const getAllBySelector = (selector) => {
    return document.querySelectorAll(selector);
};

export const cloneAndReplace = (oldElement) => {
    const newElement = oldElement.cloneNode(true);
    oldElement.parentNode.replaceChild(newElement, oldElement);
    return newElement;
};

export const isDisabled = (target) => {
    const disabledAttribute = target.getAttribute('disabled');
    return (disabledAttribute === 'disabled')
};