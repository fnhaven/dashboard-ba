<?php

namespace App\Services\Adapter;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;

class GuzzleHttpAdapter implements AdapterInterface
{
    /** @var ClientInterface */
    protected $client;

    /** @var Response */
    protected $response;

    /**
     * GuzzleHttpAdapter constructor
     *
     * @param ClientInterface|null $client
     * @param array $config
     */
    public function __construct(ClientInterface $client = null, array $config = [])
    {
        $this->client = $client ?: new Client(
            array_merge($config, [
                'timeout'  => 10,
                'http_errors' => false,
                'verify' => false // TODO: this is a serious issue
            ])
        );
    }

    /**
     * Get request
     *
     * @param $url
     * @param array $contents
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get($url, array $contents = [])
    {
        return $this->response = $this->client->request('GET', $url, $contents);
    }

    /**
     * Post request
     *
     * @param $url
     * @param array $contents
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post($url, array $contents = [])
    {
        return $this->response = $this->client->request('POST', $url, $contents);
    }

    /**
     * Put request
     *
     * @param $url
     * @param array $contents
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function put($url, array $contents = [])
    {
        return $this->response = $this->client->request('PUT', $url, $contents);
    }

    /**
     * Patch request
     *
     * @param $url
     * @param array $contents
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function patch($url, array $contents = [])
    {
        return $this->response = $this->client->request('PATCH', $url, $contents);
    }

    /**
     * Delete request
     *
     * @param $url
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete($url)
    {
        return $this->response = $this->client->request('DELETE', $url, $contents);
    }
}