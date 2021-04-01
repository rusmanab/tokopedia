<?php
namespace Rusmanab\Tokopedia;

use InvalidArgumentException;
use Rusmanab\Tokopedia\Module\Autentikasi;
use Rusmanab\Tokopedia\Module\Category;
use Rusmanab\Tokopedia\Module\Product;
use Rusmanab\Tokopedia\Module\Order;
use Rusmanab\Tokopedia\Module\Webhook;

class Client{

    public const FS_ID          = 14655;
    public const CLIENT_ID      = "97f50807a11943cc9ad3306b73753fc1";
    public const CLIENT_SECRET  = "e69f52c4360842d3a4dede0895de8393";
    public const BASE_URL       = "https://fs.tokopedia.net";
    public const TOKEN_URL      = "https://accounts.tokopedia.com/token?grant_type=client_credentials";

    protected $tokenUrl;
    protected $clientId;
    protected $clientSecret;
    protected $httpClient;
    protected $shopId;
    protected $fsId;
    protected $baseUrl;
    protected $userAgent = "soco-tokped";

    protected $module = [];

    public function __construct(Int $shopId)
    {
        $this->tokenUrl = self::TOKEN_URL;
        $this->clientId = self::CLIENT_ID;
        $this->clientSecret = self::CLIENT_SECRET;
        $this->shopId = $shopId;
        $this->fsId = self::FS_ID;
        $this->baseUrl = self::BASE_URL;

        $autentikasi = new Autentikasi($this);
        $autentikasi->generateToken();

        $this->module['product'] = new Product($this);
        $this->module['category'] = new Category($this);
        $this->module['order'] = new Order($this);
        $this->module['webhook'] = new Webhook($this);

    }

    public function getTokenUrl():string
    {
        return $this->tokenUrl;
    }
    public function getClientId():string
    {
        return $this->clientId;
    }
    public function getClientSecret():string
    {
        return $this->clientSecret;
    }

    public function getFsId(){
        return $this->fsId;
    }

    public function getShopId(){
        return $this->shopId;
    }

    public function __get(string $name)
    {
        if (!array_key_exists($name, $this->module)) {
            throw new InvalidArgumentException(sprintf('Property "%s" not exists', $name));
        }

        return $this->module[$name];
    }
    public function authorization(){
        $session =  session('_TokpedTokenType'). " ". session('_TokpedAccessToken');

        return $session;
    }

    public function send($uri,$header = [], $data = [], $methode = "POST",$aut=0){

        if (!$aut){
            $uri = $this->baseUrl . $uri;
        }

        if (count($header) == 0){
            $header = array(
                'Content-Type: application/json',
                'Authorization: '.$this->authorization(),
                'User-Agent: '. $this->userAgent,
            );
        }

        $jsonBody = json_encode($data);

        $connection = curl_init();
        curl_setopt($connection, CURLOPT_URL, $uri);
        curl_setopt($connection, CURLOPT_HTTPHEADER, $header);
        curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);

        if ( $methode == "POST" ){
            curl_setopt($connection, CURLOPT_POST, true);
            if (count($data) > 0){
                curl_setopt($connection, CURLOPT_POSTFIELDS, $jsonBody);
            }

        }
        curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($connection);

        curl_close($connection);

        if ( $response ){
            $json_decode = json_decode($response);
        }else{
            return false;
        }

        return $json_decode;
    }

    public function printLabel($uri){

        $uri = $this->baseUrl . $uri;

        $header = array(
            'Content-Type: application/json',
            'Authorization: '.$this->authorization(),
            'User-Agent: '. $this->userAgent,
        );


        $connection = curl_init();
        curl_setopt($connection, CURLOPT_URL, $uri);
        curl_setopt($connection, CURLOPT_HTTPHEADER, $header);
        curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);

        curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($connection);

        curl_close($connection);

        return $response;
    }
}
