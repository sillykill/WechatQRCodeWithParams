<?php

require_once dirname(__FILE__)."/Net.php";
require_once dirname(__FILE__)."/Log.php";
require_once dirname(__FILE__)."/backMsg.php";
require_once dirname(__FILE__)."/singlonAccessToken.php";

class Qrcode
{

    const action_name_INT = "QR_SCENE";
    const action_name_STR = "QR_STR_SCENE";
    const action_name_LIMIT = "QR_LIMIT_SCENE";
    const action_name_LIMIT_STR = "QR_LIMIT_STR_SCENE";

    private $scene;
//    Static $count = 0;

    /**
     * @return string
     */
    public function getScene()
    {
        return $this->scene;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    private $state;

    /**
     * Qrcode constructor.
     * @param $scene
     * @param $state
     */
    public function __construct($scene = 'int', $state)
    {
        $this->scene = $this->caseAc($scene);
        $this->state = $state;
    }

    private function caseAc($case)
    {
        switch ($case) {
            case 'int':
                return self::action_name_INT;
                break;
            case 'str':
                return self::action_name_STR;
                break;
            case 'limit':
                return self::action_name_LIMIT;
                break;
            case 'limitStr':
                return self::action_name_LIMIT_STR;
                break;
            default:
                return self::action_name_INT;
        }
    }


    public function durableTicket()
    {
        $net = new Net();
        $token = singlonAccessToken::getInstance();
        $url = GlobalData::qrcode_url . "?access_token=" . $token;
        $params = array("action_name" => $this->scene, "action_info" => array("scene" => array("scene_str" => $this->state)));
        $wxres = $net->do_post($url, json_encode($params), array());
        if (isset($wxres->errcode)) {
            //写日志报错
            //循环请求
            return false;
        } else {
            $ticket = json_decode($wxres)->ticket;
            return $ticket;
        }
    }


    //图片路径固定
    public function savejpg($ticket,$scene){
        $net = new Net();
        $wxresRcode = $net->do_get(GlobalData::qrcode_ticket, array("ticket" => $ticket));
        file_put_contents(dirname(__FILE__)."/../diskjpg/" . $scene . ".jpg", $wxresRcode);
        return $scene.".jpg";
    }

}