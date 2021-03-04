<?php
namespace Rusmanab\Tokopedia\Module;

use Rusmanab\Tokopedia\ModuleAbstract;

class Order extends ModuleAbstract{
    public function getAll($parameter = []){
        $from_date = isset($parameter['from_date']) ? $parameter['from_date'] : strtotime(date(now())) ;
        $to_date   = $parameter['to_date'] ? $parameter['to_date'] : strtotime(date(now())) ;
        $url = "/v2/order/list?fs_id=$this->fsId&shop_id=$this->shopId&from_date=$from_date&$to_date=1554695331&page=1&per_page=1";
        return $this->post($url, [], "GET");
    }
}
