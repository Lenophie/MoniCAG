import assert from 'assert';
import {buildMinMaxString} from "../../../resources/js/tools.js";

describe ('MinMax strings', () => {
    // All parameters
    it ('correctly formats a MinMax string when provided min, max and both suffixes', () => {
        assert.strictEqual(
            buildMinMaxString(2, 5, "player", "players"),
            "2 - 5 players"
        );
        assert.strictEqual(
            buildMinMaxString(0, 1, "bird", "birds"),
            "0 - 1 bird"
        );
    });

    // One parameter missing
    it ('correctly formats a MinMax string when provided min, max and singular suffix', () => {
        assert.strictEqual(
            buildMinMaxString(2, 5, "player", null),
            "2 - 5"
        );
        assert.strictEqual(
            buildMinMaxString(0, 1, "bird", null),
            "0 - 1 bird"
        );
    });

    it ('correctly formats a MinMax string when provided min, max and plural suffix', () => {
        assert.strictEqual(
            buildMinMaxString(2, 5, null, "players"),
            "2 - 5 players"
        );
        assert.strictEqual(
            buildMinMaxString(0, 1, null, "birds"),
            "0 - 1"
        );
    });

    it ('correctly formats a MinMax string when provided min and both suffixes', () => {
        assert.strictEqual(
            buildMinMaxString(2, null, "player", "players"),
            ">= 2 players"
        );
        assert.strictEqual(
            buildMinMaxString(1, null, "bird", "birds"),
            ">= 1 bird"
        );
    });

    it ('correctly formats a MinMax string when provided max and both suffixes', () => {
        assert.strictEqual(
            buildMinMaxString(null, 5, "player", "players"),
            "<= 5 players"
        );
        assert.strictEqual(
            buildMinMaxString(null, 1, "bird", "birds"),
            "<= 1 bird"
        );
    });

    // 2 parameters missing
    it ('correctly formats a MinMax string when provided min and max', () => {
        assert.strictEqual(
            buildMinMaxString(2, 5, null, null),
            "2 - 5"
        );
        assert.strictEqual(
            buildMinMaxString(0, 1, null, null),
            "0 - 1"
        );
    });

    it ('correctly formats a MinMax string when provided min and singular suffix', () => {
        assert.strictEqual(
            buildMinMaxString(2, null, "player", null),
            ">= 2"
        );
        assert.strictEqual(
            buildMinMaxString(1, null, "bird", null),
            ">= 1 bird"
        );
    });

    it ('correctly formats a MinMax string when provided min and plural suffix', () => {
        assert.strictEqual(
            buildMinMaxString(2, null, null, "players"),
            ">= 2 players"
        );
        assert.strictEqual(
            buildMinMaxString(1, null, null, "birds"),
            ">= 1"
        );
    });

    it ('correctly formats a MinMax string when provided max and singular suffix', () => {
        assert.strictEqual(
            buildMinMaxString(null, 5, "player", null),
            "<= 5"
        );
        assert.strictEqual(
            buildMinMaxString(null, 1, "bird", null),
            "<= 1 bird"
        );
    });

    it ('correctly formats a MinMax string when provided max and plural suffix', () => {
        assert.strictEqual(
            buildMinMaxString(null, 5, null, "players"),
            "<= 5 players"
        );
        assert.strictEqual(
            buildMinMaxString(null, 1, null, "birds"),
            "<= 1"
        );
    });

    it ('correctly formats a MinMax string when provided singular and plural suffixes', () => {
        assert.strictEqual(
            buildMinMaxString(null, null, "player", "players"),
            ""
        );
        assert.strictEqual(
            buildMinMaxString(null, null, "bird", "birds"),
            ""
        );
    });

    // 3 parameters missing

    it ('correctly formats a MinMax string when provided min', () => {
        assert.strictEqual(
            buildMinMaxString(2, null, null, null),
            ">= 2"
        );
        assert.strictEqual(
            buildMinMaxString(1, null, null, null),
            ">= 1"
        );
    });

    it ('correctly formats a MinMax string when provided max', () => {
        assert.strictEqual(
            buildMinMaxString(null, 5, null, null),
            "<= 5"
        );
        assert.strictEqual(
            buildMinMaxString(null, 1, null, null),
            "<= 1"
        );
    });

    it ('correctly formats a MinMax string when provided a suffix', () => {
        assert.strictEqual(
            buildMinMaxString(null, null, "player", null),
            ""
        );
        assert.strictEqual(
            buildMinMaxString(null, null, null, "players"),
            ""
        );
    });

    // All parameters missing
    it ('correctly formats a MinMax string with no parameter', () => {
        assert.strictEqual(
            buildMinMaxString(null, null, null, null),
            ""
        );
    });
});

