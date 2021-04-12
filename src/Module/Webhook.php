<?php
namespace Rusmanab\Tokopedia\Module;

use Rusmanab\Tokopedia\ModuleAbstract;

class Webhook extends ModuleAbstract{

    public function register($parameters = []){
        $url = "/v1/fs/$this->fsId/register";
        return $this->post($url,[], $parameters);
    }

    public function listRegister(){
        $url = "/v1/fs/$this->fsId";

        return $this->post($url, [],[], "GET");
    }

    public function payLoadOrderStatus($parameters = []){
        
        $orderId = $parameters['order_id'];
        
        $url = "/v1/order/$orderId/fs/$this->fsId/webhook?type=order_status ";

        return $this->post($url, [],[], $parameters, "GET");
    }
    public function payLoadOrderNotification($parameters = []){ 
        
        $orderId = $parameters['order_id'];
        
        $url = "/v1/order/$orderId/fs/$this->fsId/webhook?type=order_notification ";

        return $this->post($url, [],[], $parameters, "GET");
    }
}
