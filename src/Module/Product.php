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

    public function getVariant($parameters = []){
        $category = $parameters['category_id'];
        $url = "/inventory/v1/fs/$this->fsId/category/get_variant?cat_id=$category";
        return $this->post($url, [],[], "GET");
    }


    public function getItems($parameters = []){

        $page = isset($parameters['page']) ? $parameters['page'] : 1;

        $url = "/inventory/v1/fs/$this->fsId/product/info?shop_id=$this->shopId&page=$page&per_page=5&sort=1";

        return $this->post($url, [],[], "GET");
    }

    public function getDetail($product_id){
       
        $url = "/inventory/v1/fs/$this->fsId/product/info?product_id=$product_id";
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

    public function cekStatusProduk($uploadId){
        // /v2/products/fs/13245/status/12345?shop_id=479573'
        $url = "/v2/products/fs/$this->fsId/status/$uploadId?shop_id=$this->shopId";
        return $this->post($url,[], [], "GET");
    }
}
