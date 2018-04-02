<?php
namespace Presi\AppCenter;

use GuzzleHttp\Client;
use Carbon\Carbon;

class AppCenterClient
{
    const API_URL = "api.appcenter.ms/v0.1";

    const ENDPOINT_ANALYTICS = "analytics";

    const ENDPOINT_EVENTS = self::ENDPOINT_ANALYTICS."/events";
    
    const ENDPOINT_AUDIENCES = self::ENDPOINT_ANALYTICS."/audiences";
    
    const ENDPOINT_ERRORS = "errors";

    const ENDPOINT_ERRORGROUPS = self::ENDPOINT_ERRORS."/errorGroups";


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


    /**
     * 
     * ACCOUNT
     * 
     */

     public function user() {
        return $this->get("/user");
     }

     public function readORGS() {
        return $this->get("/orgs");
     }

     public function readApps(){
        return $this->get("/apps");
     }

     public function getAnyAppResource($appName, $resource, $query=[]) {
        
        $this->setParams($query);

        return $this->get("/apps/{$this->ownerName}/{$appName}/{$resource}");
     }

    /**
     * 
     * ANALYTICS
     * 
     */

    public function readAnalytics($appName, Carbon $startDate, $resource, $query=[]) {

        $this->setParams($query);

        $this->setParam("start", $startDate->toDateTimeString());

        return $this->get("/apps/{$this->ownerName}/{$appName}/". self::ENDPOINT_ANALYTICS ."/{$resource}");
    }

    public function readEvents($appName, Carbon $startDate, $resource=null, $query=[]) {

        $this->setParams($query);

        $this->setParam("start", $startDate->toDateTimeString());

        return $this->get("/apps/{$this->ownerName}/{$appName}/".self::ENDPOINT_EVENTS . "/{$resource}");
    }

    public function readEvent($appName, Carbon $startDate, $eventName, $resource=null, $query=[]) {

        $this->setParams($query);

        $this->setParam("start", $startDate->toDateTimeString());

        return $this->get("/apps/{$this->ownerName}/{$appName}/".self::ENDPOINT_EVENTS . "/{$eventName}/{$resource}");
    }

    public function readAudiences($appName, $resource=null, $query=[]) {

        $this->setParams($query);

        return $this->get("/apps/{$this->ownerName}/{$appName}/".self::ENDPOINT_AUDIENCES . "/{$resource}");
    }

    public function readErrors($appName, Carbon $startDate, $resource, $query=[])
    {
        $this->setParams($query);

        $this->setParam("start", $startDate->toDateTimeString());

        return $this->get("/apps/{$this->ownerName}/{$appName}/".self::ENDPOINT_ERRORS . "/{$resource}");
    }

    public function readErrorGroup($appName, $errorGroupID, $resource=null, Carbon $startDate=null, $query=[])
    {
        $this->setParams($query);

        if(!is_null($startDate))
            $this->setParam("start", $startDate->toDateTimeString());
        
        return $this->get("/apps/{$this->ownerName}/{$appName}/".self::ENDPOINT_ERRORGROUPS . "/{$errorGroupID}/{$resource}");
    }
    
    public function get($endPoint) {

        $this->authenticate();
        
        $extras = array_merge(['query' => $this->additionalParams], $this->headers);

        $response = $this->client->request('GET',self::API_URL . $endPoint, $extras);

        return json_decode($response->getBody(),true);
    }
}