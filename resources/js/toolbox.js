/**
 * Calls a function when the DOM has finished loading
 * @param {function} fn The function to call
 */
export const ready = (fn) => {
    if (document.readyState !== 'loading') fn();
    else if (document.addEventListener) document.addEventListener('DOMContentLoaded', fn);
    else {
        document.attachEvent('onreadystatechange', () => {
            if (document.readyState !== 'loading') fn();
        });
    }
};

/**
 * Remove an HTML element and its children from the DOM
 * @param {HTMLElement} element
 */
export const remove = (element) => {
    if (NodeList.prototype.isPrototypeOf(element) || HTMLCollection.prototype.isPrototypeOf(element)) {
        Array.from(element).forEach((item) => item.parentNode.removeChild(item));
    } else element.parentNode.removeChild(element);
};

/**
 * Retrieves a DOM element from its id
 * @param {string} id A string representing the id of the DOM element to retrieve
 * @returns {HTMLElement} The retrieved DOM element
 */
export const getById = (id) => {
    return document.getElementById(id);
};


/**
 * Retrieves DOM elements from their class
 * @param {string} classname A string representing the class of the DOM elements to retrieve
 * @returns {HTMLCollectionOf} The retrieved DOM elements
 */
export const getByClass = (classname) => {
    return document.getElementsByClassName(classname);
};

/**
 * Retrieves the first DOM element matching a CSS selector
 * @param {string} selector A CSS selector
 * @returns {Element} The retrieved DOM element
 */
export const getBySelector = (selector) => {
    return document.querySelector(selector);
};

/**
 * Retrieves DOM elements matching a CSS selector
 * @param {string} selector A CSS selector
 * @returns {NodeListOf<Element>}
 */
export const getAllBySelector = (selector) => {
    return document.querySelectorAll(selector);
};

/**
 * Replace a node with an event-less clone of itself
 * @param {Node} oldElement The node to clone and replace
 * @returns {Node} The clone
 */
export const cloneAndReplace = (oldElement) => {
    const newElement = oldElement.cloneNode(true);
    oldElement.parentNode.replaceChild(newElement, oldElement);
    return newElement;
};

/**
 * Checks if a HTML element is disabled
 * @param {HTMLElement} target
 * @returns {boolean}
 */
export const isDisabled = (target) => {
    const disabledAttribute = target.getAttribute('disabled');
    return (disabledAttribute === 'disabled')
};
