<?php
namespace Rusmanab\Tokopedia\Module;

use Rusmanab\Tokopedia\ModuleAbstract;

class Logistic extends ModuleAbstract{

    public function getCourier($parameter = []){
        $shopid = $parameter['shopid'];
        $url = "v1/logistic/fs/$this->fsId/active-info??shop_id=$shopid";
        return $this->post($url,[], $parameter, "GET");
    }

}
