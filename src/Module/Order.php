<?php
namespace Rusmanab\Tokopedia\Module;

use Rusmanab\Tokopedia\ModuleAbstract;

class Order extends ModuleAbstract{
    public function getAll($parameter = []){
        $from_date = isset($parameter['from_date']) ? $parameter['from_date'] : strtotime(date(now())) ;
        $to_date   = isset($parameter['to_date']) ? $parameter['to_date'] : strtotime(date(now())) ;

        $url = "/v2/order/list?fs_id=$this->fsId&shop_id=$this->shopId&from_date=$from_date&to_date=$to_date&page=1&per_page=1";

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

        return $this->printLabel($url);
    }

    public function accepted($parameter=[]){
        $order_id    = isset($parameter['order_id']) ? $parameter['order_id'] : '';

        $url = "/v1/order/$order_id/fs/$this->fsId/ack";
        return $this->post($url, [],[], "GET");
    }
    /**
     *
     *
     * @param array $parameter
     * @return void
     */
    /*
    1	Product(s) out of stock
    2	Product variant unavailable
    3	Wrong price or weight
    4	Shop closed. close_end and closed_note required
    5	Others
    7	Courier problem - reason required with max length 490 characters
    8	Buyer’s request - reason required with max length 490 characters
    */
    public function rejected($parameter=[]){
        $order_id    = isset($parameter['order_id']) ? $parameter['order_id'] : '';
        /*reason_code
        reason
        shop_close_end_date
        shop_close_note*/
        $url = "/v1/order/$order_id/fs/$this->fsId/nack";
        return $this->post($url, [],$parameter);
    }

    public function confirmShipping($parameter=[]){

    }

    public function requestPickUp($parameter=[]){
        // order_id shop_id
        $url = "/inventory/v1/fs/$this->fsI/pick-up";
        return $this->post($url, [],$parameter);
    }
}
