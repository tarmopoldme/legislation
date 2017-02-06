<?php
namespace AppBundle\Classes\api;

use AppBundle\Classes\Classifier;
use AppBundle\Classes\exception\InvalidResponseException;

/**
 * Wraps api call functionality to Riigiteataja
 * Is defined via service in AirviroBundle services.yml
 *
 * @author <tarmo.poldme@brainart.ee>
 */
class ApiService extends AbstractApiService
{

    protected function getServiceName()
    {
        return Classifier::LEGISLATION_API_SERVICE;
    }

    /**
     * Api call main wrapper
     *
     * @param $url
     * @param array $options http://guzzle.readthedocs.org/en/latest/request-options.html
     * @param bool $get - defaults to get call
     *
     * @return \Psr\Http\Message\ResponseInterface|boolean
     */
    public function callApi($url, $options = [], $get = true)
    {
        try {
            $call = new ApiCall($this->client);
            if ($get === true) {
                return $call->getData($url, $options);
            }

            return $call->postData($url, $options);
        } catch (InvalidResponseException $e) {
            $this->logError($e->getMessage() . '. Url: ' . $url);
            return false;
        }

    }
}
