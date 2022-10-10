<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Api
{
    private function getBaseUrl() : string
    {
        return config('services.apex.api_url', '');
    }

    private function getApiKey() : string
    {
        return config('services.apex.api_key', '');
    }

    /**
     * @throws GuzzleException
     */
    public function getMapRotations() : array
    {
        $endpoint = "{$this->getBaseUrl()}maprotation";
        $client = new Client();
        $response = $client->request('GET', $endpoint, ['query' => [
            'auth' => $this->getApiKey(),
            'version' => 2,
        ]]);

        $statusCode = $response->getStatusCode();

        if($statusCode !== 200) {
            throw new \Exception("Could not retrieve map rotations, status: {$statusCode}");
        }

        $result = json_decode($response->getBody()?->getContents(), true);
        $jsonError = json_last_error();

        if($jsonError !== JSON_ERROR_NONE) {
            throw new \Exception("Could not retrieve map rotations, JSON ERROR: {$jsonError}");
        }

        return $result;
    }

    /**
     * @throws GuzzleException
     */
    public function getCraftingRotations() : array
    {
        $endpoint = "{$this->getBaseUrl()}crafting";
        $client = new Client();
        $response = $client->request('GET', $endpoint, ['query' => [
            'auth' => $this->getApiKey()
        ]]);

        $statusCode = $response->getStatusCode();

        if($statusCode !== 200) {
            throw new \Exception("Could not retrieve crafting rotations, status: {$statusCode}");
        }

        $result = json_decode($response->getBody()?->getContents(), true);
        $jsonError = json_last_error();

        if($jsonError !== JSON_ERROR_NONE) {
            throw new \Exception("Could not retrieve crafting rotations, JSON ERROR: {$jsonError}");
        }

        return $result;
    }

    /**
     * @throws GuzzleException
     */
    public function getServerStatus() : array
    {
        $endpoint = "{$this->getBaseUrl()}servers";
        $client = new Client();
        $response = $client->request('GET', $endpoint, ['query' => [
            'auth' => $this->getApiKey()
        ]]);

        $statusCode = $response->getStatusCode();

        if($statusCode !== 200) {
            throw new \Exception("Could not retrieve server status, status: {$statusCode}");
        }

        $result = json_decode($response->getBody()?->getContents(), true);
        $jsonError = json_last_error();

        if($jsonError !== JSON_ERROR_NONE) {
            throw new \Exception("Could not retrieve server status, JSON ERROR: {$jsonError}");
        }

        return $result;
    }
}
