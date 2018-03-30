<?php
namespace Presi\AppCenter;

use GuzzleHttp\Client;
use Carbon\Carbon;

class AppCenterClient
{
    const API_URL = "api.appcenter.ms/v0.1/apps";

    const ENDPOINT_ANALYTICS = "analytics";

    const ENDPOINT_EVENTS = self::ENDPOINT_ANALYTICS."/events";

    const ENDPOINT_AUDIENCES = self::ENDPOINT_ANALYTICS."/audiences";


    protected $client;

    protected $headers;

    protected $apiToken;

    protected $ownerName;

    protected $additionalParams;
    
    public function __construct($apiToken, $ownerName)
    {        
        $this->apiToken = $apiToken;

        $this->ownerName = $ownerName;

        $this->client = new Client();

        $this->headers = ['headers' => []];

        $this->additionalParams = [];
    }

    private function authenticate() {

        $this->headers['headers']['X-API-Token'] = $this->apiToken;   
    }

    public function setParams($params = []) {
        
        $this->additionalParams = $params;
        
        return $this;
    }

    public function setParam($key, $value) {
        
        $this->additionalParams[$key] = $value;
        
        return $this;
    }

    public function readAnalytics($appName, Carbon $startDate, $resource, $query=[]) {

        $this->setParams($query);

        $this->setParam("start", $startDate->toDateTimeString());

        return $this->get("/".$this->ownerName."/".$appName."/".self::ENDPOINT_ANALYTICS . '/'.$resource);
    }

    public function readEvents($appName, Carbon $startDate, $resource=null, $query=[]) {

        $this->setParams($query);

        $this->setParam("start", $startDate->toDateTimeString());

        return $this->get("/".$this->ownerName."/".$appName."/".self::ENDPOINT_EVENTS . '/'.$resource);
    }

    public function readAudiences($appName, $resource=null, $query=[]) {

        $this->setParams($query);

        return $this->get("/".$this->ownerName."/".$appName."/".self::ENDPOINT_AUDIENCES . '/'.$resource);
    }
    
    public function get($endPoint) {

        $this->authenticate();
        
        $extras = array_merge(['query' => $this->additionalParams], $this->headers);

        return $this->client->request('GET',self::API_URL . $endPoint, $extras);
    }
}