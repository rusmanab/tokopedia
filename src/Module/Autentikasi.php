<?php
namespace Rusmanab\Tokopedia\Module;

use Rusmanab\Tokopedia\ModuleAbstract;
use Rusmanab\Tokopedia\Client;

class Autentikasi extends ModuleAbstract{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }


    public function generateToken(){
        $authorisation = base64_encode( $this->client->getClientId() .":".$this->client->getClientSecret());
        $url = $this->client->getTokenUrl();


        $headers = array(
            'Content-Type: application/json',
            'Authorization: Basic '.$authorisation,
            'Content-Length: 0'
        );


        $response = $this->client->send($url,$headers,[],"POST",1);

        session(['_TokpedAccessToken' => $response->access_token] );
        session(['_TokpedTokenType' => $response->token_type ] ) ;

        return $response;
    }
}
