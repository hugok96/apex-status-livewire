<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Api
{
    /**
     * Retrieves the api base url from configuration, suffixed with a slash
     *
     * @return string
     */
    private function getBaseUrl(): string
    {
        return rtrim(config('services.apex.api_url', ''), '/') . '/';
    }

    /**
     * Retrieves the api key from configuration
     *
     * @return string
     */
    private function getApiKey(): string
    {
        return config('services.apex.api_key', '');
    }

    /**
     * Performs an array and returns the raw decoded json array
     *
     * @param string $endpoint
     * @param string $method
     * @param array $queryParameters
     * @return array
     * @throws GuzzleException
     * @throws Exception
     */
    public function performArrayRequest(string $endpoint, string $method = 'GET', array $queryParameters = []): array
    {
        // initialize client and perform request
        $client = new Client();
        $response = $client->request($method, $this->getBaseUrl() . $endpoint, [
            'query' => array_merge(['auth' => $this->getApiKey()], $queryParameters)
        ]);

        // Fail on status code error
        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200) {
            throw new Exception("Could not retrieve data from api, status: {$statusCode}");
        }

        // Fail on json decode error
        $result = json_decode($response->getBody()?->getContents(), true);
        $jsonError = json_last_error();
        if ($jsonError !== JSON_ERROR_NONE) {
            throw new Exception("Could not retrieve map rotations, JSON ERROR: {$jsonError}");
        }

        return $result;
    }

    /**
     * Returns the raw decoded api map rotation data as an array
     *
     * @throws GuzzleException
     * @throws Exception
     */
    public function getMapRotations(): array
    {
        return $this->performArrayRequest('maprotation', queryParameters: ['version' => 2]);
    }

    /**
     * Returns the raw decoded api map rotation data as an array
     *
     * @throws GuzzleException
     * @throws Exception
     */
    public function getCraftingRotations(): array
    {
        return $this->performArrayRequest('crafting');
    }

    /**
     * Returns the raw decoded api map rotation data as an array
     *
     * @throws GuzzleException
     * @throws Exception
     */
    public function getServerStatus(): array
    {
        return $this->performArrayRequest('servers');
    }
}
