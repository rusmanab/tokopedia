<?php
namespace Rusmanab\Tokopedia\Module;

use Rusmanab\Tokopedia\ModuleAbstract;

class Product extends ModuleAbstract{

    public function add($parameters = []){
        $url = "/v2/products/fs/$this->fsId/create?shop_id=$this->shopId";
        return $this->post($url,[], $parameters);
    }

    public function addv3($parameters = []){
        $url = "/v3/products/fs/$this->fsId/create?shop_id=$this->shopId";

        return $this->post($url,[], $parameters);
    }

    public function getAllEtalase(){
        $url = "/inventory/v1/fs/$this->fsId/product/etalase?shop_id=$this->shopId";

        return $this->post($url, [],[], "GET");
    }

    public function update($parameters = []){
        $url = "/v2/products/fs/$this->fsId/edit?shop_id=$this->shopId";
        return $this->post($url,[], $parameters);
    }

    public function updatev3($parameters = []){
        $url = "/v3/products/fs/$this->fsId/edit?shop_id=$this->shopId";

        return $this->post($url,[], $parameters, "PATCH");
    }



    public function getVariant($parameters = []){
        $category = $parameters['category_id'];
        $url = "/inventory/v1/fs/$this->fsId/category/get_variant?cat_id=$category";
        return $this->post($url, [],[], "GET");
    }

    public function getVariantV2($parameters = []){
        $category = $parameters['category_id'];
       
        $url = "/inventory/v2/fs/$this->fsId/category/get_variant?cat_id=$category";

        return $this->post($url, [],[], "GET");
    }

    public function getItems($parameters = []){

        $page    = isset($parameters['page']) ? $parameters['page'] : 1;
        $per_page= isset($parameters['per_page']) ? $parameters['per_page'] : 5;
        $url = "/inventory/v1/fs/$this->fsId/product/info?shop_id=$this->shopId&page=$page&per_page=$per_page&sort=1";

        return $this->post($url, [],[], "GET");
    }

    public function getDetail($product_id){

        $url = "/inventory/v1/fs/$this->fsId/product/info?product_id=$product_id";
        return $this->post($url, [],[], "GET");
    }

    public function getVariantProduk($product_id){
        $url = "/inventory/v1/fs/$this->fsId/product/variant/$product_id";
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
