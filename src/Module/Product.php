<?php
namespace Rusmanab\Tokopedia\Module;

use Rusmanab\Tokopedia\ModuleAbstract;

class Product extends ModuleAbstract{

    public function add($parameters = []){
        $url = "/v2/products/fs/$this->fsId/create?shop_id=$this->shopId";
        return $this->post($url,[], $parameters);
    }

    public function getAllEtalase($parameters = []){
        $url = "/inventory/v1/fs/$this->fsId/product/etalase?shop_id=$this->shopId";

        return $this->post($url, [],[], "GET");
    }

    public function getItems($product_id=""){
        $p = "";
        if (!empty($product_id)){
            $p = "?product_id=".$product_id;
        }
        $url = "/v2/products/fs/$this->fsId/1/20".$p;

        return $this->post($url, [],[], "GET");
    }

    public function setActive($parameter=[]){
        $url = "/v1/products/fs/$this->fsId/active?shop_id=$this->shopId";
        return $this->post($url,[],$parameter);
    }
    public function setInActive($parameter=[]){
        $url = "/v1/products/fs/$this->fsId/inactive?shop_id=$this->shopId";
        return $this->post($url,[],$parameter);
    }

    public function updatePrice($parameter=[]){

        $url = "/inventory/v1/fs/$this->fsId/price/update?shop_id=$this->shopId";
        return $this->post($url,[], $parameter);
    }

    public function updateStok($parameter=[]){
        $url = "/inventory/v1/fs/$this->fsId/stock/update?shop_id=$this->shopId";
        return $this->post($url,[], $parameter);
    }

    public function delete($parameter=[]){
        $url = "/v3/products/fs/$this->fsId/delete?shop_id=$this->shopId";
        return $this->post($url,[], $parameter);
    }

}
