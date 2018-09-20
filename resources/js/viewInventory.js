import $ from 'jquery';
import 'bootstrap/dist/js/bootstrap.bundle.js';
import Fuse from "fuse.js";

const gameSearchInput = $('#game-search-input');
const cancelGameSearchButton = $('#cancel-game-search-button');
const genreFilteringSelect = $('#genre-select');
const cancelGenreFilteringButton = $('#cancel-genre-filtering-button');
const durationFilteringInput = $('#duration-input');
const cancelDurationFilteringButton = $('#cancel-duration-filtering-button');
const playersFilteringInput = $('#players-input');
const cancelPlayersFilteringButton = $('#cancel-players-filtering-button');
const displayedInventoryItemsList = $('#inventory-items-list');

// After page is loaded
$().ready(() => {
    handleSearchFieldsUpdate();
    addListeners();
});

// Handlers

const addListeners = () => {
    gameSearchInput.keyup(() => handleSearchFieldsUpdate());
    genreFilteringSelect.keyup(() => handleSearchFieldsUpdate());
    durationFilteringInput.keyup(() => handleSearchFieldsUpdate());
    playersFilteringInput.keyup(() => handleSearchFieldsUpdate());

    cancelGameSearchButton.click(() => {
        gameSearchInput.val('');
        handleSearchFieldsUpdate();
    });
    cancelDurationFilteringButton.click(() => {
        durationFilteringInput.val('');
        handleSearchFieldsUpdate();
    });
    cancelGenreFilteringButton.click(() => {
        // change selected value to default
        handleSearchFieldsUpdate();
    });
    cancelPlayersFilteringButton.click(() => {
        playersFilteringInput.val('');
        handleSearchFieldsUpdate();
    });
};

const handleSearchFieldsUpdate = () => {
    const searchParameters = {
        game : gameSearchInput.val(),
        genre : genreFilteringSelect.val(),
        duration : durationFilteringInput.val(),
        playersNumber : playersFilteringInput.val()
    };

    let filteredInventoryItems = inventoryItems;
    if (searchParameters.game.length > 0) filteredInventoryItems = getInventoryItemsByName(searchParameters.game);
    updateDisplayedInventoryItems(filteredInventoryItems);
};

// Actions

const getInventoryItemsByName = (searchQuery) => {
    const options = {
        shouldSort: true,
        tokenize: true,
        threshold: 0.6,
        location: 0,
        distance: 0,
        maxPatternLength: 32,
        minMatchCharLength: 1,
        keys: [
            "name"
        ]
    };
    const fuse = new Fuse(inventoryItems, options);
    return fuse.search(searchQuery);
};

const updateDisplayedInventoryItems = (inventoryItemsToDisplay) => {
    displayedInventoryItemsList.empty();
    for (const inventoryItem of inventoryItemsToDisplay) {
        displayedInventoryItemsList.append(
            `<div class="col-md-2 mb-1">
                <button class="btn btn-outline-primary inventory-item" id="inventory-item-${inventoryItem.id}">
                    <span class="inventory-item-name">${inventoryItem.name}</span>
                    <hr class="item-hr">
                    <div class="inventory-item-footer">${inventoryItem.status.name}</div>
                </button>
            </div>`)
    }
};