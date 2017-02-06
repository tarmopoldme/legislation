<?php
namespace AppBundle\Classes\api;

use AppBundle\Classes\exception\InvalidResponseException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
 * Wraps get and post api calls
 * @author <tarmo.poldme@brainart.ee>
 * @date 04.02.2017
 */
class ApiCall
{

    /**
     * @var Client;
     */
    private $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;

    }

    /**
     * Calls basic get request via given url
     *
     * @param $url
     * @param array $options
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws InvalidResponseException
     */
    public function getData($url, $options = [])
    {
        try {
            return $this->client->get($url, $options);
        } catch (RequestException $re) {
            throw new InvalidResponseException("Error occured while making get request: " . $re->getMessage());
        }
    }

    /**
     * Used to call post requests
     *
     * @param $url
     * @param array $options
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws InvalidResponseException
     */
    public function postData($url, $options = [])
    {
        try {
            return $this->client->post($url, $options);
        } catch (RequestException $re) {
            throw new InvalidResponseException("Error occured while making post request: " . $re->getMessage());
        }
    }
}