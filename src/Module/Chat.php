<?php
namespace Rusmanab\Tokopedia\Module;

use Rusmanab\Tokopedia\ModuleAbstract;

class Chat extends ModuleAbstract{

    public function listMessage($parameter = []){
        //shop_id=:shop_id
        $url = "/v1/chat/fs/$this->fsId/messages";
        return $this->post($url,[], $parameter, "GET");

    }

    public function listReply($parameter = []){
        // shop_id=:shop_id
        $msg_id = $parameter['msg_id'];
        $url = "/v1/chat/fs/$this->fsId/messages/$msg_id/replies";
        return $this->post($url,[], $parameter, "GET");
    }

    public function init($parameter = []){
        
        $url = "/v1/chat/fs/$this->fsId/initiate";
        return $this->post($url,[], $parameter, "GET");
    }

    public function sendReply($parameter = []){
        $msg_id = $parameter['msg_id'];
        $url = "/v1/chat/fs/$this->fsId/messages/$msg_id/reply";
        return $this->post($url,[], $parameter);
    }
}
