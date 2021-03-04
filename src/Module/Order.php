<?php
namespace Rusmanab\Tokopedia\Module;

use Rusmanab\Tokopedia\ModuleAbstract;

class Order extends ModuleAbstract{
    public function getAll(){
        $url = "/v2/order/list?fs_id=$this->fsId&shop_id=$this->shopId&from_date=1491623331&to_date=1554695331&page=1&per_page=1";
        return $this->post($url, [], "GET");
    }
}
