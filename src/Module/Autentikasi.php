<?php
namespace Rusmanab\Tokopedia\Module;

use Rusmanab\Tokopedia\ModuleAbstract;
use Rusmanab\Tokopedia\Client;
use Session;
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
        if ( !Session::get('_TokpedAccessToken') ){
            $response = $this->client->send($url,$headers,[],"POST",1);
            if ($response){
                Session::put('_TokpedAccessToken',$response->access_token );
                Session::put('_TokpedTokenType',$response->token_type ) ;
            }else{
                return false;
            }
            
        }


        return true;
    }
}
