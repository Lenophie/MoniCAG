/**
 * Builds a min-max type string
 * Example : (5, 10, "player", "players") => "5 - 10 players"
 * Example : (null, 20, "minute", "minutes") => "<= 20 minutes"
 * @param min
 * @param max
 * @param singularSuffix
 * @param pluralSuffix
 * @returns {string}
 */
export const buildMinMaxString = (min, max, singularSuffix, pluralSuffix) => {
    let string = '';

    // Min and max case
    if (min !== null && max !== null) {
        string = min !== max ? `${min} - ${max}` : `${min}`;
        if (max > 1 && pluralSuffix != null) string += ` ${pluralSuffix}`;
        else if (max <= 1 && singularSuffix != null) string += ` ${singularSuffix}`;
    // Only min case
    } else if (min !== null && max === null) {
        string = `>= ${min}`;
        if (min <= 1 && singularSuffix != null) string += ` ${singularSuffix}`;
    // Only max case
    } else if (min === null && max !== null) {
        string = `<= ${max}`;
        if (max > 1 && pluralSuffix != null) string += ` ${pluralSuffix}`;
    }

    return string;
};
