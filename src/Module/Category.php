<?php
namespace Rusmanab\Tokopedia\Module;

use Rusmanab\Tokopedia\ModuleAbstract;

class Category extends ModuleAbstract{

    public function getCategory($parameter = []){
        $keyword = isset($parameter['keyword']) ? $parameter['keyword'] : "";

        $url = "/inventory/v1/fs/$this->fsId/product/category?keyword=$keyword";
        return $this->post($url,[], $parameter, "GET");
    }

}
