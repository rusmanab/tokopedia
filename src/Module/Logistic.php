<?php
namespace Rusmanab\Tokopedia\Module;

use Rusmanab\Tokopedia\ModuleAbstract;

class Logistic extends ModuleAbstract{

    public function getCourier($parameter = []){
     
        $url = "v1/logistic/fs/$this->fsId/active-info";
        return $this->post($url,[], $parameter, "GET");
    }

}
