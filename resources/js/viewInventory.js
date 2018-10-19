import Fuse from "fuse.js";

const gameSearchInput = $('#search-game-field');
const cancelGameSearchButton = $('#cancel-game-search-button');
const genreFilteringSelect = $('#genre-select');
const cancelGenreFilteringButton = $('#cancel-genre-filtering-button');
const durationFilteringInput = $('#duration-input');
const cancelDurationFilteringButton = $('#cancel-duration-filtering-button');
const playersFilteringInput = $('#players-input');
const cancelPlayersFilteringButton = $('#cancel-players-filtering-button');
const displayedInventoryItemsList = $('#inventory-items-list');
let messages = {};

// After page is loaded
$().ready(() => {
    messages.players = $("meta[name='players']").attr('content');
    messages.min = $("meta[name='min']").attr('content');
    handleSearchFieldsUpdate();
    addListeners();
});

// Handlers
const addListeners = () => {
    gameSearchInput.keyup(() => handleSearchFieldsUpdate());
    genreFilteringSelect.change(() => handleSearchFieldsUpdate());
    durationFilteringInput.keyup(() => handleSearchFieldsUpdate());
    durationFilteringInput.change(() => handleSearchFieldsUpdate());
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
        genreFilteringSelect.val('');
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

    for (const key in searchParameters) {
        if (searchParameters[key] === '') searchParameters[key] = null;
        else if (key !== 'game') searchParameters[key] = parseInt(searchParameters[key]);
    }

    let filteredInventoryItems = [];
    for (const inventoryItem of inventoryItems) filteredInventoryItems.push(inventoryItem); // first order deep copy
    if (searchParameters.game !== null) filteredInventoryItems = filterInventoryItemsByName(searchParameters.game, filteredInventoryItems);
    if (searchParameters.genre !== null) filteredInventoryItems = filterInventoryItemsByGenre(searchParameters.genre, filteredInventoryItems);
    if (searchParameters.duration !== null) filteredInventoryItems = filterInventoryItemsByDuration(searchParameters.duration, filteredInventoryItems);
    if (searchParameters.playersNumber !== null) filteredInventoryItems = filterInventoryItemsByPlayers(searchParameters.playersNumber, filteredInventoryItems);
    updateDisplayedInventoryItems(filteredInventoryItems);
};

// Actions

const filterInventoryItemsByName = (searchQuery, filteredInventoryItems) => {
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
    const fuse = new Fuse(filteredInventoryItems, options);
    return fuse.search(searchQuery);
};

const filterInventoryItemsByGenre = (selectedGenre, eligibleInventoryItems) => {
    const filteredInventoryItems = [];
    for (const inventoryItem of eligibleInventoryItems) {
        for (const genre of inventoryItem.genres) {
            if (genre.pivot.genre_id === selectedGenre) {
                filteredInventoryItems.push(inventoryItem);
                break;
            }
        }
    }
    return filteredInventoryItems;
};

const filterInventoryItemsByDuration = (desiredDuration, eligibleInventoryItems) => {
    const filteredInventoryItems = [];
    for (const inventoryItem of eligibleInventoryItems) {
        const durationMax = inventoryItem.duration.max === null ? 0 : inventoryItem.duration.max;
        const durationMin = inventoryItem.duration.min === null ? +Infinity : inventoryItem.duration.min;
        if (durationMin <= desiredDuration && durationMax >= desiredDuration) filteredInventoryItems.push(inventoryItem);
    }
    return filteredInventoryItems;
};

const filterInventoryItemsByPlayers = (desiredPlayersCount, eligibleInventoryItems) => {
    const filteredInventoryItems = [];
    for (const inventoryItem of eligibleInventoryItems) {
        const durationMax = inventoryItem.players.max === null ? 0 : inventoryItem.players.max;
        const durationMin = inventoryItem.players.min === null ? +Infinity : inventoryItem.players.min;
        if (durationMin <= desiredPlayersCount && durationMax >= desiredPlayersCount) filteredInventoryItems.push(inventoryItem);
    }
    return filteredInventoryItems;
};

const updateDisplayedInventoryItems = (inventoryItemsToDisplay) => {
    displayedInventoryItemsList.empty();
    for (const inventoryItem of inventoryItemsToDisplay) {
        const isThereDurationInfo = inventoryItem.duration.min !== null || inventoryItem.duration.max !== null;
        const isTherePlayersInfo = inventoryItem.players.min !== null || inventoryItem.players.max !== null;
        displayedInventoryItemsList.append(
            `<div class="column is-2">
                <div class="inventory-item" id="inventory-item-${inventoryItem.id}">
                    <div class="inventory-item-name">${inventoryItem.name}<hr class="item-hr"></div>
                    <div class="inventory-item-precision">
                        <i class="fas fa-trophy"></i> ${formatGenresList(inventoryItem.genres)}
                        ${isThereDurationInfo ? 
                            `<br/><i class="far fa-clock"></i> ${inventoryItem.duration.min !== null ? inventoryItem.duration.min : '?'} - ${inventoryItem.duration.max !== null ? inventoryItem.duration.max : '?'} ${messages.min.toLowerCase()}`
                            : ''}
                        ${isTherePlayersInfo ?
                            `<br/><i class="fas fa-users"></i> ${inventoryItem.players.min !== null ? inventoryItem.players.min : '?'} - ${inventoryItem.players.max !== null ? inventoryItem.players.max : '?'} ${messages.players.toLowerCase()}`
                            : ''}
                    </div>
                    <div class="inventory-item-footer">
                        ${inventoryItem.status.name}
                    </div>
                </div>
            </div>`)
    }
};

const formatGenresList = (genres) => {
    const genresLength = genres.length;
    let genresString = '';
    for (const genreIndex in genres) {
        genresString += genres[genreIndex].name;
        if (genreIndex < genresLength - 1) genresString += ', ';
    }
    return genresString;
};