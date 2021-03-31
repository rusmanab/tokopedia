<?php
namespace Rusmanab\Tokopedia\Module;

use Rusmanab\Tokopedia\ModuleAbstract;

class Webhook extends ModuleAbstract{

    public function register($parameters = []){
        $url = "/v1/fs/$this->fsId/register";
        return $this->post($url,[], $parameters);
    }

    public function getAllEtalase(){
        $url = "/v1/fs/$this->fsId";

        return $this->get($url, [],[], "GET");
    }

}
