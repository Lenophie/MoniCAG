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
    element.parentNode.removeChild(element);
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