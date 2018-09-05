/*
 * This file does the requests to the PHP API. 
 * Refer to the PHP API documentation for a list of available requests.
 */

/**
 * A string containing the base URL for the php API.
 * @type {string}
 */
const BASE_URL = 'api.php';

/**
 * The requests headers to prevent caching.
 * @type {Object}
 */
const requestHeaders =
{
  pragma: 'no-cache',
  'cache-control': 'no-store'
};

/**
 * The requests parameters.
 * @type {RequestInit}
 */
const requestInit = {
  method: 'GET',
  headers: requestHeaders
};

/**
 * Checks if the promise is successful by checking the http response code.
 * @param {Response} response Response to the promise. Contains the data if the promise is successful.
 * @return {Response} Returns or throws the response.
 */
const handleHttpErrors = (response) => {
  if (!response.ok) throw response;
  return response;
};

/**
 * Adds the base URL before the URL parameters and fetches the data from the server.
 * @param {string} urlParams URL parameters string.
 * @return {Response} Response to the promise. Contains the data if the promise is successful.
 */
const apiFetch = (urlParams) => fetch(`${BASE_URL}?type=request&${urlParams}&cache=${Math.random()}`, requestInit).then(handleHttpErrors);

export const requestInventory = () => apiFetch()