<?php
namespace Rusmanab\Tokopedia\Module;

use Rusmanab\Tokopedia\ModuleAbstract;

class Order extends ModuleAbstract{
    public function getAll($parameter = []){
        $from_date = isset($parameter['from_date']) ? $parameter['from_date'] : strtotime(date(now())) ;
        $to_date   = $parameter['to_date'] ? $parameter['to_date'] : strtotime(date(now())) ;

        $url = "/v2/order/list?fs_id=$this->fsId&shop_id=$this->shopId&from_date=$from_date&$to_date=1554695331&page=1&per_page=1";
        return $this->post($url, [],$parameter, "GET");
    }

    public function getOrder($parameter=[]){
        $invoice_num = isset($parameter['invoice_num']) ? $parameter['invoice_num'] : '';
        $order_id    = isset($parameter['order_id']) ? $parameter['order_id'] : '';
        if (!empty($invoice_num)){
            $where = "invoice_num=".$invoice_num;
        }
        if (!empty($order_id)){
            $where = "order_id=".$order_id;
        }
        $url = "/v2/fs/$this->fsId/order?".$where;
        return $this->post($url, [],[], "GET");
    }

    public function getShipLabel($parameter=[]){
        $order_id    = isset($parameter['order_id']) ? $parameter['order_id'] : '';
        $url = "/v1/order/$order_id/fs/$this->fsId/shipping-label?printed=0";
        return $this->post($url, [],[], "GET");
    }


}
