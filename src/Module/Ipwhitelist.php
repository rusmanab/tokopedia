<?php
namespace Rusmanab\Tokopedia\Module;

use Rusmanab\Tokopedia\ModuleAbstract;

class Ipwhitelist extends ModuleAbstract{

    public function registerIp($parameters = []){
       
        $url = "/v1/fs/$this->fsId/whitelist";
        
        return $this->post($url,[], $parameters);
    }

    public function getIp(){        
        $url = "/v1/fs/$this->fsId/whitelist";

        return $this->post($url, [],[], "GET");
    }

    public function activatedIp($parameters = []){              
       
        $url = "/v1/fs/$this->fsId/state";
        return $this->post($url, [],$parameters);
    }
}
