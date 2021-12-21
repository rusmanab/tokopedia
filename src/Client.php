<?php
namespace Rusmanab\Tokopedia;

use InvalidArgumentException;
use Rusmanab\Tokopedia\Module\Autentikasi;
use Rusmanab\Tokopedia\Module\Category;
use Rusmanab\Tokopedia\Module\Product;
use Rusmanab\Tokopedia\Module\Order;
use Rusmanab\Tokopedia\Module\Shop;
use Rusmanab\Tokopedia\Module\Webhook;
use Rusmanab\Tokopedia\Module\Ipwhitelist;
use Rusmanab\Tokopedia\Module\Logistic;
use Rusmanab\Tokopedia\Module\Chat;
use session;

class Client{

    public const FS_ID          = 0;
    public const CLIENT_ID      = "";
    public const CLIENT_SECRET  = "";
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
    protected $token;
    protected $module = [];

    public function __construct(Int $shopId=0)
    {
        $this->tokenUrl = self::TOKEN_URL;
        $this->clientId = config('shop.tokopedia_clientid') == NULL ? self::CLIENT_ID : config('shop.tokopedia_clientid');
        $this->clientSecret = config('shop.tokopedia_secretid') == NULL ? self::CLIENT_SECRET : config('shop.tokopedia_secretid');
        $this->shopId = $shopId;
        $this->fsId = config('shop.tokopedia_appid') == NULL ? self::FS_ID : config('shop.tokopedia_appid');
        $this->baseUrl = self::BASE_URL;

        /*$autentikasi = new Autentikasi($this);
        $aut = $autentikasi->generateToken();*/

        $this->module['autentikasi']= new Autentikasi($this);
        //$this->module['autentikasi']->generateToken();

        $this->module['product']    = new Product($this);
        $this->module['chat']    = new Chat($this);
        $this->module['logistic']   = new Logistic($this);
        $this->module['category']   = new Category($this);
        $this->module['order']      = new Order($this);
        $this->module['shop']       = new Shop($this);
        $this->module['webhook']    = new Webhook($this);
        $this->module['ipwhitelist']    = new Ipwhitelist($this);

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
    public function setToken(String $token){
        $this->token = "Bearer ". $token;
    }
    public function authorization(){
        $_TokpedAccessToken = session('_TokpedAccessToken');
        $session =  session('_TokpedTokenType'). " ". session('_TokpedAccessToken');

        if (!$_TokpedAccessToken){
            $session = $this->token;
        }

        return $session;
        
    }

    public function webhookSwitch(){
        $uri = "/v1/fs/$this->fsId/state";
        $parameter['switcher_webhook'] = true;

        $result = $this->send($uri,[],$parameter);
        return $result;
    }

    public function sendPublicKey(){

        $uri = 'https://fs.tokopedia.net/v1/fs/'.$this->fsId.'/register?upload=1';

        $header = array(
            'Content-Type: multipart/form-data',
            'Authorization: '.$this->authorization(),
            'User-Agent: '. $this->userAgent,
        );
        $filePath = "/var/www/opensslkey/public_key.txt";

        $filePath = curl_file_create($filePath,"text/plain","public_key");

        $data =array(
            'public_key' => $filePath
        );
        $jsonBody = json_encode($data);

        $connection = curl_init();
        curl_setopt($connection, CURLOPT_URL, $uri);
        curl_setopt($connection, CURLOPT_HTTPHEADER, $header);
        curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);

        curl_setopt($connection, CURLOPT_POST, true);
        curl_setopt($connection, CURLOPT_POSTFIELDS, $jsonBody);
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
        if ($methode == "GET"){
            if (  count($data) > 0 ){
                $uri = $uri . '?' . http_build_query($data);
            }
        }


        $connection = curl_init();
        curl_setopt($connection, CURLOPT_URL, $uri);
        curl_setopt($connection, CURLOPT_HTTPHEADER, $header);
        curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);

        if ( $methode == "POST" ){
            $jsonBody = json_encode($data);
            curl_setopt($connection, CURLOPT_POST, true);

            if (count($data) > 0){
                curl_setopt($connection, CURLOPT_POSTFIELDS, $jsonBody);
            }
        }
        if ($methode == "PATCH"){
            $jsonBody = json_encode($data);
            curl_setopt($connection, CURLOPT_CUSTOMREQUEST, "PATCH");
            curl_setopt($connection, CURLOPT_POSTFIELDS, $jsonBody);
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
