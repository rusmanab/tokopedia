<?php
namespace Rusmanab\Tokopedia\Module;

use Rusmanab\Tokopedia\ModuleAbstract;

class Shop extends ModuleAbstract{

    public function getInfo($parameters = []){

        $url = "/v1/shop/fs/$this->fsId/shop-info";
        return $this->post($url,[], $parameters, "GET");
    }
    public function getAll(){

        $url = "/v1/shop/fs/$this->fsId/shop-info";
        return $this->post($url,[], [], "GET");
    }

    public function getShowcase($parameters = []){
        $shop_id = $parameters['shop_id'];

        $url = "v1/showcase/fs/$this->fsId/get?shop_id=$shop_id";

        return $this->post($url, [],[], "GET");
    }
    /**
     *
     *
     * @param array $parameters
     * @return void
     * name
     */
    public function createShowcase($parameters = []){
        $shop_id = $parameters['shop_id'];
        $url = "v1/showcase/fs/$this->fsId/create?shop_id=$shop_id";
        return $this->post($url, [],$parameters, "POST");
    }
    /**
     *
     *
     * @param array $parameters
     * @return void
     * name, id
     */
    public function updateShowcase($parameters = []){
        $shop_id = $parameters['shop_id'];
        $url = "v1/showcase/fs/$this->fsId/update?shop_id=$shop_id";
        return $this->post($url, [],$parameters, "POST");
    }
    /**
     *
     *
     * @param array $parameters
     * @return void
     * id
     */
    public function deleteShowcase($parameters = []){
        $shop_id = $parameters['shop_id'];
        $url = "v1/showcase/fs/$this->fsId/delete?shop_id=$shop_id";
        return $this->post($url, [],$parameters, "POST");
    }
}
