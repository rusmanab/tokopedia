<?php
namespace Rusmanab\Tokopedia;

use Rusmanab\Tokopedia\Client;

abstract class ModuleAbstract{

    protected $client;
    protected $fsId;
    protected $shopId;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->fsId = $this->client->getFsId();
        $this->shopId = $this->client->getShopId();
    }

    public function post($uri, $header = [], $parameters, $methode="POST")
    {

        $request = $this->client->send($uri,$header, $parameters, $methode);
        return $request;
    }
}
